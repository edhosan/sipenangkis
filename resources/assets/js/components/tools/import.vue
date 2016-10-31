<template>
	<div class="row">
		<div class="box box-primary">
			<div class="box-header with-border">
		      <h3 class="box-title">Import Database From TKPK</h3>
    		</div>

    		<form role="form" @submit.prevent="simpan">
		      <div class="box-body">
		        <div class="col-md-10">
		         <div class="form-group col-md-5" v-bind:class="{'has-error':!validation.kecamatan}">
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
		          <div class="form-group col-md-5" v-bind:class="{'has-error':!validation.desa}">
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
		        </div>

		      	<div class="form-group col-md-5" v-bind:class="{'has-error':!validation.row}">
		      	  	<div class="table-responsive ">
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
				            :selected-to="selectedRow"
				        ></vuetable>
			        
			        </div>
		      		<span class="help-block" v-if="!validation.row">Checklist baris yang akan diexport</span>
		      	</div>

		        <div class="col-md-1">
		        	<button type="submit" class="btn btn-primary" :disabled="!isValid">Export</button>		      	
		      	</div>


		      	<div class="table-responsive col-md-6">
		      		 <vuetable v-ref:vuetable
			            :api-url="url2"
			            pagination-path=""
			            :fields="fields2"
			            :sort-order="sortOrder"
			            table-class="table table-bordered table-striped table-hover"
			            ascending-icon="glyphicon glyphicon-chevron-up"
			            descending-icon="glyphicon glyphicon-chevron-down"
			            pagination-class=""
			            pagination-info-class=""
			            pagination-component-class=""
			            :pagination-component="paginationComponent"			    
			            :per-page="per_page"
			            :append-params="moreParams2"
			            wrapper-class="vuetable-wrapper "
			            table-wrapper=".vuetable-wrapper"
			            loading-class="loading"			        
			        ></vuetable>
		      	</div>
		      

		      <!-- /.box-body -->
		      </div>

		    </form>
		</div>
	</div>
</template>

<script>
import { Multiselect } from 'vue-multiselect';
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default{
	data(){
		return{
			valueDesa:[],
			desa:[],
			valueKecamatan:[],
			kecamatan:[],
			selectedRow:[],
			isLoading: false,
			per_page: 100,
		  	fields:[
	     	  	{ name: '__checkbox:id'},
		        { name: '__sequence', title:'No.' },
		        { name:'id', sortField: 'id' },
		        { name:'no_kk', sortField: 'no_kk', title:'NKK' },
		        { name:'nama', sortField: 'nama' },
  		        { name:'nm_kel', sortField: 'nm_kel', title:'Kampung/Kelurahan' }
		       
	      	],
	      	sortOrder: [
		        { field: 'id', direction: 'asc' }
		    ],
		    paginationComponent: 'vuetable-pagination-pager',
			moreParams: [],
			url2: this.$root.$config.API + '/api/pembaharuan/index',
			fields2:[	     	  
		        { name: '__sequence', title:'No.' },		     
		        { name:'nkk', sortField: 'nkk', title:'NKK' },
		        { name:'nama', sortField: 'nama' },
		        { name:'alamat', sortField: 'alamat' },
		        { name:'desa', sortField: 'desa', title:'Kelurahan/Desa' },
		        { name:'kecamatan', sortField: 'kecamatan', title:'Kecamatan' },
		        { name:'kriteria', sortField: 'kriteria'},		       
	      	],
	      	moreParams2: [],
		}
	},

	computed: {
	    url: function(){
	    	return this.$root.$config.API + '/api/tools/export/index'
	    },

	    isValid: function(){
	      var validation = this.validation
	      return Object.keys(validation).every(function(key){
	        return validation[key]
	      })
	    },

	    validation: function(){
	      return{
	        row:!!this.selectedRow.length > 0,
	        kecamatan:!!this.valueKecamatan.value,
	        desa:!!this.valueDesa.value
	      }
	    },
	},

	ready(){
		this.fetchKecamatan()
	},

	methods:{		

		updateDesa: function(value){
			this.valueDesa = value
			this.setFilter(value.label)
			this.setFilter2(value.value)			
		},

		updateKecamatan: function(value){
			this.valueKecamatan = value
			this.fetchDesa(value.value)			
		},

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

	    setFilter: function(value) {
	        if(value != null){
	          this.moreParams = [
	              'filter='+ value,
	              'key=nm_kel'
	          ]
	          this.$nextTick(function() {
	              this.$broadcast('vuetable:refresh')
	          })
	        }
	    },

	    setFilter2: function(value) {
	        if(value != null){
	          this.moreParams2 = [
	              'filter='+ value,
	              'key=m_desa.id'
	          ]
	          this.$nextTick(function() {
	              this.$broadcast('vuetable:refresh')
	          })
	        }
	    },

	    simpan: function(){	     
	      this.$Progress.start()
	      event.preventDefault()
	      var self = this

	      var data = { data: this.selectedRow, desa_id: this.valueDesa.value }
	      var url = this.$root.$config.API + '/api/tools/export/store'

	      this.$http.post(url,data).then((response)=>{
	        toastr.success('Export Data Berhasil', 'Export Data', {timeOut: 3000})
	        this.selectedRow = []
	        this.$broadcast('vuetable:refresh')
	        this.$Progress.finish()
	      },(error)=>{
	        if(error.data.error.code==23000){
	          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
	        }else{
	          toastr.error('Export Data Gagal', 'Error', {timeOut: 3000})
	        }
	        console.log(error)
	        this.$Progress.fail()
	      })
	    },
	},

	components: { 
		Multiselect, 
		'vuetable': Vuetable		
	},

	route: {
	  activate: function(t) {
	      this.$parent.$parent.$data.title = 'Import Export Database';
	      t.next();
	  }
  	},
}	
</script>

