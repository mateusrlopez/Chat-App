<template>
  <div :class="['alert', { 'error-alert': error, 'success-alert': success }]">
    <span>{{ message }}</span>
    <button class="float-right" @click="$emit('clear-alert')"><i class="fas fa-times fa-sm"></i></button>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    },
    success: {
      type: Boolean,
      required: false
    },
    error: {
      type: Boolean,
      required: false
    }
  }
}
</script>

<style scoped>
  .alert {
    @apply border p-2 rounded text-center;
  }

  .error-alert {
    @apply border-red-600 text-red-600 bg-red-300;
  }

  .success-alert {
    @apply border-green-600 text-green-600 bg-green-300;
  }
</style>
