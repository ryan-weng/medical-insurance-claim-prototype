<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="name"
      :rules="[v => !!v || 'This is required']"
      label="Name"
      required
    ></v-text-field>
    <v-select
      v-model="id_type"
      :items="items"
      :rules="[v => !!v || 'This is required']"
      label="ID Type"
      required
    ></v-select>
    <v-text-field
      v-model="id_number"
      :rules="[v => !!v || 'This is required']"
      label="ID Number"
      required
    ></v-text-field>
    <v-menu
      ref="menu"
      :close-on-content-click="false"
      v-model="menu"
      :nudge-right="40"
      lazy
      transition="scale-transition"
      offset-y
      full-width
      min-width="290px"
    >
      <v-text-field
        slot="activator"
        v-model="birthday_date"
        label="Birthday"
        prepend-icon="event"
        readonly
      ></v-text-field>
      <v-date-picker
        ref="picker"
        v-model="birthday_date"
        locale="zh-tw"
        :max="new Date().toISOString().substr(0, 10)"
        min="1940-01-01"
        @change="save"
      ></v-date-picker>
    </v-menu>
    <v-radio-group v-model="gender" row>
      <label>Gender : </label>
      <v-radio label="M" value="M"></v-radio>
      <v-radio label="F" value="F"></v-radio>
    </v-radio-group>
    <v-text-field
      v-model="phone"
      :rules="[v => !!v || 'This is required']"
      label="Phone"
      required
    ></v-text-field>
    <v-text-field
      v-model="address"
      :rules="[v => !!v || 'This is required']"
      label="Address"
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
      id_number: '',
      id_type: '',
      birthday_date: null,
      menu: false,
      phone: '',
      address: '',
      gender: null,
      items: [
        '身份證',
        '居留證',
        '護照'
      ]
    }),
    watch: {
      menu (val) {
        val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
      }
    },
    methods: {
      submit () {
        let vm = this;
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          axios.post('/api/patients/create', {
            name: this.name,
            birthday: this.birthday_date,
            gender: this.gender,
            phone: this.phone,
            address: this.address,
            id_type: this.id_type,
            id_number: this.id_number
          }).then((response) => {
            console.log(response);
            this.clear();
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      },
      save (date) {
        this.$refs.menu.save(date)
      }
    }
  }
</script>
