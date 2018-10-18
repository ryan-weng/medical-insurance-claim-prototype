<template>
  <v-app id="login" class="primary">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <h1 class="flex my-4 primary--text">Claim APP Prototype</h1>
                </div>
                <v-alert
                  :value="true"
                  type="error"
                  v-if="error"
                >
                  {{ message }}
                </v-alert>
                <v-form>
                  <v-text-field append-icon="person" name="login" label="Username" type="text" v-model="model.username"></v-text-field>
                  <v-text-field append-icon="lock" name="password" label="Password" id="password" type="password" v-model="model.password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn block color="primary" @click="login" :loading="loading">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    loading: false,
    error: false,
    message: '',
    model: {
      username: '',
      password: ''
    }
  }),
  methods: {
    login () {
      this.loading = true;
      this.error = false;
      this.message = '';
      // axios.post('/api/authenticate', this.model)
      //   .then(response => {
      //     console.log(response);
      //     localStorage.setItem("token", response.data.token);
      //     this.$router.push({ name: 'dashboard' });
      //   }).catch(error => {
      //     this.message = error.response.data.error;
      //     this.error = true;
      //     this.loading = false;
      //   });
      this.$store.dispatch('login', this.model);
      // this.$router.push({ name: 'dashboard' });
    }
  }
};
</script>
<style scoped lang="css">
  #login {
    height: 50%;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    content: "";
    z-index: 0;
  }
</style>
