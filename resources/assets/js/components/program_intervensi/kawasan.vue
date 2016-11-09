<template>
  <div class="tab-pane active">
	<div class="row">
	  <div class="col-md-12" v-if="isAction == 'list'">
	    <div class="box box-warning">
	      <div class="box-header with-border">
	        <h3 class="box-title">Daftar Penerima Manfaat Kawasan</h3>
	      </div>
	      <!-- /.box-header -->
	      <div class="box-body">
	        <div class="row">
	          <div class="col-md-5">
	            <bs-input type="text" :value.sync="searchFor" @keyup.enter="setFilter">
	            <v-select slot="before" text="dropdown" :value.sync="filterValue" :options="filterBy" options-value="val" close-on-select placeholder="Filter"></v-select>
	              <span slot="after" class="input-group-btn">
	                <button type="button" class="btn btn-primary" @click="setFilter">
	                  <i class="fa fa-search"></i>
	                </button>
	              </span>
	            </bs-input>
	          </div>
	          <div class="col-md-7">
	            <div class="dropdown form-inline pull-right">
	              <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
	                <i class="fa fa-gear"></i>
	              </button>
	              <ul class="dropdown-menu">
	                <li class="divider"></li>
	                <li v-for="field in fields">
	                  <span class="checkbox">
	                      <label>
	                          <input type="checkbox" v-model="field.visible">
	                          {{ field.title == '' ? field.name.replace('__', '') : field.title | capitalize }}
	                      </label>
	                  </span>
	                </li>
	              </ul>
	            </div>
	          </div>
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
	    </div>
	    </div>
	    <!-- /.box -->

	  </div>
	  
	</div>  	
  </div>

</template>

<script>
var Vuetable = require('vuetable/src/components/Vuetable.vue')
var vSelect = require('vue-strap').select;
var bsInput = require('vue-strap').input;

export default{
	data(){
		return{
		  isAction: 'list',
		  per_page: 10,
	      url: this.$root.$config.API + '/api/program_intervensi/index_kawasan',
	      fields:[
	        { name: '__sequence', title:'No.' },
	        { name:'id', sortField: 'id', visible: false },
	        { name:'kecamatan', sortField: 'kecamatan', title:'Kecamatan' },
	        { name:'desa', sortField: 'desa', title:'Kampung/Kelurahan' },
	        { name:'intervensi', sortField: 'intervensi', title:'Bentuk Intervensi'},
	        { name: '__actions', title: '', titleClass: 'text-center', dataClass: 'text-center'},
	      ],
	      filterBy:[
	        { val:'m_desa.id', label:'Id' },
	        { val:'m_desa.name', label:'Kampung/Kelurahan' },
	        { val:'m_kecamatan.nama', label:'Kecamatan' },
	        { val:'m_intervensi.name', label:'Bentuk Intervensi' },
	      ],
	      filterValue:[],
	      sortOrder: [
    	    { field: 'id', direction: 'asc' }
      	  ],
      	  paginationComponent: 'vuetable-pagination-pager',
	      itemActions: [
	           { name: 'edit-item', label: 'Proses Intervensi', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning'}         
	      ],
       	  moreParams: [],
       	  searchFor:''
		}
	},

	methods: {
	    preg_quote: function( str ) {
	         return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
	    },
	    highlight: function(needle, haystack) {
	        return haystack.replace(
	           new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
	           '<span class="highlight">$1</span>'
	        )
	    },

	    setFilter: function() {
	        if(this.filterValue == null){
	            toastr.error('Pilih key filter untuk pencarian data', 'Error', {timeOut: 3000})
	        }else{
	          this.moreParams = [
	              'filter=' + this.searchFor,
	              'key='+ this.filterValue
	          ]
	          this.$nextTick(function() {
	              this.$broadcast('vuetable:refresh')
	          })
	        }
	    },
  	},

  	components: {
	  'vuetable': Vuetable,
	   vSelect,
	   bsInput
	},

	events:{
    	'vuetable:action': function(action, data) {
        	this.$Progress.start()
         	if (action == 'edit-item') {
           		this.$router.go({path:'/pengajuan/detail_kawasan/'+data.id})
         	}
    	}
    }
}
	
</script>

