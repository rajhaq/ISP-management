import Vue from 'vue'
import Router from 'vue-router'
import home from './components/dashboard/home.vue'
import userlist from './components/user/userlist.vue'
import arealist from './components/area/arealist.vue'
import packagelist from './components/package/packagelist.vue'
import customerlist from './components/customer/customerlist.vue'
import billlist from './components/bill/billlist.vue'
import invoicecreate from './components/invoice/create.vue'
import invoicecreateuser from './components/invoice/createuser.vue'
import invoicelist from './components/invoice/invoicelist.vue'
import collector from './components/collector/collector.vue'
import setting from './components/setting/setting.vue'
import profile from './components/setting/profile.vue'
import collectorprofile from './components/collector/profile.vue'
import customerlistcollector from './components/collector/customerlist.vue'

let onlyAdmin = ['Admin']
let onlyCollector = ['Collector']
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
		{
			path: '/dashboard/billlist',
			name: 'billlist',
			component: billlist,
			meta: {
				allowed: onlyAdmin
			}
				  
		},		
		{
			path: '/dashboard/invoicecreate/:id',
			name: 'invoicecreateuser',
			component: invoicecreateuser,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		{
			path: '/dashboard/invoicecreate',
			name: 'invoicecreate',
			component: invoicecreate,
			meta: {
				allowed: onlyAdmin
			}
				  
		},

		{
			path: '/dashboard/invoicelist',
			name: 'invoicelist',
			component: invoicelist,
			meta: {
				allowed: onlyAdmin
			}
				  
		},	
		{
			path: '/collector',
			name: 'collector',
			component: collector,
			meta: {
				allowed: onlyCollector
			}
				  
		},
		{
			path: '/collector/profile',
			name: 'collectorprofile',
			component: collectorprofile,
			meta: {
				allowed: onlyCollector
			}
				  
		},
		{
			path: '/collector/customerlist',
			name: 'customerlistcollector',
			component: customerlistcollector,
			meta: {
				allowed: onlyCollector
			}
				  
		},		
		{
			path: '/dashboard/setting',
			name: 'setting',
			component: setting,
			meta: {
				allowed: onlyAdmin
			}
				  
		},
		{
			path: '/dashboard/profile',
			name: 'profile',
			component: profile,
			meta: {
				allowed: onlyAdmin
			}
				  
		},						  
	    						
		]
})