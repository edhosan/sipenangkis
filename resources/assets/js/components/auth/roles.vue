<template>  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Tipe Pengguna</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" @submit.prevent="simpanRoles">
          <div class="box-body">
            <div class="col-md-6">
              <div class="form-group" v-bind:class="{'has-error':!validation.name}">
                <label for="frmNama">Nama</label>
                <input type="text" class="form-control" id="frmNama" placeholder="Nama" v-model="role.name">
                <span class="help-block" v-if="!validation.name">Nama harus diisi.</span>
              </div>
              <div class="form-group" v-bind:class="{'has-error':!validation.display_name}">
                <label for="frmJudul">Judul</label>
                <input type="text" class="form-control" id="frmJudul" placeholder="Judul" v-model="role.display_name">
                <span class="help-block" v-if="!validation.display_name">Judul harus diisi.</span>
              </div>
              <div class="form-group">
                <label for="frmKeterangan">Keterangan</label>
                <textarea class="form-control" rows="3" placeholder="Keterangan ..." v-model="role.description"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Hak Akses Pengguna:</label>
                <multiselect
                  :selected.sync="multiValue"
                  :options="permissions"
                  :multiple="true"
                  :searchable="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  placeholder="Pilih hak akses"
                  label="label"
                  key="value"
                  @update="updateMultiValue">
                </multiselect>
              </div>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid">Simpan</button>
            <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid">Ubah</button>
            <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Tipe Pengguna</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th style="width: 10px">Id</th>
              <th>Nama</th>
              <th>Judul</th>
              <th>Keterangan</th>
              <th>Action</th>
            </tr>
            <tr v-for="item in items">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.display_name }}</td>
              <td>{{ item.description }}</td>
              <td>
                <button class="btn btn-primary" @click.prevent="editItem(item)">Ubah</button>
			          <button class="btn btn-danger" @click.prevent="deleteItem(item)">Hapus</button>
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
        </div>
      </div>
      <!-- /.box -->

    </div>
  </div>

</template>

<script>
import { Multiselect } from 'vue-multiselect';

export default {
  data () {
    return {
      role:{ id: null, name: '', display_name: '', description: '',hak_akses:[]},
      offset: 4,
      per_page: 10,
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
      items: [],
      isAction: 'add',
      permissions:[],
      multiValue: []
    }
  },
  computed: {
    validation: function(){
      return{
        name:!!this.role.name.trim(),
        display_name:!!this.role.display_name.trim()
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
    },

  },

  ready () {
    this.fetchData(this.pagination.current_page)
    this.getHakAkses()
  },
  attached () {},

  components: { Multiselect },

  methods: {
    simpanRoles: function(){
      event.preventDefault()
      this.$Progress.start()
      var self = this

      this.multiValue.forEach(function(item,index){
        self.role.hak_akses.push(item.value)
      })
      var data = this.role
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/role/store'
      }else{
          url = url + '/api/role/'+this.role.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.cancel()
        this.$Progress.finish()
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        this.$Progress.fail()
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
        console.log(error)
      })


    },

    fetchData: function(page) {
      this.$Progress.start()
      var url = this.$root.$config.API + '/api/role/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('items', response.data.data)
        this.$set('pagination', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    editItem: function(item){
      var self = this
      this.$Progress.start()
      this.role.id = item.id
      this.role.name = item.name
      this.role.display_name = item.display_name
      this.role.description = item.description
      this.$http.get(this.$root.$config.API + '/api/role/'+item.id+'/edit').then((response)=>{
        this.$set('multiValue', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
      this.isAction = 'edit'
    },

    cancel: function(){
      this.isAction = 'add'
      this.role = {id: '', name: '', display_name: '', description: '', hak_akses:[]}
      this.multiValue = []
    },

    deleteItem: function(item){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/role/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData(this.pagination.current_page)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    getHakAkses: function(){
      this.$Progress.start()
      this.$http.get(this.$root.$config.API + '/api/all_permission/').then((response)=>{
        this.$set('permissions',response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    updateMultiValue: function(value){
      this.multiValue = value
    }
  },

  route: {
      activate: function(t) {
          this.$parent.$parent.$data.title = 'Tipe Pengguna';
          t.next();
      }
  }

}
</script>

<style lang="css">
</style>
