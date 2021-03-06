<template>
	<article class="media wnl-chat-message" :class="{ 'is-full': showAuthor }" :data-id="id">
		<figure class="media-left" @click="showModal" :class="{'author-forgotten': author.deleted_at}">
			<wnl-avatar
				:fullName="fullName"
				:url="avatar"
				v-if="showAuthor">
			</wnl-avatar>
			<div class="media-left-placeholder" v-else></div>
		</figure>
		<div class="media-content">
			<div class="content">
				<p class="wnl-message-meta" v-if="showAuthor">
					<strong
						class="author"
						:class="{'author-forgotten': author.deleted_at}"
						@click="showModal">{{ nameToDisplay }}</strong>
					<small class="wnl-message-time">{{ formattedTime }}</small>
				</p>
				<p class="wnl-message-content" v-html="content"></p>
			</div>
		</div>
		<wnl-modal :isModalVisible="isVisible" @closeModal="closeModal" v-if="isVisible">
			<wnl-user-profile-modal :author="author"/>
		</wnl-modal>
	</article>
</template>
<style lang="sass">
	@import 'resources/assets/sass/variables'

	.media.wnl-chat-message
		border-top: 0
		line-height: 24px
		padding-top: 0
		margin-top: 0.5rem

		&.is-full
			margin-top: 1.25rem

		.media-left
			margin: 0 $margin-small 0 0
			cursor: pointer
			&.author-forgotten
				color: $color-gray-dimmed
				pointer-events: none

		.media-left-placeholder
			height: 1px
			width: map-get($rounded-square-sizes, 'medium')

		.media-content
			.content
				color: $color-gray-lighter
				word-wrap: break-word
				word-break: break-word

				.wnl-message-meta
					color: $color-inactive-gray
					line-height: 1em
					margin-bottom: $margin-tiny
					.author
						cursor: pointer
						color: $color-sky-blue
						&.author-forgotten
							color: $color-gray-dimmed
							pointer-events: none

				.wnl-message-time
					margin-left: $margin-small

				p
					margin: 0
</style>
<script>
	import { mapActions } from 'vuex'
	import { timeFromMs } from 'js/utils/time'

	import Modal from 'js/components/global/Modal.vue'
	import UserProfileModal from 'js/components/users/UserProfileModal'
	import Avatar from 'js/components/global/Avatar'

	export default{
		props: ['author', 'avatar', 'time', 'showAuthor', 'content', 'id', 'fullName'],
		components: {
			'wnl-avatar': Avatar,
			'wnl-user-profile-modal': UserProfileModal,
			'wnl-modal': Modal
		},
		data() {
			return {
				isVisible: false
			}
		},
		computed: {
			formattedTime () {
				return timeFromMs(this.time)
			},
			nameToDisplay() {
				return this.author.display_name || this.fullName
			}
		},
		methods: {
			showModal() {
				this.isVisible = true
			},
			closeModal() {
				this.isVisible = false
			}
		}
	}
</script>
