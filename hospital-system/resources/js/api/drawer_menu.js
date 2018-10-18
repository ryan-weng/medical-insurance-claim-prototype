const menu = [
  {
    title: 'Dashboard',
    icon: 'dashboard',
    component: '/dashboard'
  },
  { title: 'Patient Management',
    icon: 'perm_identity',
    items: [
      { title: 'Create New Patient Basic Information', component: '/patient/new'},
      { title: 'Patient List', component: '/patient' }
    ]
  },
  { title: 'Outpatient Management',
    icon: 'local_hospital',
    items: [
      { title: 'Outpatient List', component: '/outpatient' }
    ]
  },
  { title: 'Inpatient Management',
    icon: 'local_hotel',
    items: [
      { title: 'Inpatient List', component: '/inpatient' }
    ]
  },
  { title: 'Treatment Management',
    icon: 'local_pharmacy',
    items: [
      { title: 'Treatment List', component: '/treatment' }
    ]
  }
];

export default menu;
