<template>
  <v-container>
    <Navbar />
  </v-container>
</template>

<script>
import Navbar from '@/components/Navbar'

export default {
  components: {
    Navbar
  },
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
