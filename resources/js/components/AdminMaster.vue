<template>
    <div id="app">
        <navbar></navbar>
        <div class="py-4 container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar.vue'
export default {
    data () {
        return {

        }
    },
    components: {
        navbar: Navbar
    }
}
</script>

<style>

</style>