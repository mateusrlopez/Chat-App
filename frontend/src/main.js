import Echo from 'laravel-echo'
import pusher from 'pusher-js'
import Vue from 'vue'

import router from '@/router'
import store from '@/store'
import vuetify from '@/plugins/vuetify'
import '@/plugins/vuelidate'
import '@/services/filters'

import '@/assets/css/style.css'

import App from '@/App.vue'

Vue.config.productionTip = false

window.Pusher = pusher

window.Echo = new Echo({
  authEndpoint: '/api/broadcasting/auth',
  broadcaster: 'pusher',
  disableStats: true,
  forceTLS: false,
  enabledTransports: ['ws'],
  encrypted: false,
  key: process.env.VUE_APP_PUSHER_KEY,
  wsHost: window.location.hostname
})

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
