<template>
  <div>
    <v-card>
      <v-card-title>病患基本資料</v-card-title>
      <v-card-text>
        <ul v-for="(value, key) in patientDetail">
          <li>{{key}} : {{value}}</li>
        </ul>
      </v-card-text>
    </v-card>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-select
        v-model="department"
        :items="departments"
        item-text="name"
        item-value="id"
        :rules="[v => !!v || 'This is required']"
        label="科別"
        required
        @change="fetchDoctorList"
      ></v-select>
      <v-select
        v-model="doctor"
        :items="doctors"
        item-text="name"
        item-value="id"
        :rules="[v => !!v || 'This is required']"
        label="醫師 "
        required
        :disabled="department == ''"
      ></v-select>
      <v-menu
        ref="menu"
        :close-on-content-click="false"
        v-model="menu"
        :nudge-right="40"
        :return-value.sync="outpatient_date"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        min-width="290px"
      >
        <v-text-field
          slot="activator"
          v-model="outpatient_date"
          label="門診日期"
          prepend-icon="event"
          readonly
        ></v-text-field>
        <v-date-picker
          v-model="outpatient_date"
          locale="zh-tw"
          :min="new Date().toISOString().substr(0, 10)"
          :max="new Date(new Date().setFullYear(new Date().getFullYear() + 2)).toISOString().substr(0, 10)"
          @change="save"
        ></v-date-picker>
      </v-menu>
      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        submit
      </v-btn>
      <v-btn @click="clear">clear</v-btn>
    </v-form>
  </div>
</template>

<script>
  export default {
    props: ['query'],
    data: () => ({
      valid: true,
      department: '',
      doctor: '',
      outpatient_date: null,
      menu: false,
      patientDetail: null,
      departments: [],
      doctors: []
    }),
    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          axios.post('/api/outpatient/create', {
            patient_id: this.$route.query.userId,
            doctor_id: this.doctor,
            date: this.outpatient_date
          }).then((response) => {
            console.log(response)
            this.clear()
            this.$router.push({ name: 'patient-detail', params: { id: this.$route.query.userId }})
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      },
      save (date) {
        this.$refs.menu.save(date)
      },
      fetchPatientBasicInformation(){
        axios.get('/api/patients/'+this.$route.query.userId)
          .then((response) => {
            console.log(response)
            this.patientDetail = response.data
          })
      },
      fetchDepartmentList(){
        axios.get('/api/departments')
          .then((response) => {
            console.log(response);
            this.departments = response.data;
          })
      },
      fetchDoctorList(){
        axios.get('/api/departments/'+this.department+'/doctors')
          .then((response) => {
            console.log(response);
            this.doctors = response.data;
          })
      }
    },
    mounted() {
      this.fetchPatientBasicInformation();
      this.fetchDepartmentList();
    }
  }
</script>
