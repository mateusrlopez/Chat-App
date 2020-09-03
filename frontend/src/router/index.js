import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/home',
    meta: { private: true },
    name: 'Home',
    component: () => import('@/views/Home.vue')
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
  const routes = to.matched.some(val => val.meta.private)

  if (!routes && window.localStorage.getItem('access_token')) {
    next('/home')
  } else if (routes && !window.localStorage.getItem('access_token')) {
    next('/')
  } else {
    next()
  }
})

export default router
