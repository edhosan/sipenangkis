<template lang="html">
  <div class="row">
    <div class="col-md-12" v-if="isAction == 'add' || isAction == 'edit'">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Program</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" @submit.prevent="simpan">
          <div class="box-body">
            <div class="col-md-12">
              <div class="form-group" v-bind:class="{'has-error':!validation.name}">
                <label for="frmNama">Nama Program</label>
                <input type="text" class="form-control" id="frmNama" placeholder="Nama Program" v-model="program.name">
                <span class="help-block" v-if="!validation.name">Nama program harus diisi.</span>
              </div>
              <div class="form-group" v-bind:class="{'has-error':!validation.stakeholder}">
                <label for="frmNama">Stakeholders</label>
                <multiselect
                  :selected.sync="valueStakeholder"
                  :options="stakeholders"
                  :multiple="true"
                  :searchable="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :allow-empty="false"
                  placeholder="Pilih Stakeholders"
                  label="label"
                  key="value"
                  @update="updateStakeholder">
                </multiselect>
                <span class="help-block" v-if="!validation.stakeholder">Stakeholders harus diisi.</span>
              </div>
              <div class="form-group" v-bind:class="{'has-error':!validation.sumber_dana}">
                <label for="frmNama">Sumber Dana</label>
                <multiselect
                  :selected.sync="valueSumberdana"
                  :options="sumber_dana"
                  :multiple="true"
                  :searchable="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :allow-empty="false"
                  placeholder="Pilih Sumber Dana"
                  label="label"
                  key="value"
                  @update="updateSumberdana">
                </multiselect>
                <span class="help-block" v-if="!validation.sumber_dana">Sumber dana harus diisi.</span>
              </div>
            </div>
          <!-- /.box-body -->
          </div>
          <div class="box-footer">
            <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid">Simpan</button>
            <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid">Ubah</button>
            <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-12" v-if="isAction == 'list'">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Program</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th style="width: 10px">Id</th>
              <th>Nama Program</th>
              <th>Stakeholders</th>
              <th>Sumber Dana</th>
              <th>Action</th>
            </tr>
            <tr v-for="item in items">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>
                <div v-for="stakeholder in item.stakeholders">
                  <span class="label label-success">{{ stakeholder.name }}</span>
                </div>
              </td>
              <td>
                <div v-for="sumber_dana in item.sumber_dana">
                  <span class="label label-info">{{ sumber_dana.name }}</span>
                </div>
              </td>
              <td>
                <button class="btn btn-primary" @click.prevent="editItem(item)">Ubah</button>
                <button class="btn btn-danger" @click.prevent="deleteItem(item)">Hapus</button>
              </td>
            </tr>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <ul class="pagination pagination-sm no-margin pull-right">
            <li v-if="pagination.current_page > 1">
              <a href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li v-for="page in pagesNumber" v-bind:class="[page == isActived ? 'active': '']" >
              <a href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
              <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)" >
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
          <div >
            <button class="btn btn-primary" @click.prevent="entryItem()">Tambah Data</button>
          </div>
        </div>
      </div>
      <!-- /.box -->

    </div>
  </div>

</template>

<script>
import { Multiselect } from 'vue-multiselect';

export default {
  data () {
    return {
      program:{ id: null, name: '',stakeholders:[], sumber_dana:[]},
      valueStakeholder: [],
      stakeholders:[],
      isAction: 'list',
      valueSumberdana:[],
      sumber_dana:[],
      offset: 4,
      per_page: 10,
      pagination: {
        current_page: 1,
        from: 1,
        last_page: 0,
        next_page_url: '',
        per_page: 1,
        prev_page_url: '',
        to: 1,
        total: 0
      },
      items: [],
    }
  },

  computed: {
    validation: function(){
      return{
        name:!!this.program.name.trim(),
        stakeholder:!!this.valueStakeholder.length > 0,
        sumber_dana:!!this.valueSumberdana.length > 0
      }
    },

    isValid: function(){
      var validation = this.validation
      return Object.keys(validation).every(function(key){
        return validation[key]
      })
    },

    isActived: function() {
      return this.pagination.current_page
    },

    pagesNumber: function(){
      if(!this.pagination.to){
        return []
      }

      var from = this.pagination.current_page - this.offset;
      if(from < 1){
        from = 1
      }

      var to = from + (this.offset * 2);
      if(to >= this.pagination.last_page){
        to = this.pagination.last_page
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from)
        from++
      }

      return pagesArray
    },
  },

  ready () {
  },

  attached () {},
  methods: {
    simpan: function(){
      event.preventDefault()

      var data = this.program
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/program/store'
      }else{
          url = url + '/api/program/'+this.program.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.cancel()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        console.log(error)
      })
    },

    updateStakeholder: function(value){
      this.valueStakeholder = value
      this.program.stakeholders = value
    },

    updateSumberdana: function(value){
      this.valueSumberdana = value
      this.program.sumber_dana = value
    },

    fetchStakeholder: function(){
      this.$http.get(this.$root.$config.API + '/api/stakeholder/ref_stakeholder').then((response)=>{
        this.$set('stakeholders',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchSumberdana: function(){
      this.$http.get(this.$root.$config.API + '/api/sumber_dana/ref_sumber_dana').then((response)=>{
        this.$set('sumber_dana',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    cancel: function(){
      this.isAction = 'list'
      this.program = { name: '',stakeholders:[], sumber_dana:[] }
      this.valueStakeholder = []
      this.valueSumberdana = []
    },

    fetchData: function(page) {
      var url = this.$root.$config.API + '/api/program/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('items', response.data.data)
        this.$set('pagination', response.data)
      },(error)=>{
        console.log(error)
      })
    },

    editItem: function(item){
      var self = this
      this.program.id = item.id
      this.program.name = item.name

      this.$http.get(this.$root.$config.API + '/api/stakeholder/ref_stakeholder?id='+item.id).then((response)=>{
        this.$set('valueStakeholder', response.data)
        this.program.stakeholders = response.data
      },(error)=>{
        console.log(error)
      })

      this.$http.get(this.$root.$config.API + '/api/sumber_dana/ref_sumber_dana?id='+item.id).then((response)=>{
        this.$set('valueSumberdana',response.data)
        this.program.sumber_dana = response.data
      },(error)=>{
        console.log(error)
      })

      this.isAction = 'edit'
    },

    deleteItem: function(item){
      this.$http.get(this.$root.$config.API + '/api/program/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        console.log(error)
      })
    },

    entryItem: function(){
      this.isAction = 'add'
      this.program = { name: '',stakeholders:[], sumber_dana:[] }
      this.valueStakeholder = []
      this.valueSumberdana = []
    },

  },
  components: {
    Multiselect
  },
  route: {
      activate: function(t) {
          this.fetchStakeholder()
          this.fetchSumberdana()
          this.fetchData(this.pagination.current_page)
          this.$parent.$parent.$data.title = 'Program';
          t.next();
      }
  }
}
</script>

<style lang="css">
</style>
