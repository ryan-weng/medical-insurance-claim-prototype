<template>
  <div>
    <v-card>
      <v-card-title>
        Patient List
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
        :items="patients"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <tr style="cursor:pointer;" @click="showUserDetail(props.item.id)">
            <td class="text-xs-left">{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.id_type }}</td>
            <td class="text-xs-left">{{ props.item.id_number }}</td>
            <td class="text-xs-left">{{ props.item.name }}</td>
            <td class="text-xs-left">{{ props.item.gender }}</td>
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
          { text: 'ID Type', value: 'id_type' },
          { text: 'ID Number', value: 'id_number' },
          { text: 'Name', value: 'name' },
          { text: 'Gender', value: 'gender' },
        ],
        patients: []
      }
    },
    methods: {
      fetchPatients() {
        axios.get('/api/patients')
          .then((response) => {
            console.log(response);
            this.patients = response.data;
          })
      },
      showUserDetail(id) {
        this.$router.push({ name: 'patient-detail', params: { id }})
      }
    },
    mounted(){
      this.fetchPatients()
    }
  }
</script>
