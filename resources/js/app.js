/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueResource from 'vue-resource'
import App from './App.vue'
import router from './router.js'
import Auth from './packages/Auth.js'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueResource)
Vue.use(Auth)
Vue.use(VueSweetalert2)

router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.meta.forVisited)) {
            if (Vue.auth.isLogin()) {
                next({
                    path: "/admin"
                })
            } else {
                next()
            }
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isLogin()) {
                next({
                    path: "/admin/login"
                })
            } else {
                next()
            }
        } else {
            next()
        }
    }
)

new Vue({
    el: '#app',
    render: h => h(App),
    router
})