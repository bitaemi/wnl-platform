import _ from 'lodash'
import axios from 'axios'
import * as types from '../mutations-types'
import {getApiUrl} from 'js/utils/env'
import {mockData} from 'js/store/modules/qnaMockData'
import {set} from 'vue'

// API
/**
 * @param lessonId
 * @returns {Promise}
 * @private
 */
function _getQuestions(lessonId) {
	return axios.get(getApiUrl(`lessons/${lessonId}?include=qna_questions`))
}

/**
 * @param questionId
 * @returns {Promise}
 * @private
 */
function _getQuestion(questionId) {
	return axios.get(getApiUrl(`qna_questions/${questionId}?include=profiles,qna_answers.profiles,qna_answers.comments`))
}

/**
 * @param answerId
 * @returns {Promise}
 * @private
 */
function _getComments(answerId) {
	return axios.get(getApiUrl(`qna_answers/${answerId}?include=comments.profiles`))
}

/**
 * @param lessonId
 * @param text
 * @returns {Promise}
 * @private
 */
function _postQuestion(lessonId, text) {
	return axios.post(getApiUrl(`questions`), {lessonId, text})
}

/**
 * @param questionId
 * @param text
 * @returns {Promise}
 * @private
 */
function _postAnswer(questionId, text) {
	return axios.post(getApiUrl(`answers`), {questionId, text})
}

/**
 * @param answerId
 * @returns {Promise}
 * @private
 */
function _getAnswer(answerId) {
	return axios.get(getApiUrl(`answers/${answerId}?include=users`))
}

const namespaced = true

// Initial state
const state = {
	loading: true,
	questionsIds: [],
	qna_questions: {},
	qna_answers: {},
	comments: {},
	profiles: {},
}

// Getters
const getters = {
	sortedQuestions: state => {
		return state.questionsIds.map((id) => state.qna_questions[id])
	},



	qnaGetMockData: state => (lessonId) => {
		return mockData[lessonId]
	},
	qnaGetQuestions: state => (lessonId) => {
		try {
			return state.questions[lessonId].included.questions
		}
		catch (e) {
			return false
		}
	},
	qnaGetUser: state => (lessonId, userId) => {
		return state.questions[lessonId].included.users[userId]
	},
	qnaGetAnswers: state => (lessonId, ids) => {
		let answers = {}
		ids.forEach((id) => {
			answers[id] = state.questions[lessonId].included.answers[id]
		})
		return answers
	}
}

// Mutations
const mutations = {
	[types.IS_LOADING] (state, isLoading) {
		set(state, 'loading', isLoading)
	},
	[types.QNA_SET_QUESTIONS_IDS] (state, questionsIds) {
		set(state, 'questionsIds', questionsIds)
	},
	[types.QNA_UPDATE_QUESTION] (state, payload) {
		let id = payload.questionId, data = payload.data

		set(state.qna_questions, id, _.merge(state.qna_questions[id], data))
	},
	[types.UPDATE_INCLUDED] (state, included) {
		_.each(included, (items, resource) => {
			set(state, resource, _.merge(state[resource], items))
		})
	},


	[types.QNA_ADD_QUESTION] (state, payload) {
		set(state.questions[payload.lessonId].included.questions, payload.data.id, payload.data)
	},
	[types.QNA_ADD_ANSWER] (state, payload) {
		set(state.questions[payload.lessonId].included.answers, payload.data.id, payload.data)
		state.questions[payload.lessonId].included.questions[payload.questionId].answers.push(payload.data.id)
	},
}

// Actions
const actions = {
	qnaGetMockData(lessonId) {
		return mockData[lessonId]
	},
	fetchQuestions({commit, rootState}) {
		let lessonId = rootState.route.params.lessonId

		// TODO: Error when lessonId is not defined

		return new Promise((resolve, reject) => {
			_getQuestions(lessonId)
				.then((response) => {
					let data = response.data
					if (data.qna_questions.length > 0) {
						commit(types.UPDATE_INCLUDED, data.included)
						commit(types.QNA_SET_QUESTIONS_IDS, data.qna_questions)
					}
					resolve()
				})
				.catch((error) => {
					$wnl.logger.error(error)
					reject()
				})
		})
	},
	fetchQuestion({commit}, questionId) {
		_getQuestion(questionId)
			.then((response) => {
				let data = response.data,
					included = data.included

				delete(data.included)
				commit(types.QNA_UPDATE_QUESTION, {questionId, data})

				if (data.qna_answers.length > 0) {
					commit(types.UPDATE_INCLUDED, included)
				}
			})
			.catch((error) => {
				$wnl.logger.error(error)
			})
	},

	/**
	 * @param commit
	 * @param lessonId
	 * @returns {Promise}
	 */
	qnaSetQuestions({commit}, lessonId) {
		return new Promise((resolve) => {
			_getQuestions(lessonId).then((response) => {
				commit(types.QNA_SET_QUESTIONS_IDS, {lessonId, data: response.data})
				resolve()
			})
		})
	},
	qnaAddQuestion({commit}, {lessonId, text}){
		return new Promise((resolve, reject) => {
			_postQuestion(lessonId, text).then((response) => {
				if (response.status === 201) {
					_getQuestion(response.data.id).then((response) => {
						commit(types.QNA_ADD_QUESTION, {lessonId, data: response.data})
						resolve()
					})
				} else {
					reject()
				}
			})
		})
	},
	qnaAddAnswer({commit}, {lessonId, questionId, text}){
		return new Promise((resolve, reject) => {
			_postAnswer(questionId, text).then((response) => {
				if (response.status === 201) {
					_getAnswer(response.data.id).then((response) => {
						commit(types.QNA_ADD_ANSWER, {lessonId, questionId, data: response.data})
						resolve()
					})
				} else {
					reject()
				}
			})
		})
	},
}

export default {
	actions,
	getters,
	mutations,
	namespaced,
	state,
}
