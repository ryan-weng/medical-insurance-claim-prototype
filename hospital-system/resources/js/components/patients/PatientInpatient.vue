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
      :items="inpatientRecord"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <tr style="cursor:pointer" @click="goToInpatientDetail(props.item.id)">
          <td>{{ props.item.reservation.id }}</td>
          <td>{{ props.item.diagnostic.id }}</td>
          <td>{{ props.item.reservation.room.room_bed }}</td>
          <td>{{ props.item.reservation.starting_date }}</td>
          <td>{{ props.item.reservation.ending_date }}</td>
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
            text: '住院編號',
            align: 'left',
            value: 'id'
          },
          { text: '診斷編號', value: 'diagnostic_id' },
          { text: '房間床位', value: 'room_bed' },
          { text: '開始日期', value: 'start_date' },
          { text: '結束日期', value: 'end_date' },
        ],
        inpatientRecord: []
      }
    },
    methods: {
      fetchInpatientRecord(){
        axios.get('/api/inpatient/'+this.userId)
          .then(response => {
            // console.log('record',response);
            this.inpatientRecord = response.data;
          })
      },
      goToNewInpatient(userId){
        this.$router.push({ name: 'inpatient-new', query: { userId: userId } })
      },
      goToInpatientDetail(recordId){
        this.$router.push({ name: 'inpatient-detail', params: { id: recordId } })
      }
    },
    mounted(){
      this.fetchInpatientRecord();
    }
  }
</script>
