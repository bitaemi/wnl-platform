import * as io from 'socket.io-client'
import {envValue} from 'js/utils/env'
import { SOCKET_CONNECTION_ERROR, SOCKET_CONNECTION_RECONNECTED } from '../store/mutations-types';

export const SOCKET_EVENT_SEND_MESSAGE = 'send-message'
export const SOCKET_EVENT_MESSAGE_PROCESSED = 'message-processed'
export const SOCKET_EVENT_USER_SENT_MESSAGE = 'user-sent-message'
export const SOCKET_EVENT_JOIN_ROOM = 'join-room'
export const SOCKET_EVENT_JOIN_ROOM_SUCCESS = 'join-room-success'
export const SOCKET_EVENT_LEAVE_ROOM = 'leave-room'

const WnlSocket = {
    install(Vue, {store}) {
        const onSocketError = (error) => {
            if (error === 'Authentication error') {
                window.location.replace('/login');
                return
            }
            $wnl.logger.error(`Socket error: ${error}`)
        }

        const getSocketInstance = () => {
            if (!global.$socket) {
                global.$socket = io(`${envValue('chatHost')}:${envValue('chatPort')}`)
                global.$socket.on('error', onSocketError);
            }
            return global.$socket
        }

        const socket = getSocketInstance()

        const onSocketConnectionError = (err) => {
            store.dispatch(SOCKET_CONNECTION_ERROR)
            socket.off('connect_error')
        }

        socket.on('connect_error', onSocketConnectionError)

        socket.on('reconnect', () => {
            store.dispatch(SOCKET_CONNECTION_RECONNECTED)
            socket.on('connect_error', onSocketConnectionError)
        })

        Vue.prototype.$socketEmit = (event, payload) => {
            socket.emit(event, payload)
        }

        Vue.prototype.$socketRegisterListener = (event, listener) => {
            socket.on(event, listener)
        }

        Vue.prototype.$socketRemoveListener = (event, listener) => {
            socket.off(event, listener)
        }

        Vue.prototype.$socketJoinRoom = (room) => {
            return new Promise((resolve, reject) => {
                socket.emit(SOCKET_EVENT_JOIN_ROOM, {room})

                const timerId = setTimeout(() => {
                    $wnl.logger.error('Failed to connect to room', room)
                }, 5000)

                socket.on(SOCKET_EVENT_JOIN_ROOM_SUCCESS, (data) => {
                    if (room === data.room) {
                        clearTimeout(timerId)
                        resolve(data)
                    }
                })
            })
        }
    }
}

export default WnlSocket
