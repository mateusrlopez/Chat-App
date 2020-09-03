<template>
  <div class="w-full md:w-3/4 p-5 md:shadow-2xl bg-white md:rounded-lg">
    <AlertBox v-if="errors" error :message="errors" @clear-alert="errors=null"/>

    <form @submit.prevent="submitLoginForm">
      <div class="my-2">
        <label :class="['cursor-pointer', !$v.email.$error ? 'text-black' : 'text-red-500']" for="email">Email:</label>
        <input :class="['w-full', 'border', !$v.email.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="email" type="text" v-model.lazy.trim="email" autocomplete="off">
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.required">Email is required</small>
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.email">Enter a valid email</small>
      </div>

      <div class="mt-2 mb-4">
        <label :class="['cursor-pointer', !$v.password.$error ? 'text-black' : 'text-red-500']" for="password">Password:</label>
        <router-link class="float-right text-sm text-blue-600" tag="a" to="/recover-password">Forgot your password?</router-link>
        <input :class="['w-full', 'border', !$v.password.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="password" type="password" v-model.lazy.trim="password">
        <small class="text-red-500" v-if="$v.password.$error && !$v.password.required">Password is required</small>
      </div>

      <LoadingButton label="Login" class="w-full p-1 bg-teal-500 text-white rounded hover:bg-teal-600" type="submit" />
    </form>

    <router-link class="block mt-3 text-blue-600 text-sm" tag="a" to="/sign-up">Doesn't have an account?</router-link>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { required, email } from 'vuelidate/lib/validators'

export default {
  components: {
    AlertBox: () => import('@/components/AlertBox.vue'),
    LoadingButton: () => import('@/components/LoadingButton.vue')
  },
  data () {
    return {
      email: '',
      password: '',
      errors: null
    }
  },
  computed: {
    ...mapGetters([
      'isLoading'
    ])
  },
  validations: {
    email: {
      required,
      email
    },
    password: {
      required
    }
  },
  methods: {
    ...mapActions([
      'login'
    ]),
    submitLoginForm () {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.login({ email: this.email, password: this.password })
          .then(() => {
            this.$router.push('/home')
          })
          .catch(error => {
            this.errors = error.response.data.errors
          })
      }
    }
  }
}
</script>
