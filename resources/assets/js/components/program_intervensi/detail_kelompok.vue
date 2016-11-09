<template>
  <div class="tab-pane active"> 
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Kelompok Penerima</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="frmNama">Kecamatan</label>
          <input type="text" class="form-control" id="frmNama" v-model="kecamatan.name" disabled>
        </div>
        <div class="form-group">
          <label for="frmNama">Kampung / Kelurahan</label>
          <input type="text" class="form-control" id="frmNama" v-model="desa.name" disabled>
        </div>
        <div class="form-group">
          <label for="frmNama">Nama Kelompok</label>
          <input type="text" class="form-control" id="frmNama" v-model="kelompok.name" disabled>
        </div>
        <div class="form-group">
          <label for="frmNama">Dasar Pembentukan</label>
          <input type="text" class="form-control" id="frmNama" v-model="kelompok.sk" disabled>
        </div>
      </div>  
    </div>  

    <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Detail Penerima Manfaat</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->     
    <div class="box-body">
        <div class="table-responsive col-md-12">
          <vuetable v-ref:vuetable
              :api-url="url_penerima"
              pagination-path=""
              :fields="fields_penerima"
              table-class="table table-bordered table-striped table-hover"
              ascending-icon="glyphicon glyphicon-chevron-up"
              descending-icon="glyphicon glyphicon-chevron-down"
              pagination-class=""
              pagination-info-class=""
              pagination-component-class=""
              :pagination-component="paginationComponent_1"
              :per-page="per_page"
              :append-params="penerimaParams"
              wrapper-class="vuetable-wrapper "
              table-wrapper=".vuetable-wrapper"
              loading-class="loading"
          ></vuetable>
        </div>
      <!-- /.box-body -->
    </div>       
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Riwayat Program Intervensi</h3>
        </div>
        <div class="box-body">
          <div class="table-responsive col-md-12">
            <vuetable v-ref:intervensi
                :api-url="url_program_intervensi"
                pagination-path=""
                :fields="fields_intervensi"
                table-class="table table-bordered table-striped table-hover"
                ascending-icon="glyphicon glyphicon-chevron-up"
                descending-icon="glyphicon glyphicon-chevron-down"
                pagination-class=""
                pagination-info-class=""
                pagination-component-class=""
                :pagination-component="paginationComponent_3"
                :item-actions="itemActions"
                :per-page="per_page"
                :append-params="intervensiParams"
                wrapper-class="vuetable-wrapper "
                table-wrapper=".vuetable-wrapper"
                loading-class="loading"
                detail-row-component="intervensi-detail-row"
                detail-row-id="id"
                detail-row-transition="expand"
                row-class-callback="rowClassCB"
            ></vuetable>         
        </div>
        </div>
    </div>

       <a v-link="{ path: '/pengajuan/form_intervensi_kelompok/add/'+$route.params.id }" class="btn btn-primary"><i class="fa fa-random"></i> Proses Pemberian Intervensi</a>
  </div>

</template>

<script>
import mixin from '../mixins/refdata.js'
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default {
  data(){
    return{
          kecamatan:[],
          desa:[],
          kelompok:[],
          url_penerima: this.$root.$config.API + '/api/kelompok/penerima/index',
          fields_penerima: [
            { name: '__sequence', title:'No.' },
            { name:'id', sortField: 'id', visible: false },
            { name:'nkk', sortField: 'nkk', title:'NKK' },
            { name:'nama', sortField: 'nama' },
            { name:'alamat', sortField: 'alamat' },
            { name:'desa', sortField: 'desa', title: 'Kampung' },
            { name:'kriteria', sortField: 'kriteria' },
        ],
        paginationComponent_1: 'vuetable-pagination-pager',
        penerimaParams:[
            'kelompok_id='+this.$route.params.id
        ],
        per_page: 10,      
        fields_intervensi:[
            { name:'id', title:'', dataClass: 'text-center', callback: 'showDetailRow' },
            { name: '__sequence', title:'No.' },
            { name:'name', title:'Bentuk Intervensi', sortField: 'm_intervensi.name' },
            { name:'tahun', title: 'Tahun', sortField: 't_intervensi.tahun' },
            { name:'rujukan', title: 'Rujukan', sortField:'t_intervensi.rujukan' },
            { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
        ],
        url_program_intervensi: this.$root.$config.API + '/api/program_intervensi/detail_intervensi_keluarga',
        intervensiParams:[
            'penerima_id='+this.$route.params.id,
            'sasaran=3'
        ],
        itemActions: [
               { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
               { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
        ],
        paginationComponent_3:'vuetable-pagination'
    }
  },

  mixins:[mixin],

  computed:{

  },

  ready(){
    this.fetchData(this.$route.params.id)
  },

  components: { 
      'vuetable': Vuetable,
  },

  methods:{
    fetchData: function(id){
      this.$Progress.start()
        this.$http.get(this.$root.$config.API + '/api/kelompok/'+id+'/edit').then((response)=>{
          this.$set('kecamatan',response.data.kecamatan)
          this.$set('desa',response.data.desa)
          this.$set('kelompok',response.data.kelompok)
          this.$Progress.finish()
        },(error)=>{
          console.log(error)
          this.$Progress.fail()
        })
    },

    showDetailRow: function(value) {
          var icon = this.$refs.intervensi.isVisibleDetailRow(value) ? 'glyphicon glyphicon-minus-sign' : 'glyphicon glyphicon-plus-sign'
          return [
              '<a href="#" class="show-detail-row">',
                  '<i class="' + icon + '"></i>',
              '</a>'
          ].join('')
      },

      rowClassCB: function(data, index) {
          return (index % 2) === 0 ? 'positive' : ''
      },
  },

  events:{
      'vuetable:action': function(action, data) {
           if (action == 'edit-item') {
             this.$router.go({path:'/pengajuan/form_intervensi_kelompok/edit/'+data.id})
           } else if (action == 'delete-item') {
             this.$http.get(this.$root.$config.API + '/api/program_intervensi/'+data.id+'/delete_intervensi').then((response)=>{
               toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
               this.$broadcast('vuetable:refresh')
             },(error)=>{
               toastr.error('Gagal hapus data', 'Error', {timeOut: 3000})
               console.log(error)
             })
           }
       },

      'vuetable:cell-clicked': function(data, field, event) {
          event.preventDefault()
          if (field.name !== '__actions') {
              this.$broadcast('vuetable:toggle-detail', data.id)
          }
      },
  },
}
</script>