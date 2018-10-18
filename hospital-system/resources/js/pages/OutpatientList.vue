<template>
  <div>
    <v-card>
      <v-card-title>
        全部門診記錄
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
        :items="outpatientData"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.diagnostic.id }}</td>
          <td>{{ props.item.patient.id_type }}</td>
          <td>{{ props.item.patient.id_number }}</td>
          <td>{{ props.item.patient.name }}</td>
          <td>{{ props.item.diagnostic.doctor.department.name }}</td>
          <td>{{ props.item.diagnostic.doctor.name }}</td>
          <td>{{ props.item.diagnostic.outpatient_date }}</td>
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
            text: '診斷編號',
            align: 'left',
            value: 'diagnostic.id'
          },
          { text: '身分證類型', value: 'patient.id_type' },
          { text: '身分證號碼', value: 'patient.id_number' },
          { text: '病患姓名', value: 'patient.name' },
          { text: '科別', value: 'diagnostic.doctor.department.name' },
          { text: '醫師', value: 'diagnostic.doctor.name' },
          { text: '日期', value: 'diagnostic.outpatient_date' },
        ],
        outpatientData: [

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
      fetchOutpatientData(){
        axios.get('/api/outpatient/')
          .then((response) => {
            console.log(response.data);
            this.outpatientData = response.data;
          })
      }
    },
    mounted(){
      this.fetchOutpatientData();
    }
  }
</script>
