import Dashboard from './pages/Dashboard.vue'
import RemitNew from './pages/RemitNew.vue'
import RemitList from './pages/RemitList.vue'
import RemitDetail from './pages/RemitDetail.vue'
import NotFound from './pages/NotFound.vue'
import Login from './pages/Login.vue'

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
    // redirect: '/dashboard',
    component: Login,
    meta: {
      public: true,
    },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard
  },
  {
    path: '/remit/new',
    name: 'remittance-new',
    component: RemitNew
  },
  {
    path: '/remit',
    name: 'remittance-list',
    component: RemitList
  },
  {
    path: '/remit/:id',
    name: 'remittance-detail',
    component: RemitDetail
  }
]

// exports the routes const
export default routes;
