import Dashboard from './pages/Dashboard.vue'
import PatientNew from './pages/PatientNew.vue'
import PatientList from './pages/PatientList.vue'
import PatientDetail from './pages/PatientDetail.vue'
import PatientHistoryNew from './pages/PatientHistoryNew.vue'
import InpatientNew from './pages/InpatientNew.vue'
import InpatientList from './pages/InpatientList.vue'
import InpatientDetail from './pages/InpatientDetail.vue'
import TreatmentNew from './pages/TreatmentNew.vue'
import TreatmentList from './pages/TreatmentList.vue'
import OutpatientNew from './pages/OutpatientNew.vue'
import OutpatientList from './pages/OutpatientList.vue'
import OutpatientDetail from './pages/OutpatientDetail.vue'
import NotFound from './pages/NotFound.vue'
import Login from './pages/Login.vue'
import PaymentNew from './pages/PaymentNew.vue'
import PaymentDetail from './pages/PaymentDetail.vue'

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
    // redirect: '/dashboard',
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
    path: '/patient',
    name: 'patient-list',
    component: PatientList
  },
  {
    path: '/patient/new',
    name: 'patient-new',
    component: PatientNew
  },
  {
    path: '/patient/:id',
    name: 'patient-detail',
    component: PatientDetail
  },
  {
    path: '/patient/:id/history/new',
    name: 'patient-history-new',
    component: PatientHistoryNew
  },
  {
    path: '/inpatient',
    name: 'inpatient-list',
    component: InpatientList
  },
  {
    path: '/inpatient/new',
    name: 'inpatient-new',
    component: InpatientNew
  },
  {
    path: '/inpatient/:id',
    name: 'inpatient-detail',
    component: InpatientDetail
  },
  {
    path: '/outpatient',
    name: 'outpatient-list',
    component: OutpatientList
  },
  {
    path: '/outpatient/new',
    name: 'outpatient-new',
    component: OutpatientNew
  },
  {
    path: '/outpatient/:id',
    name: 'outpatient-detail',
    component: OutpatientDetail
  },
  {
    path: '/treatment',
    name: 'treatment-list',
    component: TreatmentList
  },
  {
    path: '/treatment/new',
    name: 'treatment-new',
    component: TreatmentNew
  },
  {
    path: '/payment/:record_id',
    name: 'payment-new',
    component: PaymentNew
  },
  {
    path: '/payment/:id',
    name: 'payment-detail',
    component: PaymentDetail
  }
]

// exports the routes const
export default routes;
