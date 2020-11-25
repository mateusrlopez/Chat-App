<template>
  <v-dialog
    persistent
    max-width="650px"
    v-model="showModal"
  >
    <template #activator="{ attrs, on }">
      <v-btn
        icon
        v-bind="attrs"
        v-on="on"
      >
        <v-icon>add</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <v-spacer></v-spacer>
        <span>Create channel</span>
        <v-spacer></v-spacer>
        <v-btn
          icon
          :ripple="false"
          class="no-background-hover"
          @click="showModal = !showModal"
        >
          <v-icon>close</v-icon>
        </v-btn>
      </v-card-title>
      <v-divider></v-divider>
      <v-card-text>
        <v-container class="tw-py-6">
          <v-form>
            <v-text-field
              outlined
              label="Name"
              v-model="name"
              :error="$v.name.$error"
              :error-messages="nameErrors"
            ></v-text-field>
            <v-textarea
              outlined
              label="Description"
              hint="A short description to better describe your channel"
              v-model="description"
            ></v-textarea>
            <v-combobox
              chips
              outlined
              multiple
              label="Tags"
              hint="Add tags to help others find your channel"
              v-model="tags"
            >
              <template #selection="{ attrs, item }">
                <v-chip
                  close
                  v-bind="attrs"
                > {{ item }} </v-chip>
              </template>
            </v-combobox>
            <v-checkbox
              hide-details
              label="Private channel"
              v-model="isPrivate"
            ></v-checkbox>
          </v-form>
        </v-container>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions class="tw-py-4 tw-px-2">
        <v-spacer></v-spacer>
        <v-btn
          tile
          dark
          color="teal"
          @click="submitCreateChannelForm"
        >Create</v-btn>
        <v-btn
          tile
          dark
          color="teal"
          @click="showModal = !showModal"
        >Cancel</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import { mapActions } from 'vuex'

export default {
  data () {
    return {
      name: '',
      description: '',
      file: null,
      isPrivate: false,
      tags: [],
      showModal: false
    }
  },
  computed: {
    nameErrors () {
      const errors = []
      if (this.$v.name.$error) {
        errors.push('Name is required')
      }
      return errors
    }
  },
  validations: {
    name: {
      required
    }
  },
  methods: {
    ...mapActions([
      'createChannel'
    ]),
    submitCreateChannelForm () {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.createChannel({ name: this.name, isPrivate: this.isPrivate, tags: this.tags, description: this.description })
      }
    }
  }
}
</script>
