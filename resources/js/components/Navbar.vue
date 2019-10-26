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
                <ul class="navbar-nav ml-auto" v-if="checkLogin | isAuth">
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
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" role="button" @click="showDropMenu(isClick)">
                            Admin <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" @click="logout">Logout</a>
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
                {path: '/admin/posts', name: 'Posts', isAuth: true},
                {path: '/admin/categories', name: 'Categories', isAuth: true},
                {path: '/admin/tags', name: 'Tags', isLogin: true},
            ],
            isAuth: this.$auth.isLogin(),
            isClick: true
        }
    },
    methods: {
        showDropMenu (a) {
            if(a){
                $('.dropdown-menu-right').css('display','block')
                this.isClick = false
            }else{
                $('.dropdown-menu-right').css('display','none')
                this.isClick = true
            }
        },
        logout () {
            this.$auth.destroyToken()
            this.$store.commit('checkLogin')
            this.$router.push('/admin/login')
        }
    },
    computed: {
        checkLogin () {
            return this.$store.state.isLogin
        }
    },
    mounted() {
        
    },
}
</script>

<style>

</style>