<template>
	<div class="row overflow-auto">
		<div class="col-12">
			<ul class="list-group w-100">
				<MapResult v-for="poi in this.$store.getters.visiblePointsOfInterest" :key="poi.id" :pointOfInterest="poi" />
			</ul>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MapResult from '@/components/MapResult.vue';

@Component({
	components: {
		MapResult
	}
})
export default class MapFilters extends Vue {
	
}
</script>
