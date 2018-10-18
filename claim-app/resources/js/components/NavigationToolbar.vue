<template>
  <v-toolbar app dark color="primary">
    <v-toolbar-side-icon @click="handleDrawerToggle"></v-toolbar-side-icon>

    <v-spacer></v-spacer>

    <v-menu offset-y origin="center center" class="elelvation-1" :nudge-bottom="14" transition="scale-transition">
      <v-btn icon flat slot="activator">
      <v-badge color="red" overlap>
        <span slot="badge" v-if="notifications.length > 0">{{notifications.length}}</span>
        <v-icon>notifications</v-icon>
      </v-badge>
      </v-btn>
      <notification-list v-if="notifications.length > 0" :notifications="notifications"></notification-list>
    </v-menu>

    <v-btn icon @click="logout">
      <v-icon>power_settings_new</v-icon>
    </v-btn>
  </v-toolbar>
</template>
<script>
  import NotificationList from './NotificationList';

  export default {
    name: 'navigation-toolbar',
    computed: {
      notifications() {
        return !this.$store.getters.notifications ? false : this.$store.getters.notifications
      }
    },
    components: {
      NotificationList
    },
    methods: {
      handleDrawerToggle () {
        window.getApp.$emit('APP_DRAWER_TOGGLED');
      },
      logout() {
        // window.getApp.$emit('APP_LOGOUT');
        this.$store.dispatch('logout');
      }
    },
    mounted() {
      this.$store.dispatch('fetchNotification');
    }
  }
</script>
