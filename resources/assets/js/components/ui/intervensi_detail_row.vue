<template lang="html">
    <table class="table table-bordered">
    <tr>
    	<th>Rincian Intervensi</th>
    	<th>Volume</th>
    	<th>Satuan</th>
    	<th>Nilai</th>
    	<th>Jumlah</th>
    </tr>
    <tr v-for="item in rincian">
    	<td>{{ item.name }}</td>
    	<td>{{ item.volume }}</td>
    	<td>{{ item.satuan }}</td>
    	<td>{{ item.nilai }}</td>
    	<td>{{ item.jumlah }}</td>
    </tr>
    </table>
</template>

<script>
export default {
	data(){
		return{
			rincian:[]
		}
	},

	props:{
		rowData:{
			type: Object,
			required: true
		}
	},

	ready(){
		this.fetchData()
	},

	methods:{		
		fetchData: function(){
			this.$Progress.start()
			this.$http.get(this.$root.$config.API + '/api/program_intervensi/rincian?page=1&per_page=20&t_intervensi_id='+this.rowData.id).then((response)=>{
				this.$set('rincian', response.data.data)				
				this.$Progress.finish()
           },(error)=>{
             console.log(error)
             this.$Progress.fail()
           })
		}
	}
}	
</script>

<style>
.vuetable-detail-row {
    height: 200px;
}
.detail-row {
    margin-left: 40px;
}
.expand-transition {
    transition: all .5s ease;
}
.expand-enter, .expand-leave {
    height: 0;
    opacity: 0;
}	
</style>