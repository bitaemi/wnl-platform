<template>
	<div class="field">
		<div class="control screens-control">
			<div class="screens-wrapper">
				<div class="slide-snippet" v-for="slide in slides" :context="slide.context" :key="slide.id">
					<h5>{{slide.snippet.header}}</h5>
					<p>{{slide.snippet.subheader}}</p>
					<i class="fa fa-times close-icon" @click="removeSlide(slide)"></i>
				</div>
			</div>
			<div class="inputs-wrapper">
				<input
					v-model="screenIdInput"
					class="input"
					type="text"
					placeholder="Id screena"
					ref="slideIdInput"
				>
				<input
					v-model="slideNumberInput"
					class="input"
					type="number"
					placeholder="Numer slajdu"
					ref="orderNumberInput"
				>
				<a
					@click="onButtonClicked"
					class="button"
				>
					Dodaj
				</a>
			</div>
		</div>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	.screens-wrapper
		display: flex
		flex-wrap: wrap

	.slide-snippet
		border: 1px solid #efefef
		margin: 5px 5px 20px
		padding: 10px 45px 10px 10px
		position: relative

	h5, p
		max-width: 100px;

	h5
		border-bottom: 1px solid #efefef
		font-weight: bold
		margin-bottom: 5px
		padding-bottom: 5px

	p
		overflow: hidden
		text-overflow: ellipsis
		white-space: nowrap

	.close-icon
		cursor: pointer
		padding: 3px
		position: absolute
		right: 0
		top: 0

	.inputs-wrapper
		display: flex

	.input
		margin: 5px

	.button
		display: block
		background: #11afb2
		color: #fff
		margin: 5px


</style>

<script>
	import { formInput } from 'js/mixins/form-input'
	import SlideLink from 'js/components/global/SlideLink'
	import _ from 'lodash'
	import { mapActions } from 'vuex'

	const keys = {
		enter: 13,
		esc: 27,
		arrowUp: 38,
		arrowDown: 40
	}

	export default {
		name: 'SlideIds',
		components: {
			'wnl-slide-link': SlideLink
		},
		props: ['defaultSlides'],
		data: function () {
			return {
				autocompleteItems: [],
				slides: [],
				screenIdInput: '',
				slideNumberInput: '',
			}
		},
		computed: {
			default() {
				return ''
			}
		},
		methods: {
			...mapActions(['getSlideDataForQuizEditor']),
			onButtonClicked() {
				this.getSlideDataForQuizEditor({
					screenId: this.screenIdInput,
					slideNumber: this.slideNumberInput
				}).then(data => {
					if (this.slides.map(slide => slide.id).indexOf(data.id) === -1) {
						this.slides.push(data);
					}
				})
			},

			removeSlide(slide) {
				this.slides = _.filter(
					this.slides,
					foundSlide => slide.id !== foundSlide.id
				)
			},

			haveSlidesChanged() {
				if (this.slides.length !== this.defaultSlides.length) return true

				return !!this.slides.some(slide => !_.find(this.defaultSlides, defSlide => defSlide.id === slide.id))
			}
		},
		watch: {
			defaultSlides() {
				this.slides = this.defaultSlides.slice()
			}
		}
	}
</script>
