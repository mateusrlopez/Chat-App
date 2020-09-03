<template>
  <button :disabled="isLoading">
    <span v-if="!isLoading">{{ label }}</span>
    <i v-else class="fas fa-circle-notch fa-spin text-white"></i>
  </button>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    label: {
      type: String,
      required: true
    }
  },
  computed: mapGetters(['isLoading'])
}
</script>
