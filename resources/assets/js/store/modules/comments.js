import axios from 'axios'

import * as types from 'js/store/mutations-types'
import { getApiUrl } from 'js/utils/env'

export const commentsGetters = {
	/**
	 * [getComments description]
	 * @param  {Object} commentable { commentable_resource: String, commentable_id: Int }
	 */
	comments: (state) => (payload) => {
		if (!state[payload.resource][payload.id].hasOwnProperty('comments')) {
			return []
		}

		return state[payload.resource][payload.id].comments.map((commentId) => state.comments[commentId])
	},
	commentProfile: (state) => (id) => state.profiles[id]
}

export const commentsMutations = {
	[types.ADD_COMMENT] () {
		console.log('Mutation ADD_COMMENT!')
	},
	[types.REMOVE_COMMENT] () {
		console.log('Mutation REMOVE_COMMENT!')
	},
}

export const commentsActions = {
	addComment({commit}, payload) {
		console.log('Action addComment!')
	},
	removeComment({commit}, payload) {
		console.log('Action removeComment!')
	},
}
//
// export default {
// 	commentsGetters,
// 	commentsMutations,
// 	commentsActions,
// }
