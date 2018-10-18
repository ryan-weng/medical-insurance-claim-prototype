<template>
  <div>
    <v-card>
      <v-card-title>
        Hospital List
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
        :items="hospitalData"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.phone }}</td>
          <td>{{ props.item.address }}</td>
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
          { text: 'Phone', value: 'phone' },
          { text: 'Address', value: 'address' },
        ],
        hospitalData: [

        ]
      }
    },
    methods: {
      fetchHospitalData(){
        axios.get('/api/hospitals/')
          .then((response) => {
            console.log(response.data);
            this.hospitalData = response.data;
          })
      }
    },
    mounted(){
      this.fetchHospitalData();
    }
  }
</script>
