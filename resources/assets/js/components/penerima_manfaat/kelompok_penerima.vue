<template lang="html">
<div class="row">
  <div class="col-md-12" >
    <div class="box" v-if="isAction == 'list'">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Kelompok Penerima Manfaat</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-5">
            <bs-input type="text" :value.sync="searchFor" @keyup.enter="setFilter">
            <v-select slot="before" text="dropdown" :value.sync="filterValue" :options="filterBy" options-value="val" close-on-select placeholder="Filter"></v-select>
              <span slot="after" class="input-group-btn">
                <button type="button" class="btn btn-primary" @click="setFilter">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </bs-input>
          </div>
          <div class="col-md-7">
            <div class="dropdown form-inline pull-right">
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
                :sort-order="sortOrder"
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

      <div class="box-footer">
          <button type="button" class="btn btn-primary" @click.prevent="entry()"><i class="fa fa-plus"></i> Tambah Data</button>
      </div>
    </div>
    </div>
    <!-- /.box -->

    <form-kelompok :action='isAction' :id="kelompok_id" v-if="isAction == 'add' || isAction == 'edit'"></form-kelompok>

  </div>
</div>
</template>

<script>
var Vuetable = require('vuetable/src/components/Vuetable.vue')
var vSelect = require('vue-strap').select;
var bsInput = require('vue-strap').input;
var formKelompok = require('./form_kelompok_penerima.vue')

export default {
  data () {
    return {
      isAction: 'list',
      showModal: false,
      per_page: 10,
      url: this.$root.$config.API + '/api/kelompok/index',
      fields:[
        { name: '__sequence', title:'No.' },
        { name:'id', sortField: 'id', visible: false },
        { name:'kecamatan', sortField: 'kecamatan', title:'Kecamatan' },
        { name:'desa', sortField: 'desa', title:'Kampung / Kelurahan' },
        { name:'name', sortField: 'name', title:'Nama Kelompok' },
        { name:'sk', sortField: 'sk', title:'Dasar' },
        { name:'total', sortField: 'total', title:'Jumlah Penerima' },
        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
      ],
      filterBy:[
        { val:'m_kelompok.id', label:'Id' },
        { val:'m_kecamatan.name', label:'Kecamatan' },
        { val:'m_desa.nama', label:'Kampung/Kelurahan' },
        { val:'m_kelompok.name', label:'Nama Kelompok' },
        { val:'m_kelompok.sk', label:'SK' }
      ],
      filterValue:[],
      sortOrder: [
        { field: 'id', direction: 'asc' }
      ],
      paginationComponent: 'vuetable-pagination-pager',
      itemActions: [
           { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
       ],
       moreParams: [],
       searchFor:'',
       kelompok_id:null
    }
  },
  computed: {},
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

     setFilter: function() {
         if(this.filterValue == null){
             toastr.error('Pilih key filter untuk pencarian data', 'Error', {timeOut: 3000})
         }else{
           this.moreParams = [
               'filter=' + this.searchFor,
               'key='+ this.filterValue
           ]
           this.$nextTick(function() {
               this.$broadcast('vuetable:refresh')
           })
         }
     },

     entry: function(){
      this.isAction = 'add'
     }


  },
  components: {
    'vuetable': Vuetable,
     vSelect,
     bsInput,
     'form-kelompok': formKelompok
  },

  events:{
    'vuetable:action': function(action, data) {
         if (action == 'edit-item') {
           this.kelompok_id = data.id
           this.isAction = 'edit'
         } else if (action == 'delete-item') {
           this.$http.get(this.$root.$config.API + '/api/kelompok/'+data.id+'/delete').then((response)=>{
             toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
             this.$broadcast('vuetable:refresh')
           },(error)=>{
             toastr.error('Gagal hapus data', 'Error', {timeOut: 3000})
             console.log(error)
           })
         }
     },

    'cancel': function(){
        this.isAction = 'list'
     }
  },

  route: {
      activate: function(t) {
          this.$parent.$parent.$data.title = 'Kelompok Penerima Manfaat';
          t.next();
      }
  },
}
</script>

<style lang="css">

</style>
