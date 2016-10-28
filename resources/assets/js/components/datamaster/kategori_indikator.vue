<template lang="html">
<div class="row">
  <div class="col-md-12" v-if="isAction == 'list'">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Indikator</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="box-group" id="accordion">
          <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
          <div class="panel box box-primary" v-for="(index,item) in kategori_list">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#{{ index.length }}">
                  {{ index }}
                </a>
              </h4>
              <div class="box-tools">
                <div class="btn-group">
                  <button type="button" class="btn btn-info btn-flat">Aksi</button>
                  <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:void(0)" @click.prevent="edit(item)">Ubah</a></li>
                    <li><a href="javascript:void(0)" @click.prevent="hapus(item)">Hapus</a></li>
                  </ul>
                </div>

              </div>
            </div>
            <div id="{{ index.length }}" class="panel-collapse collapse in">
              <div class="box-body">
                <div class="form-group" v-for="pertanyaan in item">
                  <label for="">{{ pertanyaan.name }}</label>
                  <div class="form-group" v-for="jawaban in pertanyaan.jawaban">
                    <label for="">({{ jawaban.nilai }}) {{ jawaban.name }}</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        <button class="btn btn-primary" @click.prevent="entryItem()">Tambah Data</button>
      </div>
    </div>
    <!-- /.box -->
  </div>

  <div class="col-md-12" v-if="isAction == 'add' || isAction == 'edit'">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Form Kategori Indikator</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" @submit.prevent="simpan">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group" v-bind:class="{'has-error':!validation.name}">
              <label for="frmNama">Kategori Indikator</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nama kategori indikator" v-model="kategori.name" :disabled="isFreeze">
              <span class="help-block" v-if="!validation.name">Nama kategori indikator harus diisi.</span>
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

  <indikator v-if="isAction != 'list'" :kategori_id='kategori.id'></indikator
</div>
</template>

<script>
var indikator = require('./indikator.vue')
export default {
  data () {
    return {
      isAction: 'list',
      kategori:{id:null, name:'',indikator:[]},
      kategori_list:[],
      isFreeze: false
    }
  },

  computed: {
    validation: function(){
      return{
        name:!!this.kategori.name.trim()
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
    this.fetchData()
  },

  attached () {},

  methods: {
    entryItem: function(){
      this.isAction = 'add'
      this.kategori = {id:null,name:'',indikator:[]}
      this.isFreeze = false
    },

    cancel: function(){
      this.isAction = 'list'
    },

    simpan: function(){
      event.preventDefault()
      var self = this
      var data = this.kategori
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/kategori/store'
      }else{
          url = url + '/api/kategori/'+this.kategori.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isFreeze = true
        this.$set('kategori', response.data)
        this.fetchData()

      },(error)=>{
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        console.log(error)
      })
    },

    fetchData: function() {
      var url = this.$root.$config.API + '/api/kategori/index'
      this.$http.get(url).then((response)=>{
        this.$set('kategori_list', response.data)
      },(error)=>{
        console.log(error)
      })
    },

    edit: function(item){
      this.isAction = 'edit'
      this.isFreeze = false
      this.kategori.id = item[0].m_kategori_indikator_id
      this.kategori.name = item[0].kategori.name
    },

    hapus: function(item){
      this.$http.get(this.$root.$config.API + '/api/kategori/'+item[0].m_kategori_indikator_id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData()

      },(error)=>{
        console.log(error)
      })
    },



  },

  components: {
    indikator
  },

  route: {
      activate: function(t) {
          this.$parent.$parent.$data.title = 'Indikator';
          t.next();
      }
  }
}
</script>

<style lang="css">
</style>
