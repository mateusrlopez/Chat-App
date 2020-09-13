<template>
  <button :disabled="isLoading" class="disabled:opacity-75">
    <span v-if="!isLoading">{{ label }}</span>
    <span key="spin-loader" v-else><i class="fas fa-circle-notch fa-spin text-white"></i></span>
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
