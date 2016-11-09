<template lang="html">
<div class="row">
  <div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Tempat Tinggal Keluarga</a></li>
        <li><a href="#tab_2" data-toggle="tab" v-on:click="tabClick('2')">Anggota Keluarga</a></li>
        <li><a href="#tab_3" data-toggle="tab" v-on:click="tabClick('3')">Indikator</a></li>
        <li class="pull-right"><a href="#" v-on:click="tabClick('4')" class="text"><i class="fa fa-file"></i>&nbsp;&nbsp;Entry Data Baru</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <tmpt v-ref:tempat :keluarga="keluarga" :isfreeze="isFreeze"></tmpt>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
          <anggota v-ref:foo :penerima_manfaat_id="penerima_manfaat_id"></anggota>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_3">
          <indikator v-ref:indikator :penerima_manfaat_id="penerima_manfaat_id" :penilaian_id="penilaian_id"></indikator>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
</template>

<script>
var tmpt = require('./tempat_tinggal.vue')
var anggota = require('./anggota_keluarga.vue')
var indikator = require('./rincian_indikator.vue')

export default {
  data () {
    return {
      anggota_keluarga:{id:null, m_penerima_manfaat_id:null, kepala:'', nik: '', nama: '', sex:'',tgl_lhr:null,tempat_lhr:'',agama:'',status:'',hubungan:'',hubungan_ket:'',akta_nikah:'',kartu_identitas:'',disabilitas_jenis:'',disabilitas_kategori:'',penyakit_kronis:'',pekerjaan:'',pendidikan_jenjang:'',nama_sekolah:''},
      keluarga:{id:null, m_desa_id:null, rt:'', alamat:'',no_rumah:'',domisili:0,nkk:'',userid:localStorage.userid,rw:'',nama:'',anggota_keluarga:this.anggota_keluarga},
      isFreeze: false,
      penerima_manfaat_id:null,
      penilaian_id: null,
      isActiveTab: false
    }
  },
  computed: {

  },
  ready () {

  },
  attached () {},
  methods: {
    tabClick:function(tab){
      switch (tab) {
        case '2':
          this.$refs.foo.loadAnggota()
          break;
        case '3':
          this.$refs.indikator.loadIndikator()
          this.$refs.indikator.loadData()
          break;
        case '4':
          event.preventDefault()
          this.$router.go({path: '/rtm/add_rtm/0'})
          this.refresh()
          break;
        default:
      }

    },

    fetchKeluarga: function(id){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/penerima_manfaat/'+id+'/index').then((response)=>{
        this.$set('keluarga', response.data.penerima_manfaat)
        this.$refs.tempat.valueKecamatan = { value: response.data.penerima_manfaat.desa.kecamatan.id, label: response.data.penerima_manfaat.desa.kecamatan.name}
        this.$refs.tempat.valueDesa = { value: response.data.penerima_manfaat.desa.id, label: response.data.penerima_manfaat.desa.name}
        this.$refs.tempat.isAction = 'edit'
        this.penerima_manfaat_id = this.keluarga.id
        this.penilaian_id = response.data.hasil_indikator.id
        this.$Progress.finish()
      },(error)=>{
        this.$Progress.fail()
        console.log(error)
      })
    },

    refresh:function(){
      this.keluarga = {id:null, m_desa_id:null, rt:'', alamat:'',no_rumah:'',domisili:0,nkk:'',userid:localStorage.userid,rw:'',nama:''}
      this.isFreeze = false

      this.$refs.tempat.isAction = 'add'
      this.$refs.indikator.isAction = 'add'

      this.penerima_manfaat_id = null
      this.penilaian_id = null

      this.$refs.tempat.valueKecamatan = { value: '', label: ''}
      this.$refs.tempat.valueDesa = { value: '', label: ''}

      this.$refs.foo.anggota_list = []
      this.$refs.indikator.indikator = []
    }
  },
  components: {
    tmpt, anggota, indikator
  },
  route: {
      activate: function(t) {
          if(t.to.params.action == 'edit_rtm'){
            this.fetchKeluarga(t.to.params.id)
            this.$refs.indikator.isAction = 'list'
          }else{
            this.refresh()
          }

          this.$parent.$parent.$data.title = 'Rumah Tangga Penerima Manfaat';
          t.next();
      }
  },
 /* watch:{
    '$route'(to, from){
      if(to.params.action == 'add_rtm'){
        this.refresh()
      }
    }
  }*/
}
</script>

<style lang="css">
</style>
