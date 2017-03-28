<template>
	<div class="wnl-lesson">
		<keep-alive>
			<router-view></router-view>
		</keep-alive>
		<wnl-qna :lessonId="lessonId"></wnl-qna>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'
	import { resource } from 'js/utils/config'
	import  Qna from './../qna/Qna.vue'

	export default {
		name: 'Lesson',
		props: ['courseId', 'lessonId', 'screenId'],
		computed: {
			...mapGetters([
				'getScreens',
				'progressGetSavedLesson',
			]),
			firstScreenId() {
				if (typeof this.getScreens(this.lessonId) !== 'undefined') {
					return parseInt(this.getScreens(this.lessonId)[0])
				}
			},
			lastScreenId() {
				if (typeof this.getScreens(this.lessonId) !== 'undefined') {
					return parseInt(this.getScreens(this.lessonId).slice(-1)[0])
				}
			},
			lessonProgressContext() {
				return {
					courseId: this.courseId,
					lessonId: this.lessonId,
					route: {
						name: this.$route.name,
						params: this.$route.params,
						query: this.$route.query,
						meta: this.$route.meta,
					},
				}
			},
		},
		methods: {
			...mapActions([
				'progressStartLesson',
				'progressUpdateLesson',
				'progressCompleteLesson',
			]),
			startLesson() {
				console.log(`Starting lesson ${this.lessonId}`)
				this.progressStartLesson(this.lessonProgressContext)
				this.goToDefaultScreenIfNone()
			},
			goToDefaultScreenIfNone() {
				if (!this.screenId) {
					let savedRoute = this.progressGetSavedLesson(this.courseId, this.lessonId)
					if (typeof savedRoute !== 'undefined' && savedRoute.hasOwnProperty('name')) {
						this.$router.replace(savedRoute)
					} else if (typeof this.firstScreenId !== 'undefined') {
						this.$router.replace({ name: resource('screens'), params: {
							courseId: this.courseId,
							lessonId: this.lessonId,
							screenId: this.firstScreenId,
						} })
					}
				}
			},
			updateLessonProgress() {
				if (typeof this.screenId !== 'undefined') {
					if (parseInt(this.screenId) === this.lastScreenId) {
						console.log(`Marking lesson ${this.lessonId} as complete`)
						this.progressCompleteLesson(this.lessonProgressContext)
					}
					this.progressUpdateLesson(this.lessonProgressContext)
				}
			},
		},
		mounted () {
			this.startLesson()
		},
		watch: {
			'$route' (to, from) {
				this.goToDefaultScreenIfNone()
				this.updateLessonProgress()
			}
		},
		components: {
			'wnl-qna': Qna,
		},
	}
</script>