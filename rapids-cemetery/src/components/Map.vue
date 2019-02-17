<template>
	<div :id='this.mapContainerId' :style='{ width: this.width, height: this.height }'>

	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import uuidv4 from 'uuid/v4';

import * as L from 'leaflet';
import 'leaflet/dist/leaflet.css';

import PointOfInterest from '@/data/objects/PointOfInterest';

@Component
export default class Map extends Vue {
	@Prop({ default: '250px' }) width!: string;
	@Prop({ default: '250px' }) height!: string;
	@Prop({ default: 20 }) maxZoom!: number;
	@Prop({ default: 0 }) startLat!: number;
	@Prop({ default: 0 }) startLong!: number;
	@Prop({ default: 10 }) startZoom!: number;

	private map!: L.Map;
	private mapContainerId: string = uuidv4();

	mounted(): void {
		this.map = L.map(this.mapContainerId).setView([this.startLat, this.startLong], this.startZoom);

		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			maxZoom: this.maxZoom,
			maxNativeZoom: 20,
			id: 'mapbox.satellite',
			accessToken: 'pk.eyJ1Ijoic3BlbmNlcmdyZWVuIiwiYSI6ImNqcmIwbG1ycTAwcTE0OXBma3M2cXZlOXYifQ.GwKx_RQjXh_-ZZ7SeXob5g'
		} as any).addTo(this.map);

		this.$store.dispatch("loadPointsOfInterest").then(() => {
			this.drawPointsOfInterest();
		});
	}

	private drawPointsOfInterest(): void {
		for (let pointOfInterest of this.$store.state.pointsOfInterest) {
			pointOfInterest.mapMarker.addTo(this.map);
		}
	}
}
</script>

<style lang="scss" scoped>

</style>
