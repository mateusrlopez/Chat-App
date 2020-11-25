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

    <v-alert
      dark
      dismissible
      tile
      border="left"
      color="#028A0F"
      class="alert"
      v-if="isSuccess"
      v-model="isSuccess"
    >
      <span>{{ success }}</span>
    </v-alert>

    <v-form
      @submit.prevent="submitResetPasswordForm"
    >
      <v-text-field
        outlined
        label="New password"
        v-model="password"
        :error="$v.password.$error"
        :error-messages="passwordErrors"
        :append-icon="showPassword ? 'visibility_off' : 'visibility'"
        :type="showPassword ? 'text' : 'password'"
        @click:append="showPassword = !showPassword"
      ></v-text-field>

      <v-text-field
        outlined
        label="Confirm your new password"
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
        Reset password
      </v-btn>
    </v-form>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { required, sameAs, minLength } from 'vuelidate/lib/validators'
import api from '@/services/api'

export default {
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
      hasErrors: false,
      isSuccess: false,
      errors: null,
      success: null,
      showPassword: false,
      showPasswordConfirmation: false
    }
  },
  computed: {
    ...mapGetters([
      'isLoading'
    ]),
    passwordErrors () {
      const errors = []
      if (this.$v.password.$error) {
        !this.$v.password.required && errors.push('A new password is required')
        !this.$v.password.minLength && errors.push('The new password must have at least 8 characters')
      }
      return errors
    },
    passwordConfirmationErrors () {
      const errors = []
      if (this.$v.password_confirmation.$error) {
        !this.$v.password_confirmation.required && errors.push('You must confirm your new password')
        !this.$v.password.sameAs && errors.push('Passwords must match')
      }
      return errors
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
      'alterLoading'
    ]),
    submitResetPasswordForm () {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.alterLoading()
        api.post('/auth/reset-password', { email: this.email, token: this.token, password: this.password, password_confirmation: this.password_confirmation })
          .then(response => {
            this.isSuccess = true
            this.success = response.data
          })
          .catch(error => {
            this.hasErrors = true
            this.errors = error.response.data.errors
          })
          .finally(() => {
            this.alterLoading()
          })
      }
    }
  }
}
</script>
