<template>
	<div v-if="!reactionsDisabled" class="watch" :class="{'has-reacted': hasReacted}" @click="toggleReaction">
		<span v-if="!isMobile" v-t="reactionMessage"></span>
		<span v-if="!isLoading" class="icon is-small watch-icon">
			<i class="fa" :class="hasReactedClass"></i>
		</span>
		<span v-else class="loader"></span>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	.watch
		align-items: center
		border: $border-light-gray
		cursor: pointer
		display: inline-flex
		font-size: $font-size-minus-2
		margin: 0 $margin-small
		padding: 0 $margin-small
		text-transform: uppercase

		&.has-reacted
			border-color: $color-green
			color: $color-green

	.watch-icon
		margin-left: $margin-small

	.loader
		height: 1rem
		margin-left: $margin-small
		width: 1rem
</style>

<script>
	import { mapGetters } from 'vuex'

	import { reaction } from 'js/mixins/reaction'

	export default {
		name: 'Watch',
		mixins: [reaction],
		data() {
			return {
				isLoading: false,
				name: 'watch'
			}
		},
		computed: {
			...mapGetters(['isMobile']),
			hasReactedClass() {
				return this.hasReacted ? 'fa-check' : 'fa-eye'
			},
			reactionMessage() {
				return this.hasReacted ? 'ui.action.watching' : 'ui.action.watch'
			},
		}
	}
</script>
