<template>
	<HeadComponent />
	<RouterView />
	<FootComponent />
</template>

<script setup>
	import { RouterView } from 'vue-router';
	import HeadComponent from './components/HeadComponent.vue';
	import FootComponent from './components/FootComponent.vue';
</script>