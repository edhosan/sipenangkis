<template lang="html">
  <div class="box box-warning" v-if="isAction == 'list'">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Anggota Keluarga</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
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
    <!-- /.box-body -->
    <div class="box-footer clearfix">
     <button class="btn btn-primary" @click.prevent="entryItem()" :disabled="isValid">Tambah Data</button>
    </div>
  </div>

  <form-anggota :action="isAction" :id="anggota_id" v-if="isAction == 'add' || isAction == 'edit'"></form-anggota>

</template>

<script>
import mixin from '../mixins/refdata.js'
var Vuetable = require('vuetable/src/components/Vuetable.vue')
var form_anggota = require('./form_keluarga.vue')
export default {
  data () {
    return {
      isAction:'list',
      isValid: true,
      per_page: 10,
      url: this.$root.$config.API + '/api/keluarga/index',
      fields:[
        { name: '__sequence', title:'No.' },
        { name:'id', sortField: 'id', visible: false },
        { name:'nik', title:'NIK', sortField: 'nik' },
        { name:'nama', title: 'Nama', sortField: 'nama' },
        { name:'sex', title: 'Jenis Kelamin', callback: 'gender' },
        { name:'tgl_lhr', title: 'Tanggal Lahir', callback: 'tgl_lhr' },
        { name:'hubungan', title: 'Hubungan Keluarga', callback: 'hubungan' },
        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
      ],
      sortOrder: [
        { field: 'hubungan', direction: 'asc' }
      ],
      itemActions: [
           { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
      ],
      paginationComponent: 'vuetable-pagination',
      moreParams: [
        'filter='+ this.$route.params.id
      ],
      isValid: false,
      id:null,
      anggota:{id:null, m_penerima_manfaat_id:null, kepala:'0', nik: '', nama: '',
               sex:'',tgl_lhr:'',tempat_lhr:'',agama:'',status:'',hubungan:'',hubungan_ket:'',akta_nikah:'',kartu_identitas:'',
               disabilitas_jenis:'',disabilitas_kategori:'',penyakit_kronis:'',m_pekerjaan_id:'',m_pendidikan_id:0,nama_sekolah:''},
      anggota_id:0

    }
  },
  mixins:[mixin], 
  computed: {
  },
  ready () {
    if(this.$route.params.id==0){
       this.isValid = false
       toastr.warning('Silahkan isi Tempat Tinggal Keluarga terlebih dahulu', 'Info', {timeOut: 3000})
    }
  },
  attached () {},
  methods: {
    gender: function(value){
      if(value == null) return ''
      return value == 'L' ? 'Laki-laki' : 'Perempuan'
    },

    tgl_lhr: function(value){
      if(value == null) return ''
      return this.$moment(value, 'YYYY-MM-DD').format('D MMM YYYY')
    },

    hubungan: function(value){
      if(value == null) return ''
      return this.hubLabel(value)
    },

    entryItem: function(){     
      this.isAction = 'add'
    },

  },
  components: { 
    'vuetable': Vuetable,
    'form-anggota': form_anggota
  },
  events:{
    'vuetable:action': function(action, data) {
         if (action == 'edit-item') {
           this.isAction = 'edit'
           this.anggota_id = data.id
         } else if (action == 'delete-item') {          
           this.$http.get(this.$root.$config.API + '/api/keluarga/'+data.id+'/delete').then((response)=>{
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
  }
}
</script>

<style lang="css">
</style>
