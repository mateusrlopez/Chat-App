<template>
  <div class="w-full md:w-3/4 p-5 md:shadow-2xl bg-white md:rounded-lg">
    <form @submit.prevent="submitSignUpForm">
      <div class="my-2">
        <label :class="['cursor-pointer', !$v.email.$error || errors.email ? 'text-black' : 'text-red-500']" for="email">Email:</label>
        <input :class="['w-full', 'border', !$v.email.$error || errors.email ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="email" type="text" v-model.lazy.trim="email">
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.required">Email is required</small>
        <small class="text-red-500" v-if="$v.email.$error && !$v.email.email">Enter a valid email</small>
        <small class="text-red-500" v-if="errors.email">{{ errors.email[0] }}</small>
      </div>

      <div class="my-2">
        <label :class="['cursor-pointer', !$v.name.$error ? 'text-black' : 'text-red-500']" for="name">Name:</label>
        <input :class="['w-full', 'border', !$v.name.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="name" type="text" v-model.lazy.trim="name">
        <small class="text-red-500" v-if="$v.name.$error && !$v.name.required">Name is required</small>
      </div>

      <div class="my-2">
        <label :class="['cursor-pointer', !$v.password.$error ? 'text-black' : 'text-red-500']" for="password">Password:</label>
        <input :class="['w-full', 'border', !$v.password.$error ?  'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="password" type="password" v-model.trim="password">
        <small class="text-red-500" v-if="$v.password.$error && !$v.password.required">Password is required</small>
        <small class="text-red-500" v-if="$v.password.$error && !$v.password.minLength">Password must have at least 8 characters</small>
      </div>

      <div class="my-2">
        <label :class="['cursor-pointer', !$v.password_confirmation.$error ? 'text-black' : 'text-red-500']" for="password_confirmation">Confirm your password:</label>
        <input :class="['w-full', 'border', !$v.password_confirmation.$error ? 'border-gray-700' : 'border-red-500', 'px-2', 'py-1', 'rounded', 'mt-1']" id="password_confirmation" type="password" v-model.lazy.trim="password_confirmation">
        <small class="text-red-500" v-if="$v.password_confirmation.$error && !$v.password_confirmation.required">You must confirm your password</small>
        <small class="text-red-500" v-if="$v.password_confirmation.$error && !$v.password_confirmation.sameAs">Passwords don't match</small>
      </div>

      <button class="my-2 w-full bg-teal-500 hover:bg-teal-600 text-white rounded py-1" type="submit">Sign Up</button>
    </form>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { required, email, minLength, sameAs } from 'vuelidate/lib/validators'

export default {
  data () {
    return {
      email: '',
      name: '',
      password: '',
      password_confirmation: '',
      password_strength: '',
      errors: {
        email: null
      }
    }
  },
  validations: {
    email: {
      required,
      email
    },
    name: {
      required
    },
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
      'signUp'
    ]),
    submitSignUpForm () {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.signUp({ email: this.email, name: this.name, password: this.password, password_confirmation: this.password_confirmation })
          .then(() => {
            this.$router.push('/home')
          })
          .catch(error => {
            this.errors = Object.assign(this.errors, error.response.data.errors)
          })
      }
    }
  }
}
</script>
