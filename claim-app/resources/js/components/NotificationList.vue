<template>
  <v-card class="elevation-0">
    <v-toolbar card dense color="transparent">
      <v-toolbar-title><h4>Notification</h4></v-toolbar-title>
    </v-toolbar>
    <v-divider></v-divider>
    <v-card-text class="pa-0">
      <v-list two-line class="pa-0">
        <template v-for="(item, index) in notifications">
          <v-subheader v-if="item.header" :key="item.header">{{ item.header }}</v-subheader>
          <v-divider v-else-if="item.divider" :key="index"></v-divider>
          <v-list-tile avatar v-else :key="item.title" @click="goToClaimDetail(item.id)">
            <v-list-tile-avatar color="red">
              <v-icon dark>monetization_on</v-icon>
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-sub-title v-html="item.title"></v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: ['notifications'],
  data: () => ({

  }),
  methods: {
    goToClaimDetail(claimId){
      this.$router.push({name: 'claim-detail', params: {id: claimId}});
      // console.log(remittanceId);
    }
  },
  mounted(){

  }
};
</script>
