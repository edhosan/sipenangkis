<template>
	<div class="row">
		<div class="box box-primary">
			<div class="box-header with-border">
		      <h3 class="box-title">Import Database From TKPK</h3>
    		</div>

    		<form role="form" @submit.prevent="simpan">
		      <div class="box-body">
		        <div class="col-md-12">
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
		            <span class="help-block" v-if="!validation.desa">Desa harus diisi.</span>
		          </div>		         
		        </div>

		        <div class="table-responsive col-md-5">
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
			            wrapper-class="vuetable-wrapper "
			            table-wrapper=".vuetable-wrapper"
			            loading-class="loading"
			            :selected-to="selectedRow"
			        ></vuetable>
		        </div>

		        <div class="col-md-2">
		        	<button type="submit" class="btn btn-primary" :disabled="!isValid">Simpan</button>		      	
		      	</div>

		      	<div class="col-md-5">
		      		
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
		        { name:'id', sortField: 'id' },
		        { name:'no_kk', sortField: 'no_kk', title:'NKK' },
		        { name:'nama', sortField: 'nama' },
		        { name: '__checkbox:id'},
		        { name: '__sequence' }
	      	],
	      	sortOrder: [
		        { field: 'id', direction: 'asc' }
		    ],
		    paginationComponent: 'vuetable-pagination',
		    desa_name:'%'
		}
	},

	computed: {
		validation: function(){
	      return{
	        desa:!!this.valueDesa.value,
	        kecamatan:!!this.valueKecamatan.value
	      }
	    },

	    isValid: function(){
	      var validation = this.validation
	      return Object.keys(validation).every(function(key){
	        return validation[key]
	      })
	    },

	    url: function(){
	    	return this.$root.$config.API + '/api/tools/export/index'
	    }
	},

	ready(){
		this.fetchKecamatan()
	},

	methods:{
		 preg_quote: function( str ) {
	         return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
	     },
	     highlight: function(needle, haystack) {
	         return haystack.replace(
	             new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
	             '<span class="highlight">$1</span>'
	         )
	     },

		updateDesa: function(value){
			this.valueDesa = value			
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
	},

	components: { 
		Multiselect, 
		'vuetable': Vuetable, 
	},

	route: {
	  activate: function(t) {
	      this.$parent.$parent.$data.title = 'Import Export Database';
	      t.next();
	  }
  	},
}	
</script>

