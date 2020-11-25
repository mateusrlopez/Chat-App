<template>
  <v-container>
    <v-form
      @submit.prevent="submitSignUpForm"
    >
      <v-text-field
        outlined
        label="Name"
        v-model="name"
        :error="$v.name.$error"
        :error-messages="nameErrors"
      ></v-text-field>

      <v-text-field
        outlined
        label="Email"
        v-model="email"
        :error="$v.name.$error || hasErrors"
        :error-messages="[...emailErrors, ...errors.email]"
      ></v-text-field>

      <v-text-field
        outlined
        label="Password"
        v-model="password"
        :error="$v.password.$error"
        :error-messages="passwordErrors"
        :append-icon="showPassword ? 'visibility_off' : 'visibility'"
        :type="showPassword ? 'text' : 'password'"
        @click:append="showPassword = !showPassword"
      ></v-text-field>

      <v-text-field
        outlined
        label="Confirm your password"
        v-model="password_confirmation"
        :error="$v.password_confirmation.$error"
        :error-messages="passwordConfirmationErrors"
        :append-icon="showPasswordConfirmation ? 'visibility_off' : 'visibility'"
        :type="showPasswordConfirmation ? 'text' : 'password'"
        @click:append="showPasswordConfirmation = !showPasswordConfirmation"
      ></v-text-field>

      <v-btn
        block
        dark
        tile
        color="teal"
        class="tw-mt-2"
        type="submit"
        :loading="isLoading"
      >
        Sign Up
      </v-btn>
    </v-form>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { required, email, minLength, sameAs } from 'vuelidate/lib/validators'

export default {
  data () {
    return {
      email: '',
      name: '',
      password: '',
      password_confirmation: '',
      errors: {
        email: []
      },
      hasErrors: false,
      showPassword: false,
      showPasswordConfirmation: false
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
        !this.$v.email.email && errors.push('Enter a valid email')
      }
      return errors
    },
    nameErrors () {
      const errors = []
      if (this.$v.name.$error) {
        errors.push('Name is required')
      }
      return errors
    },
    passwordErrors () {
      const errors = []
      if (this.$v.password.$error) {
        !this.$v.password.required && errors.push('Password is required')
        !this.$v.password.minLength && errors.push('Password must have at least 8 characters')
      }
      return errors
    },
    passwordConfirmationErrors () {
      const errors = []
      if (this.$v.password_confirmation.$error) {
        !this.$v.password_confirmation.required && errors.push('You must confirm your password')
        !this.$v.password_confirmation.sameAs && errors.push('Passwords must match')
      }
      return errors
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
            this.$router.push({ name: 'Home' })
          })
          .catch(error => {
            this.hasErrors = true
            this.errors = error.response.data.errors
          })
      }
    }
  }
}
</script>
