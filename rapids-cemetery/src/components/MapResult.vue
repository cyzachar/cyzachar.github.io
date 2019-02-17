<template>
	<li class="list-group-item" :class="{ 'active': this.selected }" v-on:click="select();">
		<div :id="this.id" class="row">
			<div class="col-12">
				<h5>{{ this.pointOfInterest.name }}</h5>
			</div>
			<div class="col-12">
				<p>{{ this.pointOfInterest.description }}</p>
			</div>
		</div>
	</li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import PointOfInterest from '@/data/objects/PointOfInterest';

@Component
export default class MapResult extends Vue {
	@Prop(PointOfInterest) pointOfInterest!: PointOfInterest;

	private get id(): string {
		return "poiResult-" + this.pointOfInterest.id;
	}

	private get selected(): boolean {
		return (this.$store.state.selectedPoiId === this.pointOfInterest.id);
	}

	private select(): void {
		if (this.selected) {
			this.$store.commit("selectPoi", null);
		} else {
			this.$store.commit("selectPoi", this.pointOfInterest.id);
		}
	}
}
</script>

<style lang="scss" scoped>
	img {
		width: 100%;
		height: auto;
	}
</style>
