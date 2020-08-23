<template>
  <div class="w-full md:w-9/12 p-5 md:shadow-xl md:rounded-lg">
    <form @submit.prevent="submitRecoverPasswordForm">
      <div class="mt-2 mb-4">
        <label class="block cursor-pointer" for="email">Enter your account email:</label>
        <input class="w-full border border-gray-500 px-2 py-1 rounded mt-1" id="email" type="text" v-model="email">
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.required">Email is required</small>
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.email">Enter a valid email</small>
      </div>

      <button class="w-full p-1 bg-teal-500 text-white rounded hover:bg-teal-600" type="submit">Request</button>
    </form>
  </div>
</template>

<script>
import { mapMutations } from 'vuex'
import { required, email } from 'vuelidate/lib/validators'
import api from '@/services/api'

export default {
  data () {
    return {
      email: ''
    }
  },
  validations: {
    email: {
      required,
      email
    }
  },
  methods: {
    ...mapMutations([
      'setErrors'
    ]),
    submitRecoverPasswordForm () {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        api.post('/auth/request-password-reset', { email: this.email })
          .then(() => {

          })
          .catch(error => {
            this.setErrors(error.response.data.errors)
          })
      }
    }
  }
}
</script>
