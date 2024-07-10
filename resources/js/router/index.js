import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CategoryView from '../views/CategoryView.vue'
import ProductView from '../views/ProductView.vue'
import CategoriesView from '../views/CategoriesView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
		{
			path: '/category/:uuid',
			name: 'category',
			component: CategoryView
		},
		{
			path: '/product/:uuid',
			name: 'product',
			component: ProductView
		},
		{
			path: '/top-products',
			name: 'top-products',
			component: CategoryView
		},
		{
			path: '/categories',
			name: 'categories',
			component: CategoriesView
		},
  ]
})

export default router
