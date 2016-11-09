<template>
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

    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Detail Penerima Manfaat</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->	    
    <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label for="frmNama">NIK</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nomor induk keluarga" v-model="anggota.nik" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Nama Keluarga</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nama keluarga" v-model="anggota.nama" disabled>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin :</label>
            <div class="radio">
              <input type="radio" name="sex" id="sex" value="L" checked v-model="anggota.sex" disabled>
              Laki - Laki
            </div>
            <div class="radio">
              <input type="radio" name="sex" id="optionsRadios1" value="P" v-model="anggota.sex" disabled>
              Perempuan
            </div>
          </div>
          <div class="form-group">
            <label for="frmNama">Tanggal lahir</label>
            <div class="input-group date">
	              <input type="text" class="form-control" id="frmNama"  v-model="anggota.tgl_lhr" disabled>
            </div>
          </div>
          <div class="form-group" >
            <label for="frmNama">Tempat Lahir</label>
            <input type="text" class="form-control" id="frmNama"  v-model="anggota.tempat_lhr" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Agama</label>
            <input type="text" class="form-control" id="frmNama" value="{{ agamaLabel(anggota.agama) }}" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Status Perkawinan</label>
            <input type="text" class="form-control" id="frmNama"  value="{{ statusLabel(anggota.status) }}" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Status hubungan dalam keluarga</label>
            <input type="text" class="form-control" id="frmNama" value="{{ hubLabel(anggota.hubungan) }}" disabled>
            <input type="text" v-if="input_hub_lain" class="form-control" id="frmNama" placeholder="Keterangan hubungan lainnya" v-model="anggota.hubungan_ket" disabled>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Kepemilikan Akta Nikah :</label>
            <div class="radio">
              <input type="radio" name="akta" id="optionsRadios1" value="1" checked v-model="anggota.akta_nikah" disabled>
              Ada
            </div>
            <div class="radio">
              <input type="radio" name="akta" id="optionsRadios1" value="2" v-model="anggota.akta_nikah" disabled>
              Tidak ada
            </div>
          </div>
          <div class="form-group">
            <label for="frmNama">Kepemilikan Kartu Identitas</label>
            <input type="text" class="form-control" id="frmNama" value="{{ kartuLabel(anggota.kartu_identitas) }}" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Disabilitas</label>
            <input type="text" class="form-control" id="frmNama" value="{{ disabilitasLabel(anggota.disabilitas_jenis) }}" disabled>
            <label>Kategori Disabilitas :</label>
            <div class="radio">
              <input type="radio" name="disabilitas_kategori" id="optionsRadios1" value="1" checked v-model="anggota.disabilitas_kategori" disabled>
              Ringan
            </div>
            <div class="radio">
              <input type="radio" name="disabilitas_kategori" id="optionsRadios1" value="2" v-model="anggota.disabilitas_kategori" disabled>
              Sedang
            </div>
            <div class="radio">
              <input type="radio" name="disabilitas_kategori" id="optionsRadios1" value="3" v-model="anggota.disabilitas_kategori" disabled>
              Berat
            </div>
          </div>
          <div class="form-group">
            <label for="frmNama">Penyakit Kronis</label>
            <input type="text" class="form-control" id="frmNama" v-model="anggota.penyakit_kronis" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Pekerjaan</label>
            <input type="text" class="form-control" id="frmNama" v-model="pekerjaan.pekerjaan" disabled>	           
          </div>
          <div class="form-group">
            <label for="frmNama">Jenjang Pendidikan</label>
            <input type="text" class="form-control" id="frmNama" v-model="pendidikan.name" disabled>
          </div>
          <div class="form-group">
            <label for="frmNama">Nama Sekolah</label>
            <input type="text" class="form-control" id="frmNama" v-model="anggota.nama_sekolah" disabled>
          </div>
        </div>
      <!-- /.box-body -->
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

       <a v-link="{ path: '/pengajuan/form_intervensi_individu/add/'+$route.params.id }" class="btn btn-primary"><i class="fa fa-random"></i> Proses Pemberian Intervensi</a>
  </div>

</template>

<script>
import mixin from '../mixins/refdata.js'
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default {
	data(){
		return{
			keluarga: [],
			kecamatan:'',
	        desa:'',
	        anggota:[],
	        url_riwayat_indikator: this.$root.$config.API + '/api/keluarga/'+this.$route.params.id+'/indikator_individu',
	        fields_indikator: [
		        { name: '__sequence', title:'No.' },
		        { name:'nilai' },
		        { name:'kriteria' },
		        { name:'created_at' },
		        { name:'updated_at' }
		    ],
		    paginationComponent_2: 'vuetable-pagination',
		    per_page: 10,
		    pekerjaan:[],
		    pendidikan:[],
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
		        'sasaran=5'
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
	      this.$http.get(this.$root.$config.API + '/api/keluarga/'+id+'/detail_keluarga').then((response)=>{
	        this.$set('keluarga',response.data.tempat)
	        if(response.data!=null && response.data.desa!=null && response.data.kecamatan!=null){
	          this.kecamatan = response.data.kecamatan.name
	          this.desa = response.data.desa.name
	        }
	        this.$set('anggota', response.data.keluarga)
	        this.$set('pekerjaan', response.data.pekerjaan)
   	        this.$set('pendidikan', response.data.pendidikan)
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
	           this.$router.go({path:'/pengajuan/form_intervensi_individu/edit/'+data.id})
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