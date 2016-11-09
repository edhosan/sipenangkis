<template>
<div class="tab-pane active">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Form Proses Intervensi Individu</h3>
    </div>
    <form role="form" @submit.prevent="simpan">
      <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label for="frmNama">Nama Penerima</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nama Penerima" v-model="nama_penerima" disabled>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.program}">
            <label for="frmNama">Program</label>
            <multiselect
              :selected.sync="valueProgram"
              :options="program"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Program"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateProgram" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.program">Program harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.bentuk_intervensi}">
            <label for="frmNama">Bentuk Intervensi</label>
            <multiselect
              :selected.sync="valueBentukIntervensi"
              :options="bentuk_intervensi"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :loading="isLoading"
              :allow-empty="false"
              placeholder="Pilih Bentuk Intervensi"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateBentukIntervensi" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.bentuk_intervensi">Bentuk Intervensi harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.tahun}">
            <label for="frmNama">Tahun</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Tahun" v-model="t_intervensi.tahun" :disabled="isfreeze">
            <span class="help-block" v-if="!validation.tahun">Tahun harus berupa angka.</span>
          </div>
          <div class="form-group">
            <label for="frmNama">Rujukan</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Rujukan" v-model="t_intervensi.rujukan" :disabled="isfreeze">
          </div>
        </div>
      <!-- /.box-body -->
      </div>
      <div class="box-footer">
        <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Simpan</button>
        <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Ubah</button>
        <a v-link="{ path: '/pengajuan/individu' }" class="btn btn-warning">Batal</a>
      </div>
    </form>
  </div>
  <div class="box box-warning" v-if="isRincian == 'list'">
    <div class="box-header with-border">
      <h3 class="box-title">Rincian Intervensi</h3>
    </div>
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
    <div class="box-footer">
        <button v-if="isRincian == 'list'" class="btn btn-primary" @click="entryRincian()">Tambah Rincian</button>
    </div>
  </div>

  <div class="box box-info" v-if="isRincian == 'add' || isRincian == 'edit'">
    <div class="box-header with-border">
      <h3 class="box-title">Form Rincian Intervensi</h3>
    </div>
    <form role="form" @submit.prevent="simpanRincian">
    <div class="box-body">
      <div class="col-md-12">
        <div class="form-group" v-bind:class="{'has-error':!validationRincian.name}">
          <label for="frmNama">Nama Rincian</label>
          <input type="text" class="form-control" id="frmNama" placeholder="Nama Rincian" v-model="rincian.name">
          <span class="help-block" v-if="!validationRincian.name">Nama rincian harus diisi.</span>
        </div>
        <div class="form-group" v-bind:class="{'has-error':!validationRincian.volume}">
          <label for="frmNama">Volume</label>
          <input type="text" class="form-control" id="frmNama" placeholder="Volume" v-model="rincian.volume">
          <span class="help-block" v-if="!validationRincian.volume">Volume harus diisi.</span>
          <span class="help-block" v-if="!validationRincian.volumeNumber">Volume harus berupa angka.</span>
        </div>
        <div class="form-group" v-bind:class="{'has-error':!validationRincian.satuan}">
          <label for="frmNama">Satuan</label>
          <input type="text" class="form-control" id="frmNama" placeholder="Satuan" v-model="rincian.satuan">
          <span class="help-block" v-if="!validationRincian.satuan">Satuan harus diisi.</span>
        </div>
        <div class="form-group" v-bind:class="{'has-error':!validationRincian.nilai}">
          <label for="frmNama">Nilai</label>
          <input type="text" class="form-control" id="frmNama" placeholder="Nilai" v-model="rincian.nilai">
          <span class="help-block" v-if="!validationRincian.nilai">Nilai harus diisi.</span>
          <span class="help-block" v-if="!validationRincian.nilaiNumber">Nilai harus berupa angka.</span>
        </div>
        <div class="form-group">
          <label for="frmNama">Jumlah</label>
          <input type="text" class="form-control" id="frmNama" placeholder="Jumlah" value="{{ rincian.volume * rincian.nilai }}"  v-model="rincian.jumlah" disabled>
        </div>

      </div>
    </div>
    <div class="box-footer">
      <button v-if="isRincian == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Simpan</button>
      <button v-if="isRincian == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Ubah</button>
      <button class="btn btn-warning" @click="cancelRincian" >Batal</button>
    </div>
    </form>
  </div>
</div>
</template>

<script>
import { Multiselect } from 'vue-multiselect';
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default {
	data(){
		return{
			nama_penerima:'',
			isAction: this.$route.params.action,
			valueProgram: [],
		    program: [],
		    valueBentukIntervensi:[],
		    bentuk_intervensi:[],
		    t_intervensi:{id:null,m_intervensi_id:null,tahun:0,penerima_id:null,rujukan:'',userid:localStorage.userid},
		    isLoading: false,
		    url: this.$root.$config.API + '/api/program_intervensi/rincian',
		    isRincian: 'list',
		    fields:[
		        { name: '__sequence', title:'No.' },
		        { name:'id', sortField: 'id', visible: false },
		        { name:'name', sortField: 'name', title:'Nama' },
		        { name:'volume', sortField: 'volume' },
		        { name:'satuan', sortField: 'satuan' },
		        { name:'nilai', sortField: 'nilai' },
		        { name:'jumlah', sortField: 'jumlah'},
		        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
		    ],
		    sortOrder: [
		        { field: 'id', direction: 'asc' }
		    ],
		    paginationComponent: 'vuetable-pagination',
		    itemActions: [
		           { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'},
		           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
		    ],
		    moreParams: [],
		    rincian:{ id:null,t_intervensi_id:null,name:'',volume:0,satuan:'',nilai:0,jumlah:0 }

		}
	},

	computed: {
	    validation: function(){
	      return{
	        program:!!this.valueProgram.value,
	        bentuk_intervensi:!!this.valueBentukIntervensi.value,
	        tahun:!!/^[-+]?[0-9]+$/.test(this.t_intervensi.tahun),
	      }
	    },

	    validationRincian: function(){
	      return{
	        name:!!this.rincian.name,
	        volume:!!this.rincian.volume,
	        satuan:!!this.rincian.satuan,
	        nilai:!!this.rincian.satuan,
	        volumeNumber:!!/^[-+]?[0-9]+$/.test(this.rincian.volume),
	        nilaiNumber:!!/^[-+]?[0-9]+$/.test(this.rincian.nilai),
	      }
	    },

	    isValid: function(){
	      var validation = this.validation
	      return Object.keys(validation).every(function(key){
	        return validation[key]
	      })
	    },

	},

	ready(){
		this.fetchRef()
		if(this.isAction == 'add'){	     
	      this.fetchIndividu(this.$route.params.id)
	    }else{
	      this.fetchData(this.$route.params.id)
	    }
	},

	methods:{
 		fetchRef: function(){
	      this.$Progress.start()
	      this.$http.get(this.$root.$config.API + '/api/program_intervensi/'+localStorage.userid+'/ref_data').then((response)=>{
	        this.$set('program',response.data.list_program)
	        this.$Progress.finish()
	      },(error)=>{
	        console.log(error)
	        this.$Progress.fail()
	      })
	    },

	    fetchIndividu: function(penerima_id){
	      this.$Progress.start()
	      this.$http.get(this.$root.$config.API + '/api/keluarga/'+penerima_id+'/detail_keluarga').then((response)=>{
	        this.$set('nama_penerima',response.data.keluarga.nama)
	        this.$Progress.finish()
	      },(error)=>{
	        console.log(error)
	        this.$Progress.fail()
	      })
	    },

	    fetchIntervensi: function(program_id){
	      this.$Progress.start()
	      this.$http.get(this.$root.$config.API + '/api/intervensi/'+program_id+'/5/intervensi_program').then((response)=>{
	        this.$set('bentuk_intervensi',response.data)
	        this.isLoading = false
	        this.$Progress.finish()
	      },(error)=>{
	        console.log(error)
	        this.$Progress.fail()
	      })
	    },

	    updateProgram: function(value){
	      this.valueProgram = value
	      this.isLoading = true
	      this.fetchIntervensi(value.value)
	    },

	    updateBentukIntervensi: function(value){
	      this.valueBentukIntervensi = value
	      this.t_intervensi.m_intervensi_id = value.value
	    },

	    simpan: function(){
	      this.$Progress.start()
	      event.preventDefault()
	      var self = this

	      var url = this.$root.$config.API

	      if(this.isAction=='add'){
	          this.t_intervensi.penerima_id = this.$route.params.id
	          url = url + '/api/program_intervensi/'+this.$route.params.id+'/store_individu'
	      }else{
	          url = url + '/api/program_intervensi/update_intervensi_individu'
	      }

	      var data = this.t_intervensi

	      this.$http.post(url,data).then((response)=>{
	        if(response.data.result!=null){
	          toastr.error('Penerima manfaat sudah menerima bentuk intervensi pada tahun yang sama', 'Error', {timeOut: 3000})
	        }else{
	          toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
	          this.isAction = 'edit'
	          this.$set('t_intervensi',response.data)
	          this.$broadcast('vuetable:refresh')
	        }
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

	    entryRincian: function(){
	      event.preventDefault()
	      if(this.t_intervensi.id == null){
	        toastr.error('Simpan proses intervensi terlebih dahulu', 'Error', {timeOut: 3000})
	      }else{
	        this.rincian = { id:null,t_intervensi_id:null,name:'',volume:0,satuan:'',nilai:0,jumlah:0 }
	        this.isRincian = 'add'
	      }
	    },

	    simpanRincian: function(){
	      this.$Progress.start()
	      event.preventDefault()
	      var self = this

	      var data = this.rincian;
	      var url = this.$root.$config.API

	      if(this.isRincian=='add'){
	          url = url + '/api/program_intervensi/'+this.t_intervensi.id+'/store_rincian'
	      }else{
	          url = url + '/api/program_intervensi/'+this.rincian.id+'/update_rincian'
	      }

	      this.$http.post(url,data).then((response)=>{
	        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
	        this.isRincian = 'list'
	        this.$Progress.finish()
	        this.setFilter(response.data.t_intervensi_id)
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

	    cancelRincian: function(){
	      event.preventDefault()
	      this.isRincian = 'list'
	    },

	    fetchData: function(id){
	      this.$Progress.start()
	      this.$http.get(this.$root.$config.API + '/api/program_intervensi/'+id+'/edit_individu').then((response)=>{
	        this.$set('nama_penerima',response.data.keluarga.nama)
	        this.updateProgram({value:response.data.program.id, label: response.data.program.name})
	        this.updateBentukIntervensi({value: response.data.intervensi.id, label: response.data.intervensi.name})
	        this.$set('t_intervensi', response.data.t_intervensi)
	        this.setFilter(response.data.t_intervensi.id)
	        this.$Progress.finish()
	      },(error)=>{
	        console.log(error)
	        this.$Progress.fail()
	      })
	    },

	    setFilter: function(intervensi_id) {
	      this.moreParams = [
	          't_intervensi_id=' + intervensi_id
	      ]     
	      this.$nextTick(function() {
	          this.$broadcast('vuetable:refresh')
	      })
	    },


	},

	components: {
   		Multiselect,
    	'vuetable': Vuetable,
  	},

  	events:{
    'vuetable:action': function(action, data) {
         if (action == 'edit-item') {
           this.isRincian = 'edit'
           this.$set('rincian',data)
         } else if (action == 'delete-item') {
           this.$Progress.start()
           this.$http.get(this.$root.$config.API + '/api/program_intervensi/'+data.id+'/delete_rincian').then((response)=>{
             toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
             this.$broadcast('vuetable:refresh')
             this.$Progress.finish()
           },(error)=>{
             toastr.error('Gagal hapus data', 'Error', {timeOut: 3000})
             console.log(error)
             this.$Progress.fail()
           })
         }
    },
  }
}
</script>