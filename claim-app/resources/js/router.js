import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Dashboard from './pages/Dashboard.vue'
import ClaimList from './pages/ClaimList.vue'
import ClaimNew from './pages/ClaimNew.vue'
import NotFound from './pages/NotFound.vue'
import Login from './pages/Login.vue'

import store from './store'

function requireAuth(to, from, next){
  if (store.state.token)
  {
    next()
  }
  else{
    next('/');
  }
}

const routes = [
  {
    path: '*',
    redirect: {
      path: '/404'
    }
  },
  {
    path: '/404',
    name: 'NotFound',
    component: NotFound,
    meta: {
      public: true,
    },
  },
  {
    path: '/',
    name: 'login',
    component: Login,
    meta: {
      public: true,
    },
    beforeEnter (to, from, next){
      // if (localStorage.getItem("token"))
      if (store.state.token)
      {
        next('/dashboard')
      }
      else {
        next()
      }
    }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    beforeEnter: requireAuth
  },
  {
    path: '/claim',
    name: 'claim-list',
    component: ClaimList,
    beforeEnter: requireAuth
  },
  {
    path: '/claim/new',
    name: 'claim-new',
    component: ClaimNew,
    beforeEnter: requireAuth
  }
]

// exports the routes const
export default new VueRouter({
  routes, // short for routes: routes
  linkExactActiveClass: 'active'
});;
