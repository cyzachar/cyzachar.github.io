<template>
	<div class="mx-auto">
		<img class="placeholder" alt="Prinny" src="../assets/prinnysalute.png" />
		<h1>This page is not implemented yet, dood.</h1>
		<p><strong>Hopefully we get to it at some point.</strong></p>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class Placeholder extends Vue {
	
}
</script>

<style scoped lang="scss">
div {
	text-align: center;
}

img.placeholder {
	width: 200px;
	height: auto;
}
</style>
