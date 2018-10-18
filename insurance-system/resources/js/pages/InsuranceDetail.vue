<template>
  <div>
    <v-card>
      <v-card-title primary-title>
       <h4>Insurance Detail</h4>
      </v-card-title>
      <v-card-text>
        ID : {{ insuranceData.id }}<br/>
        Name : {{ insuranceData.name }}<br/>
        Maximum Claimable Amount : {{ insuranceData.max_claimable_amount }}
      </v-card-text>
    </v-card>
    <v-card>
      <v-card-title>
        <h4>Claimable List</h4>
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
        :items="insuranceData.claimables"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.amount }}</td>
          <td>{{ props.item.max_count }}</td>
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
    data() {
      return {
        user: {},
        insuranceData: {},
        search: '',
        headers: [
          {
            text: 'ID',
            align: 'left',
            value: 'id'
          },
          { text: 'Name', value: 'name' },
          { text: 'Amount', value: 'amount' },
          { text: 'Max Count', value: 'max_count' }
        ],
      }
    },
    methods: {
      goBack(){
        this.$router.go(-1)
      },
      fetchInsuranceDetail(){
        axios.get('/api/insurances/'+this.$route.params.id)
          .then(response => {
            console.log(response);
            this.insuranceData = response.data;
          })
      }
    },
    mounted() {
      this.fetchInsuranceDetail();
    }
  }
</script>
