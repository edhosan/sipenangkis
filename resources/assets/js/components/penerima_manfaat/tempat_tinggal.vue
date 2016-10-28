<template lang="html">
  <div class="box box-primary" v-if="isAction == 'add' || isAction == 'edit'">
    <form role="form" @submit.prevent="simpan" >
    <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" v-bind:class="{'has-error':!validation.nkk}">
              <label for="frmNama">Nomor Kartu Keluarga</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nomor kartu keluarga" v-model="keluarga.nkk" :disabled="isfreeze">
              <span class="help-block" v-if="!validation.nkk">Nomor kartu keluarga harus diisi.</span>
            </div>
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
            <div class="form-group" v-bind:class="{'has-error':!validation.alamat}">
              <label for="frmKeterangan">Alamat</label>
              <textarea class="form-control" rows="3" placeholder="Alamat ..." v-model="keluarga.alamat" :disabled="isfreeze"></textarea>
              <span class="help-block" v-if="!validation.alamat">Alamat harus diisi.</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="frmNama">RW</label>
              <input type="text" class="form-control" id="frmNama" placeholder="RW" v-model="keluarga.rw" :disabled="isfreeze">
            </div>
            <div class="form-group">
              <label for="frmNama">RT</label>
              <input type="text" class="form-control" id="frmNama" placeholder="RT" v-model="keluarga.rt" :disabled="isfreeze">
            </div>
            <div class="form-group">
              <label for="frmNama">Nomor Rumah</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Nomor rumah" v-model="keluarga.no_rumah" :disabled="isfreeze">
            </div>
            <div class="form-group" v-bind:class="{'has-error':!validation.domisili}">
              <label for="frmNama">Lamanya berdomisili pada alamat diatas</label>
              <input type="text" class="form-control" id="frmNama" placeholder="Lamanya berdomisili" v-model="keluarga.domisili" :disabled="isfreeze">
              <span class="help-block" v-if="!validation.domisili">Input lamanya domisili harus berupa angka.</span>
            </div>
          </div>
        </div>
    </div>
    <div class="box-footer">
      <button v-if="isAction == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Simpan</button>
      <button v-if="isAction == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Ubah</button>
      <button type="button" class="btn btn-warning" @click.prevent="cancel">Batal</button>
    </div>
    </form>
  </div>
</template>

<script>
import { Multiselect } from 'vue-multiselect';
export default {
  data () {
    return {
      isAction: 'add',
      valueKecamatan:[],
      valueDesa:[],
      kecamatan:[],
      desa:[],
      isLoading: false,
      anggota_keluarga:[]
    }
  },
  props:{
    keluarga: Object,
    isfreeze: Boolean
  },
  computed: {
    validation: function(){
      return{
        nkk:!!this.keluarga.nkk,
        kecamatan:!!this.valueKecamatan.value,
        desa:!!this.valueDesa.value,
        alamat:!!this.keluarga.alamat.trim(),
        domisili:!!/^[-+]?[0-9]+$/.test(this.keluarga.domisili)
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
    this.fetchKecamatan()
    this.fetchDesa()
  },
  attached () {},
  methods: {
    updateKecamatan: function(value){
      this.valueKecamatan = value
      this.fetchDesa(value.value)
    },

    updateDesa: function(value){
      this.valueDesa = value
      this.keluarga.m_desa_id = value.value
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

    simpan: function(){
      this.$Progress.start()
      event.preventDefault()
      var self = this

      var data = this.keluarga
      var url = this.$root.$config.API

      if(this.isAction=='add'){
          url = url + '/api/penerima_manfaat/store'
      }else{
          url = url + '/api/penerima_manfaat/'+this.keluarga.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.isAction = 'edit'
        this.$set('keluarga', response.data.penerima_manfaat)
        this.$parent.$data.penerima_manfaat_id = this.keluarga.id
        this.$parent.$data.penilaian_id = response.data.hasil_indikator.id
        this.$Progress.finish()
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

    cancel: function(){
      this.keluarga = {id:null, m_desa_id:null, rt:'', alamat:'',no_rumah:'',domisili:0,nkk:'',userid:localStorage.userid,rw:'',nama:''}
      this.isfreeze = false
    },

  },
  components: {
    Multiselect
  }
}
</script>

<style lang="css">
</style>
