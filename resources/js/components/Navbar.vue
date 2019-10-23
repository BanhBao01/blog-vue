<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <router-link to= "/admin" tag="span">
                <a class="navbar-brand">Blog Vue</a>
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <!-- <router-link v-for="(link,i) in links" :key="i" :class="nav-item" :to="link.path" tag="li">
                        <a class="nav-link">{{ link.name }}</a>
                    </router-link> -->
                    
                    <li class="nav-item" v-for="(link,i) in links" :key="i">
                        <router-link :to="link.path" tag="span">
                            <li class="nav-item">
                                <a class="nav-link">{{ link.name }}</a>
                            </li>
                        </router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Admin <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data () {
        return {
            links: [
                {path: '/admin/categories', name: 'Categories'},
                {path: '/admin/tags', name: 'Tags'},
                {path: '/admin/login', name: 'Login'},
            ]
        }
    }
}
</script>

<style>

</style>