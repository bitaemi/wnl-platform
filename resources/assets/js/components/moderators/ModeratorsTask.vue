<template>
	<div class="card">
		<header class="card-header">
			<p class="card-header-title">{{title}}</p>
			<p class="events-counter">
				<span class="tag is-light is-medium" v-t="'tasks.task.fields.eventsCount'"/>
				<span class="tag is-danger is-medium">{{eventsCount}}</span>
			</p>
		</header>
		<div class="card-content task-summary">
			<div class="tags field has-addons">
				<span class="tag is-light is-medium" v-t="'tasks.task.fields.status'"/>
				<wnl-dropdown>
					<p slot="activator" class="tag is-medium" :class="statusTag.class">
						{{statusTag.text}}&nbsp
						<span class="icon is-small">
							<i class="fa fa-angle-down"></i>
						</span>
					</p>
					<div slot="content">
						<div @click="$emit('statusSelected', {status: st, id: task.id})" class="dropdown-item" v-for="(st, index) in status" :key="index">
							{{$t(`tasks.task.status.${st}`)}}
						</div>
					</div>
				</wnl-dropdown>
			</div>
			<div class="tags field has-addons is-relative">
				<span class="tag is-light is-medium" v-t="'tasks.task.fields.createdAt'"/>
				<span class="tag is-medium">{{formatedCreatedAt}}</span>
			</div>
			<div class="tags field has-addons is-relative">
				<span class="tag is-light is-medium" v-t="'tasks.task.fields.assignee'"/>
				<input
					:value="assigneeTextComputed"
					:class="{'is-empty': assigneeTextComputed.length === 0}"
					@focus="onFocus"
					@input="onInput"
					@keydown="onKeyDown"
				/>
				<wnl-autocomplete
					v-if="showAutocomplete"
					:items="availableModeratorsFilter"
					:onItemChosen="assign"
					:itemComponent="'wnl-user-autocomplete-item'"
					@close="onClose"
					class="wnl-autocomplete-dropdown"
					ref="autocomplete"
				/>
			</div>
			<div class="tags field has-addons is-relative">
				<span class="tag is-light is-medium" v-t="'tasks.task.fields.updatedAt'"/>
				<span class="tag is-medium">{{formatedUpdatedAt}}</span>
			</div>
		</div>
		<div class="card-content">
			<wnl-task-events :events="task.events" :routeContext="taskContext"/>
		</div>
		<footer class="card-footer">
			<router-link :to="taskContext" class="card-footer-item">{{$t('tasks.task.action.go')}}</router-link>
			<div class="card-footer-item" @click="$emit('assign', {assignee_id: currentUserId, id: task.id})">Biore to!</div>
		</footer>
	</div>
</template>

<style lang="sass" rel="stylesheet/sass" scoped>
	@import 'resources/assets/sass/variables'

	.tag
		border-radius: 0

	.task-summary
		display: flex
		flex-wrap: wrap
		padding-bottom: 0

		.tags.field
			flex: 1 0 50%

	.card-header
		align-items: center
		background-color: $color-background-light-gray

	.events-counter
		margin: 0 $margin-small

	.card-footer-item, .dropdown-item
		cursor: pointer

		&:hover
			background-color: $color-background-light-gray

	.dropdown-item
		padding: $margin-small
		border-bottom: $border-light-gray

	.wnl-autocomplete-dropdown
		top: 100%
		height: 250px
		overflow-y: auto

	.is-empty
		border: 2px solid $color-yellow
		border-radius: 5px

</style>

<script>
import {mapGetters} from 'vuex'

import Dropdown from 'js/components/global/Dropdown'
import Autocomplete from 'js/components/global/Autocomplete'
import TaskEvents from 'js/components/moderators/ModeratorsTaskEvents'

import { timeFromS } from 'js/utils/time'

const keys = {
		enter: 13,
		esc: 27,
		arrowUp: 38,
		arrowDown: 40,
	}

export default {
	props: {
		task: {
			type: Object,
			required: true
		},
		availableModerators: {
			type: Array,
			default: () => []
		},
		closeDropdown: {
			type: Boolean,
			default: false
		}
	},
	components: {
		'wnl-dropdown': Dropdown,
		'wnl-autocomplete': Autocomplete,
		'wnl-task-events': TaskEvents
	},
	data() {
		return {
			status: {
				OPEN: 'open',
				IN_PROGRESS: 'inProgress',
				DONE: 'done'
			},
			showAutocomplete: false,
			assigneeTextInput: '',
			focused: false
		}
	},
	computed: {
		...mapGetters(['currentUserId']),
		title() {
			return this.task.text || this.$t('tasks.task.defaultTitle')
		},
		statusTag() {
			switch (this.task.status) {
				case this.status.OPEN:
					return {
						class: 'is-warning',
						text: this.$t('tasks.task.status.open')
					}
				case this.status.IN_PROGRESS:
					return {
						class: 'is-info',
						text: this.$t('tasks.task.status.inProgress')
					}
				case this.status.DONE:
					return {
						class: 'is-success',
						text: this.$t('tasks.task.status.done')
					}
				default:
					return {
						class: 'is-ligth',
						text: this.$t('tasks.task.status.unknown')
					}
			}
		},
		eventsCount() {
			return this.task.events.length
		},
		lastEvent() {
			return this.task.events[this.eventsCount - 1]
		},
		taskContext() {
			return _.get(this.lastEvent, 'data.context', this.lastEvent.data.referer)
		},
		availableModeratorsFilter() {
			return this.availableModerators.filter(moderator => (
				moderator.full_name.toLowerCase().indexOf(this.assigneeTextInput.toLowerCase()) > -1)
			)
		},
		assigneeTextComputed() {
			return this.focused ? this.assigneeTextInput : this.task.assignee.full_name || ''
		},
		formatedCreatedAt() {
			return timeFromS(this.task.created_at)
		},
		formatedUpdatedAt() {
			return timeFromS(this.task.updated_at)
		},
	},
	methods: {
		assign(user) {
			this.$emit('assign', {assignee_id: user.user_id, id: this.task.id})
			this.onClose()
		},
		onFocus() {
			this.onOpen()
		},
		onKeyDown(evt) {
			const { enter, arrowUp, arrowDown, esc } = keys

			if (this.availableModerators.length === 0) {
				this.showAutocomplete = false
				return
			}

			if (evt.keyCode === esc) {
				this.onClose()
				return
			}
			if ([enter, arrowUp, arrowDown].indexOf(evt.keyCode) === -1) {
				this.onOpen()
				return
			}

			this.$refs.autocomplete.onKeyDown(evt)
			this.killEvent(evt)

			//for some of the old browsers, returning false is the true way to kill propagation
			return false
		},
		killEvent(evt) {
			evt.preventDefault()
			evt.stopPropagation()
		},
		onClose() {
			this.showAutocomplete = false
			this.focused = false
			this.assigneeTextInput = ''
		},
		onOpen() {
			this.focused = true
			this.showAutocomplete = true
		},
		onInput(event) {
			this.assigneeTextInput = event.target.value
		}
	},
	watch: {
		closeDropdown(newValue) {
			if (!newValue) return;

			this.$emit('dropdownClosed')
			this.onClose()
		}
	}
};
</script>