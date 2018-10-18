<template>
  <div>
    <v-card>
      <v-card-title>
        全部住院記錄
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
        :items="inpatientData"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.reservation.id }}</td>
          <td>{{ props.item.patient.name }}</td>
          <td>{{ props.item.diagnostic.id }}</td>
          <td>{{ props.item.reservation.room.room_bed }}</td>
          <td>{{ props.item.reservation.starting_date }}</td>
          <td>{{ props.item.reservation.ending_date }}</td>
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
            text: '住院編號',
            align: 'left',
            value: 'reservation.id'
          },
          { text: '病患姓名', value: 'patient.name' },
          { text: '診斷編號', value: 'diagnostic.id' },
          { text: '房間床位', value: 'reservation.room.room_bed' },
          { text: '開始日期', value: 'reservation.starting_date' },
          { text: '結束日期', value: 'reservation.ending_date' },
        ],
        inpatientData: [

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
      fetchInpatientData(){
        axios.get('/api/inpatient/')
          .then((response) => {
            console.log(response.data);
            this.inpatientData = response.data;
          })
      }
    },
    mounted(){
      this.fetchInpatientData();
    }
  }
</script>
