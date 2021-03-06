<template>
	<div class="annotations-list">
		<slot name="search"></slot>
		<slot name="pagination"/>
		<ul v-if="list.length">
			<li
				v-for="(annotation, index) in list"
				:key="annotation.id"
				class="annotation-item"
				:class="{'annotation-item--is-even': isEven(index)}"
				@click="toggleAnnotation(annotation)"
			>
					<div class="annotation-item__header">
						<span class="annotation-item__header__item">
							{{annotation.id}}
						</span>
						<span class="annotation-item__header__item annotation-item__header__item--grow">
							{{annotation.title}}
						</span>
						<div class="annotation-item__header__tags annotation-item__header__item">
							<span
								class="tag"
								v-for="tag in annotation.tags"
								:style="{backgroundColor: getColourForStr(tag.name)}">
								{{tag.name}}
							</span>
						</div>
						<span class="annotation-item__header__item  annotation-item__header__item--small" v-if="modifiedAnnotationId === annotation.id">
							...niezapisany
						</span>
						<span
							class="icon is-small annotation-item__header__item annotation-item__header__item--edit"
							@click="(event) => onAnnotationClick({annotation, event})"
						>
							<i class="fa fa-pencil"></i>
						</span>
						<span class="icon is-small  annotation-item__header__item annotation-item__header__item--chevron">
							<i class="toggle fa fa-angle-down"
								 :class="{'fa-rotate-180': isOpen(annotation)}">
							</i>
						</span>
					</div>
					<div
						class="annotation-item__description"
						v-if="isOpen(annotation)"
						v-html="annotation.description">
					</div>
			</li>
		</ul>
		<div v-else>
			<span class="title is-6">Nic tu nie ma...</span>
		</div>
	</div>
</template>

<style lang="sass" scoped>
	@import 'resources/assets/sass/variables'

	.annotation-item
		min-height: 35px
		display: flex
		margin: 10px 0
		cursor: pointer
		width: 100%
		flex-direction: column
		padding: 5px
		&__header
			display: flex
			&__item
				margin-right: $margin-base
				flex: 0 1 auto
				&--grow
					flex-grow: 1
				&:last-child
					margin-right: 0
				&--edit
					padding: $margin-base
					margin-right: 0
					color: $color-ocean-blue
				&--chevron
					padding: $margin-base
				&--small
					font-size: 0.8rem
					font-style: italic
					color: $color-background-gray
			&__tags
				display: flex
				justify-content: flex-start
				margin-left: $margin-big
				flex-wrap: wrap
				align-items: center
				max-width: 60%
				.tag
					color: black
					font-size: 0.75rem
					margin-right: 10px
					margin-top: 5px
					margin-bottom: 5px
					padding: 5px 10px
		&__description
			margin: $margin-medium
		&--is-even
			background-color: $color-background-light-gray
</style>

<script>
	export default {
		name: 'AnnotationsList',
		data() {
			return {
				openAnnotations: []
			}
		},
		props: {
			list: {
				type: Array,
				required: true
			},
			modifiedAnnotationId: {
				type: Number,
				default: 0
			}
		},
		methods: {
			getColourForStr(str) {
				let hash = 0;
				for (let i = 0; i < str.length; i++) {
					hash = str.charCodeAt(i) + ((hash << 5) - hash);
				}

				let hex =
				((hash >> 24) & 0xff).toString(16) +
					((hash >> 16) & 0xff).toString(16) +
					((hash >> 8) & 0xff).toString(16) +
					(hash & 0xff).toString(16);

				hex += "000000";
				hex = hex.substring(0, 6)
				const r = parseInt(hex.substring(0,2), 16);
				const g = parseInt(hex.substring(2,4), 16);
				const b = parseInt(hex.substring(4,6), 16);

				return `rgba(${r}, ${g}, ${b}, 0.2)`
			},
			isEven(index) {
				return index % 2 === 0
			},
			toggleAnnotation(annotation) {
				if (this.openAnnotations.indexOf(annotation.id) === -1) {
					this.openAnnotations.push(annotation.id)
				} else {
					const index = this.openAnnotations.indexOf(annotation.id)
					if (index > -1) {
						this.openAnnotations.splice(index, 1)
					}
				}
			},
			isOpen(annotation) {
				return this.openAnnotations.indexOf(annotation.id) > -1
			},
			onAnnotationClick({annotation, event}) {
				this.$emit('annotationSelect', annotation);
				event.stopImmediatePropagation();
			}
		}
	}
</script>
