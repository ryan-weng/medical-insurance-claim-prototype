<template>
  <div>
    <v-card>
      <v-card-title primary-title>
        病患者資料
      </v-card-title>
      <v-card-text>
        <ul v-for="(value, key) in patientDetail">
          <li>{{key}} : {{value}}</li>
        </ul>
      </v-card-text>
    </v-card><br/>
    <v-form v-if="showDiagnosticForm" ref="form" v-model="valid" lazy-validation>
      <v-textarea
          label="主訴/病徵"
          v-model="complaint"
        ></v-textarea>
      <v-textarea
        label="診斷"
        v-model="diagnostic"
      ></v-textarea>
      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        submit
      </v-btn>
      <v-btn @click="clear">clear</v-btn>
    </v-form>
    <div v-else>
      <v-card>
        <v-card-text>
          主訴/病徵: {{diagnosticDetail.diagnostic.complaint}}<br/>
          診斷: {{diagnosticDetail.diagnostic.diagnostic}}
        </v-card-text>
      </v-card>
      <v-card v-if="reservation">
        <v-card-text>
          住院編號: {{diagnosticDetail.reservation.id}}<br/>
          房間-床位: {{diagnosticDetail.reservation.room.room_bed}}<br/>
          開始日期: {{diagnosticDetail.reservation.starting_date}}<br/>
          結束日期: {{diagnosticDetail.reservation.ending_date}}
        </v-card-text>
      </v-card>
      <v-btn v-if="!reservation" @click="hospitalize">需要住院</v-btn><v-btn @click="goBack">回返</v-btn>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        user: {},
        showDiagnosticForm: false,
        diagnostic: null,
        complaint: null,
        valid: true,
        reservation: null,
        patientDetail: {

        },
        diagnosticDetail: {
          diagnostic: {

          },
          reservation: {
            room: {

            }
          }
        }
      }
    },
    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          // console.log(this.diagnostic, this.complaint, this.$route.params.id);
          axios.post('/api/outpatient/diagnose', {
            record_id: this.$route.params.id,
            complaint: this.complaint,
            diagnostic: this.diagnostic
          }).then((response) => {
            console.log(response)
            this.clear()
            this.$router.go(-1);
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
        axios.get('/api/outpatient/'+this.$route.params.id+'/patient')
          .then((response) => {
            // console.log(response.data);
            this.patientDetail = response.data
          })
      },
      fetchDiagnostic(){
        axios.get('/api/outpatient/'+this.$route.params.id+'/diagnostic')
          .then((response) => {
            console.log(response.data);
            this.diagnosticDetail = response.data;
            if (response.data.reservation)
              this.reservation = response.data.reservation.id;
            if (!response.data.diagnostic.diagnostic && !response.data.diagnostic.complaint)
              this.showDiagnosticForm = true;
            console.log(this.diagnostic, this.complaint);
          })
      },
      goBack(){
        this.$router.go(-1)
      },
      hospitalize(){
        this.$router.push({ name: 'inpatient-new', query: { diagnosticId: this.$route.params.id } })
      }
    },
    mounted() {
      this.fetchPatientBasicInformation();
      this.fetchDiagnostic();
    }
  }
</script>
