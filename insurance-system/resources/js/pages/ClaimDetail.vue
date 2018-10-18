<template>
  <div>
    <v-card>
      <v-card-title primary-title>
       <h4>Claim Request Information</h4>
      </v-card-title>
      <v-card-text>
        Applicant : {{ claimRequestData.user.name }}<br/>
        Hospital : {{ claimRequestData.hospital.name }}<br/>
        Department : {{ claimRequestData.hospital_department }}<br/>
        Insurance Policy : {{ claimRequestData.policy.name }}
      </v-card-text>
    </v-card>
    <v-card>
      <v-card-title primary-title>
       <h4></h4>
      </v-card-title>
      <v-card-text>

      </v-card-text>
    </v-card>
    <v-card>
      <v-card-title primary-title>
       <h4>Medical Record Data</h4>
      </v-card-title>
      <v-card-text>

      </v-card-text>
    </v-card>
    <v-card>
      <v-card-title primary-title>
       <h4>Approved Request Amount</h4>
      </v-card-title>
      <v-card-text>

      </v-card-text>
    </v-card>
    <v-btn @click="approve()">Approve</v-btn>
    <v-btn @click="goBack()">Back</v-btn>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        user: {},
        claimRequestData: {
          user: {},
          hospital: {},
          policy: {}
        }
      }
    },
    methods: {
      approve(){
        axios.post('/api/claims/'+this.$route.params.id+'/approve', {

        }).then(response => {
          this.$router.push({ name: 'claim-list' });
        })
      },
      reject(){
        axios.post('/api/claims/'+this.$route.params.id+'/reject', {
          claim_id: this.claimRequestData.id
        }).then(response => {
          this.$router.push({ name: 'claim-list' });
        })
      },
      goBack(){
        this.$router.go(-1)
      },
      fetchClaimRequestData(){
        axios.get('/api/claims/'+this.$route.params.id)
          .then(response => {
            this.claimRequestData = response.data;
          })
      }
    },
    mounted() {
      this.fetchClaimRequestData();
    }
  }
</script>
