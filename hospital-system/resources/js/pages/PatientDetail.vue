<template>
  <div>
    <v-card>
      <v-card-title primary-title>
        <h3 class="headline mb-0">病患者編號 : {{ this.$route.params.id }}</h3>
      </v-card-title>

      <v-expansion-panel>
        <v-expansion-panel-content
          v-for="(item,i) in items"
          :key="i">
          <div slot="header">{{ item.title }}</div>
          <v-card>
            <component :is="item.component" :user-id="$route.params.id"></component>
          </v-card>
        </v-expansion-panel-content>
      </v-expansion-panel>

      <v-card-actions>

      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
  import PatientBasicInformation from '../components/patients/PatientBasicInformation.vue'
  import PatientMedicalHistory from '../components/patients/PatientMedicalHistory.vue'
  import PatientOutpatient from '../components/patients/PatientOutpatient.vue'
  import PatientInpatient from '../components/patients/PatientInpatient.vue'
  import PatientTreatment from '../components/patients/PatientTreatment.vue'
  import PatientPayment from '../components/patients/PatientPayment.vue'

  export default {
    components: {
      PatientBasicInformation,
      PatientOutpatient,
      PatientInpatient,
      PatientTreatment,
      PatientMedicalHistory,
      PatientPayment
    },
    data() {
      return {
        user: {},
        items: [
          {
            title: '基本資料',
            component: PatientBasicInformation
          },
          {
            title: '病歷',
            component: PatientMedicalHistory
          },
          {
            title: '門診記錄',
            component: PatientOutpatient
          },
          {
            title: '住院記錄',
            component: PatientInpatient
          },
          {
            title: '醫療記錄',
            component: PatientTreatment
          },
          {
            title: '付款記錄',
            component: PatientPayment
          }
        ]
      }
    }
  }
</script>
