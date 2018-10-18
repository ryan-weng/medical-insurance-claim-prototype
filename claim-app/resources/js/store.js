import Vue from 'vue'
import Vuex from 'vuex'

import router from './router'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    token: null,
    userId: null,
    user: null,
    notifications: []
  },
  mutations: {
    authUser(state, userData){
      state.token = userData.token
      state.userId = userData.userId
    },
    clearAuthData(state){
      state.token = null
      state.userId = null
    },
    storeUser(state, user){
      state.user = user
    },
    storeNotifications(state, notifications){
      state.notifications = notifications
    }
  },
  actions: {
    setLogoutTimer({dispatch}, expirationTime) {
      setTimeout(() => {
        dispatch('logout')
      }, expirationTime * 1000);
    },
    autoLogin({commit}){
      const token = localStorage.getItem('token')
      if (!token) return
      const expirationDate = localStorage.getItem('expirationDate')
      if (new Date(expirationDate) < new Date()) return
      const userId = localStorage.getItem('userId')
      commit('authUser',{
        token: token,
        userId: userId
      })
      router.replace({ name: 'dashboard' })
    },
    login({commit, dispatch}, authData){
      axios.post('/api/authenticate', {
        username: authData.username,
        password: authData.password
      }).then(response => {
        console.log(response)
        commit('authUser', {
          token: response.data.token,
          userId: response.data.user.id
        })
        const expirationDate = new Date(new Date().getTime() + response.data.expiresIn * 1000);
        localStorage.setItem('token', response.data.token)
        localStorage.setItem('userId', response.data.user.id)
        localStorage.setItem('expirationDate', expirationDate)
        dispatch('setLogoutTimer', response.data.expiresIn)
        router.push({ name: 'dashboard' })
      }).catch(error => {
        console.log(error)
      });
    },
    logout({commit}){
      commit('clearAuthData')
      // localStorage.removeItem('token')
      // localStorage.removeItem('userId')
      // localStorage.removeItem('expirationDate')
      localStorage.clear()
      router.replace({ name: 'login' })
    },
    fetchUser({commit, state}){
      if (!state.token) return
      axios.get('/api/user/')
        .then((response) => {
          // console.log(response)
          commit('storeUser', response.data.user)
        })
    },
    fetchNotification({commit, state}){
      if (!state.token) return
      axios.post('/api/claims/notifications/app', {
        id: state.userId
      }).then((response) => {
        commit('storeNotifications', response.data)
      })
    }
  },
  getters: {
    user(state){
      return state.user
    },
    notifications(state){
      return state.notifications
    }
  }
})
