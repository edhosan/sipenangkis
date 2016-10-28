<template lang="html">
    <div class="row">
      <div class="col-md-12" v-if="isAction == 'list'">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Pekerjaan</h3>
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
                  <button type="button" class="btn btn-primary" @click="entryItem()">
                    <i class="fa fa-plus"></i> Tambah Data
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

      <div class="col-md-12" v-if="isAction == 'add' || isAction == 'edit'">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Form Pekerjaan</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" @submit.prevent="simpan">
            <div class="box-body">
              <div class="col-md-12">
                <div class="form-group" v-bind:class="{'has-error':!validation.name}">
                  <label for="frmNama">Nama Pekerjaan</label>
                  <input type="text" class="form-control" id="frmNama" placeholder="Nama Pekerjaan" v-model="pekerjaan.pekerjaan" :disabled="isFreeze">
                  <span class="help-block" v-if="!validation.name">Pekerjaan harus diisi.</span>
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
      pekerjaan: {id:null,pekerjaan:''},
      url: this.$root.$config.API + '/api/pekerjaan/index',
      fields:[
        { name:'id', sortField: 'id' },
        { name:'pekerjaan', sortField: 'pekerjaan' },
        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
      ],
      filterBy:[
        { val:'id', label:'Id' },
        { val:'pekerjaan', label:'Pekerjaan' },
      ],
      filterValue:[],
      sortOrder: [
        { field: 'id', direction: 'asc' }
      ],
      paginationComponent: 'vuetable-pagination',
      itemActions: [
           { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
       ],
       moreParams: [],
       searchFor:''
    }
  },
  computed: {
    validation: function(){
      return{
        name:!!this.pekerjaan.pekerjaan
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
  created(){

  },
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

    editItem: function(item){
      this.$set('pekerjaan',item)
      this.isAction = 'edit'
      this.isFreeze = false
    },

    deleteItem: function(item){

    },

    entryItem: function(){
      console.log('test')
      this.isAction = 'add'
      this.pekerjaan = {id:null,name:''}
      this.isFreeze = false
    },

    simpan: function(){
      this.$Progress.start()
      event.preventDefault()
      var self = this

      var data = this.pekerjaan
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/pekerjaan/store'
      }else{
          url = url + '/api/pekerjaan/'+this.pekerjaan.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isFreeze = true
        this.$set('pekerjaan', response.data)
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
             this.$set('pekerjaan',data)
             this.isAction = 'edit'
             this.isFreeze = false
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

  route: {
      activate: function(t) {
          this.$parent.$parent.$data.title = 'Pekerjaan';
          t.next();
      }
  },

  watch:{

  }

}
</script>

<style lang="css">
ul.dropdown-menu li {
    margin-left: 20px;
}
.vuetable th.sortable:hover {
      color: #2185d0;
      cursor: pointer;
  }
  .vuetable-actions {
      width: 15%;
      padding: 12px 0px;
      text-align: center;
  }
  .vuetable-actions > button {
    padding: 3px 6px;
    margin-right: 4px;
  }
  .vuetable-pagination {
  }
  .vuetable-pagination-info {
      float: left;
      margin-top: auto;
      margin-bottom: auto;
  }
  .vuetable-pagination-component {
    float: right;
  }
  .vuetable-pagination-component .pagination {
    margin: 0px;
  }
  .vuetable-pagination-component .pagination .btn {
      cursor: pointer;
      margin: 2px;
  }
  [v-cloak] {
      display: none;
  }
  .highlight {
      background-color: yellow;
  }
  /* Loading Animation: */
  .vuetable-wrapper {
      opacity: 1;
      position: relative;
      filter: alpha(opacity=100); /* IE8 and earlier */
  }
  .vuetable-wrapper.loading {
    opacity:0.4;
     transition: opacity .3s ease-in-out;
     -moz-transition: opacity .3s ease-in-out;
     -webkit-transition: opacity .3s ease-in-out;
  }
  .vuetable-wrapper.loading:after {
    position: absolute;
    content: '';
    top: 40%;
    left: 50%;
    margin: -30px 0 0 -30px;
    border-radius: 100%;
    -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
    border: 4px solid #000;
    height: 60px;
    width: 60px;
    background: transparent !important;
    display: inline-block;
    -webkit-animation: pulse 1s 0s ease-in-out infinite;
            animation: pulse 1s 0s ease-in-out infinite;
  }
  @keyframes pulse {
    0% {
      -webkit-transform: scale(0.6);
              transform: scale(0.6); }
    50% {
      -webkit-transform: scale(1);
              transform: scale(1);
           border-width: 12px; }
    100% {
      -webkit-transform: scale(0.6);
              transform: scale(0.6); }
  }
</style>
