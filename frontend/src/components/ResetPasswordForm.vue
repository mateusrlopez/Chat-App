<template>
  <div class="w-full md:w-9/12 p-5 md:shadow-xl md:rounded-lg bg-white">
    <form @submit.prevent="submitResetPasswordForm">
      <div>
        <label for="password">New password</label>
        <input id="password" type="password" v-model="password">
        <small v-if="$v.password.$error && $v.password.required">Password is required</small>
        <small v-if="$v.password.$error && $v.password.minLength">Password must have at least 8 characters</small>
      </div>
      <div>
        <label for="password_confirmation">Confirm your new password</label>
        <input id="password_confirmation" type="password" v-model="password_confirmation">
        <small v-if="$v.password_confirmation.$error && $v.password_confirmation.required">You must confirm your password</small>
        <small v-if="$v.password_confirmation.$error && $v.password_confirmation.sameAs">Passwords don't match</small>
      </div>

      <button type="submit">Reset password</button>
    </form>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { required, sameAs, minLength } from 'vuelidate/lib/validators'

export default {
  data () {
    return {
      password: '',
      password_confirmation: ''
    }
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
      }
    }
  }
}
</script>
