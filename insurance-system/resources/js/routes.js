import Dashboard from './pages/Dashboard.vue'
import NotFound from './pages/NotFound.vue'
import Login from './pages/Login.vue'
import InsuranceNew from './pages/InsuranceNew.vue'
import InsuranceList from './pages/InsuranceList.vue'
import InsuranceDetail from './pages/InsuranceDetail.vue'
import HospitalNew from './pages/HospitalNew.vue'
import HospitalList from './pages/HospitalList.vue'
import ClaimList from './pages/ClaimList.vue'
import ClaimDetail from './pages/ClaimDetail.vue'
import ClaimableNew from './pages/ClaimableNew.vue'
import ClaimableList from './pages/ClaimableList.vue'

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
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard
  },
  {
    path: '/insurance/new',
    name: 'policy-new',
    component: InsuranceNew
  },
  {
    path: '/insurance',
    name: 'policy-list',
    component: InsuranceList
  },
  {
    path: '/insurance/:id',
    name: 'policy-detail',
    component: InsuranceDetail
  },
  {
    path: '/hospital/new',
    name: 'hospital-new',
    component: HospitalNew
  },
  {
    path: '/hospital',
    name: 'hospital-list',
    component: HospitalList
  },
  {
    path: '/claimable/new',
    name: 'claimable-new',
    component: ClaimableNew
  },
  {
    path: '/claimable',
    name: 'claimable-list',
    component: ClaimableList
  },
  {
    path: '/claims',
    name: 'claim-list',
    component: ClaimList
  },
  {
    path: '/claims/:id',
    name: 'claim-detail',
    component: ClaimDetail
  }
]

// exports the routes const
export default routes;
