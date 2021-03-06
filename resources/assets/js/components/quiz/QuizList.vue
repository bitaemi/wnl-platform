<template>
	<div class="wnl-quiz-list" :class="{'has-errors': hasErrors, 'has-header': !plainList}">
		<p v-if="!plainList && isComplete" class="has-text-centered margin vertical">
			<a class="button is-primary is-outlined" @click="$emit('resetState')">Rozwiąż pytania ponownie</a>
		</p>

		<p class="title is-5" v-if="!plainList && !displayResults">Pozostało pytań: {{howManyLeft}}</p>
		<div class="question" v-for="(question, index) in questions" :key="index">
			<span class="question-number">
				{{index+1}}/{{questions.length}}
			</span>
			<wnl-quiz-question
				:module="module"
				:class="`quiz-question-${question.id}`"
				:question="question"
				:index="index"
				:isQuizComplete="isComplete"
				:key="question.id"
				:readOnly="readOnly"
				:getReaction="getReaction"
				@selectAnswer="onSelectAnswer"
			></wnl-quiz-question>
		</div>
		<p class="has-text-centered" v-if="!plainList && !displayResults">
			<a class="button is-primary" :class="{'is-loading': isProcessing}" @click="verify">
				Sprawdź wyniki
			</a>
			<p v-if="canEndQuiz && !displayResults" class="has-text-centered margin vertical">
				<a class="link" @click="$emit('checkQuiz', true)">Przerwij test i sprawdź wyniki</a>
			</p>
		</p>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	.wnl-quiz-list.has-header
		border-top: $border-light-gray
		margin: $margin-big 0
		padding-top: $margin-base

		.question
			display: flex
			flex-direction: column
			.question-number
				text-align: center

</style>

<script>
	import _ from 'lodash'
	import QuizQuestion from 'js/components/quiz/QuizQuestion.vue'
	import { scrollToElement } from 'js/utils/animations'
	import { swalConfig } from 'js/utils/swal'

	export default {
		name: 'QuizList',
		components: {
			'wnl-quiz-question': QuizQuestion,
		},
		props: ['readOnly', 'allQuestions', 'getReaction', 'module', 'isComplete', 'isProcessing', 'plainList', 'canEndQuiz'],
		data() {
			return {
				hasErrors: false,
			}
		},
		computed: {
			questions() {
				if (this.isComplete) {
					return this.allQuestions
				}

				return this.questionsUnresolved
			},
			questionsUnresolved() {
				return this.allQuestions.filter((question) => !question.isResolved)
			},
			questionsUnaswered() {
				return _.filter(this.allQuestions, (question) => {
					return !_.isNumber(question.selectedAnswer) && !question.isResolved
				})
			},
			displayResults() {
				return this.isComplete || this.readOnly || !this.allQuestions.length
			},
			howManyLeft() {
				return `${_.size(this.questionsUnresolved)}/${_.size(this.allQuestions)}`
			},
		},
		methods: {
			confirmQuizEnd(unanswered) {
				const config = swalConfig({
					confirmButtonText: this.$t('questions.solving.confirm.yes'),
					cancelButtonText: this.$t('questions.solving.confirm.no'),
					reverseButtons: true,
					showCancelButton: true,
					showConfirmButton: true,
					text: this.$t('questions.solving.confirm.unanswered', {
						count: unanswered
					}),
					title: this.$t('questions.solving.confirm.title'),
					type: 'question',
				})

				return new Promise((resolve, reject) => {
					this.$swal(config)
						.then(() => resolve(), (dismiss) => {
							if (dismiss==='cancel') {
								reject()
							}
						})
						.catch(e => reject())
				})
			},
			verify() {
				const unanswered = this.questionsUnaswered.length
				if (!this.plainList && unanswered > 0) {
					this.hasErrors = true

					this.confirmQuizEnd(unanswered)
						.then(() => false)
						.catch(() => this.$emit('checkQuiz', true))

					this.scrollToFirstUnanswered()
					return false
				}

				this.hasErrors = false
				this.$emit('checkQuiz')
			},
			onSelectAnswer(data) {
				this.$emit('selectAnswer', data)
			},
			scrollToFirstUnanswered() {
				const id = _.head(this.questionsUnaswered).id
				scrollToElement(document.querySelector(`.quiz-question-${id}`))
			},
		},
	}
</script>
