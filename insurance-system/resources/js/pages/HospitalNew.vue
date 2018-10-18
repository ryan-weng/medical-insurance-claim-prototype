<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="name"
      :rules="[v => !!v || 'This is required']"
      label="Name"
      required
    ></v-text-field>
    <v-textarea
      v-model="address"
      :rules="[v => !!v || 'This is required']"
      name="address"
      label="Address"
    ></v-textarea>
    <v-text-field
      v-model="phone"
      :rules="[v => !!v || 'This is required']"
      label="Phone Number"
      required
    ></v-text-field>
    <v-btn
      :disabled="!valid"
      @click="submit"
    >
      submit
    </v-btn>
    <v-btn @click="clear">clear</v-btn>
  </v-form>
</template>

<script>
  export default {
    data: () => ({
      valid: true,
      name: '',
      address: '',
      phone: '',
    }),

    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          axios.post('/api/hospitals/create', {
            name: this.name,
            address: this.address,
            phone: this.phone
          }).then(response => {
            this.$router.push({ name: 'hospital-list' });
          });
        }
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>
