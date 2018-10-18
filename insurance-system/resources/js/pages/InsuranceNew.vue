<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="name"
      :rules="[v => !!v || 'This is required']"
      label="Name"
      required
    ></v-text-field>
    <v-text-field
      v-model="max_claimable_amount"
      :rules="[v => !!v || 'This is required']"
      label="Maximum Claimable Amount"
      required
    ></v-text-field>
    <v-combobox
          v-model="claimables"
          :items="claimableList"
          item-text="name"
          item-value="id"
          chips
          multiple
          label="Claimable Items"
        ></v-combobox>
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
      status: '',
      max_claimable_amount: '',
      claimables: [],
      claimableList: [
        
      ]
    }),

    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          // axios.post('/api/submit', {
          //   name: this.name,
          //   email: this.email,
          //   select: this.select,
          //   checkbox: this.checkbox
          // })
        }
      },
      clear () {
        this.$refs.form.reset()
      },
      fetchClaimableList(){
        axios.get('/api/claimables')
          .then((response) => {
            console.log(response);
            this.claimableList = response.data;
          })
      }
    },
    mounted() {
      this.fetchClaimableList();
    }
  }
</script>
