<template>
  <div>
    <v-container v-if="medicalHistory.length == 0">
      <v-btn primary :to="'/patient/'+userId+'/history/new'">建立病歷記錄</v-btn>
    </v-container>
    <v-container v-else>
      <v-data-table
        :headers="headers"
        :items="medicalHistory"
      >
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-left">{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.item.name }}</td>
            <td class="text-xs-left">{{ props.item.value == '1' ? '有' : '無' }}</td>
          </tr>
        </template>
      </v-data-table>
    </v-container>
  </div>
</template>
<script>
  export default {
    props: ['userId'],
    data() {
      return {
        search: '',
        medicalHistory: [],
        headers: [
          {
            text: '編號',
            align: 'left',
            value: 'id'
          },
          { text: '病歷項目', value: 'name' },
          { text: '有無情況', value: 'value' }
        ]
      }
    },
    methods: {
      fetchMedicalHistory(){
        axios.get('/api/patients/'+this.userId+'/history')
          .then(response => {
            this.medicalHistory = response.data;
            // console.log('hist',this.medicalHistory);
          })
      }
    },
    mounted(){
      this.fetchMedicalHistory();
    }
  }
</script>
