<template>
  <div>
    <v-card>
      <v-card-title>
        Claimable List
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
        :items="claimableData"
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
          { text: 'Amount', value: 'amount' },
          { text: 'Maximum Count', value: 'max_count' },
        ],
        claimableData: [

        ]
      }
    },
    methods: {
      fetchClaimableData(){
        axios.get('/api/claimables/')
          .then((response) => {
            console.log(response.data);
            this.claimableData = response.data;
          })
      }
    },
    mounted(){
      this.fetchClaimableData();
    }
  }
</script>
