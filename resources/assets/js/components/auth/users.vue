<template lang="html">
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Form Pengguna</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" @submit.prevent="simpanUser">
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group" v-bind:class="{'has-error':!validation.name}">
              <label for="frmNama">Nama</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nama" v-model="user.name">
              <span class="help-block" v-if="!validation.name">Nama harus diisi.</span>
            </div>
            <div class="form-group" v-bind:class="{'has-error':!validation.userid}">
              <label for="frmJudul">User Id</label>
              <input type="text" class="form-control" id="frmJudul" placeholder="Judul" v-model="user.userid">
              <span class="help-block" v-if="!validation.userid">User id harus diisi.</span>
            </div>
            <div class="form-group" v-bind:class="{'has-error':!validation.password}">
              <label for="frmPassword">Password</label>
              <input type="password" class="form-control" id="frmPassword" placeholder="Password" v-model="user.password">
              <span class="help-block" v-if="!validation.password">Password harus diisi.</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Tipe Pengguna:</label>
              <multiselect
                :selected.sync="multiValue"
                :options="roles"
                :multiple="true"
                :searchable="true"
                :close-on-select="false"
                :clear-on-select="false"
                placeholder="Pilih tipe penguna"
                label="label"
                key="value"
                @update="updateMultiValue">
              </multiselect>
            </div>
            <div class="form-group">
              <label>Stakeholders:</label>
              <multiselect
                :selected.sync="stakeholderValue"
                :options="stakeholders"
                :multiple="false"
                :searchable="true"
                :allow-empty="false"
                :close-on-select="true"
                deselect-label="Can't remove this value"
                placeholder="Pilih Stakeholders"
                label="label"
                key="value"
                @update="updateStakeholder">
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
        <h3 class="box-title">Daftar Pengguna</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th style="width: 10px">Id</th>
            <th>Nama</th>
            <th>User Id</th>
            <th>Tipe Pengguna</th>
            <th>Stakeholder</th>
            <th>Action</th>
          </tr>
          <tr v-for="item in items">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.userid }}</td>
            <td>
              <div v-for="role in item.roles">
                <span class="label label-success">{{ role.display_name }}</span>
              </div>
            </td>
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
      roles:[],
      multiValue: [],
      user:{ id: null, name: '', userid: '', password: '', tipe:[], m_stakeholer_id:''},
      stakeholderValue:[],
      stakeholders:[]
    }
  },

  computed: {
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

    validation: function(){
      return{
        name:!!this.user.name.trim(),
        userid:!!this.user.userid.trim(),
        password:!!this.user.password
      }
    },

    isValid: function(){
      var validation = this.validation
      return Object.keys(validation).every(function(key){
        return validation[key]
      })
    },

  },

  ready () {
      this.fetchData(this.pagination.current_page)
      this.getRoles()
  },

  attached () {},

  methods: {
    simpanUser: function(){
      event.preventDefault()
      this.$Progress.start()

      var self = this
      this.multiValue.forEach(function(item,index){
        self.user.tipe.push(item.value)
      })
      var data = this.user
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/user/store'
      }else{
          url = url + '/api/user/'+this.user.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.cancel()
        this.$Progress.finish()
        this.fetchData(this.pagination.current_page)        
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

    fetchData: function(page) {
      this.$Progress.start()

      var url = this.$root.$config.API + '/api/user/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
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

    updateMultiValue: function(value){
      this.multiValue = value
    },

    cancel: function(){
      this.isAction = 'add'
      this.user = {id: '', name: '', userid: '', password: '', tipe:[]}
      this.multiValue = []
      this.stakeholderValue = [];
    },

    getRoles: function(){
      this.$Progress.start()

      this.$http.get(this.$root.$config.API + '/api/role/all').then((response)=>{
        this.$set('roles',response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    editItem: function(item){
      this.$Progress.start()

      var self = this    
      this.user.id = item.id
      this.user.name = item.name
      this.user.userid = item.userid
      this.user.password = item.password
      this.stakeholderValue = {value:item.m_stakeholder_id,label:item.stakeholder.name}
      this.user.m_stakeholer_id = item.id
      this.$http.get(this.$root.$config.API + '/api/user/'+item.id+'/edit').then((response)=>{
        this.$set('multiValue', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
      console.log(item)
      this.isAction = 'edit'
    },

    deleteItem: function(item){
      this.$Progress.start()

      this.$http.get(this.$root.$config.API + '/api/user/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData(this.pagination.current_page)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },

    updateStakeholder: function(value){
      this.stakeholderValue = value
      this.user.m_stakeholer_id = value.value
    },

    fetchStakeholder: function(){
      this.$Progress.start()

      this.$http.get(this.$root.$config.API + '/api/stakeholder/ref_stakeholder').then((response)=>{
        this.$set('stakeholders',response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    },
  },

  components: { Multiselect },

  route: {
      activate: function(t) {
          this.fetchStakeholder()
          this.$parent.$parent.$data.title = 'Pengguna';
          t.next();
      }
  }
}
</script>

<style lang="css">
</style>
