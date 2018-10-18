<template>
  <div>
    <v-card>
      <v-card-title>
        Claim List
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
        :items="claimRequestData"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.user.name }}</td>
          <td>{{ props.item.hospital.name }}</td>
          <td>{{ props.item.policy.name }}</td>
          <td>{{ props.item.status }}</td>
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
          { text: 'Applicant', value: 'user.name' },
          { text: 'Hospital Name', value: 'hospital.name' },
          { text: 'Insurance Policy', value: 'policy.name' },
          { text: 'Status', value: 'status' },
        ],
        claimRequestData: [

        ]
      }
    },
    methods: {
      fetchClaimRequestData(){
        axios.get('/api/user/claims')
          .then((response) => {
            console.log(response.data);
            this.claimRequestData = response.data;
          })
      }
    },
    mounted(){
      this.fetchClaimRequestData();
    }
  }
</script>
