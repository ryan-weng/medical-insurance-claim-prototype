<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="name"
      :rules="[v => !!v || 'This is required']"
      label="Claimable Name"
      required
    ></v-text-field>
    <v-text-field
      v-model="amount"
      :rules="[v => !!v || 'This is required']"
      name="address"
      label="Amount"
    ></v-text-field>
    <v-text-field
      v-model="max_count"
      :rules="[v => !!v || 'This is required']"
      label="Maximum Count"
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
      amount: '',
      max_count: '',
    }),

    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          axios.post('/api/claimables/create', {
            name: this.name,
            amount: this.amount,
            max_count: this.max_count
          }).then((response) => {
            console.log(response)
            this.$router.push({ name: 'claimable-list' });
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>
