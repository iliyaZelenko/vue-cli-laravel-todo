import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-plugin-axios'

Vue.use(VueAxios, {
  axios,
  config: {
    baseURL: process.env.VUE_APP_BACKEND + '/api/'
  },
  interceptors: {
    beforeResponseError (error) {
      if (error.response.data.message) {
        alert(error.response.data.message) // showing error message

        return Promise.reject(error)
      }
    }
  }
})
