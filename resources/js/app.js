
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import store from './store'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'font-awesome/css/font-awesome.min.css' // Ensure you are using css-loader

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import Vuetify from 'vuetify'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


Vue.use(Vuetify, {
    iconfont: 'mdi' || 'md' || 'fa' || 'fa4'
  })/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let userType = window.authUser.userType


router.beforeEach((to, from, next) => {
	//document.title=to.meta.title
   
    if(to.meta){
        let allowed = to.meta.allowed
        for(let a of allowed){
            if(a!=userType){
                return
            }
        }
    }
    
    next();
  
  });
Vue.component('dashboard', require('./components/dashboard.vue').default);
import router from './router'
const app = new Vue({
    el: '#app',
    router,
   store: store,
});

