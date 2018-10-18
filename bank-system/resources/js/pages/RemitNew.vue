<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="hospital_id"
      :rules="[v => !!v || 'This is required']"
      label="Hospital ID (Receiver)"
      required
    ></v-text-field>
    <v-text-field
      v-model="amount"
      :rules="[v => !!v || 'This is required']"
      label="Amount"
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
    data () {
      return {
        valid: true,
        amount: '',
        hospital_id: ''
      }
    },
    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          axios.post('/api/remittances/create', {
            hospital_id: this.hospital_id,
            amount: this.amount
          }).then(response => {
            this.$router.push({ name: 'remittance-list' });
          }).catch(error => {
            console.log(error);
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>
