import Vue from 'vue'
import Router from 'vue-router'
import home from './components/dashboard/home.vue'

Vue.use(Router)
export default new Router({
	  mode: 'history',
	  routes: 
	  [
		{
			path: '/dashboard',
			name: 'home',
			component: home,
				  
		}
				  
	    						
		]
})