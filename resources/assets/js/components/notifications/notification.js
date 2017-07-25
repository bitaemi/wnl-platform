/**
 * A mixin with basic logic for a component of a Notification type.
 * @type {Object}
 */

import { mapActions } from 'vuex'

import { timeFromS } from 'js/utils/time'

export const notification = {
	props: {
		channel: {
			required: true,
			type: String,
		},
		message: {
			required: true,
			type: Object,
		},
		routeContext: {
			type: String|Object
		}
	},
	computed: {
		formattedTime () {
			return timeFromS(this.message.timestamp)
		},
		hasContext() {
			return this.routeContext.length > 0
		},
		isRead() {
			return !!this.message.read_at
		},
	},
	methods: {
		...mapActions('notifications', ['markAsRead']),
		goToContext() {
			if(!this.hasContext) return false;

			this.markAsRead({notification: this.message, channel: this.channel})
				.then(() => {
					if (typeof this.routeContext === 'object') {
						this.$router.push(this.routeContext)
					} else if (typeof this.routeContext === 'string') {
						window.location.href=this.routeContext
					}
				})
		},
	},
}
