import Vue from 'vue'
import Router from 'vue-router'
import home from './components/dashboard/home.vue'
import userlist from './components/user/userlist.vue'
let onlyAdmin = [1]
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
				  
		}
		
				  
	    						
		]
})