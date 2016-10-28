<template lang="html">
  <formkeluarga :isfreeze="freeze" :anggota="anggota" v-ref:form></formkeluarga>

  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Anggota Keluarga</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">Id</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Jenis Kelamin</th>
          <th>Hubungan Keluarga</th>
          <th style="width: 200px">Action</th>
        </tr>
        <tr v-for="item in anggota_list">
          <td>{{ item.id }}</td>
          <td>{{ item.nik }}</td>
          <td>{{ item.nama }}</td>
          <td>{{ sexLabel(item.sex) }}</td>
          <td>{{ hubLabel(item.hubungan) }}</td>
          <td>
            <button class="btn btn-primary" @click.prevent="editItem(item)">Ubah</button>
            <button class="btn btn-danger" @click.prevent="deleteItem(item)">Hapus</button>
          </td>
        </tr>
      </table>
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
        <button class="btn btn-primary" @click.prevent="entryItem()" :disabled="!isValid">Tambah Data</button>
      </div>
    </div>
  </div>

</template>

<script>
var formkeluarga = require('./form_keluarga.vue')
import mixin from '../mixins/refdata.js'

export default {
  data () {
    return {
      isAction:'list',
      anggota_list:[],
      offset: 4,
      per_page: 10,
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
      isValid: false,
      freeze:true,
      anggota:{id:null, m_penerima_manfaat_id:null, kepala:'0', nik: '', nama: '',
               sex:'',tgl_lhr:'',tempat_lhr:'',agama:'',status:'',hubungan:'',hubungan_ket:'',akta_nikah:'',kartu_identitas:'',
               disabilitas_jenis:'',disabilitas_kategori:'',penyakit_kronis:'',m_pekerjaan_id:'',m_pendidikan_id:0,nama_sekolah:''}

    }
  },
  mixins:[mixin],
  props:{
    penerima_manfaat_id: Number
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
  },
  ready () {
  },
  attached () {},
  methods: {
    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    loadAnggota: function(){
      if(this.penerima_manfaat_id == null){
        this.isValid = false
        toastr.warning('Silahkan isi Tempat Tinggal Keluarga terlebih dahulu', 'Info', {timeOut: 3000})
      }else{
        this.fetchData(this.pagination.current_page)
        this.isValid = true
      }
    },

    entryItem: function(){
      this.freeze = false
      this.$refs.form.isAction = 'add'
    },

    isFreeze: function(isfreez){
      this.freeze = isfreez
    },

    fetchData: function(page) {
      this.$Progress.start()
      var url = this.$root.$config.API + '/api/keluarga/'+this.penerima_manfaat_id+'/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('anggota_list', response.data.data)
        this.$set('pagination', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    editItem: function(item){
      this.$set('anggota', item)
      this.isFreeze(false)
      this.$refs.form.valueAgama = {value:item.agama,label:this.agamaLabel(item.agama)}
      this.$refs.form.valueStatus = {value:item.status,label:this.statusLabel(item.status)}
      this.$refs.form.valueHubungan = {value:item.hubungan,label:this.hubLabel(item.hubungan)}
      this.$refs.form.valueKartu = {value:item.kartu_identitas,label:this.kartuLabel(item.kartu_identitas)}
      this.$refs.form.valueDisabilitas = {value:item.disabilitas_jenis,label:this.disabilitasLabel(item.disabilitas_jenis)}
      this.$refs.form.valuePekerjaan = {value:item.pekerjaan.id,label:item.pekerjaan.pekerjaan}
      this.$refs.form.valuePendidikan = {value:item.pendidikan.id,label:item.pendidikan.name}
      this.$refs.form.isAction = 'edit'
    },

    clearForm: function(){
      this.anggota = {id:null, m_penerima_manfaat_id:null, kepala:'0', nik: '', nama: '',
               sex:'L',tgl_lhr:'',tempat_lhr:'',agama:'',status:'',hubungan:'',hubungan_ket:'',akta_nikah:'2',kartu_identitas:'',
               disabilitas_jenis:'',disabilitas_kategori:'1',penyakit_kronis:'',m_pekerjaan_id:'',m_pendidikan_id:0,nama_sekolah:''}
      this.isFreeze(true)
      this.$refs.form.isAction = 'add'
    },

    deleteItem: function(item){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/keluarga/'+item.m_penerima_manfaat_id+'/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.$Progress.finish()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        this.$Progress.fail()
        console.log(error)
      })
    },


  },
  components: { formkeluarga },
  events:{
    'fetchDataKeluarga' : 'fetchData',
    'freezeForm': 'isFreeze',
    'clear': 'clearForm'
  }
}
</script>

<style lang="css">
</style>
