<template lang="html">
  <div class="tab-pane active">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Tempat Tinggal Keluarga</h3>
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="frmNama">Nomor Kartu Keluarga</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nomor kartu keluarga" v-model="keluarga.nkk" disabled>
            </div>
            <div class="form-group">
              <label for="frmNama">Kecamatan</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Kecamatan" v-model="kecamatan" disabled>
            </div>
            <div class="form-group">
              <label for="frmNama">Kelurahan/Desa</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Kelurahan/Desa" v-model="desa" disabled>
            </div>
            <div class="form-group">
              <label for="frmKeterangan">Alamat</label>
              <textarea class="form-control" rows="3" placeholder="Alamat" v-model="keluarga.alamat" disabled></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="frmNama">RT</label>
              <input type="text" class="form-control" id="frmNama" placeholder="RT" v-model="keluarga.rt" disabled>
            </div>
            <div class="form-group">
              <label for="frmNama">RW</label>
              <input type="text" class="form-control" id="frmNama" placeholder="RW" v-model="keluarga.rw" disabled>
            </div>
            <div class="form-group">
              <label for="frmNama">Nomor Rumah</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nomor Rumah" v-model="keluarga.no_rumah" disabled>
            </div>
            <div class="form-group">
              <label for="frmNama">Lamanya berdomisili pada alamat diatas</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Lamanya berdomisili pada alamat diatas" v-model="keluarga.domisili" disabled>
            </div>
          </div>
        </div>
      </div>

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Anggota Keluarga</h3>
        </div>
        <div class="box-body">
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
              :per-page="per_page"
              :append-params="moreParams"
              wrapper-class="vuetable-wrapper "
              table-wrapper=".vuetable-wrapper"
              loading-class="loading"
          ></vuetable>
        </div>
      </div>

      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Riwayat Penilaian Indikator</h3>
        </div>
        <div class="box-body">
          <div class="table-responsive col-md-12">
            <vuetable v-ref:vuetable
                :api-url="url_riwayat_indikator"
                pagination-path=""
                :fields="fields_indikator"
                table-class="table table-bordered table-striped table-hover"
                ascending-icon="glyphicon glyphicon-chevron-up"
                descending-icon="glyphicon glyphicon-chevron-down"
                pagination-class=""
                pagination-info-class=""
                pagination-component-class=""
                :pagination-component="paginationComponent_2"
                :per-page="per_page"
                wrapper-class="vuetable-wrapper "
                table-wrapper=".vuetable-wrapper"
                loading-class="loading"
            ></vuetable>
        </div>
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
      <a v-link="{ path: '/pengajuan/form_intervensi/add/'+$route.params.id }" class="btn btn-primary"><i class="fa fa-random"></i> Proses Pemberian Intervensi</a>     
  </div>

</template>

<script>
import mixin from '../mixins/refdata.js'
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default {
  data () {
    return {
      keluarga:[],
      kecamatan:'',
      desa:'',
      fields:[
        { name: '__sequence', title:'No.' },
        { name:'nik', title:'NIK', sortField: 'nik' },
        { name:'nama', title: 'Nama', sortField: 'nama' },
        { name:'sex', title: 'Jenis Kelamin', callback: 'gender' },
        { name:'tgl_lhr', title: 'Tanggal Lahir', callback: 'tgl_lhr' },
        { name:'hubungan', title: 'Hubungan Keluarga', callback: 'hubungan' }
      ],
      sortOrder: [
        { field: 'hubungan', direction: 'asc' }
      ],
      paginationComponent: 'vuetable-pagination',
      per_page: 10,     
      fields_indikator: [
        { name: '__sequence', title:'No.' },
        { name:'nilai' },
        { name:'kriteria' },
        { name:'created_at' },
        { name:'updated_at' }
      ],
      paginationComponent_2: 'vuetable-pagination',
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
        'sasaran=4'
      ],
      itemActions: [
           { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
      ],
      paginationComponent_3:'vuetable-pagination'

    }

  },

  computed: {
    url: function(){
      return this.$root.$config.API + '/api/keluarga/'+this.$route.params.id+'/index'
    },

    url_riwayat_indikator: function(){
      return this.$root.$config.API + '/api/penerima_indikator/'+this.$route.params.id+'/index'
    }

  },
  ready () {
    this.fetchData(this.$route.params.id)
  },
  mixins:[mixin],
  attached () {},
  methods: {
    fetchData:function(id){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/program_intervensi/'+id+'/detail_keluarga').then((response)=>{
        this.$set('keluarga',response.data)
        if(response.data!=null && response.data.desa!=null && response.data.desa.kecamatan!=null){
          this.kecamatan = response.data.desa.kecamatan.name
          this.desa = response.data.desa.name
        }
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    gender: function(value){
      return value == 'L' ? 'Laki-laki' : 'Perempuan'
    },

    tgl_lhr: function(value){
      if(value == null) return ''
      return this.$moment(value, 'YYYY-MM-DD').format('D MMM YYYY')
    },

    hubungan: function(value){
      return this.hubLabel(value)
    },

    preg_quote: function( str ) {
         return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
     },
    highlight: function(needle, haystack) {
         return haystack.replace(
             new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
             '<span class="highlight">$1</span>'
         )
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
  components: { 
    'vuetable': Vuetable,
  },

  events:{
    'vuetable:action': function(action, data) {
         if (action == 'edit-item') {
           this.$router.go({path:'/pengajuan/form_intervensi/edit/'+data.id})
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

<style lang="css">
</style>
