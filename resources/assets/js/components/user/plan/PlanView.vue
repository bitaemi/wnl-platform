<template>
	<div class="scrollable-main-container">
		<div class="level wnl-screen-title tabs" v-if="!isMobile">
			<ul>
				<li
					v-for="tab in tabs"
					@click="onTabSelect(tab)"
					:class="[tab.isActive ? 'is-active' : '', 'big', 'strong']"
					:key="tab.title"
				>
					<a>{{tab.title}}</a>
				</li>
			</ul>
		</div>
		<div class="dropdown-container" v-else>
			<wnl-dropdown>
				<div slot="activator" class="dropdown-trigger is-active">
					{{activeTab.title}}
					<span class="icon"><i class="fa fa-angle-down"></i></span>
				</div>
				<div slot="content" class="dropdown-menu">
					<div class="dropdown-menu__content">
						<ul>
							<li
								v-for="tab in tabs"
								@click="onTabSelect(tab)"
								:key="tab.title"
								class="dropdown-menu__item"
							>
								<a class="dropdown-menu__item">{{tab.title}}</a>
							</li>
						</ul>
					</div>
				</div>
			</wnl-dropdown>
		</div>
		<component :is="activeView"/>
	</div>
</template>

<style lang="sass" scoped>
	$dropdownWidth: 250px

	.dropdown-container
		position: relative
		width: $dropdownWidth
		margin-bottom: 20px

	.dropdown-trigger
		border: 1px solid black
		border-radius: 5px
		width: $dropdownWidth
		height: 50px
		padding: 0 10px
		display: flex
		justify-content: space-between
		align-items: center
	.dropdown-menu
		width: $dropdownWidth
		&__item
			color: black
			padding: 10px 20px
</style>

<script>
	import {mapGetters} from 'vuex';

	import LessonsPlanner from './LessonsPlanner';
	import PlannerGuarantee from './PlanGuarantee.vue';
	import PlannerGuide from './PlannerGuide';
	import Dropdown from 'js/components/global/Dropdown'

	export default {
		name: 'PlanView',
		components: { 'wnl-dropdown': Dropdown },
		data() {
			return {
				tabs: [
					{
						title: 'Twój Plan Pracy',
						component: LessonsPlanner,
						isActive: true
					},
					{
						title: 'Jak zmienić plan?',
						component: PlannerGuide,
					},
					{
						title: 'Gwarancja Satysfakcji',
						component: PlannerGuarantee,
					},
				]
			}
		},
		computed: {
			...mapGetters(['isMobile']),
			activeTab() {
				return this.tabs.find(tab => tab.isActive) || {}
			},
			activeView() {
				return this.activeTab.component
			}
		},
		methods: {
			onTabSelect(selectedTab) {
				this.tabs = this.tabs.map(tab => {
					if (selectedTab.title === tab.title) {
						return {
							...tab,
							isActive: true
						}
					}
					return {
						...tab,
						isActive: false
					}
				});
			}
		}
	}
</script>
