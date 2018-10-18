<template>
  <div>
    <v-card>
      <v-card-title>
        醫療記錄
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="尋找"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>

      <v-data-table
        :headers="headers"
        :items="treatments"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.category.name }}</td>
          <td>{{ props.item.cost }}</td>
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
        pagination: {},
        selected: [],
        headers: [
          {
            text: '醫療編號',
            align: 'left',
            value: 'id'
          },
          { text: '醫療名稱', value: 'name' },
          { text: '醫療類型', value: 'category.name' },
          { text: '費用', value: 'cost' }
        ],
        treatments: [

        ]
      }
    },
    computed: {
      pages () {
        if (this.pagination.rowsPerPage == null ||
          this.pagination.totalItems == null
        ) return 0

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      }
    },
    methods: {
      fetchTreatmentsList() {
        axios.get('/api/treatments')
          .then((response) => {
            console.log(response);
            this.treatments = response.data;
          })
      }
    },
    mounted() {
      this.fetchTreatmentsList()
    }
  }
</script>
