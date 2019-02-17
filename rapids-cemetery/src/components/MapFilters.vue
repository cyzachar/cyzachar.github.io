<template>
	<div class="row overflow-auto">
		<div class="col-12">
			<ul class="list-group w-100">
				<MapFilterToggle v-for="tag in this.$store.getters.tags" :key="tag" :tag="tag" />
			</ul>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MapFilterToggle from '@/components/MapFilterToggle.vue';

@Component({
	components: {
		MapFilterToggle
	}
})
export default class MapFilters extends Vue {
	
}
</script>

<style lang="scss" scoped>

</style>
