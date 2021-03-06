<template>
	<div class="wnl-active-question">
		<p v-if="!isMobile" class="tip">{{$t('questions.solving.activeQuestionTip')}}</p>
		<div class="active-question-controls">
			<div class="widget-control">
				<a class="small unselectable" @click="previousQuestion()">
					<span class="icon is-small"><i class="fa fa-angle-left"></i></span> Poprzednie
				</a>
			</div>
			<div class="widget-control">
				{{$t('questions.solving.current', {number: questionNumber})}}
				<span class="matched-count">{{allQuestionsCount}}</span>
			</div>
			<div class="widget-control">
				<a class="small unselectable" @click="nextQuestion()">
					Następne <span class="icon is-small"><i class="fa fa-angle-right"></i></span>
				</a>
			</div>
		</div>
		<wnl-quiz-question
			v-if="question"
			:class="`quiz-question-${question.id}`"
			:id="question.id"
			:question="question"
			:showComments="displayResults"
			:getReaction="getReaction"
			:module="module"
			@selectAnswer="selectAnswer"
			@answerDoubleclick="onAnswerDoubleclick"
		/>
		<p class="active-question-button has-text-centered">
			<a v-if="!question.isResolved" class="button is-primary" :disabled="!hasAnswer" @click="verify">
				Sprawdź odpowiedź
			</a>
			<a v-else class="button is-primary is-outlined" @click="nextQuestion()">
				Następne
			</a>
		</p>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	.tip
		color: $color-gray-dimmed
		font-size: $font-size-minus-2
		margin-bottom: $margin-base

	.active-question-button
		margin-bottom: $margin-big * 6
		margin-top: -$margin-big

	.active-question-controls
		display: flex
		font-size: $font-size-base
		justify-content: space-between
		margin-bottom: $margin-base

	.matched-count
		color: $color-green
</style>

<script>
	import _ from 'lodash'
	import { mapGetters, mapActions } from 'vuex'

	import QuizQuestion from 'js/components/quiz/QuizQuestion.vue'
	import { scrollToElement } from 'js/utils/animations'
	import { swalConfig } from 'js/utils/swal'

	const KEYS = {
		leftArrow: 37,
		upArrow: 38,
		rightArrow: 39,
		downArrow: 40,
		enter: 13
	}

	export default {
		name: 'ActiveQuestion',
		components: {
			'wnl-quiz-question': QuizQuestion,
		},
		props: {
			allQuestionsCount: {
				default: 0,
				type: Number,
			},
			getReaction: {
				default: () => {},
				type: Function,
			},
			module: {
				type: String,
				default: 'questions'
			},
			question: {
				type: Object,
				default: {},
			},
			questionNumber: {
				type: Number,
				default: 0,
			},
		},
		data() {
			return {
				hasErrors: false,
				allowDoubleclick: true,
				timeout: 0,
			}
		},
		computed: {
			...mapGetters(['isMobile']),
			...mapGetters('questions', ['getQuestion']),
			hasAnswer() {
				return _.isNumber(this.question.selectedAnswer)
			},
			selectedAnswerIndex () {
				if (this.hasAnswer) {
					return this.question.selectedAnswer
				} else {
					return -1
				}
			},
			isSubmitDisabled() {
				return !this.hasAnswer
			},
			displayResults() {
				return this.question.isResolved
			},
		},
		methods: {
			nextQuestion() {
				this.$emit('changeQuestion', 1)
				scrollToElement(this.$el, 63)
			},
			onAnswerDoubleclick() {
				this.allowDoubleclick && this.displayResults && this.nextQuestion()
			},
			previousQuestion() {
				this.$emit('changeQuestion', -1)
				scrollToElement(this.$el, 63)
			},
			selectAnswer(data) {
				this.allowDoubleclick = false
				this.$emit('selectAnswer', data)
				this.timeout = setTimeout(() => {
					this.allowDoubleclick = true
				}, 500)
			},
			verify() {
				this.hasAnswer && this.$emit('verify', this.question.id)
			},
			keyDown(e) {
				if (e.keyCode === KEYS.leftArrow) {
					this.previousQuestion()
				}

				if (e.keyCode === KEYS.upArrow) {
					if(this.question.isResolved) {
						return false
					}
					if (this.selectedAnswerIndex < 1) {
						this.selectAnswer({id: this.question.id, answer: this.question.answers.length - 1})
					} else {
						this.selectAnswer({id: this.question.id, answer: this.selectedAnswerIndex - 1})
					}
					return false
				}

				if (e.keyCode === KEYS.rightArrow) {
					this.nextQuestion()
				}

				if (e.keyCode === KEYS.downArrow) {
					if(this.question.isResolved) {
						return false
					}
					if (this.selectedAnswerIndex > this.question.answers.length - 2) {
						this.selectAnswer({id: this.question.id, answer: 0})
					} else {
						this.selectAnswer({id: this.question.id, answer: this.selectedAnswerIndex + 1})
					}
					return false
				}

				if (e.keyCode === KEYS.enter) {
					if (this.question.isResolved) {
						this.nextQuestion()
					} else {
						this.verify()
					}
				}
			},
		},
		mounted() {
			window.addEventListener('keydown', this.keyDown)
		},
		beforeDestroy() {
			window.removeEventListener('keydown', this.keyDown)
		}
	}
</script>
