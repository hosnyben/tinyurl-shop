<template>
    <footer aria-labelledby="footer-heading" class="bg-gray-50">
		<h2 id="footer-heading" class="sr-only">Footer</h2>
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="py-20">
				<div class="grid grid-cols-1 md:grid-flow-col md:auto-rows-min md:grid-cols-12 md:gap-x-8 md:gap-y-16">
					<!-- Image section -->
					<div class="col-span-1 md:col-span-2 lg:col-start-1 lg:row-start-1">
						<img src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" />
					</div>

					<!-- Sitemap sections -->
					<div class="col-span-6 mt-10 grid grid-cols-2 gap-8 sm:grid-cols-3 md:col-span-8 md:col-start-3 md:row-start-1 md:mt-0 lg:col-span-6 lg:col-start-2">
						<div class="grid grid-cols-1 gap-y-12 sm:col-span-2 sm:grid-cols-2 sm:gap-x-8">
							<div>
								<h3 class="text-sm font-medium text-gray-900">Products</h3>
								<ul role="list" class="mt-6 space-y-6">
									<li v-for="item in footerNavigation.products" :key="item.name" class="text-sm">
										<a :href="item.href" class="text-gray-500 hover:text-gray-600">{{ item.name }}</a>
									</li>
								</ul>
							</div>
							<div>
								<h3 class="text-sm font-medium text-gray-900">Company</h3>
								<ul role="list" class="mt-6 space-y-6">
									<li v-for="item in footerNavigation.company" :key="item.name" class="text-sm">
										<a :href="item.href" class="text-gray-500 hover:text-gray-600">{{ item.name }}</a>
									</li>
								</ul>
							</div>
						</div>
						<div>
							<h3 class="text-sm font-medium text-gray-900">Customer Service</h3>
							<ul role="list" class="mt-6 space-y-6">
								<li v-for="item in footerNavigation.customerService" :key="item.name" class="text-sm">
									<a :href="item.href" class="text-gray-500 hover:text-gray-600">{{ item.name }}</a>
								</li>
							</ul>
						</div>
					</div>

					<!-- Newsletter section -->
					<div class="mt-12 md:col-span-8 md:col-start-3 md:row-start-2 md:mt-0 lg:col-span-4 lg:col-start-9 lg:row-start-1">
						<h3 class="text-sm font-medium text-gray-900">Sign up for our newsletter</h3>
						<p class="mt-6 text-sm text-gray-500">The latest deals and savings, sent to your inbox weekly.</p>
						<form class="mt-2 flex sm:max-w-md">
							<label for="email-address" class="sr-only">Email address</label>
							<input id="email-address" type="text" autocomplete="email" required="" class="w-full min-w-0 appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" />
							<div class="ml-4 flex-shrink-0">
								<button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Sign up</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="border-t border-gray-100 py-10 text-center">
				<p class="text-sm text-gray-500">&copy; 2021 Your Company, Inc. All rights reserved.</p>
			</div>
		</div>
    </footer>
</template>

<script setup>
const footerNavigation = {
  products: [
    { name: 'Bags', href: '#' },
    { name: 'Tees', href: '#' },
    { name: 'Objects', href: '#' },
    { name: 'Home Goods', href: '#' },
    { name: 'Accessories', href: '#' },
  ],
  company: [
    { name: 'Who we are', href: '#' },
    { name: 'Sustainability', href: '#' },
    { name: 'Press', href: '#' },
    { name: 'Careers', href: '#' },
    { name: 'Terms & Conditions', href: '#' },
    { name: 'Privacy', href: '#' },
  ],
  customerService: [
    { name: 'Contact', href: '#' },
    { name: 'Shipping', href: '#' },
    { name: 'Returns', href: '#' },
    { name: 'Warranty', href: '#' },
    { name: 'Secure Payments', href: '#' },
    { name: 'FAQ', href: '#' },
    { name: 'Find a store', href: '#' },
  ],
}
</script>