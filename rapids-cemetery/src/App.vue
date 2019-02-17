<template>
	<div id="app" class="container-fluid d-flex h-100 flex-column">
		<header>
			<Navbar />
		</header>

		<div id="page" class="d-flex flex-grow-1">
			<router-view />
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import 'bootstrap';

//fix default Leaflet marker icon
import * as L from 'leaflet';

delete (L.Icon.Default.prototype as any)._getIconUrl;

L.Icon.Default.mergeOptions({
   iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
   iconUrl: require('leaflet/dist/images/marker-icon.png'),
   shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

import Navbar from '@/components/Navbar.vue';

@Component({
	components: {
		Navbar,
	}
})
export default class Home extends Vue {}
</script>

<style lang="scss">
@import 'node_modules/bootstrap/scss/bootstrap';

.scroll-y {
	overflow-y: scroll;
}

html, body {
	height: 100%;
}

#app {
	padding-left: 0;
	padding-right: 0;
}

#page {
	margin-left: 15px;
	margin-right: 15px;
	padding-top: 15px;
	padding-bottom: 15px;
}
</style>
