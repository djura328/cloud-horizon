import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'dashboard',
      component: () => import('../pages/Dashboard.vue')
  },
  {
    path: '/report-1',
    name: 'report1',
    component: () => import('../pages/reports/Report1.vue')
  },
  {
    path: '/report-2',
    name: 'report2',
    component: () => import('../pages/reports/Report2.vue')
  },
  {
    path: '/report-3',
    name: 'report3',
    component: () => import('../pages/reports/Report3.vue')
  },
  {
      path: '/report-4',
      name: 'report4',
      component: () => import('../pages/reports/Report4.vue')
  },
  {
      path: '/report-5',
      name: 'report5',
      component: () => import('../pages/reports/Report5.vue')
  },
  {
      path: '/report-6',
      name: 'report6',
      component: () => import('../pages/reports/Report6.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
