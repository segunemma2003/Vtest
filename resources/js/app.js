/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import store from './store';
import router from './router';
// import Vuetify from 'vueti fy';
import Vuetify from 'vuetify'
import VueSweetalert2 from 'vue-sweetalert2';
// import Vuetify from '../plugins/vuetify';
window.Vue = require('vue');
Vue.use(VueSweetalert2);

Vue.use(Vuetify);
import 'vuetify/dist/vuetify.min.css'
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-home', require('./components/Home.vue').default);
Vue.component('login-form', require('./pages/loginForm.vue').default);
Vue.component('register-form', require('./pages/registerForm.vue').default);
const vuetify = new Vuetify();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify,
    store,
    router,
    el: '#app',
    
});
