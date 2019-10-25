import Vue from 'vue'
import VueRouter from 'vue-router'
import AdminMaster from './components/AdminMaster'
import Login from './components/Auth/Login'
import Dashboard from './components/Dashboard.vue'
import Categories from './components/Category/Categories.vue'
import Tags from './components/Tag/Tags.vue'
import Posts from './components/Posts/Posts.vue'
import CreatePost from './components/Posts/Create.vue'
import EditPost from './components/Posts/Edit.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [{
        path: '/admin',
        component: AdminMaster,
        children: [
            { path: 'login', component: Login, meta: { forVisited: true } },
            { path: '', component: Dashboard, meta: { forAuth: true } },
            { path: 'categories', component: Categories, meta: { forAuth: true } },
            { path: 'tags', component: Tags, meta: { forAuth: true } },
            { path: 'posts', component: Posts, meta: { forAuth: true } },
            { path: 'posts/create', component: CreatePost, meta: { forAuth: true } },
            { path: 'posts/:id/edit', component: EditPost, meta: { forAuth: true } },
        ]
    }, ]
})

export default router