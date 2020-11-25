import Vue from 'vue'
import Vuex from 'vuex'

import channels from './modules/channels.module'
import users from './modules/users.module'
import auth from './modules/auth.module'
import notifications from './modules/notifications.module'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loading: false
  },
  mutations: {
    alterLoading (state) {
      state.loading = !state.loading
    }
  },
  actions: {
  },
  getters: {
    isLoading: state => state.loading
  },
  modules: {
    auth,
    channels,
    notifications,
    users
  }
})
