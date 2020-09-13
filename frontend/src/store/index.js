import Vue from 'vue'
import Vuex from 'vuex'

import channels from './modules/channels.module'
import users from './modules/users.module'

import api from '@/services/api'
import { saveAuth, refreshAuth, destroyAuth } from '@/services/auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    accessToken: window.localStorage.getItem('access_token'),
    refreshToken: window.localStorage.getItem('refresh_token'),
    loggedUser: JSON.parse(window.localStorage.getItem('user')) || null,
    loading: false
  },
  mutations: {
    alterLoading (state) {
      state.loading = !state.loading
    },
    setAuth (state, { accessToken, refreshToken, user }) {
      state.accessToken = accessToken
      state.refreshToken = refreshToken
      state.loggedUser = user
    },
    refreshAccessToken (state, accessToken) {
      state.accessToken = accessToken
    },
    destroyAuth (state) {
      state.accessToken = null
      state.refreshToken = null
      state.loggedUser = null
    }
  },
  actions: {
    login ({ commit }, payload) {
      commit('alterLoading')
      return new Promise((resolve, reject) => {
        api.post('/auth/login', payload)
          .then(response => {
            saveAuth(response.data.access_token, response.data.refresh_token, response.data.user)
            commit('setAuth', { accessToken: response.data.access_token, refreshToken: response.data.refresh_token, user: response.data.user })
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
      destroyAuth()
      commit('destroyAuth')
    },
    refresh ({ commit, state }) {
      return new Promise((resolve, reject) => {
        api.defaults.headers.common.Authorization = `Bearer ${state.refreshToken}`
        api.get('/auth/refresh')
          .then(response => {
            refreshAuth(response.data.access_token)
            commit('refreshAccessToken', response.data.access_token)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    resetPassword ({ commit }, payload) {
      commit('alterLoading')
      return new Promise((resolve, reject) => {
        api.post('/auth/reset-password', payload)
          .then(response => {
            saveAuth(response.data.access_token, response.data.refresh_token, response.data.user)
            commit('setAuth', { accessToken: response.data.access_token, refreshToken: response.data.refresh_token, user: response.data.user })
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
            saveAuth(response.data.access_token, response.data.refresh_token, response.data.user)
            commit('setAuth', { accessToken: response.data.access_token, refreshToken: response.data.refresh_token, user: response.data.user })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
          .finally(() => {
            commit('alterLoading')
          })
      })
    }
  },
  getters: {
    getLoggedUserId: state => state.loggedUser?.id,
    isLoading: state => state.loading
  },
  modules: {
    channels,
    users
  }
})
