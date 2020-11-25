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
      @submit.prevent="submitRecoverPasswordForm"
    >
      <v-text-field
        outlined
        label="Enter your account's email"
        v-model="email"
        :error="$v.email.$error"
        :error-messages="emailErrors"
      >
      </v-text-field>

      <v-btn
        block
        dark
        tile
        color="teal"
        type="submit"
        :loading="isLoading"
      >
        Request password reset
      </v-btn>
    </v-form>
  </v-container>
</template>

<script>
import { mapMutations, mapGetters } from 'vuex'
import { required, email } from 'vuelidate/lib/validators'
import api from '@/services/api'

export default {
  data () {
    return {
      email: '',
      errors: null,
      hasErrors: false,
      isSuccess: false,
      success: null
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
      'alterLoading'
    ]),
    submitRecoverPasswordForm () {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.alterLoading()
        api.post('/auth/request-password-reset', { email: this.email })
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
