<template>
  <v-container>
    <div class="d-flex">
      <v-spacer></v-spacer>
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
      :items="treatmentRecords"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <tr>
          <td class="text-xs-left">{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.treatment.name }}</td>
          <td class="text-xs-left">{{ props.item.amount }}</td>
          <td class="text-xs-left">{{ props.item.treatment.cost }}</td>
          <td class="text-xs-left">{{ props.item.created_at }}</td>
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
          { text: '醫療名稱', value: 'treatment.name' },
          { text: '數量', value: 'amount' },
          { text: '價格', value: 'treatment.cost' },
          { text: '日期', value: 'created_at' }
        ],
        treatmentRecords: []
      }
    },
    methods: {
      fetchTreatmentRecord(){
        axios.get('/api/treatments/'+this.userId)
          .then(response => {
            // console.log('treatments',response);

            for(let i in response.data){
              // console.log(response.data[i].treatments);
              this.treatmentRecords.push(...response.data[i].treatments);
            }
            //
            // console.log('treatments',this.treatmentRecords);
          })
      }
    },
    mounted(){
      this.fetchTreatmentRecord();
    }
  }
</script>
