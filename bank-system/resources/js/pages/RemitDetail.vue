<template>
  <div>
    <v-card>
      <v-card-title primary-title>
       <h4>Remittance Detail</h4>
      </v-card-title>
      <v-card-text>
        ID : {{ remittanceData.id }}<br/>
        Hospital ID (Receiver) : {{ remittanceData.receiver }}<br/>
        Amount : {{ remittanceData.amount }}<br/>
        Request Created At : {{ remittanceData.created_at }}<br/>
        Status: {{ remittanceData.status }}
      </v-card-text>
    </v-card>
    
    <v-btn v-if="remittanceData.status == 'In Review'" @click="approve()">Approve</v-btn>
    <v-btn v-if="remittanceData.status == 'In Review'" @click="reject()">Reject</v-btn>
    <v-btn @click="goBack()">Back</v-btn>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        user: {},
        remittanceData: {}
      }
    },
    methods: {
      approve(){
        axios.post('/api/remittances/approveRequest', {
          remittance_id: this.remittanceData.id
        }).then(response => {
          this.$router.push({ name: 'remittance-list' });
        })
      },
      reject(){
        axios.post('/api/remittances/rejectRequest', {
          remittance_id: this.remittanceData.id
        }).then(response => {
          this.$router.push({ name: 'remittance-list' });
        })
      },
      goBack(){
        this.$router.go(-1)
      },
      fetchRemittanceData(){
        axios.get('/api/remittances/'+this.$route.params.id)
          .then(response => {
            this.remittanceData = response.data;
          })
      }
    },
    mounted() {
      this.fetchRemittanceData();
    }
  }
</script>
