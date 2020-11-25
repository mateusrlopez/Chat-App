import api from '@/services/api'

const state = {
  administrators: [],
  channel: null,
  invites: [],
  messages: [],
  users: []
}

const getters = {
}

const actions = {
  createChannel ({ getters }, { name, isPrivate, tags, description }) {
    return new Promise((resolve, reject) => {
      api.post('/channels', { name, private: isPrivate, tags, description, owner_id: getters.authId })
        .then(response => {
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  }
}

const mutations = {
}

export default {
  state,
  getters,
  actions,
  mutations
}
