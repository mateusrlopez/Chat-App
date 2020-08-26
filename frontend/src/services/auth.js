import jwtDecode from 'jwt-decode'

export const saveToken = token => {
  window.localStorage.setItem('access_token', token)
  window.Echo.connector.options.auth.headers.Authorization = token
}

export const getUserFromToken = token => {
  const tokenData = jwtDecode(token)
  return { id: tokenData.sub, name: tokenData.name }
}

export const destroyToken = () => {
  window.localStorage.removeItem('access_token')
}
