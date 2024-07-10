<template>
	<header class="relative">
		<nav aria-label="Top">
			<!-- Secondary navigation -->
			<div class="bg-white">
				<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
					<div class="flex h-16 items-center justify-between">
						<!-- Logo (lg+) -->
						<div class="hidden lg:flex lg:flex-1 lg:items-center">
							<a href="#">
								<span class="sr-only">Your Company</span>
								<img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="" />
							</a>
						</div>

						<div class="hidden h-full lg:flex">
							<div class="flex h-full justify-center space-x-8">
								<RouterLink v-for="page in navigation.pages" :key="page.name" :to="page.href" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">{{ page.name }}</RouterLink>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</header>
</template>

<script setup>
	import { RouterLink } from 'vue-router';

    const navigation = {
        pages: [
			{
                name: 'Company',
                href: '#'
            },
            {
                name: 'Stores',
                href: '#'
            },
        ],
    };
</script>