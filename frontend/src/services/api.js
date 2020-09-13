import axios from 'axios'
import store from '@/store'

const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL
})

api.interceptors.response.use(response => {
  return Promise.resolve(response)
}, error => {
  const { config } = error
  const { status, data } = error.response
  if (status === 401 && data.message === 'Token has expired') {
    return store.dispatch('refresh')
      .then(response => {
        config.headers.Authorization = `Bearer ${store.state.accessToken}`
        return api(config)
      })
      .catch(error => {
        return Promise.reject(error)
      })
  }
  return Promise.reject(error)
})

export default api
