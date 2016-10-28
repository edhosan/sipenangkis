<template lang="html">
<div class="col-md-12" v-if="isAction == 'list'">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Pertanyaan Indikator</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-group" v-for="item in indikator_list">
        <div class="pull-right box-tools">
          <button class="btn btn-primary" @click.prevent="editItem(item)">Ubah</button>
          <button class="btn btn-danger" @click.prevent="deleteItem(item)">Hapus</button>
        </div>
        <label for="">{{ item.name }}</label>
        <div class="form-group" v-for="jawaban in item.jawaban">
          <label for="">({{ jawaban.nilai }}) {{ jawaban.name }}</label>
        </div>
      </div>
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
  <!-- /.box -->
  </div>
</div>

<div class="col-md-12" v-if="isAction == 'add' || isAction == 'edit'">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Pertanyaan Indikator</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" @submit.prevent="simpan">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group" v-bind:class="{'has-error':!validation.name}">
            <label for="frmNama">Pertanyaan Indikator</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nama" v-model="indikator.name" :disabled="isFreeze">
            <span class="help-block" v-if="!validation.name">Pertanyaan indikator harus diisi.</span>
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

  <jawaban v-if="isAction != 'list'" :indikator_id="indikator.id"></jawaban>
</div>


</template>

<script>
var jawaban = require('./jawaban.vue')

export default {
  data () {
    return {
      indikator:{id:null,name:'',jawaban:[]},
      indikator_list:[],
      offset: 4,
      per_page: 5,
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
      i:1,
      isFreeze: false
    }
  },
  props:{
    kategori_id:Number
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
        name:!!this.indikator.name.trim()
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
    this.fetchData(this.pagination.current_page)
  },

  attached () {},

  methods: {
    entryItem: function(){
      this.isFreeze = false
      if(this.kategori_id == null){
          toastr.error('Simpan Kategori Indikator terlebih dahulu', 'Error', {timeOut: 3000})
      }else{
        this.isAction = 'add'
      }
    },

    isNumeric: function(val){
      return /^[-+]?[0-9]+$/.test(val)
    },

    simpan: function(){
      this.$Progress.start()
      event.preventDefault()
      var self = this
      var data = this.indikator
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/indikator/'+this.kategori_id+'/store'
      }else{
          url = url + '/api/indikator/'+this.indikator.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isFreeze = true
        this.isAction = 'edit'
        this.$set('indikator', response.data)
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

    fetchData: function(page) {
      this.$Progress.start()
      var url = this.$root.$config.API + '/api/indikator/'+this.kategori_id+'/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('indikator_list', response.data.data)
        this.$set('pagination', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    cancel: function(){
      this.isAction = 'list'
      this.indikator = {id:null,name:'',pil_1:'',bobot_1:0,pil_2:'',bobot_2:0,pil_3:'',bobot_3:0,pil_4:'',bobot_4:0}
      this.fetchData(this.pagination.current_page)
    },

    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    editItem: function(edit_item){
      console.log(edit_item)
      this.$set('indikator',edit_item)
      this.isAction = 'edit'
    },

    deleteItem: function(item){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/indikator/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.$Progress.finish()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },
  },
  components: { jawaban }
}
</script>

<style lang="css">
</style>
