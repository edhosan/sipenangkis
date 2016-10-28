<template lang="html">
  <div class="row">
    <div class="col-md-12" v-if="isAction == 'list'">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Jawaban Indikator</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th style="width: 10px">Id</th>
              <th>Jawaban</th>
              <th>Nilai</th>
              <th style="width: 200px">Action</th>
            </tr>
            <tr v-for="item in list">
              <td>{{ item.id }}</td>
               <td>{{ item.name }}</td>
               <td>{{ item.nilai }}</td>
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
          <div >
            <button class="btn btn-primary" @click.prevent="entryItem()">Tambah Data</button>
          </div>
        </div>
      </div>
      <!-- /.box -->

    </div>

    <div class="col-md-12" v-if="isAction == 'add' || isAction == 'edit'">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Jawaban Indikator</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" @submit.prevent="simpan">
          <div class="box-body">
            <div class="col-md-12">
              <div class="form-group" v-bind:class="{'has-error':!validation.name}">
                <label for="frmNama">Jawaban Pertanyaan</label>
                <input type="text" class="form-control" id="frmNama" placeholder="Jawaban Pertanyaan" v-model="jawaban.name" :disabled="isFreeze">
                <span class="help-block" v-if="!validation.name">Jawaban pertanyaan harus diisi.</span>
              </div>
              <div class="form-group" v-bind:class="{'has-error':!validation.nilai || !validation.nilai_angka}">
                <label for="frmNama">Nilai</label>
                <input type="text" class="form-control" id="frmNama" placeholder="Nilai" v-model="jawaban.nilai" :disabled="isFreeze">
                <span class="help-block" v-if="!validation.nilai">Nilai pertanyaan harus diisi.</span>
                <span class="help-block" v-if="!validation.nilai_angka">Nilai harus berupa angka.</span>
              </div>
            </div>
          <!-- /.box-body -->
          </div>
          <div class="box-footer">
            <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isFreeze">Simpan</button>
            <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isFreeze">Ubah</button>
            <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data () {
    return {
      isAction: 'list',
      list:[],
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
      jawaban: {id:null,name:'',nilai:0,m_indikator_id:0}
    }
  },
  props:{
    indikator_id: Number
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
        name:!!this.jawaban.name,
        nilai:!!this.jawaban.nilai,
        nilai_angka:!!/^[-+]?[0-9]+$/.test(this.jawaban.nilai)
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
  },
  attached () {},
  methods: {
    fetchData: function(page) {
      var url = this.$root.$config.API + '/api/jawaban/'+this.indikator_id+'/index?page='+page+'&per_page='+this.per_page+'&sort=id|asc'
      this.$http.get(url).then((response)=>{
        this.$set('list', response.data.data)
        this.$set('pagination', response.data)
      },(error)=>{
        console.log(error)
      })
    },

    editItem: function(item){
      this.$set('jawaban',item)
      this.isAction = 'edit'
      this.isFreeze = false
    },

    deleteItem: function(item){
      this.$http.get(this.$root.$config.API + '/api/jawaban/'+this.indikator_id+'/'+item.id+'/delete').then((response)=>{
        toastr.success('Data berhasil dihapus.', 'Hapus Data', {timeOut: 3000})
        this.fetchData(this.pagination.current_page)
      },(error)=>{
        console.log(error)
      })
    },

    changePage: function(page){
      this.pagination.current_page = page
      this.fetchData(page)
    },

    entryItem: function(){
      if(this.indikator_id == null){
        toastr.error('Simpan pertanyaan indikator terlebih dahulu', 'Error', {timeOut: 3000})
      }else{
        this.isAction = 'add'
        this.jawaban =  {id:null,name:'',nilai:0,m_indikator_id:0}
        this.isFreeze = false
      }

    },

    simpan: function(){
      event.preventDefault()
      var self = this

      var data = this.jawaban
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/jawaban/'+this.indikator_id+'/store'
      }else{
          url = url + '/api/jawaban/'+this.indikator_id+'/'+this.jawaban.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isFreeze = true
        this.$set('jawaban', response.data)
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

    cancel: function(){
      this.isAction = 'list'
    },


  },
  components: {}

}
</script>

<style lang="css">
</style>
