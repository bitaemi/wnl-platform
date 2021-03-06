<template>
	<div>
		<button class="button is-primary" @click="addAnnotation">+ Nowy Przypis</button>
		<div class="tabs">
			<ul>
				<li :class="{'is-active': tab.active}" @click="changeTab(name)" v-for="(tab, name) in tabs" :key="name">
					<a>{{tab.text}}</a>
				</li>
			</ul>
		</div>
		<component
			:is="activeComponent"
			:list="annotations"
			:annotation="activeAnnotation"
			:modifiedAnnotationId="modifiedAnnotationId"
			@annotationSelect="onAnnotationSelect"
			@addSuccess="onAddSuccess"
			@editSuccess="onEditSuccess"
			@deleteSuccess="onDeleteSuccess"
			@hasChanges="onEditorChange"
		>
			<div class="search" slot="search">
				<search @search="search"/>
				<template v-if="searchPhrase">
					<span>Aktualne wyszukiwanie:</span>
					<span class="tag is-success">
						{{searchPhrase}}
						<button class="delete is-small" @click="clearSearch"></button>
					</span>
				</template>
			</div>
			<pagination v-if="paginationMeta.last_page > 1"
				:currentPage="page"
				:lastPage="paginationMeta.last_page"
				@changePage="onPageChange"
				slot="pagination"
				class="annotations__pagination"
			/>
		</component>
	</div>
</template>

<style lang="sass">
	.annotations__pagination .pagination-list
		justify-content: flex-end
</style>

<script>
	import axios from 'axios';
	import {mapActions} from 'vuex'

	import { getApiUrl } from 'js/utils/env'
	import AnnotationsList from "./AnnotationsList";
	import AnnotationsEditor from "./AnnotationsEditor";
	import Pagination from "js/components/global/Pagination";
	import Search from "./Search";

	export default {
		components: {AnnotationsList, AnnotationsEditor, Search, Pagination},
		data() {
			return {
				tabs: {
					list: {
						component: AnnotationsList,
						active: true,
						text: 'Lista'
					},
					editor: {
						component: AnnotationsEditor,
						active: false,
						text: 'Edytor'
					}
				},
				activeAnnotation: {},
				annotations: [],
				modifiedAnnotationId: 0,
				searchPhrase: '',
				searchFields: [],
				perPage: 24,
				page: 1,
				includes: 'keywords,tags',
				paginationMeta: {}
			}
		},
		computed: {
			activeTab() {
				return Object.values(this.tabs).find(tab => tab.active)
			},
			activeComponent() {
				return this.activeTab.component
			},
		},
		methods: {
			...mapActions(['addAutoDismissableAlert']),
			async search({phrase, fields}) {
				this.page = 1
				this.searchPhrase = phrase
				this.searchFields = fields

				await this.fetchAnnotations('annotations/.filter', 'post')
			},
			async clearSearch() {
				this.searchPhrase = ''
				this.searchFields = []
				this.page = 1
				await this.fetchAnnotations()
			},
			changeTab(name) {
				this.activeTab.active = false;
				this.tabs[name].active = true;
			},
			addAnnotation() {
				this.changeTab('editor');
				this.activeAnnotation = {
					tags: [],
					keywords: '',
				};
			},
			onEditorChange(changedAnnotation) {
				this.modifiedAnnotationId = changedAnnotation
			},
			async onPageChange(page) {
				this.page = page
				await this.fetchAnnotations()
			},
			onAnnotationSelect(annotation) {
				if (this.modifiedAnnotationId && annotation.id !== this.modifiedAnnotationId) {
					const result = window.confirm(
						`Masz niezapisane zmiany w przypisie ${this.modifiedAnnotationId}. Czy na pewno chcesz zmienić edytowany przypis?`
					)
					if (result) {
						this.onEditorActivate(annotation)
					}
				} else {
					this.onEditorActivate(annotation)
				}
			},
			onEditorActivate(annotation) {
				this.activeAnnotation = annotation;
				this.activeTab.active = false;
				this.tabs.editor.active = true;
				if (annotation.id !== this.modifiedAnnotationId) {
					this.modifiedAnnotationId = 0
				}
			},
			onAddSuccess(annotation) {
				this.activeAnnotation = {
					...annotation,
					keywords: (annotation.keywords || []).join(',')
				}
				this.annotations.splice(0,0, this.activeAnnotation);
			},
			onEditSuccess(annotation) {
				this.activeAnnotation = {
					...annotation,
						keywords: (annotation.keywords || []).join(',')
				}

				this.annotations = this.annotations.map(item => {
					if (item.id === annotation.id) {
						return {
							...this.activeAnnotation
						}
					}
					return item;
				})
			},
			onDeleteSuccess({id}) {
				this.activeAnnotation = {}

				const annotationIndex = this.annotations.findIndex(annotation => annotation.id === id)
				this.annotations.splice(annotationIndex, 1)
			},
			serializeResponse({data}) {
				const {included, ...annotations} = data;
				const {tags, keywords} = included;

				return Object.values(annotations).map(annotation => {
					return {
						...annotation,
						tags: (annotation.tags || []).map(tagId => ({
							id: tags[tagId].id,
							name: tags[tagId].name,
						})),
						keywords: (annotation.keywords || []).map(keywordId => keywords[keywordId].text).join(',')
					}
				})
			},
			getRequestParams() {
				const params = {
					include: this.includes,
					limit: this.perPage,
					page: this.page,
					active: [],
					filters: []
				}

				if (this.searchPhrase) {
					params.active = [`search.${this.searchPhrase}`]
					params.filters = [{search: {phrase: this.searchPhrase, fields: this.searchFields}}]
				}
				return params
			},
			async fetchAnnotations(url = 'annotations/all', method = 'get') {
				try {
					const params = method === 'get' ? {
						params: this.getRequestParams()
					} : this.getRequestParams()
					const annotationsResponse = await axios[method](getApiUrl(url), params)

					const {data: response} = annotationsResponse
					const {data, ...paginationMeta} = response
					this.paginationMeta = paginationMeta
					if (paginationMeta.total === 0) {
						this.annotations = []
					} else {
						this.annotations = this.serializeResponse(response);
					}
				} catch (e) {
					this.addAutoDismissableAlert({
						text: "Ops, nie udało się pobrać przypisów. Odśwież stronę i spróbuj jeszcze raz",
						type: 'error'
					})
				}
			},
		},
		async mounted() {
			await this.fetchAnnotations()
		},
		beforeRouteLeave(to, from, next) {
			if (this.modifiedAnnotationId) {
				const result = window.confirm(
					`Masz niezapisane zmiany w przypisie ${this.modifiedAnnotationId}. Czy na pewno chcesz wyjść?`
				)
				result && next()
			} else {
				next()
			}
		}
	}
</script>
