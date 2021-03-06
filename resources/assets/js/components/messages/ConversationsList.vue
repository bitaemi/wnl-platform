<template lang="html">
	<div class="scrollable-container" @scroll="pullConversations" >
		<div class="rooms-header" v-if="withSearch">
			<header>{{$t('messages.dashboard.privateMessages')}}</header>
			<div class="rooms-list-controls">
				<span class="rooms-list-controls-item is-active" @click="toggleUserSearch">
					<div class="search-icon" v-if="!userSearchVisible">
						<i class="fa fa-search" :title="$t('messages.search.searchButton')"></i>
						<span class="text">{{$t('messages.search.searchButton')}}</span>
					</div>
					<div class="close-icon" v-else>
						<i class="fa fa-times" :title="$t('messages.search.closeButton')"></i>
						<span class="text">{{$t('messages.search.closeButton')}}</span>
					</div>
				</span>
			</div>
		</div>
		<div v-if="userSearchVisible">
			<wnl-conversations-search @close="closeUserSearch"/>
		</div>
		<div v-else-if="roomsToShow.length" class="conversation-list scrollable-container">
			<wnl-message-link
				v-for="(room, index) in roomsToShow"
				:key="room.id"
				:userId="getOtherUser(room).user_id"
				:roomId="room.id"
				 class="is-relative is-block"
			>
				<wnl-conversation-snippet
					:key="room.id"
					:room="room"
					:profile="getOtherUser(room)"
					:isActive="isActive(room)"
					:class="{'has-unread': room.unread_count > 0}"
				/>
				 <div v-if="room.unread_count" class="counter">{{room.unread_count > 9 ? '9+' : room.unread_count}}</div>
			</wnl-message-link>
		</div>
		<div v-else class="notification aligncenter">Nie masz żadnych rozmów</div>
	</div>
</template>

<style lang="sass">
	@import 'resources/assets/sass/variables'

	.scrollable-container
		overflow-y: scroll

	.rooms-header
		color: $color-gray-dimmed
		font-size: $font-size-minus-1
		display: flex
		justify-content: space-between
		border-bottom: $border-light-gray
		overflow-y: hidden
		min-height: $margin-huge

		header
			margin: $margin-base

		.rooms-list-controls-item
			padding: $margin-small
			display: flex
			align-items: center
			height: 100%

			.search-icon, .close-icon
				display: flex
				flex-direction: column
				align-items: center
				justify-content: center
				height: 100%
				min-width: 50px

			.text
				text-transform: uppercase
				font-size: $font-size-minus-3

			&:hover, &.is-active
				background: $color-background-lighter-gray
				cursor: pointer

	.conversation-list
		width: 100%
		display: flex
		flex-direction: column
		overflow-x: hidden

	.is-block
		display: block

	.counter
		align-items: center
		background: red
		border-radius: $border-radius-full
		color: $color-white
		display: flex
		font-size: $font-size-minus-3
		font-weight: $font-weight-black
		justify-content: center
		height: 1.7em
		position: absolute
		bottom: 10px
		width: 1.7em
		right: 10px
</style>

<script>
	import axios from 'axios'
	import ConversationsSearch from 'js/components/messages/ConversationsSearch'
	import MessageLink from "js/components/global/MessageLink"
	import ConversationSnippet from "js/components/messages/ConversationSnippet"
	import {mapGetters, mapActions} from 'vuex'

	export default {
		name: 'ConversationsList',
		components: {
			'wnl-conversations-search': ConversationsSearch,
			'wnl-message-link': MessageLink,
			'wnl-conversation-snippet': ConversationSnippet
		},
		props: {
			withSearch: {
				required: false,
				default: true
			},
		},
		data() {
			return  {
				userSearchVisible: false,
			}
		},
		computed: {
			...mapGetters(['currentUser']),
			...mapGetters('chatMessages', [
				'sortedRooms',
				'getRoomById',
				'getInterlocutor',
				'hasMoreRooms',
				'currentPage'
			]),
			roomsToShow() {
				return this.sortedRooms.map(roomId => {
					return this.getRoomById(roomId)
				})
			},
		},
		methods: {
			...mapActions('chatMessages', ['fetchUserRoomsWithMessages']),
			closeUserSearch() {
				this.userSearchVisible = false
			},
			toggleUserSearch() {
				this.userSearchVisible = !this.userSearchVisible
			},
			isActive(room) {
				if (!this.userSearchVisible) {
					return this.$route.query.roomId == room.id
				}
			},
			getOtherUser(room) {
				const profile = this.getInterlocutor(room.profiles)
				if (profile.id) return profile
				return this.currentUser
			},
			pullConversations: _.debounce(function(event) {
				if (!this.userSearchVisible && this.hasMoreRooms) {
					if (event.target.scrollHeight - event.target.scrollTop === event.target.clientHeight) {
						return this.fetchUserRoomsWithMessages({page: this.currentPage + 1})
					}
				}
			}),
		}
	}
</script>
