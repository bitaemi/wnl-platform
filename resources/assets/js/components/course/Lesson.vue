<template>
	<div class="scrollable-main-container" :style="{height: `${elementHeight}px`}">
		<div class="wnl-lesson" v-if="isLessonAvailable(lesson.id)">
			<div class="wnl-lesson-view">
				<div class="level wnl-screen-title">
					<div class="level-left">
						<div class="level-item metadata">
							{{lessonName}}
						</div>
					</div>
					<div class="level-right">
						<div class="level-item small">
							Lekcja {{lessonNumber}}
						</div>
					</div>
				</div>
				<router-view/>
			</div>
			<div class="wnl-lesson-previous-next-nav">
				<wnl-previous-next></wnl-previous-next>
			</div>
		</div>
		<div v-else>
			<h3 class="has-text-centered">O nie! Ta lekcja nie jest jeszcze dostępna!</h3>
			<p class="has-text-centered margin vertical">
				<img src="https://media.giphy.com/media/MQEBfbPco0fao/giphy.gif"></img>
			</p>
			<p class="has-text-centered">
				<router-link to="/" class="button is-outlined is-primary">Wróć do auli</router-link>
			</p>
		</div>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	$previous-next-height: 45px

	.wnl-lesson
		width: 100%

	.wnl-lesson-view
		padding-bottom: calc(2 * #{$previous-next-height})

	.wnl-lesson-previous-next-nav
		background: $color-white
		bottom: 0
		height: $previous-next-height
		left: 0
		right: 0
		position: absolute

	.wnl-screen-title
		padding-bottom: $margin-base
</style>

<script>
	import _ from 'lodash'
	import Breadcrumbs from 'js/components/global/Breadcrumbs'
	import PreviousNext from 'js/components/course/PreviousNext'
	import {mapGetters, mapActions} from 'vuex'
	import {resource} from 'js/utils/config'
	import {breadcrumb} from 'js/mixins/breadcrumb'
	import Qna from 'js/components/qna/Qna.vue'
	import {STATUS_COMPLETE, STATUS_IN_PROGRESS} from 'js/services/progressStore';

	export default {
		name: 'Lesson',
		components: {
			'wnl-previous-next': PreviousNext,
			'wnl-breadcrumbs': Breadcrumbs,
		},
		mixins: [breadcrumb],
		props: ['courseId', 'lessonId', 'presenceChannel', 'screenId', 'slide'],
		data() {
			return {
				/**
				 * elementHeight is used to prevent Safari from expanding
				 * a container with an overflow-y: auto and height: 100%.
				 * Using a specific height, the height of the parent element
				 * (which btw is defined as 100% of its parent element),
				 * all browsers are able to beautifully scroll the content.
				 */
				elementHeight: _.get(this.$parent, '$el.offsetHeight') || '100%'
			}
		},
		computed: {
			...mapGetters('course', [
				'getScreens',
				'getLesson',
				'getSections',
				'getSubsections',
				'getScreen',
				'getScreenSectionsCheckpoints',
				'getSectionSubsectionsCheckpoints',
				'isLessonAvailable',
			]),
			...mapGetters('progress', {
				getSavedLesson: 'getSavedLesson',
				screenProgress: 'getScreen',
				lessonProgress: 'getLesson'
			}),
			breadcrumb() {
				return {
					level: 1,
					text: this.lessonName,
					to: {
						name: 'lessons',
						params: {
							courseId: this.courseId,
							lessonId: this.lessonId,
						}
					}
				}
			},
			lesson() {
				return this.getLesson(this.lessonId)
			},
			lessonName() {
				return this.lesson && this.lesson.name
			},
			lessonNumber() {
				return this.lesson.order_number
			},
			screens() {
				return this.getScreens(this.lessonId)
			},
			currentScreen() {
				return this.getScreen(this.screenId);
			},
			currentSection() {
				return this.sectionsReversed.find((section) => this.slide >= section.slide);
			},
			currentSubsection() {
				return this.subsectionsReversed.find((subsection) => this.slide >= subsection.slide);
			},
			sectionsReversed() {
				const sectionsIds = _.get(this.currentScreen, 'sections', []);
				const sections = this.getSections(sectionsIds);

				// map needed because reverse modifies intial array
				return sections.map(el => el).reverse();
			},
			subsectionsReversed() {
				const subsectionsIds = _.get(this.currentSection, 'subsections', []);
				const subsections = this.getSubsections(subsectionsIds);

				// map needed because reverse modifies intial array
				return subsections.map(el => el).reverse();
			},
			hasSubsections() {
				return this.subsectionsReversed.length > 0
			},
			firstScreenId() {
				if (_.isEmpty(this.screens)) {
					return null
				}

				return _.head(this.screens).id
			},
			lessonProgressContext() {
				return {
					courseId: this.courseId,
					lessonId: this.lessonId,
					screenId: this.screenId,
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
			...mapActions('progress', [
				'startLesson',
				'completeLesson',
				'completeScreen',
				'completeSection',
				'completeSubsection',
				'saveLessonProgress',
			]),
			...mapActions([
				'updateLessonNav',
			]),
			...mapActions('users', ['setActiveUsers', 'userJoined', 'userLeft']),
			launchLesson() {
				this.startLesson(this.lessonProgressContext).then(() => {
					this.goToDefaultScreenIfNone()
				});

				window.Echo.join(this.presenceChannel)
					.here(users => this.setActiveUsers({users, channel: this.presenceChannel}))
					.joining(user => this.userJoined({user, channel: this.presenceChannel}))
					.leaving(user => this.userLeft({user, channel: this.presenceChannel}))
			},
			goToDefaultScreenIfNone() {
				const query = this.$route.query || {}

				if (!this.screenId) {
					this.getSavedLesson(this.courseId, this.lessonId)
						.then(({route, status}) => {
							if (this.firstScreenId && (!route || status === STATUS_COMPLETE || route && route.name !== resource('screens'))) {
								const params = {
									courseId: this.courseId,
									lessonId: this.lessonId,
									screenId: this.firstScreenId,
								};
								if (this.getScreen(this.firstScreenId) && this.getScreen(this.firstScreenId).type === 'slideshow' && !_.get(route, 'params.slide')) {
									params.slide = 1;
								}
								this.$router.replace({name: resource('screens'), params, query})
							} else if (route && route.hasOwnProperty('name')) {
								this.$router.replace({...route, query})
							}
						});
				} else if (this.screenId && !this.slide) {
					const params = {
						courseId: this.courseId,
						lessonId: this.lessonId,
						screenId: this.screenId,
					};

					if (this.currentScreen.type === 'slideshow') {
						params.slide = 1;
					}
					this.$router.replace({name: resource('screens'), params, query})
				}

				this.updateLessonNav({
					activeSection: (this.currentSection && this.currentSection.id) || 0,
					activeSubsection: (this.currentSubsection && this.currentSection.id) || 0,
					activeScreen: parseInt(this.screenId)
				});
			},
			shouldCompleteScreen() {
				if (!this.currentScreen.sections) {
					return true;
				}

				const allSections = this.currentScreen.sections;
				const completedSections = _.get(this.screenProgress(this.courseId, this.lessonId, this.currentScreen.id), 'sections', {});

				return !allSections.find(id => !completedSections[id]);
			},
			shouldCompleteLesson() {
				const startedScreens = _.get(this.lessonProgress(this.courseId, this.lessonId), 'screens', {});

				if (this.screens && !startedScreens) {
					return false;
				}

				return !this.screens.find(({id}) => {
					return !startedScreens[id] || startedScreens[id].status === STATUS_IN_PROGRESS;
				});
			},
			updateLessonProgress() {
				if (typeof this.screenId !== 'undefined') {
					if (this.currentSection) {
						if (this.getScreenSectionsCheckpoints(this.screenId).includes(this.slide)) {
							this.completeSection({...this.lessonProgressContext, sectionId: this.currentSection.id})
						}
					}

					if (this.currentSubsection) {
						if (this.getSectionSubsectionsCheckpoints(this.currentSection.id).includes(this.slide)) {
							this.completeSubsection({...this.lessonProgressContext, sectionId: this.currentSection.id, subsectionId: this.currentSubsection.id})
						}
					}

					if (this.shouldCompleteScreen()) {
						this.completeScreen(this.lessonProgressContext);

						if (this.shouldCompleteLesson()) {
							this.completeLesson(this.lessonProgressContext)
						}
					}

					this.updateLessonNav({
						activeSection: (this.currentSection && this.currentSection.id) || 0,
						activeSubsection: parseInt(this.currentSubsection && this.currentSubsection.id,) || 0,
						activeScreen: parseInt(this.screenId) || 0,
					})
				}
			},
			updateElementHeight() {
				this.elementHeight = this.$parent.$el.offsetHeight
			},
		},
		mounted () {
			this.launchLesson()
			window.addEventListener('resize', this.updateElementHeight)
		},
		beforeDestroy () {
			window.Echo.leave(this.presenceChannel)
			window.removeEventListener('resize', this.updateElementHeight)
		},
		watch: {
			'$route' () {
				this.goToDefaultScreenIfNone()
				this.updateLessonProgress()
			}
		},
	}
</script>
