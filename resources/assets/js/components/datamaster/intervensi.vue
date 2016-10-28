<template lang="html">
<div class="row">
  <div class="col-md-12" v-if="isAction == 'list'">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Intervensi</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th style="width: 10px">Id</th>
            <th>Program</th>
            <th>Bentuk Intervensi</th>
            <th>Sasaran Intervensi</th>
            <th>Tujuan Intervensi</th>
            <th style="width: 200px">Action</th>
          </tr>
          <tr v-for="li in list_intervensi">
            <td>{{ li.id }}</td>
            <td>{{ li.program.name }}</td>
            <td>{{ li.name }}</td>
            <td>{{ li.sasaran.name }}</td>
            <td>
              <div v-for="tujuan in li.tujuan" class="col-md-8">
                <span class="label label-warning">{{ tujuan.name }}</span>
              </div>
            </td>
            <td>
              <button class="btn btn-primary" @click.prevent="editItem(li)">Ubah</button>
              <button class="btn btn-danger" @click.prevent="deleteItem(li)">Hapus</button>
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

  <div class="col-md-12" v-if="isAction == 'add' || isAction == 'edit'">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Form Intervensi</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" @submit.prevent="simpan">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group" v-bind:class="{'has-error':!validation.program}">
              <label for="frmNama">Nama Program</label>
              <multiselect
                :selected.sync="valueProgram"
                :options="program"
                :multiple="false"
                :searchable="true"
                :close-on-select="true"
                :allow-empty="false"
                placeholder="Pilih Program"
                deselect-label="Can't remove this value"
                label="label"
                key="value"
                @update="updateProgram" :disabled="isFreeze">
              </multiselect>
              <span class="help-block" v-if="!validation.program">Program harus diisi.</span>
            </div>
            <div class="form-group" v-bind:class="{'has-error':!validation.name}">
              <label for="frmNama">Bentuk Intervensi</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nama Intervensi" v-model="intervensi.name" :disabled="isFreeze">
              <span class="help-block" v-if="!validation.name">Bentuk intervensi harus diisi.</span>
            </div>
            <div class="form-group" v-bind:class="{'has-error':!validation.sasaran}">
              <label for="frmNama">Bentuk Sasaran</label>
              <multiselect
                :selected.sync="valueSasaran"
                :options="sasaran"
                :multiple="false"
                :searchable="true"
                :close-on-select="true"
                :allow-empty="false"
                placeholder="Pilih Sasaran"
                deselect-label="Can't remove this value"
                label="label"
                key="value"
                @update="updateSasaran" :disabled="isFreeze">
              </multiselect>
              <span class="help-block" v-if="!validation.sasaran">Sasaran harus diisi.</span>
            </div>
          </div>
        <!-- /.box-body -->
        </div>
        <div class="box-footer">
          <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isFreeze">Simpan</button>
          <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isFreeze">Ubah</button>
          <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <tujuan v-if="isAction != 'list'"  :m_intervensi_id="intervensi.id"></tujuan>

</div>
</template>

<script>
var tujuan = require('./tujuan.vue')
import { Multiselect } from 'vue-multiselect';

export default {
  data () {
    return {
      intervensi:{ id: null, program_id:0, name: '',tujuan:[], m_sasaran_intervensi_id:''},
      list_intervensi:[],
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
    isAction: 'list',
    isFreeze: false,
    valueProgram: [],
    program:[],
    valueSasaran: [],
    sasaran:[]
  }
},

  computed: {
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

    validation: function(){
      return{
        name:!!this.intervensi.name.trim(),
        sasaran:!!this.valueSasaran.value,
        program:!!this.valueProgram.value
      }
    },

    isValid: function(){
      var validation = this.validation
      return Object.keys(validation).every(function(key){
        return validation[key]
      })
    },

  },

  ready () {
  },

  attached () {},
  methods: {
    fetchData: function(page) {
      this.$Progress.start()
      var url = this.$root.$config.API + '/api/intervensi/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('list_intervensi', response.data.data)
        this.$set('pagination', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    entryItem: function(){
      this.isAction = 'add'
      this.valueProgram = []
      this.intervensi = {id:null,name:'',desa:[]}
      this.isFreeze = false
    },

    simpan: function(){
      event.preventDefault()
      var self = this
      this.$Progress.start()

      var data = this.intervensi
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/intervensi/store'
      }else{
          url = url + '/api/intervensi/'+this.intervensi.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isFreeze = true
        this.$set('intervensi', response.data)
        this.$Progress.finish()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        this.$Progress.fail()
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        console.log(error)
      })
    },

    cancel: function(){
      this.isAction = 'list'
      this.fetchData(this.pagination.current_page)
    },

    editItem: function(item){
      this.intervensi.id = item.id
      this.intervensi.program_id = item.program.id
      this.intervensi.name = item.name
      this.intervensi.m_sasaran_intervensi_id = item.sasaran.id

      this.$set('valueSasaran',{value:item.sasaran.id,label:item.sasaran.name})
      this.$set('valueProgram',{value:item.program.id,label:item.program.name})

      this.isAction = 'edit'
      this.isFreeze = false
    },

    deleteItem: function(item){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/intervensi/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.$Progress.finish()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    updateProgram: function(value){
      this.valueProgram = value
      this.intervensi.program_id = value.value
    },

    updateSasaran: function(value){
      this.valueSasaran = value
      this.intervensi.m_sasaran_intervensi_id = value.value
    },

    fetchProgram: function(){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/program/ref_program').then((response)=>{
        this.$set('program',response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    fetchSasaran: function(){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/sasaran/ref_sasaran_intervensi').then((response)=>{
        this.$set('sasaran',response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    }

  },
  components: {
    tujuan, Multiselect
  },

  route: {
      activate: function(t) {
          this.fetchProgram()
          this.fetchData(this.pagination.current_page)
          this.fetchSasaran()
          this.$parent.$parent.$data.title = 'Intervensi';
          t.next();
      }
  }
}
</script>

<style lang="css">
</style>
