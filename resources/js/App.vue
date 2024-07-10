<template>
	<HeadComponent />
	<RouterView v-if="route.name == 'product'" :key="route.path" />
	<RouterView v-else />
	<FootComponent />
</template>

<script setup>
	import { RouterView } from 'vue-router';
	import HeadComponent from './components/HeadComponent.vue';
	import FootComponent from './components/FootComponent.vue';
	import { useRoute } from 'vue-router';

	const route = useRoute();
</script>