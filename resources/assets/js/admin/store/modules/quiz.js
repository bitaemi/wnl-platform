import axios from "axios";
import {set} from "vue";
import {getApiUrl} from "js/utils/env";
import {resource} from "js/utils/config";
import * as types from "js/admin/store/mutations-types";

// Helper functions

// Namespace
const namespaced = false

// Initial state
const state = {
	question: null,
	questionId: null,
	answers: null,
	slides: null
}

function getSlideshowId(screenId) {
	return axios.get(`/papi/v1/screens/${screenId}`)
		.then(response => {
			let resources = response.data.meta.resources
			let resourceName = resource('slideshows')
			let slideshowId

			Object.keys(resources).forEach((key) => {
				if (resources[key].name === resourceName) {
					slideshowId = resources[key].id
				}
			})

			return slideshowId
		})
}

function getSlideId(slideshowId, slideNumber) {
	const conditions = {
		query: {
			where: [
				['presentable_type', '=', 'App\\Models\\Slideshow'],
				['presentable_id', '=', slideshowId],
				['order_number', '=', slideNumber - 1],
			]
		}
	}
	return axios.post('/papi/v1/presentables/.search', conditions)
		.then(response => {
			return response.data[0].slide_id
		})
}

function getSlideData(slideId) {
	return axios.get(`/papi/v1/slides/${slideId}?include=context`);
}

function getEmptyAnswers(stateAnswers) {
	return [
		{
			text: '',
			is_correct: false
		},
		{
			text: '',
			is_correct: false
		},
		{
			text: '',
			is_correct: false
		},
		{
			text: '',
			is_correct: false
		},
		{
			text: '',
			is_correct: false
		}
	]
}

// Getters
const getters = {
	questionText: state => state.question ? state.question.text : '',
	questionExplanation: state => state.question ? state.question.explanation : '',
	questionAnswers: state => state.answers || getEmptyAnswers(),
	questionSlides: state => state.slides || [],
	questionAnswersMap: state => state.answersMap,
	questionId: state => state.question && state.question.id,
	questionTags: state => state.question ? state.question.tags : [],
	preserveOrder: state => state.question && state.question.preserve_order
}

function getSlidesArray(included = {}) {
	if (!included.slides) {
		return []
	} else {
		return Object.values(included.slides)
	}
}

// Mutations
const mutations = {
	[types.SETUP_QUIZ_QUESTION] (state, data) {
		const answersObject = data.included && data.included.quiz_answers || {}
		const answersArray = data.quiz_answers && data.quiz_answers.map(id => answersObject[id])

		set(state, 'question', data)
		set(state, 'answers', answersArray)
		set(state, 'slides', getSlidesArray(data.included))
		set(state, 'answersMap', answersObject)
	},
	[types.CLEAR_QUIZ_QUESTION] (state, data) {
		set(state, 'answers', getEmptyAnswers())
	}
}

// Actions
const actions = {
	getQuizQuestion({ commit }, id) {
		axios.get(getApiUrl(`quiz_questions/${id}?include=quiz_answers,slides`))
			.then((response) => {
				commit(types.SETUP_QUIZ_QUESTION, response.data)
			})
	},
	setupFreshQuestion({ commit }) {
		commit(types.CLEAR_QUIZ_QUESTION)
	},
	getSlideDataForQuizEditor({ commit }, { slideNumber, screenId }) {
		return getSlideshowId(screenId)
			.then(slideshowId => {
				return getSlideId(slideshowId, slideNumber)
			})
			.then(slideId => {
				return getSlideData(slideId)
			})
			.then(response => {
				return response.data
			})
			.catch(exception => {
				console.error(exception)
			})
	}
}

export default {
	namespaced,
	state,
	getters,
	mutations,
	actions
}
