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
      :items="paymentRecords"
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
            text: '診斷編號',
            align: 'left',
            value: 'id'
          },
          { text: '日期', value: 'amount' },
          { text: '金額', value: 'cost' }
        ],
        paymentRecords: []
      }
    },
    methods: {
      fetchPaymentRecord(){
        axios.get('/api/patients/'+this.userId+'/payment')
          .then(response => {
            // console.log("a",response);
            this.paymentRecords = response.data;
          })
      }
    },
    mounted(){
      this.fetchPaymentRecord();
    }
  }
</script>
