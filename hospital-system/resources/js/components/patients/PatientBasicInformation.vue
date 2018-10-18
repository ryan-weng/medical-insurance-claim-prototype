<template>
  <div>
    <v-container>
      <table>
        <ul v-for="(value, key) in userDetail">
          <li>{{key}} : {{value}}</li>
        </ul>
      </table>
    </v-container>
  </div>
</template>
<script>
  export default {
    props: ['userId'],
    data() {
      return {
        userDetail: {}
      }
    },
    methods: {
      fetchUserDetail(){
        axios.get('/api/patients/'+this.userId)
          .then(response => {
            // console.log(response);
            this.userDetail = response.data;
            // console.log(this.userDetail);
          })
      }
    },
    mounted(){
      // console.log(this.userId);
      this.fetchUserDetail();
    }
  }
</script>
