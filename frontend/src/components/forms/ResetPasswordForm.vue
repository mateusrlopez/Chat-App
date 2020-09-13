<template>
  <div class="w-full md:w-3/4 p-5 md:shadow-2xl bg-white md:rounded-lg">
    <AlertBox v-if="errors" :message="errors" alertType="error" @clear-alert="errors = null"/>

    <form @submit.prevent="submitResetPasswordForm">
      <div class="my-2">
        <label :class="['cursor-pointer', !$v.password.$error ? 'text-black' : 'text-red-500']" for="password">New password:</label>
        <input :class="['w-full border', !$v.password.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="password" type="password" v-model="password">
        <small class="text-red-500" v-if="$v.password.$error && !$v.password.required">Password is required</small>
        <small class="text-red-500" v-if="$v.password.$error && !$v.password.minLength">Password must have at least 8 characters</small>
      </div>
      <div class="mt-2 mb-4">
        <label :class="['cursor-pointer', !$v.password_confirmation.$error ? 'text-black' : 'text-red-500']" for="password_confirmation">Confirm your new password:</label>
        <input :class="['w-full', 'border', !$v.password_confirmation.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="password_confirmation" type="password" v-model="password_confirmation">
        <small class="text-red-500" v-if="$v.password_confirmation.$error && !$v.password_confirmation.required">You must confirm your password</small>
        <small class="text-red-500" v-if="$v.password_confirmation.$error && !$v.password_confirmation.sameAs">Passwords don't match</small>
      </div>

      <LoadingButton label="Reset Password" class="w-full p-1 bg-teal-500 text-white rounded hover:bg-teal-600" type="submit" />
    </form>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { required, sameAs, minLength } from 'vuelidate/lib/validators'

export default {
  components: {
    AlertBox: () => import('@/components/AlertBox.vue'),
    LoadingButton: () => import('@/components/LoadingButton.vue')
  },
  props: {
    email: {
      type: String,
      required: true
    },
    token: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      password: '',
      password_confirmation: '',
      errors: null
    }
  },
  validations: {
    password: {
      required,
      minLength: minLength(8)
    },
    password_confirmation: {
      required,
      sameAs: sameAs('password')
    }
  },
  methods: {
    ...mapActions([
      'resetPassword'
    ]),
    submitResetPasswordForm () {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.resetPassword({ email: this.email, token: this.token, password: this.password, password_confirmation: this.password_confirmation })
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
