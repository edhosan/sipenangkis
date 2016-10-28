<template lang="html">
  <div class="box box-info"  v-if="isAction == 'list'">
    <div class="box-header with-border">
      <h3 class="box-title">Riwayat Indikator</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-5">

        </div>
        <div class="col-md-7">
          <div class="dropdown form-inline pull-right">
            <button type="button" class="btn btn-primary" @click="entryItem()">
              <i class="fa fa-plus"></i> Tambah Indikator
            </button>
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-gear"></i>
            </button>
            <ul class="dropdown-menu">
              <li class="divider"></li>
              <li v-for="field in fields">
                <span class="checkbox">
                    <label>
                        <input type="checkbox" v-model="field.visible">
                        {{ field.title == '' ? field.name.replace('__', '') : field.title | capitalize }}
                    </label>
                </span>
              </li>
            </ul>
          </div>
        </div>
        <div class="table-responsive col-md-12">
          <vuetable v-ref:vuetable
              :api-url="url"
              pagination-path=""
              :fields="fields"
              table-class="table table-bordered table-striped table-hover"
              ascending-icon="glyphicon glyphicon-chevron-up"
              descending-icon="glyphicon glyphicon-chevron-down"
              pagination-class=""
              pagination-info-class=""
              pagination-component-class=""
              :pagination-component="paginationComponent"
              :item-actions="itemActions"
              :per-page="per_page"
              :append-params="moreParams"
              wrapper-class="vuetable-wrapper "
              table-wrapper=".vuetable-wrapper"
              loading-class="loading"
          ></vuetable>
      </div>
    </div>
  </div>
  </div>

<div class="box box-info">
  <form role="form" @submit.prevent="simpan" v-if="isAction == 'add' || isAction == 'edit'">
    <div class="box-header with-border">
      <h3 class="box-title">Indikator Penilaian</h3>
    </div>
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
          </div>
          <div id="{{ index.length }}" class="panel-collapse collapse in">
            <div class="box-body">
              <div class="form-group" v-for="pertanyaan in item">
                <label for="">{{ pertanyaan.name }}</label>
                <div v-for="jawaban in pertanyaan.jawaban">
                  <input type="radio" name="{{pertanyaan.id}}" :value="jawaban.nilai" v-model='indikator[pertanyaan.id]'>
                  {{ jawaban.name }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Simpan</button>
      <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Ubah</button>
      <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
    </div>
  </form>
</div>
</template>

<script>
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default {
  data () {
    return {
      isValid: false,
      kategori_list:[],
      indikator:[],
      tab:0,
      isAction: 'add',
      valueIndikator:{id:0,value:0},
      arr_indikator:[],
      per_page: 10,
      fields:[
        { name:'id' },
        { name:'nilai' },
        { name:'kriteria' },
        { name:'created_at' },
        { name:'updated_at' },
        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
      ],
      paginationComponent: 'vuetable-pagination',
      itemActions: [
           { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
       ],
       moreParams: [],
    }
  },
  props:{
    penerima_manfaat_id: Number,
    penilaian_id:Number
  },
  computed: {
    url: function(){
      return this.$root.$config.API + '/api/penerima_indikator/'+this.penerima_manfaat_id+'/index'
    }
  },
  ready () {
  },
  attached () {},
  methods: {
    preg_quote: function( str ) {
         return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
     },
     highlight: function(needle, haystack) {
         return haystack.replace(
             new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
             '<span class="highlight">$1</span>'
         )
     },

     loadData: function(){
       this.$broadcast('vuetable:refresh')
     },

    updateRadio: function(val){
      console.log(radio)
    },

    loadIndikator: function(){
      if(this.penerima_manfaat_id == null){
        this.isValid = false
        toastr.warning('Silahkan isi Tempat Tinggal Keluarga terlebih dahulu', 'Info', {timeOut: 3000})
      }else{
        this.fetchIndikator()
        this.isValid = true
      }
    },

    fetchHasil: function(id) {
      this.$Progress.start()
      var self = this
      var url = this.$root.$config.API + '/api/penerima_indikator/'+id+'/hasil'
      this.$http.get(url).then((response)=>{
        response.data.forEach(function(item, index){
          self.indikator[item.m_indikator_id] = item.value
        })
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    fetchIndikator: function() {
      this.$Progress.start()
      var url = this.$root.$config.API + '/api/indikator/dasar'
      this.$http.get(url).then((response)=>{
        this.$set('kategori_list', response.data)
        this.$Progress.finish()
      },(error)=>{
        this.$Progress.fail()
        console.log(error)
      })
    },

    simpan: function(){
      this.$Progress.start()
      event.preventDefault()
      var self = this
      this.arr_indikator = []
      this.indikator.forEach(function(item,index){
        var arr_item = { id:index, value: item }
        self.arr_indikator.push(arr_item)
      })

      var data = this.arr_indikator
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/penerima_indikator/'+this.penilaian_id+'/store'
      }else{
          url = url + '/api/penerima_indikator/'+this.penilaian_id+'/store'
      }

      this.$http.post(url,{indikator: data}).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isAction = 'edit'
        this.$Progress.finish()
      },(error)=>{
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        console.log(error)
        this.$Progress.fail()
      })

    },

    cancel: function(){
      this.isAction = 'list'
    },

    entryItem: function(){
      this.$Progress.start()
      var url = this.$root.$config.API + '/api/penerima_indikator/'+this.penerima_manfaat_id+'/new'
      this.$http.get(url).then((response)=>{
        this.penilaian_id = response.data.id
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })

      this.fetchIndikator()
      this.isAction = 'add'
    }
  },
  components: {
      'vuetable': Vuetable
  },
  events:{
    'vuetable:action': function(action, data) {
         if (action == 'edit-item') {
            this.isAction = 'edit'
            this.penilaian_id = data.id
            this.fetchIndikator()
            this.fetchHasil(data.id)
         } else if (action == 'delete-item') {
           this.$http.get(this.$root.$config.API + '/api/pekerjaan/'+data.id+'/delete').then((response)=>{
             toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
             this.$broadcast('vuetable:refresh')
           },(error)=>{
             toastr.error('Gagal hapus data', 'Error', {timeOut: 3000})
             console.log(error)
           })
         }
     },
  },
}
</script>

<style lang="css">
</style>
