<template>
  <v-container>
    <v-alert
      dark
      dismissible
      tile
      border="left"
      color="#E3242B"
      class="alert"
      v-if="hasError"
      v-model="hasError"
    >
      <span>{{ errors }}</span>
    </v-alert>

    <v-form
      @submit.prevent="submitLoginForm"
    >
      <v-text-field
        outlined
        label="Email"
        v-model="email"
        :error="$v.email.$error"
        :error-messages="emailErrors"
      >
      </v-text-field>

      <v-text-field
        outlined
        label="Password"
        v-model="password"
        :error="$v.password.$error"
        :error-messages="passwordErrors"
        :append-icon="showPassword ? 'visibility_off' : 'visibility'"
        :type="showPassword ? 'text' : 'password'"
        @click:append="showPassword = !showPassword"
      >
      </v-text-field>

      <div
        class="tw-mb-3 tw-text-center tw-text-sm"
      >
        <router-link
          class="tw-block md:tw-inline md:tw-mr-1"
          tag="a"
          :to="{ name: 'SignUp' }"
        >
          Doesn't have an account?
        </router-link>

        <router-link
          class="tw-block md:tw-inline"
          tag="a"
          :to="{ name: 'RecoverPassword' }"
        >
          Forgot your password?
        </router-link>
      </div>

      <v-btn
        block
        dark
        tile
        color="teal"
        type="submit"
        :loading="isLoading"
      >
        Login
      </v-btn>
    </v-form>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { required, email } from 'vuelidate/lib/validators'

export default {
  data () {
    return {
      email: '',
      password: '',
      errors: null,
      hasError: false,
      showPassword: false
    }
  },
  computed: {
    ...mapGetters([
      'isLoading'
    ]),
    emailErrors () {
      const errors = []
      if (this.$v.email.$error) {
        !this.$v.email.required && errors.push('Email is required')
        !this.$v.email.email && errors.push('Invalid email')
      }
      return errors
    },
    passwordErrors () {
      const errors = []
      if (this.$v.password.$error) {
        errors.push('Password is required')
      }
      return errors
    }
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
            this.$router.push({ name: 'Home' })
          })
          .catch(error => {
            this.hasError = true
            this.errors = error.response.data
          })
      }
    }
  }
}
</script>
