import Vue from 'vue'
import Vuex from 'vuex'
import api from '@/services/api'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {},
    errors: {}
  },
  mutations: {
    setUser (state, user) {
      state.user = user
    },
    setErrors (state, error) {
      state.errors = error
    }
  },
  actions: {
    login ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        api.post('/auth/login', payload)
          .then(response => {
            window.localStorage.setItem('access_token', response.data.token)
            commit('setUser', response.data.user)
            resolve(response)
          })
          .catch(error => {
            commit('setErrors', error.response.data.errors)
            reject(error)
          })
      })
    },
    signUp ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        api.post('/auth/sign-up', payload)
          .then(response => {
            window.localStorage.setItem('access_token', response.data.token)
            commit('setUser', response.data)
            resolve(response)
          })
          .catch(error => {
            commit('setErrors', error.response.data.errors)
            reject(error)
          })
      })
    },
    resetPassword ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        api.post('/auth/reset-password', payload)
          .then(response => {
            window.localStorage.setItem('access_token', response.data.token)
            commit('setUser', response.data)
            resolve(response)
          })
          .catch(error => {
            commit('setErrors', error.response.data.errors)
            reject(error)
          })
      })
    }
  },
  getters: {
    currentUser: state => state.user,
    getErrors: state => state.errors
  },
  modules: {
  }
})
