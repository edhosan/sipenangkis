<template>
		<div class="box box-primary">
			<div class="box-header with-border">
		      <h3 class="box-title">Form Kelompok Penerima</h3>
    		</div>
			<form role="form" @submit.prevent="simpan">
    		<div class="box-body">
    			<div class="form-group" v-bind:class="{'has-error':!validation.kecamatan}">
		            <label for="frmNama">Kecamatan</label>
		            <multiselect
		              :selected.sync="valueKecamatan"
		              :options="kecamatan"
		              :multiple="false"
		              :searchable="true"
		              :close-on-select="true"
		              :allow-empty="false"
		              placeholder="Pilih Kecamatan"
		              deselect-label="Can't remove this value"
		              label="label"
		              key="value"
		              @update="updateKecamatan" :disabled="isfreeze">
		            </multiselect>
                    <span class="help-block" v-if="!validation.kecamatan">Kecamatan harus diisi.</span>
		        </div>

		        <div class="form-group" v-bind:class="{'has-error':!validation.desa}">
		            <label for="frmNama">Kelurahan/Desa</label>
		            <multiselect
		              :selected.sync="valueDesa"
		              :options="desa"
		              :multiple="false"
		              :searchable="true"
		              :close-on-select="true"
		              :allow-empty="false"
		              :loading="isLoading"
		              placeholder="Pilih Desa"
		              deselect-label="Can't remove this value"
		              label="label"
		              key="value"
		              @update="updateDesa" :disabled="isfreeze">
		            </multiselect>
	                <span class="help-block" v-if="!validation.desa">Kelurahan/Desa harus diisi.</span>
		        </div>	

		        <div class="form-group" v-bind:class="{'has-error':!validation.nama}">
		            <label for="frmNama">Nama Kelompok</label>
		            <input type="text" class="form-control" id="frmNama" placeholder="Nama Kelompok" v-model="kelompok.name" :disabled="isfreeze">
		            <span class="help-block" v-if="!validation.nama">Nama kelompok harus diisi.</span>
		        </div>

		        <div class="form-group">
		            <label for="frmNama">SK Pembentukan</label>
		            <input type="text" class="form-control" id="frmNama" placeholder="SK Pembentukkan" v-model="kelompok.sk" :disabled="isfreeze">
		        </div>	      	         		       
    
    		</div>

    		<div class="box-footer">
    			<button v-if="action == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Simpan</button>
      			<button v-if="action == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Ubah</button>
      			<button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
    		</div>
    		</form>
		</div>

		<table-keluarga :kelompok_id="kelompok.id"></table-keluarga>
	
</template>

<script>
	import { Multiselect } from 'vue-multiselect';
	var rincianKelompok = require('./rincian_kelompok_penerima.vue')

	export default{
		data(){
			return{
				kecamatan:[],
				valueKecamatan:[],
				desa:[],
				valueDesa:[],
				isLoading: false,
				kelompok: { id:null, m_desa_id:null, name:'',sk:''}

			}
		},

		props:{
			action: String,
			id: Number
		},

		computed:{
			isValid: function(){
		      var validation = this.validation
		      return Object.keys(validation).every(function(key){
		        return validation[key]
		      })
		    },

		    validation: function(){
		      return{
		        nama:!!this.kelompok.name,		        
		        kecamatan:!!this.valueKecamatan.value,
		        desa:!!this.valueDesa.value
		      }
		    },
		},

		ready(){
			this.fetchKecamatan()

			if(this.action == 'edit'){
				this.fetchData(this.id)				
			}
		},

		methods:{
			fetchKecamatan: function(){
		      this.$Progress.start()
		      this.$http.get(this.$root.$config.API + '/api/kecamatan/ref_kecamatan').then((response)=>{
		        this.$set('kecamatan',response.data)
		        this.$Progress.finish()
		      },(error)=>{
		        console.log(error)
		        this.$Progress.fail()
		      })
		    },

		    updateKecamatan: function(value){
				this.valueKecamatan = value
				this.isLoading = true
				this.fetchDesa(value.value)			
			},

			fetchDesa: function(kecamatan_id){
		      this.$Progress.start()
		      this.isLoading = true
		      var url = this.$root.$config.API
		      if(kecamatan_id!=null){
		        url = url +'/api/desa/'+kecamatan_id+'/ref_desa_by_kec'
		      }else{
		        url = url + '/api/desa/ref_desa'
		      }

		      this.$http.get(url).then((response)=>{
		        this.$set('desa',response.data)
		        this.isLoading = false
		        this.$Progress.finish()
		      },(error)=>{
		        this.$Progress.fail()
		        console.log(error)
		      })
		    },

		    updateDesa: function(value){
				this.valueDesa = value
				this.kelompok.m_desa_id = value.value
				this.$nextTick(function(){
					this.$broadcast('table-keluarga:filter', value.value)
				})
	
			},

			fetchData: function(id){
			  this.$Progress.start()
		      this.$http.get(this.$root.$config.API + '/api/kelompok/'+id+'/edit').then((response)=>{
		      	this.$set('kelompok', response.data.kelompok)
		      	this.updateKecamatan({ value: response.data.kecamatan.id, label: response.data.kecamatan.name })
		      	this.valueDesa = { value: response.data.desa.id, label: response.data.desa.name }
		        this.$Progress.finish()

		        this.$nextTick(function(){
					this.$broadcast('table-keluarga:filter', response.data.desa.id)
				})
		      },(error)=>{
		        console.log(error)
		        this.$Progress.fail()
		      })
			},

			cancel: function(){
				this.$dispatch('cancel')
			},

			simpan: function(){
		      this.$Progress.start()
		      event.preventDefault()
		      var self = this

		      var url = this.$root.$config.API

		      if(this.action == 'add'){
		          url = url + '/api/kelompok/store'
		      }else{
		          url = url + '/api/kelompok/'+this.id+'/update'
		      }

		      var data = this.kelompok

		      this.$http.post(url,data).then((response)=>{		      	
		      	toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
		        this.$Progress.finish()
		        this.$set('kelompok', response.data)
		        this.action = 'edit'
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
		},

		components: { 
			Multiselect,
			'table-keluarga': rincianKelompok 
		},		
	}
</script>