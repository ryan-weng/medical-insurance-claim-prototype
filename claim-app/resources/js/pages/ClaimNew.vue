<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-select
      :items="insurances"
      label="Insurance Policy"
      item-text="name"
      item-value="id"
      :rules="[v => !!v || 'This is required']"
      v-model="insurance"
    ></v-select>
    <v-select
      :items="hospitals"
      item-text="name"
      item-value="id"
      label="Hospital"
      :rules="[v => !!v || 'This is required']"
      v-model="hospital"
    ></v-select>
    <v-text-field
      v-model="hospital_department"
      :rules="[v => !!v || 'This is required']"
      label="Department"
    ></v-text-field>
    <v-text-field
      v-model="medical_history_number"
      :rules="[v => !!v || 'This is required']"
      name="medical_history_number"
      label="Medical History Number"
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
      phone: '',
      insurances: [],
      hospitals: [],
      medical_history_number: '',
      hospital_department: '',
      insurance: '',
      hospital: '',
      userData: {}
    }),
    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          console.log(this.userData);
          axios.post('/api/claims/create', {
            user_id: this.userData.id,
            hospital_id: this.hospital,
            insurance_policy_id: this.insurance,
            hospital_department: this.hospital_department,
            medical_history_number: this.medical_history_number
          }).then(response => {
            this.$router.push({ name: 'claim-list' });
          }).catch(error => {
            console.log(error.response);
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      },
      fetchInsuranceList(){
        axios.get('/api/user/insurances/')
          .then((response) => {
            console.log(response.data);
            this.insurances = response.data;
          })
      },
      fetchHospitalList(){
        axios.get('/api/hospitals/')
          .then((response) => {
            console.log(response.data);
            this.hospitals = response.data;
          })
      },
      fetchUserInformation(){
        axios.get('/api/user/')
          .then((response) => {
            console.log(response.data);
            this.userData = response.data.user;
          })
      }
    },
    mounted(){
      this.fetchInsuranceList();
      this.fetchHospitalList();
      this.fetchUserInformation();
    }
  }
</script>
