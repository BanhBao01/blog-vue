import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        isLogin: false,
        count: 0
    },
    mutations: {
        checkLogin(state) {
            state.isLogin = !state.isLogin
        },
        increment(state) {
            state.count++
        }
    }
})