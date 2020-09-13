import Echo from 'laravel-echo'
import pusher from 'pusher-js'
import Vue from 'vue'
import Vuelidate from 'vuelidate'

import App from './App.vue'
import router from './router'
import store from './store'
import api from './services/api'

import '@/assets/css/style.css'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all'

Vue.config.productionTip = false

Vue.use(Vuelidate)

window.Pusher = pusher

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.VUE_APP_PUSHER_KEY,
  wsHost: window.location.hostname,
  enabledTransports: ['ws'],
  forceTLS: false,
  disableStats: true,
  encrypted: false
})

window.Echo.connector.options.auth.headers.Authorization = `Bearer ${window.localStorage.getItem('access_token')}`
api.defaults.headers.common.Authorization = `Bearer ${window.localStorage.getItem('access_token')}`

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
