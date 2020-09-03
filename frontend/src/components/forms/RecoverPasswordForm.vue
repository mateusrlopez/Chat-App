<template>
  <div class="w-full md:w-3/4 p-5 md:shadow-2xl bg-white md:rounded-lg">
    <AlertBox v-if="success" :message="success" success @clear-alert="success = null"/>
    <AlertBox v-if="errors" :message="errors" error @clear-alert="errors = null"/>

    <form @submit.prevent="submitRecoverPasswordForm">
      <div class="mt-2 mb-4">
        <label :class="['block', 'cursor-pointer', !$v.email.$error ? 'text-black' : 'text-red-500']" for="email">Enter your account email:</label>
        <input :class="['w-full', 'border', !$v.email.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="email" type="text" v-model="email">
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.required">Email is required</small>
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.email">Enter a valid email</small>
      </div>

      <LoadingButton label="Request" class="w-full p-1 bg-teal-500 text-white rounded hover:bg-teal-600" type="submit" />
    </form>
  </div>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators'
import api from '@/services/api'

export default {
  components: {
    AlertBox: () => import('@/components/AlertBox.vue'),
    LoadingButton: () => import('@/components/LoadingButton.vue')
  },
  data () {
    return {
      email: '',
      errors: null,
      success: null
    }
  },
  validations: {
    email: {
      required,
      email
    }
  },
  methods: {
    submitRecoverPasswordForm () {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        api.post('/auth/request-password-reset', { email: this.email })
          .then(response => {
            this.success = response.data
          })
          .catch(error => {
            this.errors = error.response.data.errors
          })
      }
    }
  }
}
</script>
