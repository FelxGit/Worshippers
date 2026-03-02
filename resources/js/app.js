require('./bootstrap')

import Vue from 'vue'
import App from './pages/App'
import lang from './config/lang.js'
import axios from './config/axios.js'
import router from './config/routes.js'
import moment from 'moment'
import vuelidate from 'vuelidate'

import { getters, mutations, actions } from "./store";

Vue.use(router)
Vue.use(vuelidate)
Vue.prototype.$http = axios
Vue.prototype.moment = moment

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    validations:{},
    created: function () {
        mutations.setLoading(true)

        // Auth
        let user = localStorage['community.user']? JSON.parse(localStorage['community.user']) : null;

        if(user) {
          mutations.setUser(user)
          mutations.setIsLoggedIn(true)
        }

        // language

        this.$http.get('api/language')
        .then( response => {
            let source = {
                'en.words': response.data.messages,
                'en.auth': response.data.auth,
                'en.validation': response.data.validation
            }

            lang.setMessages(source)
            mutations.setLang(lang)
        })
        .finally(() => {
            mutations.setLoading(false)
        })

        router.beforeEach((to, from, next) => {
            // if route is set to require authentication, redirect to login
            if (to.matched.some(record => record.meta.requiresAuth)) {
              if (this.user)
                next()
              else
                next({ name: 'login' })

            } else {
              if (!this._.isEmpty(this.user) && to.name.includes(['login', 'register']))
                next({ name: 'landing-page' })
              else
                next()
            }
          })
    },
    computed: {
        ...getters
    },
    methods: {
        ...mutations, ...actions,
    }
})