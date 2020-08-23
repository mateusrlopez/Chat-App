import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    meta: { private: false },
    component: () => import('@/views/Index.vue'),
    children: [
      {
        path: 'sign-up',
        name: 'SignUp',
        component: () => import('@/components/SignUpForm.vue')
      },
      {
        path: 'recover-password',
        name: 'RecoverPassword',
        component: () => import('@/components/RecoverPasswordForm.vue')
      },
      {
        path: 'reset-password',
        name: 'ResetPassword',
        props: route => ({ email: route.query.email, token: route.query.token }),
        component: () => import('@/components/ResetPasswordForm.vue')
      },
      {
        path: '',
        name: 'Login',
        component: () => import('@/components/LoginForm.vue')
      }
    ]
  },
  {
    path: '/home',
    name: 'Home',
    meta: { private: true },
    component: () => import('@/views/Home.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  const routes = to.matched.some(val => !val.meta.private)

  if (routes && window.localStorage.getItem('access_token')) {
    next('/home')
  } else if (!routes && !window.localStorage.getItem('access_token')) {
    next('/')
  } else {
    next()
  }
})

export default router
