import api from './api'

export const saveAuth = (accessToken, refreshToken, user) => {
  window.localStorage.setItem('access_token', accessToken)
  window.localStorage.setItem('refresh_token', refreshToken)
  window.localStorage.setItem('user', JSON.stringify(user))
  window.Echo.connector.options.auth.headers.Authorization = `Bearer ${accessToken}`
  api.defaults.headers.common.Authorization = `Bearer ${accessToken}`
}

export const refreshAuth = (accessToken) => {
  window.localStorage.setItem('access_token', accessToken)
  window.Echo.connector.options.auth.headers.Authorization = `Bearer ${accessToken}`
  api.defaults.headers.common.Authorization = `Bearer ${accessToken}`
}

export const destroyAuth = () => {
  window.localStorage.removeItem('access_token')
  window.localStorage.removeItem('refresh_token')
  window.localStorage.removeItem('user')
}
