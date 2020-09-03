import api from './api'

export const saveAuth = (token, user) => {
  window.localStorage.setItem('access_token', token)
  window.localStorage.setItem('user', JSON.stringify(user))
  window.Echo.connector.options.auth.headers.Authorization = token
  api.defaults.headers.common.Authorization = `Bearer ${token}`
}

export const destroyAuth = () => {
  window.localStorage.removeItem('access_token')
  window.localStorage.removeItem('user')
}
