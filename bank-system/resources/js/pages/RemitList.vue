<template>
  <div>
    <v-card>
      <v-card-title>
        Remittance List
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>

      <v-data-table
        :headers="headers"
        :items="remittanceData"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <tr style="cursor:pointer;" @click="goToRemittanceDetail(props.item.id)">
            <td>{{ props.item.id }}</td>
            <td>{{ props.item.receiver }}</td>
            <td>{{ props.item.amount }}</td>
            <td>{{ props.item.status }}</td>
          </tr>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
          Your search for "{{ search }}" found no results.
        </v-alert>
      </v-data-table>
    </v-card>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        search: '',
        selected: [],
        headers: [
          {
            text: 'ID',
            align: 'left',
            value: 'id'
          },
          { text: 'Hospital ID (Receiver)', value: 'receiver' },
          { text: 'Amount', value: 'amount' },
          { text: 'Status', value: 'status' },
        ],
        remittanceData: [

        ]
      }
    },
    methods: {
      fetchRemittanceData(){
        axios.get('/api/remittances')
          .then((response) => {
            console.log(response.data);
            this.remittanceData = response.data;
          })
      },
      goToRemittanceDetail(remittanceId){
        this.$router.push({ name: 'remittance-detail', params: {id: remittanceId}});
      }
    },
    mounted(){
      this.fetchRemittanceData();
    }
  }
</script>
