<template>
  <main class="mx-auto max-w-2xl px-4 lg:max-w-7xl lg:px-8">
    <div class="border-b border-gray-200 pb-10 pt-24 mb-12">
      <h1 class="text-4xl font-bold tracking-tight text-gray-900">All categories (Infinite Scroll)</h1>
    </div>

    <section aria-labelledby="product-heading" class="my-6">
      <div id="categories" class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8 xl:grid-cols-4">
        <div v-for="(category, key) in categories" :key="category.uuid" class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
          <div class="aspect-h-4 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96">
            <img :src="`https://tailwindui.com/img/ecommerce-images/home-page-04-collection-0${(key % 3) + 1}.jpg`" :alt="category.name" class="h-full w-full object-cover object-center sm:h-full sm:w-full" />
          </div>
          <div class="flex flex-1 flex-col space-y-2 p-4">
            <h3 class="text-sm font-medium text-gray-900">
              <RouterLink :to="`/category/${category.uuid}`">
                <span aria-hidden="true" class="absolute inset-0" />
                {{ category.name }}
              </RouterLink>
            </h3>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import { getCategories, getCategory } from '@/api';

// Get route name
const categories = ref([]);
const page = ref(1);
const loading = ref(true);

onMounted(async () => {
  await fetchCategories();
  window.addEventListener("scroll", checkScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", checkScroll);
});

const checkScroll = () => {
    let element = document.getElementById('categories');

    if (element.getBoundingClientRect().bottom < window.innerHeight && !loading.value) {
        page.value++;
        fetchCategories();
    }
};

const fetchCategories = async () => {
  loading.value = true;

  const { data } = await getCategories(page.value);

  if( data.length === 0 ) window.removeEventListener("scroll", checkScroll);
  categories.value = [...categories.value,...data];

  loading.value = false;
};
</script>