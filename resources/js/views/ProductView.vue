<template>
	<main>
		<!-- Product info -->
		<div class="mx-auto max-w-2xl px-4 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:pt-16">
			<h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ singleProduct.name }}</h1>
			<p class="text-3xl tracking-tight text-gray-900">{{ singleProduct.price / 100 }}$</p>

			<!-- Description and details -->
			<div>
				<div class="space-y-6">
					<p class="text-base text-gray-900">{{ singleProduct.description }}</p>
				</div>
			</div>
		</div>

		<section aria-labelledby="related-products-heading" class="bg-white">
			<div class="mx-auto max-w-2xl px-4 py-24 sm:px-6 lg:max-w-7xl lg:px-8">
				<h2 id="related-products-heading" class="text-xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>

				<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
					<div v-for="(product, key) in viewedProducts" :key="product.uuid" class="group relative">
						<div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
							<img :src="`https://tailwindui.com/img/ecommerce-images/category-page-02-image-card-0${(key % 6) + 1}.jpg`" :alt="product.name" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
						</div>
						<div class="mt-4 flex justify-between">
							<div>
								<h3 class="text-sm text-gray-700">
									<RouterLink :to="`/product/${product.uuid}`">
										<span aria-hidden="true" class="absolute inset-0" />
										{{ product.name }}
									</RouterLink>
								</h3>
								<p class="mt-1 text-sm text-gray-500">{{ product.description }}</p>
							</div>
							<p class="text-sm font-medium text-gray-900">{{ product.price }}</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
</template>  
<script setup>
  import { RouterLink, useRoute } from 'vue-router';
  import { ref, onMounted, onUnmounted } from 'vue';
  import { getProduct, getLastViewedProducts } from '@/api';

  // Get route name
  const uuid = useRoute().params.uuid;
  const viewedProducts = ref([]);
  const singleProduct = ref({
    name: 'Loading',
    description: 'Loading',
    price: 0
  });

  onMounted(async () => {
    singleProduct.value = await getProduct(uuid);
    viewedProducts.value = await getLastViewedProducts();
  });
</script>