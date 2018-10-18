<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="name"
      :rules="[v => !!v || 'This is required']"
      :counter="10"
      label="醫療名稱"
      required
    ></v-text-field>
    <v-text-field
      v-model="fee"
      :rules="[v => !!v || 'This is required']"
      label="醫療費用"
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
      fee: '',
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
      }
    }
  }
</script>
