import Vue from 'vue'
import Router from 'vue-router'
import home from './components/dashboard/home.vue'
import userlist from './components/user/userlist.vue'
import arealist from './components/area/arealist.vue'
import packagelist from './components/package/packagelist.vue'
import customerlist from './components/customer/customerlist.vue'
let onlyAdmin = ['Admin']
let adminAndSale = [1, 2]
Vue.use(Router)
export default new Router({
	  mode: 'history',
	  routes: 
	  [
		{
			path: '/dashboard',
			name: 'home',
			component: home,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		{
			path: '/dashboard/userlist',
			name: 'userlist',
			component: userlist,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		{
			path: '/dashboard/arealist',
			name: 'arealist',
			component: arealist,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		{
			path: '/dashboard/packagelist',
			name: 'packagelist',
			component: packagelist,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		{
			path: '/dashboard/customerlist',
			name: 'customerlist',
			component: customerlist,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		
				  
	    						
		]
})