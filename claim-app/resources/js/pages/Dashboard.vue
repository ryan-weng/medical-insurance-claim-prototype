<template>
  <div>
    Hello {{ userData.name }}!
  </div>
</template>

<script>
  export default {
    data() {
      return {
      }
    },
    computed: {
      userData() {
        return !this.$store.getters.user ? false : this.$store.getters.user
      }
    },
    methods: {
      // fetchUserData(){
      //   axios.get('/api/user/')
      //     .then((response) => {
      //       console.log(response.data);
      //       this.userData = response.data.user;
      //     })
      // }
    },
    mounted(){
      // this.fetchUserData();
      this.$store.dispatch('fetchUser')
    }
  }
</script>
