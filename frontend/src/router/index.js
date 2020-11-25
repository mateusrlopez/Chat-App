import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../store'
import { getToken } from '../services/auth'

Vue.use(VueRouter)

const routes = [
  {
    path: '/home',
    meta: { private: true },
    name: 'Home',
    component: () => import('@/views/Home.vue')
  },
  {
    path: '/search',
    meta: { private: true },
    name: 'Search',
    props: route => ({ q: route.query.q }),
    component: () => import('@/views/Search.vue')
  },
  {
    path: '/channel/:id(\\d+)',
    meta: { private: true },
    name: 'Channel',
    props: route => ({ id: +route.params.id }),
    component: () => import('@/views/Channel.vue')
  },
  {
    path: '/profile/:id(\\d+)',
    meta: { private: true },
    name: 'Profile',
    props: route => ({ id: +route.params.id }),
    component: () => import('@/views/Profile.vue')
  },
  {
    path: '/',
    meta: { private: false },
    component: () => import('@/views/Index.vue'),
    children: [
      {
        path: 'sign-up',
        name: 'SignUp',
        component: () => import('@/components/forms/SignUpForm.vue')
      },
      {
        path: 'recover-password',
        name: 'RecoverPassword',
        component: () => import('@/components/forms/RecoverPasswordForm.vue')
      },
      {
        path: 'reset-password',
        name: 'ResetPassword',
        props: route => ({ email: route.query.email, token: route.query.token }),
        component: () => import('@/components/forms/ResetPasswordForm.vue')
      },
      {
        path: '',
        name: 'Login',
        component: () => import('@/components/forms/LoginForm.vue')
      }
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  Promise.all([store.dispatch('checkAuth')])
    .then(() => {
      const privateRoutes = to.matched.some(val => val.meta.private)
      if (!privateRoutes && getToken('access') && getToken('refresh')) {
        next('/home')
      } else if (privateRoutes && !getToken('access') && !getToken('refresh')) {
        next('/')
      } else {
        next()
      }
    })
})

export default router
