export const reaction = {
	props: ['module', 'reactableResource', 'reactableId', 'updateLocally', 'state', 'reactionsDisabled'],
	data() {
		return {
			isLoading: false,
			isReady: false,
			wasJustClicked: false,
		}
	},
	computed: {
		hasReacted() {
			return this.state.hasReacted
		},
		count() {
			return this.state.count
		}
	},
	methods: {
		setReaction(payload) {
			return this.$store.dispatch(`${this.module}/setReaction`, payload)
		},
		getReaction(resource, id, reactionName) {
			return this.$store.getters[`${this.module}/getReaction`](resource, id, reactionName)
		},
		toggleReaction() {
			if (this.isLoading || this.reactionsDisabled) {
				return false
			}
			this.wasJustClicked = true
			this.isLoading = true
			this.setReaction({
				reactableResource: this.reactableResource,
				reactableId: this.reactableId,
				reaction: this.name,
				hasReacted: this.hasReacted,
				count: this.count,
				vuexState: this.getReaction(this.reactableResource, this.reactableId, this.name)
			}).then((response) => {
				this.isLoading = false
				this.wasJustClicked = false
			})
			.catch((error) => {
				$wnl.logger.error(error)
				this.isLoading = false
				this.wasJustClicked = false
			})
		},
	},
	mounted() {
		this.isReady = true
	}
}
