<template>
	<div class="notification-wrapper" :class="{'is-desktop': !isTouchScreen}">
		<div class="questions-notification" :class="{'is-read': isRead, deleted}">
			<div class="notification-container" :class="{'unseen': !isSeen}"
				@click="dispatchMarkAsSeen"
				@contextmenu="dispatchMarkAsSeen"
			>
				<router-link class="notification-link" :to="routeContext">
					<div class="meta">
						<wnl-event-actor :size="isMobile ? 'small' : 'medium'" class="meta-actor" :message="message"/>
						<span class="icon is-small"><i class="fa" :class="icon"></i></span>
						<span class="meta-time">{{justDate}}</span>
						<span class="meta-time">{{justTime}}</span>
					</div>
					<div class="notification-content">
						<div class="notification-header">
							<span class="actor">{{ message.actors.display_name }}</span>
							<span class="action">{{ action }}</span>
							<span class="object">{{ object }}</span>
							<span class="context">{{ contextInfo }}</span>
						</div>
						<div class="object-text wrap" v-if="objectText">{{ objectText }}</div>
						<div class="subject wrap" :class="{'unseen': !isSeen}" v-if="subjectText">{{ subjectText }}</div>
						<div class="time">
						</div>
					</div>
				</router-link>
			</div>
		</div>
		<div class="delete-message" v-if="deleted">{{$t('notifications.messages.deleted')}}</div>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	.is-desktop
		.notification-link
			&:hover
				background-color: $color-background-lighter-gray

	.notification-link
		align-items: flex-start
		background: $color-white
		border-bottom: $border-light-gray
		color: $color-gray
		display: flex
		font-size: $font-size-minus-1
		justify-content: space-between
		padding: $margin-medium
		position: relative

		&.is-active
			font-weight: $font-weight-regular

	.meta
		align-items: center
		display: flex
		flex-direction: column
		margin: -$margin-small 0
		padding: $margin-small 0

		.meta-actor
			margin-bottom: $margin-small

		.meta-time
			color: $color-background-gray
			font-size: $font-size-minus-3
			line-height: $line-height-minus
			text-align: center

		.icon
			color: $color-background-gray
			text-align: center
			margin-bottom: $margin-small

	.unseen
		.icon
			color: $color-ocean-blue

	.notification-content
		flex: 1 auto
		padding: 0 0 0 $margin-medium

		.notification-header
			line-height: $line-height-minus
			margin-bottom: $margin-tiny

			.actor,
			.context
				font-weight: $font-weight-bold

		.object-text
			color: $color-gray-dimmed
			font-style: italic
			line-height: $line-height-minus
			margin-bottom: $margin-tiny

		.subject
			border-left: 2px solid $color-inactive-gray
			font-size: $font-size-minus-1
			margin-top: $margin-small
			padding-left: $margin-medium
			padding-bottom: $margin-tiny

			&.unseen
				border-color: $color-ocean-blue

		.time
			color: $color-background-gray
			font-size: $font-size-minus-2
			margin-top: $margin-tiny

			.icon
				margin-right: $margin-tiny
</style>

<script>
	import { truncate } from 'lodash'
	import { mapActions, mapGetters } from 'vuex'

	import Actor from 'js/components/notifications/Actor'
	import { notification } from 'js/components/notifications/notification'
	import { justTimeFromS, justMonthAndDayFromS } from 'js/utils/time'

	export default {
		name: 'QuestionsNotification',
		mixins: [notification],
		components: {
			'wnl-event-actor': Actor,
		},
		props: {
			icon: {
				required: true,
				type: String
			},
		},
		data() {
			return {
				objectTextLength: 100,
				subjectTextLength: 300,
			}
		},
		computed: {
			...mapGetters(['currentUserId', 'isMobile', 'isTouchScreen']),
			action() {
				return this.$t(`notifications.events.${_.camelCase(this.message.event)}`)
			},
			justDate() {
				return justMonthAndDayFromS(this.message.timestamp)
			},
			justTime() {
				return justTimeFromS(this.message.timestamp)
			},
			object() {
				const objects = this.message.objects
				const subject = this.message.subject
				const type = !!objects ? objects.type : subject.type
				const choice = !!objects ? this.currentUserId === objects.author ? 2 : 1 : 1

				return this.$tc(`notifications.objects.${_.camelCase(type)}`, choice)
			},
		},
		methods: {
			...mapActions('notifications', ['markAsUnread']),
			toggleNotification() {
				this.loading = true

				if (this.isRead) {
					return this.markAsUnread({notification: this.message, channel: this.channel})
						.then(() => this.loading = false)
				}

				return this.markAsRead({notification: this.message, channel: this.channel})
					.then(() => this.loading = false)
			},
			dispatchMarkAsSeen() {
				if(!this.hasContext) return false;

				this.loading = true

				if (!this.isSeen) {
					this.markAsSeen({notification: this.message, channel: this.channel})
						.then(() => {
							this.loading = false
						})
				} else {
					this.loading = false
				}
			},
		},
	}
</script>
