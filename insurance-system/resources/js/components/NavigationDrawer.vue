<template>
  <v-navigation-drawer
    v-model="drawer"
    app color="primary">
    <v-toolbar flat>
      <v-list>
        <v-list-tile>
          <v-list-tile-title class="title">
            Insurance System Prototype
          </v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-toolbar>

    <v-divider></v-divider>

    <v-list dense class="pt-0">
      <template v-for="(item, i) in menus">
        <v-list-group v-if="item.items" :key="item.name" :group="item.group" :prepend-icon="item.icon" no-action="no-action">
          <v-list-tile slot="activator" ripple="ripple">
            <v-list-tile-content>
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <template v-for="(subItem, i) in item.items">
            <v-list-tile  :key="i" :to="!subItem.href ? subItem.component : null" :href="subItem.href" :disabled="subItem.disabled" :target="subItem.target" ripple="ripple" exact>
              <v-list-tile-content>
                <v-list-tile-title><span>{{ subItem.title }}</span></v-list-tile-title>
              </v-list-tile-content>
              <v-list-tile-action v-if="subItem.action">
                <v-icon :class="[subItem.actionClass || 'success--text']">{{ subItem.action }}</v-icon>
              </v-list-tile-action>
            </v-list-tile>
          </template>
        </v-list-group>
        <v-subheader v-else-if="item.header" :key="i">{{ item.header }}</v-subheader>
        <v-divider v-else-if="item.divider" :key="i"></v-divider>
        <v-list-tile v-else :to="!item.href ? item.component : null" :href="item.href" ripple="ripple" :disabled="item.disabled" :target="item.target" rel="noopener" :key="item.title" exact>
          <v-list-tile-action v-if="item.icon">
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </template>
    </v-list>
  </v-navigation-drawer>
</template>
<script>
  import menu from '../api/drawer_menu';

  export default {
    name: 'navigation-drawer',
    data () {
      return {
        mini: false,
        drawer: true,
        menus: menu,
        right: null
      }
    },
    created () {
      window.getApp.$on('APP_DRAWER_TOGGLED', () => {
        this.drawer = (!this.drawer);
      });
    },
  }
</script>
