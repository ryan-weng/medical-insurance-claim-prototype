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
      <v-card-title primary-title>
        診斷結果
      </v-card-title>
      <v-card-text>
        主訴/病徵: {{complaint}}<br/>
        診斷: {{diagnostic}}
      </v-card-text>
    </v-card><br/>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-menu
        ref="menu1"
        :close-on-content-click="false"
        v-model="menu1"
        :nudge-right="40"
        :return-value.sync="start_date"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        min-width="290px"
      >
        <v-text-field
          slot="activator"
          v-model="start_date"
          label="住院日期"
          prepend-icon="event"
          readonly
        ></v-text-field>
        <v-date-picker
          locale="zh-tw"
          v-model="start_date"
          :min="new Date().toISOString().substr(0, 10)"
          @input="$refs.menu1.save(start_date)">
        </v-date-picker>
      </v-menu>
      <v-menu
        ref="menu2"
        :close-on-content-click="false"
        v-model="menu2"
        :nudge-right="40"
        :return-value.sync="end_date"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        min-width="290px"
        :disabled="start_date == null"
      >
        <v-text-field
          slot="activator"
          v-model="end_date"
          label="出院日期"
          prepend-icon="event"
          readonly
        ></v-text-field>
        <v-date-picker
          locale="zh-tw"
          v-model="end_date"
          :min="new Date(new Date().setDate(new Date(this.start_date).getDate() + 1)).toISOString().substr(0, 10)"
          @input="changeEndingDate">
        </v-date-picker>
      </v-menu>
      <v-select
        v-model="room_bed"
        :items="availableRoom"
        item-text="room_bed"
        item-value="id"
        label="房間號碼-床位"
        required
      ></v-select>
      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        submit
      </v-btn>
      <v-btn @click="clear">clear</v-btn>
      <v-btn @click="goBack">回返</v-btn>
    </v-form>
  </div>
</template>

<script>
  export default {
    data: () => ({
      valid: true,
      diagnosis_number: '',
      record_number: '',
      start_date: null,
      end_date: null,
      menu1: false,
      menu2: false,
      room_bed: '',
      patientDetail: {

      },
      diagnostic: '',
      complaint: '',
      availableRoom: []
    }),

    methods: {
      submit () {
        if (this.$refs.form.validate()) {
          console.log("...");
          axios.post('/api/inpatient/create', {
            start_date: this.start_date,
            end_date: this.end_date,
            room_id: this.room_bed,
            diagnostic_id: this.$route.query.diagnosticId
          }).then((response) => {
            console.log(response)
            // this.clear()
            this.$router.go(-1)
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      },
      fetchPatientBasicInformation(){
        axios.get('/api/outpatient/'+this.$route.query.diagnosticId+'/patient')
          .then((response) => {
            // console.log(response.data);
            this.patientDetail = response.data
          })
      },
      fetchDiagnostic(){
        axios.get('/api/outpatient/'+this.$route.query.diagnosticId+'/diagnostic')
          .then((response) => {
            console.log(response.data);
            this.diagnostic = response.data.diagnostic.diagnostic;
            this.complaint = response.data.diagnostic.complaint;
          })
      },
      fetchAvailableRoom(startingDate, endingDate) {
        axios.get('/api/inpatient/rooms', {params: {
          starting_date: startingDate,
          ending_date: endingDate
        }}).then((response) => {
            console.log(response.data);
            this.availableRoom = response.data;
          })
      },
      changeEndingDate(){
        this.$refs.menu2.save(this.end_date);
        this.fetchAvailableRoom(this.start_date, this.end_date);
      },
      goBack(){
        this.$router.go(-1)
      }
    },
    mounted() {
      this.fetchPatientBasicInformation();
      this.fetchDiagnostic();
    }
  }
</script>
