<template>
  <v-container>
    <div class="d-flex">
      <v-btn @click="goToNewOutpatient(userId)">建立新門診記錄</v-btn>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="尋找"
        single-line
        hide-details
      ></v-text-field>
    </div>

    <v-data-table
      :headers="headers"
      :items="outpatientRecord"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <tr style="cursor:pointer" @click="goToOutpatientDetail(props.item.id)">
          <td class="text-xs-left">{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.diagnostic.doctor.department.name }}</td>
          <td class="text-xs-left">{{ props.item.diagnostic.doctor.name }}</td>
          <td class="text-xs-left">{{ props.item.diagnostic.outpatient_date }}</td>
        </tr>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-container>
</template>
<script>
  export default {
    props: ['userId'],
    data() {
      return {
        search: '',
        headers: [
          {
            text: '編號',
            align: 'left',
            value: 'id'
          },
          { text: '科別', value: 'diagnostic.doctor.department.name' },
          { text: '醫師', value: 'diagnostic.doctor.name' },
          { text: '日期', value: 'diagnostic.outpatient_date' }
        ],
        outpatientRecord: []
      }
    },
    methods: {
      fetchOutpatientRecord(){
        axios.get('/api/patients/'+this.userId+'/record')
          .then(response => {
            // console.log('record',response);
            this.outpatientRecord = response.data;
          })
      },
      goToNewOutpatient(userId){
        this.$router.push({ path: '/outpatient/new', query: { userId: userId }})
      },
      goToOutpatientDetail(recordId){
        // console.log(recordId);
        this.$router.push({ path: '/outpatient/'+recordId })
      }
    },
    mounted(){
      this.fetchOutpatientRecord();
    }
  }
</script>
