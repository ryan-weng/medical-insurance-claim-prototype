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
    <v-card>
      <v-card-text>
        住院編號: {{diagnosticDetail.reservation.id}}<br/>
        房間-床位: {{diagnosticDetail.reservation.room.room_bed}}<br/>
        開始日期: {{diagnosticDetail.reservation.starting_date}}<br/>
        結束日期: {{diagnosticDetail.reservation.ending_date}}
      </v-card-text>
    </v-card><br/><br/>

    <div v-if="showTreatmentForm">
      <v-form ref="form1" v-model="valid" lazy-validation>
        <v-autocomplete
          :loading="loading"
          :items="treatmentList"
          :search-input.sync="search"
          item-text="name"
          item-value="id"
          v-model="treatment"
          cache-items
          hide-no-data
          hide-details
          label="病患醫療"
        ></v-autocomplete>

        <v-text-field
          v-model="amount"
          :rules="[v => !!v || 'This is required']"
          label="數量"
          mask="####"
          required
        ></v-text-field>
        <v-btn
          :disabled="!valid"
          @click="addTreatment"
        >
          增加
        </v-btn>
      </v-form>

      <v-form ref="form2" v-model="valid" lazy-validation>
        <v-menu
          ref="menu2"
          :close-on-content-click="false"
          v-model="menu2"
          :nudge-right="40"
          :return-value.sync="leave_date"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
        >
          <v-text-field
            slot="activator"
            v-model="leave_date"
            label="出院日期"
            prepend-icon="event"
            readonly
          ></v-text-field>
          <v-date-picker
            locale="zh-tw"
            v-model="leave_date"
            :min="new Date().toISOString().substr(0, 10)"
            @input="$refs.menu2.save(leave_date)">
          </v-date-picker>
        </v-menu>
        <v-btn
          :disabled="!valid"
          @click="checkOut"
        >
          出院
        </v-btn>
        <v-btn @click="goBack">回返</v-btn>
      </v-form>
    </div>

    <v-form v-else-if="!diagnosticDetail.reservation.leave_date" ref="form3" v-model="valid" lazy-validation>
      <v-menu
        ref="menu1"
        :close-on-content-click="false"
        v-model="menu1"
        :nudge-right="40"
        :return-value.sync="enter_date"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        min-width="290px"
      >
        <v-text-field
          slot="activator"
          v-model="enter_date"
          label="報到日期"
          prepend-icon="event"
          readonly
        ></v-text-field>
        <v-date-picker
          locale="zh-tw"
          v-model="enter_date"
          :min="new Date().toISOString().substr(0, 10)"
          @input="$refs.menu1.save(enter_date)">
        </v-date-picker>
      </v-menu>
      <v-btn
        :disabled="!valid"
        @click="checkIn"
      >
        報到
      </v-btn>
      <v-btn @click="goBack">回返</v-btn>
    </v-form>

  </div>
</template>
<script>
  export default {
    data() {
      return {
        user: {},
        search: '',
        showDiagnosticForm: false,
        valid: true,
        treatmentList: [],
        patientDetail: {

        },
        diagnosticDetail: {
          diagnostic: {

          },
          reservation: {
            id: 0,
            room: {

            }
          }
        },
        treatment: null,
        amount: 0,
        loading: false,
        showTreatmentForm: false,
        menu1: false,
        menu2: false,
        enter_date: null,
        leave_date: null
      }
    },
    methods: {
      save (date) {
        this.$refs.menu.save(date)
      },
      addTreatment () {
        if (this.$refs.form1.validate()) {
          // console.log(this.treatment);
          // console.log(this.diagnostic, this.complaint, this.$route.params.id);
          axios.post('/api/inpatient/treatment/create', {
            record_id: this.$route.params.id,
            treatment_id: this.treatment,
            amount: this.amount
          }).then((response) => {
            console.log(response)
            this.$refs.form1.reset()
          })
        }
      },
      checkIn() {
        if (this.$refs.form3.validate()) {
          axios.post('/api/inpatient/checkin', {
            reservation_id: this.diagnosticDetail.reservation.id,
            enter_date: this.enter_date,
          }).then((response) => {
            console.log(response)
            this.$refs.form3.reset()
            this.fetchDiagnostic();
          })
        }
      },
      checkOut() {
        if (this.$refs.form2.validate()) {
          axios.post('/api/inpatient/checkout', {
            reservation_id: this.diagnosticDetail.reservation.id,
            leave_date: this.leave_date,
          }).then((response) => {
            console.log(response)
            this.$refs.form2.reset()
            this.$router.push({ name: 'payment-new', params: { record_id: this.diagnosticDetail.id }});
          })
        }
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
            if (response.data.reservation){
              if (response.data.reservation.enter_date && !response.data.reservation.leave_date) this.showTreatmentForm = true;
            }
            if (!response.data.diagnostic.diagnostic && !response.data.diagnostic.complaint)
              this.showDiagnosticForm = true;
            // console.log(this.diagnostic, this.complaint);
          })
      },
      fetchTreatment(){
        axios.get('/api/treatments/')
          .then((response) => {
            // console.log(response.data);
            this.treatmentList = response.data;
          })
      },
      goBack(){
        this.$router.go(-1)
      }
    },
    mounted() {
      this.fetchPatientBasicInformation();
      this.fetchDiagnostic();
      this.fetchTreatment();
    }
  }
</script>
