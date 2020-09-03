<template>
  <div>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  beforeRouterEnter (to, from, next) {
    next()
  },
  beforeRouterUpdate (to, from, next) {
    next()
  }
}
</script>
