<template>
	<wnl-avatar
		:fullName="message.actors.full_name"
		:size="size"
		:url="message.actors.avatar"
		:disableLink="disableLink"
	/>
</template>

<script>
	export default {
		name: 'Actor',
		props: {
			message: {
				required: true,
				type: Object,
			},
			size: {
				default: 'medium',
				type: String,
			},
			disableLink: {
				default: false,
				type: Boolean
			}
		},
	}
</script>
