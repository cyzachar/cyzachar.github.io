<template>
	<div class="row flex-grow-1">
		<div class="col-lg-9 col-md-8 order-md-12 order-lg-12">
			<Map :width='"100%"' :height='"100%"' :maxZoom=20 :startLat=43.129490778815814 :startLong=-77.63922348618507 :startZoom=20 />
		</div>

		<div class="d-flex flex-column col-lg-3 col-md-4 order-md-1 order-lg-1">
			<MapFilters id="filters" class="h-50 no-gutters"></MapFilters>
			<MapResults id="results" class="row flex-grow-1 flex-shrink-1 no-gutters scroll-y"></MapResults>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Map from '@/components/Map.vue';
import MapFilters from '@/components/MapFilters.vue';
import MapResults from '@/components/MapResults.vue';

@Component({
	components: {
		Map,
		MapFilters,
		MapResults
	}
})
export default class MapView extends Vue {}
</script>

<style lang="scss" scoped>
#filters {
	max-height: 250px;
}
</style>
