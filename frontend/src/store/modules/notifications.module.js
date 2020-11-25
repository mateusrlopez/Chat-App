import api from '@/services/api'

const state = {
  notificationsList: []
}

const getters = {
  getNotificationsList: state => state.notificationsList,
  getNotificationsListLength: state => state.notificationsList.length,
  getUnreadNotificationsList: state => state.notificationsList.filter((value) => value.read_at),
  hasUnreadNotifications: (state, getters) => getters.getUnreadNotificationsList.length !== 0
}

const actions = {
  updateNotification ({ commit }, { id }) {
    return new Promise((resolve, reject) => {
      api.put(`/notifications/${id}`)
        .then(response => {
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  retrieveAuthUserNotificationsList ({ commit, getters }) {
    return new Promise((resolve, reject) => {
      api.get(`/users/${getters.authId}/notifications`)
        .then(response => {
          commit('setNotificationsList', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  }
}

const mutations = {
  addNotificationToList (state, notification) {
    state.notificationsList.push(notification)
  },
  setNotificationsList (state, notifications) {
    state.notificationsList = notifications
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
