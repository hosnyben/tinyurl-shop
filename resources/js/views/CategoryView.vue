<template>
  <main class="mx-auto max-w-2xl px-4 lg:max-w-7xl lg:px-8">
    <div class="border-b border-gray-200 pb-10 pt-24 mb-12">
      <h1 class="text-4xl font-bold tracking-tight text-gray-900">{{ pageTitle }} (Infinite Scroll)</h1>
    </div>

    <section aria-labelledby="product-heading" class="my-6">
      <div id="products" class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8 xl:grid-cols-4">
        <div v-for="(product, key) in products" :key="product.uuid" class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
          <div class="aspect-h-4 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96">
            <img :src="`https://tailwindui.com/img/ecommerce-images/category-page-02-image-card-0${(key % 6) + 1}.jpg`" :alt="product.name" class="h-full w-full object-cover object-center sm:h-full sm:w-full" />
          </div>
          <div class="flex flex-1 flex-col space-y-2 p-4">
            <h3 class="text-sm font-medium text-gray-900">
              <RouterLink :to="`/product/${product.uuid}`">
                <span aria-hidden="true" class="absolute inset-0" />
                {{ product.name }}
              </RouterLink>
            </h3>
            <p class="text-sm text-gray-500">{{ product.description }}</p>
            <div class="flex flex-1 flex-col justify-end">
              <p class="text-base font-medium text-gray-900">{{ product.price / 100 }}$</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import { getProducts, getCategory } from '@/api';

// Get route name
const routeName = useRoute().name;
const uuid = useRoute().params.uuid;
const products = ref([]);
const page = ref(1);
const loading = ref(true);
const pageTitle = ref('Custom page');

onMounted(async () => {
  if( routeName == 'category' && uuid ) {
    const data = await getCategory(uuid);
    pageTitle.value = data.name;
  } else if( routeName == 'top-products' ) {
    pageTitle.value = 'Top products';
  }
  
  await fetchProducts();
  window.addEventListener("scroll", checkScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", checkScroll);
});

const checkScroll = () => {
    let element = document.getElementById('products');

    if (element.getBoundingClientRect().bottom < window.innerHeight && !loading.value) {
        page.value++;
        fetchProducts();
    }
};

const fetchProducts = async () => {
  loading.value = true;
  var params = {
    page: page.value
  };

  if( routeName == 'category' && uuid ) {
    params = {category: uuid,...params};
  } else if( routeName == 'top-products' ) {
    params = {top: 1,...params};
  }

  const { data } = await getProducts(params);
  if( data.length === 0 ) window.removeEventListener("scroll", checkScroll);
  products.value = [...products.value,...data];

  loading.value = false;
};
</script>