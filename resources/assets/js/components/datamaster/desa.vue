<template lang="html">
  <div class="col-md-12" v-if="isAction == 'add' || isAction=='edit'">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Form Kelurahan/Desa</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" @submit.prevent="simpan">
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group" v-bind:class="{'has-error':!validation.name}">
              <label for="frmNama">Nama</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nama" v-model="desa.name">
              <span class="help-block" v-if="!validation.name">Nama desa harus diisi.</span>
            </div>
          </div>
        <!-- /.box-body -->
        </div>
        <div class="box-footer">
          <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid">Simpan</button>
          <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid">Ubah</button>
          <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
        </div>
      </form>
  </div>
</div>

<div class="col-md-12" v-if="isAction == 'list'">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Desa</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">Id</th>
          <th>Desa</th>
          <th>Action</th>
        </tr>
        <tr v-for="desa in items">
          <td>{{ desa.id }}</td>
          <td>{{ desa.name }}</td>
          <td>
            <button class="btn btn-primary" @click.prevent="editItem(desa)">Ubah</button>
            <button class="btn btn-danger" @click.prevent="deleteItem(desa)">Hapus</button>
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
        <button class="btn btn-primary" @click.prevent="entryItem()">Tambah Desa/Kelurahan</button>
      </div>
    </div>
  </div>
  <!-- /.box -->

</div>
</template>

<script>
export default {
  data () {
    return {
      isAction: 'list',
      desa:{ id: null, name: ''},
      offset: 4,
      per_page: 5,
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
      items:[]
    }
  },

  props:{
    m_kecamatan_id: Number
  },

  computed: {
    validation: function(){
      return{
        name:!!this.desa.name.trim()
      }
    },

    isValid: function(){
      var validation = this.validation
      return Object.keys(validation).every(function(key){
        return validation[key]
      })
    },

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
    }

  },

  ready () {
    this.fetchData(this.pagination.current_page)
  },
  attached () {},

  methods: {
    simpan: function(){
      event.preventDefault()
      var self = this

      var data = this.desa
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/desa/'+this.m_kecamatan_id+'/store'
      }else{
          url = url + '/api/desa/'+this.desa.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.cancel()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        console.log(error)
      })
    },

    fetchData: function(page) {
      var url = this.$root.$config.API + '/api/desa/'+this.m_kecamatan_id+'/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('items', response.data.data)
        this.$set('pagination', response.data)
      },(error)=>{
        console.log(error)
      })
    },

    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    cancel: function(){
      this.isAction = 'list'
      this.desa = {id: '', name: ''}
    },

    entryItem: function(){
      return this.isAction = 'add'
    },

    editItem: function(edit_item){
      this.desa.id = edit_item.id
      this.desa.name = edit_item.name
      this.isAction = 'edit'
    },

    deleteItem: function(item){
      this.$http.get(this.$root.$config.API + '/api/desa/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        console.log(error)
      })
    },

  },

  components: {}
}
</script>

<style lang="css">
</style>
