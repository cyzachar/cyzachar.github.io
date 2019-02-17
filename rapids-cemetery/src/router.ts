import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
	routes: [
		{
			path: '/',
			name: 'home',
			component: () => import('./views/Home.vue')
		},
		{
			path: '/about',
			name: 'about',
			component: () => import('./views/About.vue')
		},
		{
			path: '/map',
			name: 'map',
			component: () => import('./views/MapView.vue')
		},
		{
			path: '/points-of-interest',
			name: 'points-of-interest',
			component: () => import('./views/PointsOfInterest.vue')
		},
		{
			path: '/trails',
			name: 'trails',
			component: () => import('./views/Trails.vue')
		},
		{
			path: '/history',
			name: 'history',
			component: () => import('./views/History.vue')
		},
		{
			path: '/tour',
			name: 'tour',
			component: () => import('./views/Tour.vue')
		},
		{
			path: '/contact',
			name: 'contact',
			component: () => import('./views/Contact.vue')
		},
	]
});
