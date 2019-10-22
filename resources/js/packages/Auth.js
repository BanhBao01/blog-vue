export default function(Vue) {
    let Auth = {}
    Vue.auth = {
        setToken: (token, expires_in) => {
            localStorage.setItem('token', token);
            localStorage.setItem('exprire_in', expires_in);
        },

        getToken: () => {
            var token = localStorage.getItem('token')
            var exprire_in = localStorage.getItem('exprire_in')

            if (!token || !exprire_in) {
                return null
            }

            if (Date.now() > parseInt(exprire_in)) {
                this.destroyToken()
                return null
            } else {
                return token
            }
        },

        destroyToken: () => {
            localStorage.removeItem('token');
            localStorage.removeItem('exprire_in');
        },

        isLogin: () => {
            var token = localStorage.getItem('token')
            var exprire_in = localStorage.getItem('exprire_in')

            if (!token || !exprire_in) {
                return false
            }

            if (Date.now() > parseInt(exprire_in)) {
                this.destroyToken()
                return false
            } else {
                return true
            }
        },
        setUser: (data) => {
            Auth = data;
        },
        getUser: () => {
            return Auth;
        }


    }

    Object.defineProperties(Vue.prototype, {
        $auth: {
            get: () => {
                return Vue.auth
            }
        }
    })

}