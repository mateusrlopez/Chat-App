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
  beforeRouteEnter (to, from, next) {
    next()
  },
  beforeRouteUpdate (to, from, next) {
    next()
  }
}
</script>
