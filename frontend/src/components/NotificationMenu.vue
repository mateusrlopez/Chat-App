<template>
  <v-menu
    offset-y
    nudge-bottom="10"
    v-model="showMenu"
  >
    <template #activator="{ attrs, on }">
      <v-btn
        icon
        v-bind="attrs"
        v-on="on"
      >
        <v-badge
          dot
          overlap
          color="teal"
          :value="hasUnreadNotifications"
        >
          <v-icon>notifications</v-icon>
        </v-badge>
      </v-btn>
    </template>
    <v-card
      class="tw-px-2 tw-py-4"
      min-height="350px"
      max-height="450px"
      min-width="400px"
      max-width="650px"
    >
      <v-card-title></v-card-title>
      <v-divider></v-divider>
      <v-card-text>
        <v-list three-line>
          <template v-for="(notification, index) in getNotificationsList">
            <v-list-item :key="notification.id">
              <v-list-item-avatar>
                <v-img :src="notification.data.avatar" alt="Avatar da notificação"></v-img>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title></v-list-item-title>
                <v-list-item-subtitle></v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <v-list-item-action-text></v-list-item-action-text>
              </v-list-item-action>
            </v-list-item>

            <v-divider
              :key="index"
              v-if="getNotificationsListLength != index"
            ></v-divider>
          </template>
        </v-list>
        <v-container>
        </v-container>
      </v-card-text>
    </v-card>
  </v-menu>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'

export default {
  data () {
    return {
      showMenu: false
    }
  },
  computed: {
    ...mapGetters([
      'authId',
      'getNotificationsList',
      'getNotificationsListLength',
      'getUnreadNotificationsList',
      'hasUnreadNotifications'
    ])
  },
  methods: {
    ...mapActions([
      'updateNotification',
      'retrieveAuthUserNotificationsList'
    ]),
    ...mapMutations([
      'addNotificationsToList'
    ])
  },
  created () {
    this.retrieveAuthUserNotificationsList()
      .then(() => {
        window.Echo.private(`User.${this.authId}`).listen('.new.notification', e => {
          this.addNotificationsToList(e)
        })
      })
  }
}
</script>
