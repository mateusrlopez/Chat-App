<template>
  <div :class="['alert', `${alertType}-alert`]">
    <span>{{ message }}</span>
    <button class="absolute right-0 top-0 bottom-0 pr-3" @click="$emit('clear-alert')"><i class="fas fa-times fa-sm"></i></button>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    },
    alertType: {
      type: String,
      required: true,
      validator (value) {
        return ['error', 'success'].indexOf(value) !== -1
      }
    }
  }
}
</script>

<style scoped>
  .alert {
    @apply border p-2 rounded text-center relative;
  }

  .error-alert {
    @apply border-red-600 text-red-600 bg-red-300;
  }

  .success-alert {
    @apply border-green-600 text-green-600 bg-green-300;
  }
</style>
