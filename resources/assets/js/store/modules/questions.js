import {set, delete as destroy} from 'vue'
import {get, isEqual, isEmpty, isNumber, merge, size} from 'lodash'
import * as types from '../mutations-types'
import {getApiUrl} from 'js/utils/env'
import axios from 'axios'
import moment from 'moment'
import {commentsGetters, commentsMutations, commentsActions} from 'js/store/modules/comments'
import {reactionsGetters, reactionsMutations, reactionsActions} from 'js/store/modules/reactions'


const namespaced = true

const FILTER_TYPES = {
	BOOLEAN: 'boolean',
	LIST: 'list',
	TAGS: 'tags',
}

const LIMIT = 25

// Initial state
const state = {
	activeFilters: [],
	comments: {},
	currentQuestion: {
		index: 0,
		page: 0,
	},
	filters: {},
	questionsPages: {
		// {pageNumber} => []
	},
	quiz_questions: {},
	profiles: {},
	results: false,
	testQuestions: [],
}

// Getters
const getters = {
	...commentsGetters,
	...reactionsGetters,
	activeFilters: state => state.activeFilters,
	activeFiltersObjects: state => {
		return isEmpty(state.filters)
			? []
			: state.activeFilters.map(path => get(state.filters, path))
	},
	activeFiltersValues: state => {
		return isEmpty(state.filters)
			? []
			: state.activeFilters.map(path => get(state.filters, path).value)
	},
	allQuestionsCount: state => state.allCount,
	currentQuestion: state => {
		if (isEmpty(state.questionsPages) || !state.currentQuestion.page) return {}
		const {page, index} = state.currentQuestion
		let computedIndex = index

		if (index === -1) computedIndex = state.questionsPages[page].length - 1

		return {page, index: computedIndex, ...state.quiz_questions[state.questionsPages[page][computedIndex]]}
	},
	filters: state => {
		const order = [
			// 'quiz-planned',
			'quiz-resolution',
			'by_taxonomy-subjects',
			'by_taxonomy-exams',
		]

		let filters = {}
		order.forEach(group => {
			if (state.filters.hasOwnProperty(group)) {
				filters[group] = state.filters[group]
			}
		})

		return state.filters
	},
	getQuestion: state => questionId => state.quiz_questions[questionId],
	getSafePage: state => page => {
		return page > state.last_page ? state.last_page : page
	},
	getPage: (state, getters) => page => {
		return state.questionsPages[getters.getSafePage(page)];
	},
	matchedQuestionsCount: state => state.total,
	meta: state => ({
		lastPage: state.last_page,
		currentPage: state.current_page,
		perPage: state.per_page,
	}),
	questions: state => state.quiz_questions,
	questionsList: state => Object.values(state.quiz_questions || {}),
	questionsCurrentPage: state => {
		const ids = state.questionsPages[state.current_page]

		return isEmpty(ids) ? [] : ids.map(id => state.quiz_questions[id])
	},
	results: state => state.results,
	testQuestions: state => state.testQuestions.map(id => state.quiz_questions[id]),
	testQuestionsUnanswered: (state, getters) => getters.testQuestions.filter(question => {
		return !isNumber(question.selectedAnswer)
	})
}

// Mutations
const mutations = {
	...commentsMutations,
	...reactionsMutations,
	[types.ACTIVE_FILTERS_ADD] (state, filter) {
		if (state.activeFilters.indexOf(filter) === -1) {
			state.activeFilters.push(filter)
		}
	},
	[types.ACTIVE_FILTERS_SET] (state, filters) {
		set(state, 'activeFilters', filters)
	},
	[types.ACTIVE_FILTERS_REMOVE] (state, filter) {
		const index = state.activeFilters.indexOf(filter)
		if (index > -1) {
			state.activeFilters.splice(index, 1)
		}
	},
	[types.ACTIVE_FILTERS_RESET] (state, payload) {
		state.activeFilters = []
	},
	[types.QUESTIONS_DYNAMIC_FILTERS_SET] (state, data) {
		set(state, 'filters', data)
	},
	[types.QUESTIONS_RESET_TEST] (state) {
		set(state, 'testQuestions', [])
	},
	[types.QUESTIONS_RESET_PAGES] (state) {
		set(state, 'questionsPages', {})
	},
	[types.QUESTIONS_RESOLVE_QUESTION] (state, questionId) {
		set(state.quiz_questions[questionId], 'isResolved', true)
	},
	[types.QUESTIONS_SELECT_ANSWER] (state, payload) {
		set(state.quiz_questions[payload.id], 'selectedAnswer', payload.answer)
	},
	[types.QUESTIONS_SET_CURRENT] (state, {page, index}) {
		set(state, 'currentQuestion', {page, index})
	},
	[types.QUESTIONS_SET_META] (state, meta) {
		Object.keys(meta).forEach((key) => {
			set(state, key, meta[key])
		})
	},
	[types.QUESTIONS_SET_QUESTION_DATA] (state, {id, included, comments, slides}) {
		if (_.size(included) === 0) return

		comments && set(state.quiz_questions[id], 'comments', comments)

		let {quiz_answers, slides: includedSlides, ...resources} = included

		if (includedSlides) {
			set(state.quiz_questions[id], 'slides', slides.map((slideId) => includedSlides[slideId]))
		}

		_.each(resources, (items, resource) => {
				let resourceObject = state[resource]
			_.each(items, (item, index) => {
				set(resourceObject, item.id, item)
			})
		})
	},
	[types.QUESTIONS_SET_PAGE] (state, page) {
		set(state, 'current_page', page)
	},
	[types.QUESTIONS_SET_TEST] (state, {questions, answers, slides}) {
		let testQuestions = []

		questions.forEach(question => {
			testQuestions.push(question.id)

			set(state.quiz_questions, question.id, {
				...question,
				answers: question.quiz_answers.map(id => answers[id]),
				slides: (question.slides || []).map((slideId) => slides[slideId]),
				selectedAnswer: false,
				isResolved: false,
			})
		})

		set(state, 'testQuestions', testQuestions)
	},
	[types.QUESTIONS_SET_WITH_ANSWERS] (state, {questions, answers, page}) {
		const pageIds = []

		questions.forEach(question => {
			pageIds.push(question.id)

			set(state.quiz_questions, question.id, {
				...question,
				answers: question.quiz_answers.map(id => answers[id]),
				selectedAnswer: false,
				isResolved: false,
			})
		})

		set(state.questionsPages, page, pageIds)
	},
	[types.QUESTIONS_UPDATE] (state, {data: questions}) {
		questions.forEach(question => {
			const original = state.quiz_questions[question.id]
			set(state.quiz_questions, question.id, {...original, ...question})
		})
	},
	[types.UPDATE_INCLUDED] (state, included) {
		_.each(included, (items, resource) => {
			let resourceObject = state[resource]
			_.each(items, (item, index) => {
				set(resourceObject, item.id, item)
			})
		})
	},
}

// Actions
const actions = {
	...commentsActions,
	...reactionsActions,
	activeFiltersSet({commit}, filters) {
		commit(types.ACTIVE_FILTERS_SET, filters)
	},
	activeFiltersToggle({commit}, {filter, active}) {
		return new Promise(resolve => {
			if (!filter) return resolve()

			if (active) {
				commit(types.ACTIVE_FILTERS_ADD, filter)
			} else {
				commit(types.ACTIVE_FILTERS_REMOVE, filter)
			}
			resolve()
		})
	},
	activeFiltersReset({commit}) {
		commit(types.ACTIVE_FILTERS_RESET)
	},
	buildPlan({state, getters, rootGetters, commit}, data) {
		data.filters = _parseFilters(data.activeFilters, state, getters, rootGetters);
		return axios.post(getApiUrl(`user_plan/${rootGetters.currentUserId}`), data)
	},
	changeCurrentQuestion({state, getters, commit}, {page, index}) {
		return new Promise((resolve, reject) => {
			commit(types.QUESTIONS_SET_CURRENT, {page, index})
			return resolve(getters.currentQuestion)
		})
	},
	checkQuestions({commit, getters, dispatch}, meta) {
		const results = {
				unanswered: [],
				incorrect: [],
				correct: []
			},
			questionsToStore = []

		getters.testQuestions.forEach((question) => {
			if (!isNumber(question.selectedAnswer)) {
				return results.unanswered.push(question)
			}
			const selectedAnswer = question.answers[question.selectedAnswer]

			selectedAnswer.is_correct ? results.correct.push(question) : results.incorrect.push(question)

			questionsToStore.push(question.id)
			dispatch('resolveQuestion', question.id)
		})

		dispatch('saveQuestionsResults', {questions: questionsToStore, meta})

		// I'm not updating store on puropose - not sure if we want to keep results in VUEX store
		// if we decide to keep them here we need to remember about clearing them when exiting the "TEST MODE"
		// commit(types.QUESTIONS_SET_RESULTS, results)

		return Promise.resolve(results)
	},
	fetchDynamicFilters({commit, getters, rootGetters}) {
		const parsedFilters = _parseFilters(getters.activeFilters, state, getters, rootGetters)
		return _fetchDynamicFilters({filters: parsedFilters})
			.then(({data}) => {
				commit(types.QUESTIONS_DYNAMIC_FILTERS_SET, data)
			})
	},
	fetchQuestions({commit, state, getters, rootGetters},
		{filters, page, useSavedFilters, doNotSaveFilters}
	) {
		const parsedFilters = _parseFilters(filters, state, getters, rootGetters)

		return _fetchQuestions({
			active: filters,
			doNotSaveFilters,
			filters: parsedFilters,
			include: 'quiz_answers',
			page,
			useSavedFilters,
		}).then(function (response) {
			const {answers, questions, meta, included} = _handleResponse(response, commit)

			commit(types.QUESTIONS_SET_WITH_ANSWERS, {
				answers,
				questions,
				page: meta.current_page,
			})
			commit(types.QUESTIONS_SET_META, meta)
			commit(types.UPDATE_INCLUDED, included)

			if (!isEmpty(meta.active)) {
				commit(types.ACTIVE_FILTERS_SET, meta.active)
			}

			return response
		})
	},
	fetchQuestionsCount({commit}) {
		return axios.get(getApiUrl('quiz_questions/.count'))
			.then(({data}) => {
				commit(types.QUESTIONS_SET_META, {allCount: data.count})
			})
	},
	fetchQuestionData({commit, dispatch}, id) {
		return _fetchQuestionsData(id)
			.then(({data}) => {
				_.get(data, 'included.comments') && dispatch('comments/setComments', data.included.comments, {root:true})
				commit(types.QUESTIONS_SET_QUESTION_DATA, data)
			})
	},
	fetchQuestionsReactions({commit}, questionsIds) {
		return _fetchQuestions({
			filters: [
				{
					query: {
						whereIn: ['id', questionsIds || []],
					}
				}
			],
			include: 'reactions'
		}).then(({data}) => commit(types.QUESTIONS_UPDATE, data))
	},
	fetchPage({state, commit, dispatch}, page) {
		return new Promise(resolve => {
			return dispatch('fetchQuestions', {filters: state.activeFilters, page})
				.then(response => resolve(response))
		})
	},
	fetchTestQuestions({commit, state, getters, rootGetters}, {activeFilters, count: limit}) {
		const filters = _parseFilters(activeFilters, state, getters, rootGetters)

		return _fetchQuestions({
			filters,
			limit,
			randomize: true,
			include: 'quiz_answers,reactions,comments.profiles,slides'
		}).then(response => {
			const {answers, questions, slides, included} = _handleResponse(response, commit)

			commit(types.QUESTIONS_SET_TEST, {answers, questions, slides})
			commit(types.UPDATE_INCLUDED, included)

			return response
		})
	},
	saveQuestionsResults({commit, getters, rootGetters, state}, {questions, meta={}}) {
		const results = questions.map((questionId) => {
			const question = getters.getQuestion(questionId)

			if (!question.hasOwnProperty('selectedAnswer')) return
			if (!question.answers.hasOwnProperty(question.selectedAnswer)) return

				return {
					questionId,
					answerId: question.answers[question.selectedAnswer].id
				}
			}).filter((result) => result)

		const filters = _parseFilters(getters.activeFilters, state, getters, rootGetters)

		axios.post(getApiUrl(`quiz_results/${rootGetters.currentUserId}`), {results, meta: {...meta, filters}})
	},
	savePosition({getters, rootGetters, state}, payload) {
		const parsedFilters = _parseFilters(getters.activeFilters, state, getters, rootGetters)

		axios.put(getApiUrl(`users/${rootGetters.currentUserId}/state/quizPosition`), {
			...payload,
			filters: parsedFilters
		})
	},
	getPosition({getters, rootGetters, state}) {
		const parsedFilters = _parseFilters(getters.activeFilters, state, getters, rootGetters)

		return axios.post(getApiUrl(`users/${rootGetters.currentUserId}/state/quizPosition`),{filters: parsedFilters})
	},
	selectAnswer({commit}, payload) {
		commit(types.QUESTIONS_SELECT_ANSWER, payload)
	},
	setPage({commit}, page) {
		commit(types.QUESTIONS_SET_PAGE, page)
	},
	resolveQuestion({commit}, questionId) {
		commit(types.QUESTIONS_RESOLVE_QUESTION, questionId)
	},
	resetCurrentQuestion({commit}) {
		commit(types.QUESTIONS_SET_CURRENT, {index: 0, page: 1})
	},
	resetPages({commit}) {
		commit(types.QUESTIONS_RESET_PAGES)
	},
	resetTest({commit}) {
		commit(types.QUESTIONS_RESET_TEST)
	},
	deleteProgress({commit, rootGetters}) {
		return axios.delete(getApiUrl(`quiz_results/${rootGetters.currentUserId}`))
	}
}


const _fetchQuestions = (requestParams) => {
	return axios.post(getApiUrl('quiz_questions/.filter'), requestParams)
}

const _fetchQuestionsData = (id) => {
	return axios.get(getApiUrl(`quiz_questions/${id}?include=comments.profiles,slides,comments.reactions`))
}

const _fetchDynamicFilters = (activeFilters) => {
	return axios.post(getApiUrl('quiz_questions/.filterList'), activeFilters)
}

const _parseFilters = (activeFilters, state, getters, rootGetters) => {
	const filters        = []
	const groupedFilters = {}

	activeFilters.forEach((path, index) => {
		const [filterGroup, ...tail] = path.split('.')
		const filterValue            = get(state.filters, path).value
		const filterType             = state.filters[filterGroup].type

		groupedFilters[filterGroup] = groupedFilters[filterGroup] || []
		groupedFilters[filterGroup].push(filterValue)
	})

	Object.keys(groupedFilters).forEach((group) => {
		if (state.filters[group].type === FILTER_TYPES.TAGS) {
			filters.push({[group]: groupedFilters[group]})
		} else if (state.filters[group].type === FILTER_TYPES.LIST) {
			filters.push({
				[group]: {
					user_id: rootGetters.currentUserId,
					date: moment().subtract(3, 'hours').format('YYYY-MM-DD'),
					list: groupedFilters[group]
				}
			})
		}
	})

	return filters;
}

const _handleResponse = (response) => {
	var {data: {data, ...meta}} = response,
		quizQuestions           = {},
		quiz_answers            = {},
		slides                  = {},
		included                = {}

	if (size(data) > 0) {
		// this var is here on purpose due to error in babel and problems with spread operator :(
		var {included: {quiz_answers, slides, ...included}, ...quizQuestions} = data
	}

	return {
		answers: quiz_answers,
		slides,
		included,
		meta,
		questions: Object.values(quizQuestions),
	}
}

export default {
	actions,
	getters,
	mutations,
	namespaced,
	state,
}
