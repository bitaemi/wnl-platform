<template>
	<div class="wnl-screen-html">
		<div class="content" v-html="content"></div>
		<div class="margin vertical has-text-centered">
			{{this.$t('annotations.mockExamAnnotation')}}
		</div>
		<p class="margin vertical has-text-centered">
			<router-link :to="routeParams" class="button is-primary">
				{{this.$t('questions.nav.mockExam')}}!
			</router-link>
		</p>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass">
	@import 'resources/assets/sass/variables'

	.wnl-screen-html
		margin: $margin-big 0
</style>

<script>
	import _ from 'lodash'

	export default {
		name: 'MockExam',
		props: ['screenData', 'showBacklink'],
		computed: {
			content() {
				return this.screenData.content
			},
			examTagId() {
				if (!this.screenData.meta.resources) return 0

				const exam = this.screenData.meta.resources.find(resource => {
					return resource.name === 'exam_tag_id'
				}) || {}

				return exam.id || 0
			},
			routeParams() {
				return {
					name: 'questions-list',
					params: {
						presetOptions: {
							activeView: 'test',
							canChangeTime: false,
							loadingText: 'mockExam',
							sizesToChoose: [200],
							testQuestionsCount: 200,
							time: 240,
							examMode: true,
							examTagId: this.examTagId
						},
					},
				}
			},
		},
		methods: {
			wrapEmbedded() {
				let iframes = this.$el.getElementsByClassName('ql-video'),
					wrapperClass = 'ratio-16-9-wrapper'

				if (iframes.length > 0) {
					_.each(iframes, (iframe) => {
						let wrapper = document.createElement('div'),
							parent = iframe.parentNode

						wrapper.className = wrapperClass
						parent.replaceChild(wrapper, iframe)
						wrapper.appendChild(iframe)
					})
				}
			}
		},
		mounted() {
			this.wrapEmbedded()
		},
		updated() {
			this.wrapEmbedded()
		},
	}
</script>
