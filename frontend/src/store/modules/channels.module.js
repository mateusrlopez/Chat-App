const state = {
  channels: {},
  currentChannel: {}
}

const getters = {
  getCurrentChannel: state => Object.assign({}, state.currentChannel)
}

const actions = {
}

const mutations = {
}

export default {
  state,
  getters,
  actions,
  mutations
}