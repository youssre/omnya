/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Form from 'vform'
window.Form = Form;

import Swal from 'sweetalert2'
window.Swal = Swal;

import VueProgressBar from 'vue-progressbar'
import 'bootstrap-icons/font/bootstrap-icons.css';

import BootstrapVue from "bootstrap-vue";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import VueGoodTable from 'vue-good-table';

import 'vue-good-table/dist/vue-good-table.css';
import CookieLaw from "vue-cookie-law";

Vue.use(CookieLaw);

Vue.use(VueGoodTable);

Vue.use(BootstrapVue);

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})

import VueContentPlaceholders from 'vue-content-placeholders'

Vue.use(VueContentPlaceholders)

import Loading from 'vue-loading-overlay';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// const routes = [
//     { path: '/a', component: require('./components/ExampleComponent.vue').default },
// ]

// const router = new VueRouter({
//     mode: 'history',
//     router,
//     routes // short for `routes: routes`
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './routes.js'

const app = new Vue({

    router,
    el: '#app',
    components: {
        VueGoodTable,
    }
});
