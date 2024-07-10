<template>
	<header class="relative">
		<nav aria-label="Top">
			<!-- Secondary navigation -->
			<div class="bg-white">
				<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
					<div class="flex h-16 items-center justify-between">
						<!-- Logo (lg+) -->
						<div class="hidden lg:flex lg:flex-1 lg:items-center">
							<RouterLink to="/">
								<img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="" />
							</RouterLink>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</header>
</template>

<script setup>
	import { RouterLink } from 'vue-router';
</script>