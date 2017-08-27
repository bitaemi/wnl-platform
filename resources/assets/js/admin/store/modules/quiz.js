import _ from 'lodash'
import axios from 'axios'
import { set } from 'vue'
import { getApiUrl } from 'js/utils/env'
import { resource } from 'js/utils/config'
import * as types from 'js/admin/store/mutations-types'

// Helper functions

// Namespace
const namespaced = false

// Initial state
const state = {
	question: null,
	answers: null
}

// Getters
const getters = {
	questionText: state => state.question && state.question.text,
	questionAnswers: state => state.answers
}

// Mutations
const mutations = {
	[types.SETUP_QUIZ_QUESTION] (state, data) {
		const answersObject = data.included['quiz_answers']
		const answersArray = Object.keys(answersObject).map(key => answersObject[key])

		set(state, 'question', data)
		set(state, 'answers', answersArray)
	}
}

// Actions
const actions = {
	getQuizQuestion({ commit, getters }, id) {
		axios.get(getApiUrl(`quiz_questions/${id}?include=quiz_answers`))
			.then((response) => {
				commit(types.SETUP_QUIZ_QUESTION, response.data)
			})
	},
	saveQuestion({ commit }) {
		axios.post(getApiUrl('questions'))
			.then((response) => {
				commit(types.SETUP_LESSONS, response.data)
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
