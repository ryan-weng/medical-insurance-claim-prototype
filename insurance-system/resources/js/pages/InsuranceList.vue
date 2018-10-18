<template>
  <div>
    <v-card>
      <v-card-title>
        Insurance Policy List
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
        :items="insuranceData"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <tr style="cursor:pointer;" @click="goToInsuranceDetail(props.item.id)">
            <td>{{ props.item.id }}</td>
            <td>{{ props.item.name }}</td>
            <td>{{ props.item.max_claimable_amount }}</td>
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
          { text: 'Name', value: 'name' },
          { text: 'Maximum Claimable Amount', value: 'max_claimable_amount' },
        ],
        insuranceData: [

        ]
      }
    },
    methods: {
      fetchInsuranceData(){
        axios.get('/api/insurances/')
          .then((response) => {
            console.log(response.data);
            this.insuranceData = response.data;
          })
      },
      goToInsuranceDetail(insuranceId){
        this.$router.push({ name: 'policy-detail', params: { id: insuranceId }})
      }
    },
    mounted(){
      this.fetchInsuranceData();
    }
  }
</script>
