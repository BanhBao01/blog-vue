<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
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