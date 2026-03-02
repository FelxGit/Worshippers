import Vue from 'vue'
import appConfig from './app.env'
import axios from 'axios'
import { getters, mutations, actions } from '../store'

const instance = axios.create({
    baseURL: appConfig.SERVER_URL,
    headers: {
      'Authorization' : `Bearer ${(localStorage.getItem('community.jwt') ? JSON.parse(localStorage.getItem('community.jwt')) : '')}`,
      'Content-Type': 'application/json'
      }
  })

instance.interceptors.request.use(config => {
  const urlParams = new URLSearchParams(window.location.search);
  const param_token = urlParams.get('token') ? urlParams.get('token') : null;

  if (param_token) {
    config.headers['Content-Type'] = 'application/json'
    config.headers['Authorization'] = 'Bearer ' + param_token
  }

  // mutations.setLoading(true)
  return config
})


instance.interceptors.response.use(response => {
  mutations.setLoading(false)
  return response
})

export default instance
