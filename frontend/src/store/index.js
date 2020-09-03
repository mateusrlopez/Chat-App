import Vue from 'vue'
import Vuex from 'vuex'

import channels from './modules/channels.module'
import users from './modules/users.module'

import api from '@/services/api'
import { saveAuth, destroyAuth } from '@/services/auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    token: window.localStorage.getItem('access_token'),
    loggedUser: JSON.parse(window.localStorage.getItem('user')) || null,
    loading: false
  },
  mutations: {
    alterLoading (state) {
      state.loading = !state.loading
    },
    setAuth (state, { token, user }) {
      state.token = token
      state.loggedUser = user
    },
    destroyAuth (state) {
      state.token = null
      state.loggedUser = null
    }
  },
  actions: {
    login ({ commit }, payload) {
      commit('alterLoading')
      return new Promise((resolve, reject) => {
        api.post('/auth/login', payload)
          .then(response => {
            saveAuth(response.data.token, response.data.user)
            commit('setAuth', { token: response.data.token, user: response.data.user })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
          .finally(() => {
            commit('alterLoading')
          })
      })
    },
    signUp ({ commit }, payload) {
      commit('alterLoading')
      return new Promise((resolve, reject) => {
        api.post('/auth/sign-up', payload)
          .then(response => {
            saveAuth(response.data.token, response.data.user)
            commit('setAuth', { token: response.data.token, user: response.data.user })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
          .finally(() => {
            commit('alterLoading')
          })
      })
    },
    resetPassword ({ commit }, payload) {
      commit('alterLoading')
      return new Promise((resolve, reject) => {
        api.post('/auth/reset-password', payload)
          .then(response => {
            saveAuth(response.data.token, response.data.user)
            commit('setAuth', { token: response.data.token, user: response.data.user })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
          .finally(() => {
            commit('alterLoading')
          })
      })
    },
    logout ({ commit }) {
      return new Promise((resolve, reject) => {
        api.get('/auth/logout')
          .then(response => {
            destroyAuth()
            commit('destroyAuth')
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    }
  },
  getters: {
    getLoggedUserId: state => state.loggedUser.id,
    isLoading: state => state.loading
  },
  modules: {
    channels,
    users
  }
})
