import MainLayout from '@/layouts/Main.vue'
import Home from '@/pages/Home.vue'

export default [
  {
    path: '/',
    component: MainLayout,
    children: [
      {
        name: 'home',
        path: '/',
        component: Home
      },
      {
        name: 'group',
        path: '/group/:id',
        component: () => import(/* webpackChunkName: "group" */ '@/pages/Group.vue'),
        meta: { auth: true },
        props: true
      },
      {
        name: 'about',
        path: '/about',
        component: () => import(/* webpackChunkName: "about" */ '@/pages/About.vue')
      }
    ]
  }
]
