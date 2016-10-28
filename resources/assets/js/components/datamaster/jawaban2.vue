<template lang="html">
<div class="col-md-12" v-if="isAction == 'list'">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Indikator</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-group" v-for="item in indikator_list">
        <div class="pull-right box-tools">
          <button class="btn btn-primary" @click.prevent="editItem(item)">Ubah</button>
          <button class="btn btn-danger" @click.prevent="deleteItem(item)">Hapus</button>
        </div>
        <label for="">{{ item.name }}</label>
        <div>
          <label>
            <input type="radio" disabled name="optionsRadios" id="optionsRadios1" value="{{ item.bobot_1 }}">
            ({{ item.bobot_1 }})
            {{ item.pil_1 }}
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" disabled name="optionsRadios" id="optionsRadios1" value="{{ item.bobot_2 }}">
            ({{ item.bobot_2 }})
            {{ item.pil_2 }}
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" disabled name="optionsRadios" id="optionsRadios1" value="{{ item.bobot_3 }}">
            ({{ item.bobot_3 }})
            {{ item.pil_3 }}
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" disabled name="optionsRadios" id="optionsRadios1" value="{{ item.bobot_4 }}">
            ({{ item.bobot_4 }})
            {{ item.pil_4 }}
          </label>
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
      <h3 class="box-title">Form Indikator</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" @submit.prevent="simpan">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group" v-bind:class="{'has-error':!validation.name}">
            <label for="frmNama">Nama Indikator</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nama" v-model="indikator.name">
            <span class="help-block" v-if="!validation.name">Nama indikator harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.pil_1}">
            <label for="frmNama">Pilhan 1</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Pilihan 1" v-model="indikator.pil_1">
            <span class="help-block" v-if="!validation.pil_1">Pilihan 1 harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.bobot_1 || !isNumeric(indikator.bobot_1)}">
            <label for="frmNama">Bobot 1</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Bobot 1" v-model="indikator.bobot_1">
            <span class="help-block" v-if="!validation.bobot_1">Bobot 1 harus diisi.</span>
            <span class="help-block" v-if="!isNumeric(indikator.bobot_1)">Bobot 1 harus angka.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.pil_2}">
            <label for="frmNama">Pilhan 2</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Pilihan 2" v-model="indikator.pil_2">
            <span class="help-block" v-if="!validation.pil_2">Pilihan 2 harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.bobot_2 || !isNumeric(indikator.bobot_2)} ">
            <label for="frmNama">Bobot 2</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Bobot 2" v-model="indikator.bobot_2">
            <span class="help-block" v-if="!validation.bobot_2">Bobot 2 harus diisi.</span>
            <span class="help-block" v-if="!isNumeric(indikator.bobot_2)">Bobot 2 harus angka.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.pil_3}">
            <label for="frmNama">Pilhan 3</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Pilihan 3" v-model="indikator.pil_3">
            <span class="help-block" v-if="!validation.pil_3">Pilihan 3 harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.bobot_3 || !isNumeric(indikator.bobot_3)}">
            <label for="frmNama">Bobot 3</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Bobot 3" v-model="indikator.bobot_3">
            <span class="help-block" v-if="!validation.bobot_3">Bobot 3 harus diisi.</span>
            <span class="help-block" v-if="!isNumeric(indikator.bobot_3)">Bobot 3 harus angka.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.pil_4}">
            <label for="frmNama">Pilhan 4</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Pilihan 4" v-model="indikator.pil_4">
            <span class="help-block" v-if="!validation.pil_4">Pilihan 4 harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.bobot_4 || !isNumeric(indikator.bobot_4)} ">
            <label for="frmNama">Bobot 4</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Bobot 4" v-model="indikator.bobot_4">
            <span class="help-block" v-if="!validation.bobot_4">Bobot 4 harus diisi.</span>
            <span class="help-block" v-if="!isNumeric(indikator.bobot_4)">Bobot 4 harus angka.</span>
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


</template>

<script>
export default {
  data () {
    return {
      indikator:{id:null,name:'',pil_1:'',bobot_1:0,pil_2:'',bobot_2:0,pil_3:'',bobot_3:0,pil_4:'',bobot_4:0},
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
      i:1
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
        name:!!this.indikator.name.trim(),
        pil_1:!!this.indikator.pil_1.trim(),
        bobot_1:!!this.indikator.bobot_1,
        pil_2:!!this.indikator.pil_2.trim(),
        bobot_2:!!this.indikator.bobot_2,
        pil_3:!!this.indikator.pil_3.trim(),
        bobot_3:!!this.indikator.bobot_3,
        pil_4:!!this.indikator.pil_4.trim(),
        bobot_4:!!this.indikator.bobot_4
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
      this.isAction = 'add'
    },

    isNumeric: function(val){
      return /^[-+]?[0-9]+$/.test(val)
    },

    simpan: function(){
      event.preventDefault()
      var self = this
      this.$Progress.start()

      var data = this.indikator
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/indikator/'+this.kategori_id+'/store'
      }else{
          url = url + '/api/indikator/'+this.indikator.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.cancel()
        this.fetchData(this.pagination.current_page)
        this.$Progress.finish()
      },(error)=>{
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        this.$Progress.fail()
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
    },

    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    editItem: function(edit_item){
      this.$set('indikator',edit_item)
      this.isAction = 'edit'
    },

    deleteItem: function(item){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/indikator/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData(this.pagination.current_page)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },
  },
  components: {}
}
</script>

<style lang="css">
</style>
