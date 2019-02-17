<template>
	<Placeholder />
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Placeholder from '@/components/Placeholder.vue';

@Component({
	components: {
		Placeholder,
	}
})
export default class Home extends Vue {}
</script>
