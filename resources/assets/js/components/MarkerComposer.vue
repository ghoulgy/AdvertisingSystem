<template>
	<div class="marker-composer">
		<input type="text" placeholder="Type something here ..." v-model="markerText" @keyup.enter="sendMarker">
		<button class="btn btn-primary" @click="sendMarker">Send</button>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				markerText: ''
			}
		},

		methods: {
			sendMarker() {
				this.$emit('markersent', {
					message: this.markerText,
					user: {
						name: $('.navbar-right .dropdown-toggle').text()
					}
				});
				this.markerText = '';
			}
		}
	}

</script>

<style>
	.chat-composer {
		display: flex;
	}

	.chat-composer input {
		flex: 1 auto;
	}

	.chat-composer button {
		border-radius: 0;
	}
</style>