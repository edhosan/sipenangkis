<template>
	<form role="form" @submit.prevent="simpan">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
		      <h3 class="box-title">Daftar Keluarga Penerima Manfaat</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive col-md-12">
					<div class="help-block has-error">
						<span class="help-block" v-if="!validation.row">Pilih keluarga penerima manfaat!</span>
						<span class="help-block" v-if="!validation.kelompok">Simpan / Pilih kelompok penerima!</span>
					</div>
		            <vuetable v-ref:vuetable
		                :api-url="url_keluarga"
		                pagination-path=""
		                :fields="fields_keluarga"
		                :sort-order="sortOrder"
		                table-class="table table-bordered table-striped table-hover"
		                ascending-icon="glyphicon glyphicon-chevron-up"
		                descending-icon="glyphicon glyphicon-chevron-down"
		                pagination-class=""
		                pagination-info-class=""
		                pagination-component-class=""
		                :pagination-component="paginationComponent"
		                :per-page="per_page"
		                :append-params="keluargaParams"
		                wrapper-class="vuetable-wrapper "
		                table-wrapper=".vuetable-wrapper"
		                loading-class="loading"
	                    :selected-to="selectedRow"
		            ></vuetable>
		        </div>
	      		
			</div>
		</div>		
	</div>


	<div class="col-md-1">
		<button class="btn btn-primary" :disabled="!isValid || isfreeze"><i class="fa fa-forward"></i></button>
	</div>

	<div class="col-md-5">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Daftar Kelompok Penerima Manfaat</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive col-md-12">
		         	 <vuetable v-ref:vuetable
			                :api-url="url_kelompok"
			                pagination-path=""
			                :fields="fields_kelompok"
			                :sort-order="sortOrder"
			                table-class="table table-bordered table-striped table-hover"
			                ascending-icon="glyphicon glyphicon-chevron-up"
			                descending-icon="glyphicon glyphicon-chevron-down"
			                pagination-class=""
			                pagination-info-class=""
			                pagination-component-class=""
			                :pagination-component="paginationComponent2"
			                :per-page="per_page"
                            :item-actions="itemActions"
			                :append-params="keluargaParams"		             
			                wrapper-class="vuetable-wrapper "
			                table-wrapper=".vuetable-wrapper"
			                loading-class="loading"
			            ></vuetable>
		        </div>
			</div>
		</div>		
	</div>

 </form>
</template>

<script>
var Vuetable = require('vuetable/src/components/Vuetable.vue')

export default {
	data(){
		return{
			url_keluarga: this.$root.$config.API + '/api/kelompok/keluarga/index',
			fields_keluarga:[
			 	{ name: '__checkbox:id'},
	            { name: '__sequence', title:'No.' },
		        { name:'id', sortField: 'id', visible: false },
		        { name:'nkk', sortField: 'nkk', title:'NKK' },
		        { name:'nama', sortField: 'nama' },
		        { name:'alamat', sortField: 'alamat' },
	            { name:'desa', sortField: 'desa', title: 'Kampung' },
   		        { name:'kriteria', sortField: 'kriteria' },
		    ],
     	    sortOrder: [
        		{ field: 'id', direction: 'asc' }
      		],
      		paginationComponent: 'vuetable-pagination-pager',
      		paginationComponent2: 'vuetable-pagination-pager',
      		per_page: 10,
	 		keluargaParams: [],
	 		selectedRow:[],
	 		url_kelompok: this.$root.$config.API + '/api/kelompok/penerima/index',
	 		fields_kelompok:[			 
	            { name: '__sequence', title:'No.' },
		        { name:'id', sortField: 'id', visible: false },
		        { name:'nkk', sortField: 'nkk', title:'NKK' },
		        { name:'nama', sortField: 'nama' },
		        { name:'alamat', sortField: 'alamat' },
   	            { name:'desa', sortField: 'desa', title: 'Kampung' },
   		        { name:'kriteria', sortField: 'kriteria' },
   	            { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
		    ],
		    itemActions: [
	           { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger' }
	       ],
		}
	},

	props: {
		kelompok_id: Number
	},

	computed:{
		validation: function(){
	      return{
	        row:!!this.selectedRow.length > 0,
	        kelompok:!!this.kelompok_id
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

	},

	methods: {
		simpan: function(){	     
	      this.$Progress.start()
	      event.preventDefault()	   
	      var self = this

	      var data = { data: this.selectedRow, kelompok_id: this.kelompok_id }
	      var url = this.$root.$config.API + '/api/kelompok/penerima/store'

	      this.$http.post(url,data).then((response)=>{
	        toastr.success('Simpan Data Berhasil', 'Simpan Data', {timeOut: 3000})
	        this.selectedRow = []
	        this.setFilter(response.data.desa.id)
	        this.$Progress.finish()
	      },(error)=>{
	        if(error.data.error.code==23000){
	          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
	        }else{
	          toastr.error('Simpan Data Gagal', 'Error', {timeOut: 3000})
	        }
	        console.log(error)
	        this.$Progress.fail()
	      })
	    },

	    setFilter: function(value){
	    	this.keluargaParams = [
               'filter=' + value,
               'key=m_desa.id',
               'kelompok_id='+this.kelompok_id
           	]          
           this.$nextTick(function() {
               this.$broadcast('vuetable:refresh')
           })
	    }
	},

	components: {
	    'vuetable': Vuetable,
	},

	events:{
		'table-keluarga:filter': function(value){
			this.setFilter(value)			
		},

		'vuetable:action': function(action, data) {
	         if (action == 'delete-item') {
		        this.$http.get(this.$root.$config.API + '/api/kelompok/penerima/'+data.id+'/delete').then((response)=>{
		             toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})		           
		             this.$broadcast('vuetable:refresh')
		           },(error)=>{
		             toastr.error('Gagal hapus data', 'Error', {timeOut: 3000})
		             console.log(error)
		        })
	         }
	    },
	}
}
</script>