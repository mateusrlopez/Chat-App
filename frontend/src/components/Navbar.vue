<template>
  <v-app-bar
    app
  >
    <v-toolbar-title>
      <router-link
        class="md:tw-text-3xl tw-uppercase"
        tag="a"
        :to="{ name: 'Home' }"
      >
        <span class="tw-text-teal-800">Space</span>
        <span class="tw-text-teal-600">Chat</span>
      </router-link>
    </v-toolbar-title>

    <v-spacer></v-spacer>

    <v-text-field
      dense
      filled
      full-width
      hide-details
      solo
      placeholder="Search"
      prepend-inner-icon="search"
      type="search"
      v-model="searchText"
      @click:prepend-inner="handleSearch"
      @keyup.enter="handleSearch"
    >
    </v-text-field>

    <v-spacer></v-spacer>

    <div>
      <ChannelCreationModal />

      <NotificationMenu />

      <v-btn
        icon
        @click="handleLogout"
      >
        <v-icon>exit_to_app</v-icon>
      </v-btn>

      <router-link
        :to="{ name: 'Profile', params: { id: authId } }"
        #default="{ href, navigate }"
      >
        <a
          class="tw-mx-2"
          :href="href"
          @click="navigate"
        >
          <v-avatar
            size="38"
          >
            <img
              v-if="authProfilePicture"
              :src="authProfilePicture"
              alt="Profile picture"
            >
            <span v-else>OL</span>
          </v-avatar>
        </a>
      </router-link>
    </div>
  </v-app-bar>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import ChannelCreationModal from './ChannelCreationModal'
import NotificationMenu from './NotificationMenu'

export default {
  components: {
    ChannelCreationModal,
    NotificationMenu
  },
  data () {
    return {
      searchText: ''
    }
  },
  computed: {
    ...mapGetters([
      'authId',
      'authProfilePicture'
    ])
  },
  methods: {
    ...mapActions([
      'logout'
    ]),
    handleLogout () {
      this.logout()
      this.$router.push({ name: 'Login' })
    },
    handleSearch () {
      if (this.searchText) {
        this.$router.push({ name: 'Search', query: { q: this.searchText } })
      }
    }
  }
}
</script>
