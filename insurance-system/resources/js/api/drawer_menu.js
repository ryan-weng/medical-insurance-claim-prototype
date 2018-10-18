const menu = [
  {
    title: 'Dashboard',
    icon: 'dashboard',
    component: '/dashboard'
  },
  {
    title: 'Hospital Management',
    icon: 'local_hospital',
    group: 'hospital',
    items: [
      { name: 'social', title: 'Create New Hospital', component: '/hospital/new' },
      { name: 'social', title: 'Hospital List', component: '/hospital' }
    ]
  },
  {
    title: 'Claimable Management',
    icon: 'verified_user',
    group: 'claimable',
    items: [
      { name: 'social', title: 'Create New Claimable', component: '/claimable/new' },
      { name: 'social', title: 'Claimable List', component: '/claimable' }
    ]
  },
  {
    title: 'Policy Management',
    icon: 'insert_drive_file',
    group: 'insurance',
    items: [
      { name: 'social', title: 'Create New Policy', component: '/insurance/new' },
      { name: 'social', title: 'Policy List', component: '/insurance' }
    ]
  },
  {
    title: 'Claim Management',
    icon: 'rate_review',
    group: 'claims',
    items: [
      { name: 'social', title: 'Claim List', component: '/claims' }
    ]
  },
];

export default menu;
