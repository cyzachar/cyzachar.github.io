<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<router-link class="navbar-brand" to="/" :class="{ 'active': this.$route.path == '/' }">Rapids Cemetery</router-link>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#pageLinks">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse nav-pills justify-content-end" id="pageLinks">
			<router-link class="nav-item nav-link" to="/map" :class="{ 'active': this.$route.path == '/map' }">Map</router-link>
			<router-link class="nav-item nav-link" to="/points-of-interest" :class="{ 'active': this.$route.path == '/points-of-interest' }">Points of Interest</router-link>
			<router-link class="nav-item nav-link" to="/trails" :class="{ 'active': this.$route.path == '/trails' }">Trails</router-link>
			<router-link class="nav-item nav-link" to="/history" :class="{ 'active': this.$route.path == '/history' }">History</router-link>
			<router-link class="nav-item nav-link" to="/tour" :class="{ 'active': this.$route.path == '/tour' }">Tour</router-link>
			<router-link class="nav-item nav-link" to="/about" :class="{ 'active': this.$route.path == '/about' }">About</router-link>
			<router-link class="nav-item nav-link" to="/contact" :class="{ 'active': this.$route.path == '/contact' }">Contact</router-link>
		</div>
	</nav>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class Navbar extends Vue {
	
}
</script>
