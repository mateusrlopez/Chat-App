<template>
  <div>
    <h1> {{ currentUser.name }} </h1>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'currentUser'
    ])
  }
}
</script>
