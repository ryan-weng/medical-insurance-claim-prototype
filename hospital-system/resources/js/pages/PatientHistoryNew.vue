<template>
    <v-form ref="form" v-model="valid" lazy-validation>
      <div v-for="(row, index) in rows" :key="index">
        <v-radio-group
          v-model="row.value"
          :rules="[v => !!v || 'This is required!']"
           row>
          <label>{{row.name}} </label>
          <v-radio label="有" value="1"></v-radio>
          <v-radio label="無" value="0"></v-radio>
        </v-radio-group>
        <label>若有 : </label>
        <v-text-field
          v-model="row.description"
          label=""
        ></v-text-field>
      </div>

      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        submit
      </v-btn>
      <v-btn @click="clear">clear</v-btn>
    </v-form>
</template>

<script>
  export default {
    data: () => ({
      rows: [],
      valid: true
    }),
    methods: {
      submit () {
        console.log(this.rows);
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          axios.post('/api/history/create', {
            id: this.$route.params.id,
            data: this.rows
          }).then(response => {
            console.log(response);
            this.$router.push({ name: 'patient-detail', params: { id: this.$route.params.id }})
          })
        }
      },
      clear () {
        this.$refs.form.reset()
      },
      fetchMedicalHistoryItem(){
        axios.get('/api/history/items')
          .then(response => {
            for(let i in response.data){
              let item = response.data[i];
              // console.log(item);
              this.rows.push({
                id: item.id,
                name: item.name,
                value: "",
                description: ""
              });
            }
            // console.log(response);
          })
      }
    },
    mounted () {
      this.fetchMedicalHistoryItem();
    }
  }
</script>
