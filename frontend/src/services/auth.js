import api from './api'

export const setHeader = (accessToken, echoHeader = true) => {
  api.defaults.headers.common.Authorization = `Bearer ${accessToken}`
  if (echoHeader) {
    window.Echo.connector.options.auth.headers.Authorization = `Bearer ${accessToken}`
  }
}

export const saveAuth = (accessToken, refreshToken) => {
  window.localStorage.setItem('accessToken', accessToken)
  window.localStorage.setItem('refreshToken', refreshToken)
  setHeader(accessToken)
}

export const refreshAuth = accessToken => {
  window.localStorage.setItem('accessToken', accessToken)
  setHeader(accessToken)
}

export const destroyAuth = () => {
  window.localStorage.removeItem('accessToken')
  window.localStorage.removeItem('refreshToken')
}

export const getToken = tokenType => window.localStorage.getItem(`${tokenType}Token`)

export default {
  destroyAuth,
  getToken,
  refreshAuth,
  saveAuth,
  setHeader
}
