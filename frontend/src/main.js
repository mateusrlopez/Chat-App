import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Echo from 'laravel-echo'

Vue.config.productionTip = false

window.Echo = new Echo({
  broadcaster: 'socket.io',
  host: 'http://localhost/ws'
})

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
