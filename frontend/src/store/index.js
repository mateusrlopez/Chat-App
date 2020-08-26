import Vue from 'vue'
import Vuex from 'vuex'
import api from '@/services/api'
import { saveToken, getUserFromToken } from '@/services/auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    token: window.localStorage.getItem('access_token') || null
  },
  mutations: {
    setToken (state, token) {
      state.token = token
    }
  },
  actions: {
    login ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        api.post('/auth/login', payload)
          .then(response => {
            console.log(response.data)
            saveToken(response.data.token)
            commit('setToken', response.data.token)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    signUp ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        api.post('/auth/sign-up', payload)
          .then(response => {
            saveToken(response.data.token)
            commit('setToken', response.data.token)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    resetPassword ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        api.post('/auth/reset-password', payload)
          .then(response => {
            saveToken(response.data.token)
            commit('setToken', response.data.token)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    }
  },
  getters: {
    currentUser: state => getUserFromToken(state.token),
    getAuthHeader: state => ({ Authorization: `Bearer ${state.token}` })
  },
  modules: {
  }
})
