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
    q: {
      type: String,
      required: true
    }
  }
}
</script>
