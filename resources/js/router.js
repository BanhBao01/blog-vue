import Vue from 'vue'
import VueRouter from 'vue-router'
import AdminMaster from './components/AdminMaster'
import Login from './components/Auth/Login'
import Dashboard from './components/Dashboard.vue'
import Categories from './components/Category/Categories.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [{
        path: '/admin',
        component: AdminMaster,
        children: [
            { path: 'login', component: Login, meta: { forVisited: true } },
            { path: '', component: Dashboard, meta: { forAuth: true } },
            { path: 'categories', component: Categories, meta: { forAuth: true } },
        ]
    }, ]
})

export default router