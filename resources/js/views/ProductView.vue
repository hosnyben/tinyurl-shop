<template>
	<main>
		<!-- Product info -->
		<div class="mx-auto max-w-2xl px-4 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:pt-16">
			<h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ product.name }}</h1>
			<p class="text-3xl tracking-tight text-gray-900">{{ product.price }}</p>

			<!-- Description and details -->
			<div>
				<h3 class="sr-only">Description</h3>

				<div class="space-y-6">
					<p class="text-base text-gray-900">{{ product.description }}</p>
				</div>
			</div>

			<div class="mt-10">
				<h3 class="text-sm font-medium text-gray-900">Highlights</h3>

				<div class="mt-4">
					<ul role="list" class="list-disc space-y-2 pl-4 text-sm">
						<li v-for="highlight in product.highlights" :key="highlight" class="text-gray-400">
							<span class="text-gray-600">{{ highlight }}</span>
						</li>
					</ul>
				</div>
			</div>

			<section aria-labelledby="shipping-heading" class="mt-10">
				<h2 id="shipping-heading" class="text-sm font-medium text-gray-900">Details</h2>

				<div class="mt-4 space-y-6">
					<p class="text-sm text-gray-600">{{ product.details }}</p>
				</div>
			</section>
		</div>

		<section aria-labelledby="related-products-heading" class="bg-white">
			<div class="mx-auto max-w-2xl px-4 py-24 sm:px-6 lg:max-w-7xl lg:px-8">
				<h2 id="related-products-heading" class="text-xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>

				<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
					<div v-for="product in products" :key="product.id" class="group relative">
						<div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
							<img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
						</div>
						<div class="mt-4 flex justify-between">
							<div>
								<h3 class="text-sm text-gray-700">
									<a :href="product.href">
										<span aria-hidden="true" class="absolute inset-0" />
										{{ product.name }}
									</a>
								</h3>
								<p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
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
  import { ref } from 'vue'
  import {
    RadioGroup,
    RadioGroupOption,
  } from '@headlessui/vue'
	
  const product = {
    name: 'Basic Tee 6-Pack',
    price: '$192',
    href: '#',
    breadcrumbs: [
      { id: 1, name: 'Men', href: '#' },
      { id: 2, name: 'Clothing', href: '#' },
    ],
    images: [
      {
        src: 'https://tailwindui.com/img/ecommerce-images/product-page-02-secondary-product-shot.jpg',
        alt: 'Two each of gray, white, and black shirts laying flat.',
      },
      {
        src: 'https://tailwindui.com/img/ecommerce-images/product-page-02-tertiary-product-shot-01.jpg',
        alt: 'Model wearing plain black basic tee.',
      },
      {
        src: 'https://tailwindui.com/img/ecommerce-images/product-page-02-tertiary-product-shot-02.jpg',
        alt: 'Model wearing plain gray basic tee.',
      },
      {
        src: 'https://tailwindui.com/img/ecommerce-images/product-page-02-featured-product-shot.jpg',
        alt: 'Model wearing plain white basic tee.',
      },
    ],
    colors: [
      { name: 'White', class: 'bg-white', selectedClass: 'ring-gray-400' },
      { name: 'Gray', class: 'bg-gray-200', selectedClass: 'ring-gray-400' },
      { name: 'Black', class: 'bg-gray-900', selectedClass: 'ring-gray-900' },
    ],
    sizes: [
      { name: 'XXS', inStock: false },
      { name: 'XS', inStock: true },
      { name: 'S', inStock: true },
      { name: 'M', inStock: true },
      { name: 'L', inStock: true },
      { name: 'XL', inStock: true },
      { name: '2XL', inStock: true },
      { name: '3XL', inStock: true },
    ],
    description:
      'The Basic Tee 6-Pack allows you to fully express your vibrant personality with three grayscale options. Feeling adventurous? Put on a heather gray tee. Want to be a trendsetter? Try our exclusive colorway: "Black". Need to add an extra pop of color to your outfit? Our white tee has you covered.',
    highlights: [
      'Hand cut and sewn locally',
      'Dyed with our proprietary colors',
      'Pre-washed & pre-shrunk',
      'Ultra-soft 100% cotton',
    ],
    details:
      'The 6-Pack includes two black, two white, and two heather gray Basic Tees. Sign up for our subscription service and be the first to get new, exciting colors, like our upcoming "Charcoal Gray" limited release.',
  }
  const reviews = {
    href: '#',
    average: 4,
    totalCount: 117,
    featured: [
      {
        id: 1,
        title: 'This is the best white t-shirt out there',
        rating: 5,
        content: `
          <p>I've searched my entire life for a t-shirt that reflects every color in the visible spectrum. Scientists said it couldn't be done, but when I look at this shirt, I see white light bouncing right back into my eyes. Incredible!</p>
        `,
        author: 'Mark Edwards',
        avatarSrc:
          'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixqx=oilqXxSqey&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      },
      {
        id: 2,
        title: 'Adds the perfect variety to my wardrobe',
        rating: 4,
        content: `
          <p>I used to be one of those unbearable minimalists who only wore the same black v-necks every day. Now, I have expanded my wardrobe with three new crewneck options! Leaving off one star only because I wish the heather gray was more gray.</p>
        `,
        author: 'Blake Reid',
        avatarSrc:
          'https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.5&w=256&h=256&q=80',
      },
      {
        id: 3,
        title: 'All good things come in 6-Packs',
        rating: 5,
        content: `
          <p>Tasty beverages, strong abs that will never be seen due to aforementioned tasty beverages, and these Basic Tees!</p>
        `,
        author: 'Ben Russel',
        avatarSrc:
          'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      },
    ],
  }
  const products = [
    {
      id: 1,
      name: 'Basic Tee',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: '$35',
      color: 'Black',
    },
    // More products...
  ]
  
  const selectedColor = ref(product.colors[0])
  const selectedSize = ref(product.sizes[2])
  </script>