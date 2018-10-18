const menu = [
  {
    title: 'Dashboard',
    icon: 'dashboard',
    component: '/dashboard'
  },
  {
    title: 'Claim',
    group: 'claim_request',
    icon: 'rate_review',
    items: [
      { name: 'social', title: 'Apply for a claim', component: '/claim/new' },
      { name: 'social', title: 'Claim application list', component: '/claim' }
    ]
  },
];

export default menu;
