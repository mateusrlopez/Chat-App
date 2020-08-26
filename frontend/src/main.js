import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Echo from 'laravel-echo'
import io from 'socket.io-client'
import Vuelidate from 'vuelidate'

import '@/assets/css/style.css'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all'

Vue.config.productionTip = false

Vue.use(Vuelidate)

window.io = io
window.Echo = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname,
  enabledTransports: ['websocket']
})

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
