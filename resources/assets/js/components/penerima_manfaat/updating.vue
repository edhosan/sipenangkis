<template lang="html">
<div class="row">
  <div class="col-md-12" v-if="isAction == 'list'">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Penerima Manfaat</h3>
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
    </div>
    </div>
    <!-- /.box -->

  </div>
</div>
</template>

<script>
var Vuetable = require('vuetable/src/components/Vuetable.vue')
var vSelect = require('vue-strap').select;
var bsInput = require('vue-strap').input;

export default {
  data () {
    return {
      isAction: 'list',
      showModal: false,
      per_page: 10,
      url: this.$root.$config.API + '/api/pembaharuan/index',
      fields:[
        { name:'id', sortField: 'id' },
        { name:'nkk', sortField: 'nkk', title:'NKK' },
        { name:'nama', sortField: 'nama' },
        { name:'alamat', sortField: 'alamat' },
        { name:'desa', sortField: 'desa', title:'Kelurahan/Desa' },
        { name:'kecamatan', sortField: 'kecamatan', title:'Kecamatan' },
        { name:'kriteria', sortField: 'kriteria'},
        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
      ],
      filterBy:[
        { val:'m_penerima_manfaat.id', label:'Id' },
        { val:'m_penerima_manfaat.nkk', label:'Kartu Keluarga' },
        { val:'m_penerima_manfaat_keluarga.nama', label:'Nama' },
        { val:'m_penerima_manfaat.alamat', label:'Alamat' },
        { val:'m_desa.name', label:'Desa/Kelurahan' },
        { val:'m_kecamatan.name', label:'Kecamatan' },
        { val:'t_pm_penilaian.kriteria', label:'Kriteria' },
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
       searchFor:''
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


  },
  components: {
    'vuetable': Vuetable,
     vSelect,
     bsInput
  },

  events:{
    'vuetable:action': function(action, data) {
         if (action == 'edit-item') {
           this.$router.go({path:'/rtm/tempat/edit/'+data.id})
         } else if (action == 'delete-item') {
           this.$http.get(this.$root.$config.API + '/api/pembaharuan/'+data.id+'/delete').then((response)=>{
             toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
             this.$broadcast('vuetable:refresh')
           },(error)=>{
             toastr.error('Gagal hapus data', 'Error', {timeOut: 3000})
             console.log(error)
           })
         }
     },
  },

  route: {
      activate: function(t) {
          this.$parent.$parent.$data.title = 'Pembaharuan Data RTM';
          t.next();
      }
  },
}
</script>

<style lang="css">

</style>
