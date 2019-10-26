<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" v-model="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                        <div class="col-md-6">
                            <input id="password" @keyup.enter="login" v-model="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" @click="login">
                                Login
                            </button>

                                <a class="btn btn-link" href="#">
                                    Forgot Your Password?
                                </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            email: 'lesch.king@example.com',
            password: 'password'
        }
    },
    methods: {
        showAlert(title, type, message) {
            this.$swal({
                title: title,
                text: message,
                type: type,
                confirmButtonText: 'Ok'
            });
        },
        login () {
            var data = {
                client_id: 2,
                client_secret: 'kIXokuidJfYkGdQ3w8uEtX0dP9ftwrufsXqKJv5w',
                grant_type: 'password',
                username: this.email,
                password: this.password
            }

            this.$http.post('/oauth/token', data)
                .then(response => {
                    this.$auth.setToken(response.body.access_token,response.body.expires_in + Date.now())
                    this.$router.push('/admin')
                    this.$store.commit('checkLogin')
                    this.showAlert('Success','success','Login success')

                }, error => {
                    this.showAlert('Error','error','Login error !!')
                })
        }
    }
}
</script>

<style>

</style>