import _ from 'lodash'
import * as types from '../mutations-types'
import {getApiUrl} from 'js/utils/env'
import {set} from 'vue'

function _getReactions() {
	return axios.get(getApiUrl('users/current/reactions/byCategory/bookmark'))
}

function getInitialState() {
	return {
		loading: true,
		reactions: {},
		categories: [],
		slidesContent: []
	}
}

const resourcesMap = {
	'App\\Models\\QnaQuestion': 'qna_questions',
	'App\\Models\\QuizQuestion': 'quiz_questions',
	'App\\Models\\Slide': 'slides',
}

const namespaced = true

const state = getInitialState()

const getters = {
	isLoading: (state) => state.loading,
	getQnaQuestionsIdsForCategory: ({reactions}) => (category) => (reactions[category] && reactions[category].qna_questions.map(qna => qna.reactable_id)) || [],
	getQuizQuestionsIdsForCategory: ({reactions}) => (category) => (reactions[category] && reactions[category].quiz_questions.map(quiz => quiz.reactable_id)) || [],
	getSlidesIdsForCategory: ({reactions}) => (category) => (reactions[category] && reactions[category].slides.map(slide => slide.reactable_id)) || [],
	getItemsCount: ({reactions}) => (category) => {
		return reactions[category]
			&& Object.keys(reactions[category])
				.map((items) => reactions[category][items].length)
				.reduce((sum, count) => sum + count, 0)
			|| 0
	},
	categories: (state) => state.categories,
	slidesContent: (state) => state.slidesContent,
	getCategoryByName: (state, getters) => (categoryName) => getters.categories.find((category) => {
		return false
	})
}

const mutations = {
	[types.IS_LOADING] (state, isLoading) {
		set(state, 'loading', isLoading)
	},
	[types.RESET_MODULE] (state) {
		let initialState = getInitialState()
		Object.keys(initialState).forEach((field) => {
			set(state, field, initialState[field])
		})
	},
	[types.COLLECTIONS_SET_REACTABLES] (state, reactions) {
		set(state, 'reactions', reactions)
	},
	[types.COLLECTIONS_SET_CATEGORIES] (state, categories) {
		set(state, 'categories', categories)
	},
	[types.SLIDES_LOADING] (state, isLoading) {
		set(state, 'slidesLoaded', !isLoading)
	},
	[types.COLLECTIONS_SET_SLIDES] (state, slides) {
		set(state, 'slidesContent', slides)
	},
	[types.COLLECTIONS_APPEND_SLIDE] (state, slide) {
		const slidesContent = state.slidesContent || []

		set(state, 'slidesContent', [...slidesContent, slide])
	},
	[types.COLLECTIONS_REMOVE_SLIDE] (state, slideId) {
		const updatedSlides = state.slidesContent.filter(({id}) => slideId !== id)

		set(state, 'slidesContent', updatedSlides)
	}
}

const actions = {
	fetchReactions({commit}) {
		return _getReactions()
		.then(({data: { reactions }}) => {
			if (Array.isArray(reactions) && reactions.length === 0) {
				commit(types.IS_LOADING, false)
			}

			let serializedReactions = {};
			Object.keys(reactions).forEach((category) => {
				let categoriesReactions = {}

				Object.values(resourcesMap)
					.forEach((resource) => categoriesReactions[resource] = [])

				reactions[category]
					.filter(reaction => Object.keys(resourcesMap).includes(reaction.reactable_type))
					.forEach(reaction => {
						let resource = resourcesMap[reaction.reactable_type]
						categoriesReactions[resource].push(reaction)
					})

				serializedReactions[category] = categoriesReactions
			})
			commit(types.COLLECTIONS_SET_REACTABLES, serializedReactions)
			commit(types.IS_LOADING, false)

		})
	},
	fetchCategories({commit}) {
		return axios.get(getApiUrl('categories/all'))
		.then(({data: categories}) => commit(types.COLLECTIONS_SET_CATEGORIES, categories));
	},
	fetchSlidesByTagName({commit}, {tagName, ids}) {
		commit(types.SLIDES_LOADING, true);
		return axios.post(getApiUrl('slides/.search'), {
			query: {
				whereHas: {
					tags: {
						where: [['tags.name', '=', tagName]]
					}
				},
				whereIn: ['id', ids],
			},
			order: {
				id: 'desc',
			},
		}).then(({data}) => {
			commit(types.COLLECTIONS_SET_SLIDES, data)
			commit(types.SLIDES_LOADING, false);
		}).catch((error) => {
			commit(types.SLIDES_LOADING, false);
		})
	},
	addSlideToCollection({commit}, slideId) {
		return axios.post(getApiUrl('slides/.search'), {
			query: {
				where: [['id', '=', slideId]],
			},
			order: {
				id: 'desc',
			},
		}).then(({data}) => {
			data && data.length && commit(types.COLLECTIONS_APPEND_SLIDE, data[0]);
		})
	},
	removeSlideFromCollection({commit, state}, slideId) {
		commit(types.COLLECTIONS_REMOVE_SLIDE, slideId)
	}
}

export default {
	namespaced,
	state,
	getters,
	mutations,
	actions,
}
