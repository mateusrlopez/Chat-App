import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Echo from 'laravel-echo'
import io from 'socket.io-client'
import Vuelidate from 'vuelidate'

import '@/assets/css/style.css'

Vue.config.productionTip = false

Vue.use(Vuelidate)

window.io = io
window.Echo = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname,
  auth: {
    headers: {
      Authorization: `Bearer ${window.localStorage.getItem('access_token')}`
    }
  }
})

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
