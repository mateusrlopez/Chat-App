import api from '@/services/api'
import authService from '@/services/auth'

const state = {
  accessToken: authService.getToken('access'),
  refreshToken: authService.getToken('refresh'),
  authUser: null
}

const getters = {
  authId: state => state.authUser.id,
  authProfilePicture: state => state.authUser.profile_photo_url
}

const actions = {
  checkAuth ({ commit, state }) {
    if (state.accessToken && state.refreshToken) {
      authService.setHeader(state.accessToken)
      if (!state.authUser) {
        return new Promise((resolve, reject) => {
          api.get('/auth/me')
            .then(response => {
              commit('setUser', response.data.user)
              resolve(response)
            })
            .catch(error => {
              reject(error)
            })
        })
      }
    } else {
      commit('destroyAuth')
    }
  },
  login ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      commit('alterLoading')
      api.post('/auth/login', payload)
        .then(response => {
          const { accessToken, refreshToken, user } = response.data
          commit('setAuth', { accessToken, refreshToken, user })
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
    commit('destroyAuth')
  },
  refresh ({ commit, state }) {
    return new Promise((resolve, reject) => {
      authService.setHeader(state.refreshToken, false)
      api.get('/auth/refresh')
        .then(response => {
          const { accessToken } = response.data
          commit('refreshAccessToken', accessToken)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  signUp ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      commit('alterLoading')
      api.post('/auth/sign-up', payload)
        .then(response => {
          const { accessToken, refreshToken, user } = response.data
          commit('setAuth', { accessToken, refreshToken, user })
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
}

const mutations = {
  destroyAuth (state) {
    state.accessToken = null
    state.refreshToken = null
    state.authUser = null
    authService.destroyAuth()
  },
  refreshAccessToken (state, accessToken) {
    state.accessToken = accessToken
    authService.refreshAuth(accessToken)
  },
  setAuth (state, { accessToken, refreshToken, user }) {
    state.accessToken = accessToken
    state.refreshToken = refreshToken
    state.authUser = user
    authService.saveAuth(accessToken, refreshToken)
  },
  setUser (state, user) {
    state.authUser = user
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
