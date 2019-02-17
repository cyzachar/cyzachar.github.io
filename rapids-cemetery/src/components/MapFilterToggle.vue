<template>
	<li class="list-group-item">
		<form class="form-check">
			<label class="form-check-label w-100">
				<input type="checkbox" class="form-check-input" :id='this.inputId' v-model='enabled'>{{ this.tag }}
			</label>
		</form>
	</li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import uuidv4 from 'uuid';

@Component
export default class MapFilterToggle extends Vue {
	@Prop(String) tag!: string;

	private inputId: string = uuidv4();
	
	private get enabled() {
		return this.$store.getters.tagEnabled(this.tag);
	}

	private set enabled(enabled: boolean) {
		if (enabled) {
			this.$store.commit("enableTag", this.tag);
		} else {
			this.$store.commit("disableTag", this.tag);
		}
	}
}
</script>
