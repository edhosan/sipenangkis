<template lang="html">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Form Anggota Keluarga</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" @submit.prevent="simpan">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group" v-bind:class="{'has-error':!validation.nik}">
            <label for="frmNama">NIK</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nomor induk keluarga" v-model="anggota.nik" :disabled="isfreeze">
            <span class="help-block" v-if="!validation.nama">Nomor induk keluarga harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.nama}">
            <label for="frmNama">Nama Keluarga</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nama keluarga" v-model="anggota.nama" :disabled="isfreeze">
            <span class="help-block" v-if="!validation.nama">Nama keluarga harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.sex}">
            <label>Jenis Kelamin :</label>
            <div class="radio">
              <input type="radio" name="sex" id="sex" value="L" checked v-model="anggota.sex">
              Laki - Laki
            </div>
            <div class="radio">
              <input type="radio" name="sex" id="optionsRadios1" value="P" v-model="anggota.sex">
              Perempuan
            </div>
            <span class="help-block" v-if="!validation.sex">Jenis kelamin harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.tgl_lhr}">
            <label for="frmNama">Tanggal lahir</label>
            <div class="input-group date">
              <datepicker v-ref:dp :value.sync="anggota.tgl_lhr" format='dd-MM-yyyy' placeholder="Pilih tanggal lahir">
              </datepicker>
            </div>
            <span class="help-block" v-if="!validation.tgl_lhr">Tanggal lahir harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.tempat}">
            <label for="frmNama">Tempat Lahir</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Tempat lahir" v-model="anggota.tempat_lhr" :disabled="isfreeze">
            <span class="help-block" v-if="!validation.tempat">Tempat lahir harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.agama}">
            <label for="frmNama">Agama</label>
            <multiselect
              :selected.sync="valueAgama"
              :options="agama"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Agama"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateAgama" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.agama">Agama harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.status}">
            <label for="frmNama">Status Perkawinan</label>
            <multiselect
              :selected.sync="valueStatus"
              :options="status"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Status Perkawinan"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateStatus" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.status">Status perkawinan harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.hubungan}">
            <label for="frmNama">Status hubungan dalam keluarga</label>
            <multiselect
              :selected.sync="valueHubungan"
              :options="hubungan"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Status Hubungan Keluarga"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateHubungan" :disabled="isfreeze">
            </multiselect>
            <input type="text" v-if="input_hub_lain" class="form-control" id="frmNama" placeholder="Keterangan hubungan lainnya" v-model="anggota.hubungan_ket" :disabled="isfreeze">
            <span class="help-block" v-if="!validation.hubungan">Status hubungan keluarga harus diisi.</span>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Kepemilikan Akta Nikah :</label>
            <div class="radio">
              <input type="radio" name="akta" id="optionsRadios1" value="1" checked v-model="anggota.akta_nikah">
              Ada
            </div>
            <div class="radio">
              <input type="radio" name="akta" id="optionsRadios1" value="2" v-model="anggota.akta_nikah">
              Tidak ada
            </div>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.kartu}">
            <label for="frmNama">Kepemilikan Kartu Identitas</label>
            <multiselect
              :selected.sync="valueKartu"
              :options="kartu"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Kepemilikan Kartu Identitas"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateKartu" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.kartu">Kepemilikan kartu identitas harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.disabilitas}">
            <label for="frmNama">Disabilitas</label>
            <multiselect
              :selected.sync="valueDisabilitas"
              :options="disabilitas"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Disabilitas Jenis"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updateDisabilitas" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.disabilitas">Disabilitas harus diisi.</span>
            <label>Kategori Disabilitas :</label>
            <div class="radio">
              <input type="radio" name="disabilitas_kategori" id="optionsRadios1" value="1" checked v-model="anggota.disabilitas_kategori">
              Ringan
            </div>
            <div class="radio">
              <input type="radio" name="disabilitas_kategori" id="optionsRadios1" value="2" v-model="anggota.disabilitas_kategori">
              Sedang
            </div>
            <div class="radio">
              <input type="radio" name="disabilitas_kategori" id="optionsRadios1" value="3" v-model="anggota.disabilitas_kategori">
              Berat
            </div>
          </div>
          <div class="form-group">
            <label for="frmNama">Penyakit Kronis</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Penyakit Kronis" v-model="anggota.penyakit_kronis" :disabled="isfreeze">
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.pekerjaan}">
            <label for="frmNama">Pekerjaan</label>
            <multiselect
              :selected.sync="valuePekerjaan"
              :options="pekerjaan"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Pekerjaan"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updatePekerjaan" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.pekerjaan">Pekerjaan harus diisi.</span>
          </div>
          <div class="form-group" v-bind:class="{'has-error':!validation.pendidikan}">
            <label for="frmNama">Jenjang Pendidikan</label>
            <multiselect
              :selected.sync="valuePendidikan"
              :options="pendidikan"
              :multiple="false"
              :searchable="true"
              :close-on-select="true"
              :allow-empty="false"
              placeholder="Pilih Pendidikan"
              deselect-label="Can't remove this value"
              label="label"
              key="value"
              @update="updatePendidikan" :disabled="isfreeze">
            </multiselect>
            <span class="help-block" v-if="!validation.pendidikan">Pendidikan harus diisi.</span>
          </div>
          <div class="form-group">
            <label for="frmNama">Nama Sekolah</label>
            <input type="text" class="form-control" id="frmNama" placeholder="Nama Sekolah" v-model="anggota.nama_sekolah" :disabled="isfreeze">
          </div>
        </div>
      <!-- /.box-body -->
      </div>
      <div class="box-footer">
        <button v-if="action == 'add'" type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Simpan</button>
        <button v-if="action == 'edit'"type="submit" class="btn btn-primary" :disabled="!isValid || isfreeze">Ubah</button>
        <button class="btn btn-warning" @click.prevent="cancel()">Cancel</button>
      </div>
    </form>
  </div>
</template>

<script>
var datepicker = require('vue-strap').datepicker;
import { Multiselect } from 'vue-multiselect';
import mixin from '../mixins/refdata.js'

export default {
  data () {
    return {
      valueAgama:[],
      agama:[],
      valueStatus:[],
      status:[],
      valueHubungan:[],
      hubungan:[],
      input_hub_lain: false,
      valueKartu:[],
      kartu:[],
      valueDisabilitas:[],
      disabilitas:[],
      valuePekerjaan:[],
      pekerjaan:[],
      valuePendidikan:[],
      pendidikan:[],
      anggota:{id:0, m_penerima_manfaat_id:0, kepala:'', nik: '', nama: '', sex:'',tgl_lhr:'',tempat_lhr:'',agama:'',status:'',hubungan:'',hubungan_ket:'',akta_nikah:'',kartu_identitas:'',disabilitas_jenis:'',disabilitas_kategori:'',penyakit_kronis:'',pekerjaan:'',pendidikan_jenjang:'',nama_sekolah:''},
    }
  },
  mixins:[mixin], 
  props:{
    action: String,
    id: Number
  },

  computed: {
    validation: function(){
      return{
        nama:!!this.anggota.nama,
        nik:!!this.anggota.nik,
        sex:!!this.anggota.sex,
        tgl_lhr:!!this.anggota.tgl_lhr,
        tempat:!!this.anggota.tempat_lhr,
        hubungan:!!this.valueHubungan.value,
        agama:!!this.valueAgama.value,
        status:!!this.valueStatus.value,
        kartu:!!this.valueKartu.value,
        disabilitas:!!this.valueDisabilitas.value,
        pekerjaan:!!this.valuePekerjaan.value,
        pendidikan:!!this.valuePendidikan.value
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
    this.fetchAgama()
    this.fetchStatus()
    this.fetchHubungan()
    this.fetchKartu()
    this.fetchDisabilitas()
    this.fetchPekerjaan()
    this.fetchPendidikan() 
    if(this.action = 'edit'){
      this.fetchData()
    } 
  },
  attached () {},
  methods: {
    updateAgama: function(value){
      this.valueAgama = value
      this.anggota.agama = value.value
    },

    updateStatus: function(value){
      this.valueStatus = value
      this.anggota.status = value.value
    },

    updateHubungan: function(value){
      this.valueHubungan = value
      this.anggota.hubungan = value.value
      if(value.value == '11'){
        this.input_hub_lain = true
      }
    },

    updateKartu: function(value){
      this.valueKartu = value
      this.anggota.kartu_identitas = value.value
    },

    updateDisabilitas: function(value){
      this.valueDisabilitas = value
      this.anggota.disabilitas_jenis = value.value
    },

    updatePekerjaan: function(value){
      this.valuePekerjaan = value
      this.anggota.m_pekerjaan_id = value.value
    },

    updatePendidikan: function(value){
      this.valuePendidikan = value
      this.anggota.m_pendidikan_id = value.value
    },

    fetchAgama: function(){
      this.$http.get(this.$root.$config.API + '/api/keluarga/ref_agama').then((response)=>{
        this.$set('agama',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchStatus: function(){
      this.$http.get(this.$root.$config.API + '/api/keluarga/ref_status').then((response)=>{
        this.$set('status',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchHubungan: function(){
      this.$http.get(this.$root.$config.API + '/api/keluarga/ref_hubungan').then((response)=>{
        this.$set('hubungan',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchKartu: function(){
      this.$http.get(this.$root.$config.API + '/api/keluarga/ref_kartu').then((response)=>{
        this.$set('kartu',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchDisabilitas: function(){
      this.$http.get(this.$root.$config.API + '/api/keluarga/ref_disabilitas').then((response)=>{
        this.$set('disabilitas',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchPekerjaan: function(){
      this.$http.get(this.$root.$config.API + '/api/pekerjaan/ref_pekerjaan').then((response)=>{
        this.$set('pekerjaan',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchPendidikan: function(){
      this.$http.get(this.$root.$config.API + '/api/pendidikan/ref_pendidikan').then((response)=>{
        this.$set('pendidikan',response.data)
      },(error)=>{
        console.log(error)
      })
    },

    fetchData: function(){
      this.$http.get(this.$root.$config.API + '/api/keluarga/'+this.id+'/detail_keluarga').then((response)=>{
        console.log(response) 
        this.$set('anggota', response.data.keluarga)
        this.valueAgama = {value:response.data.keluarga.agama,label:this.agamaLabel(response.data.keluarga.agama)}
        this.valueStatus = {value:response.data.keluarga.status,label:this.statusLabel(response.data.keluarga.status)}
        this.valueHubungan = {value:response.data.keluarga.hubungan,label:this.hubLabel(response.data.keluarga.hubungan)}
        this.valueKartu = {value:response.data.keluarga.kartu_identitas,label:this.kartuLabel(response.data.keluarga.kartu_identitas)}
        this.valueDisabilitas = {value:response.data.keluarga.disabilitas_jenis,label:this.disabilitasLabel(response.data.keluarga.disabilitas_jenis)}
        this.valuePekerjaan = {value:response.data.pekerjaan.id,label:response.data.pekerjaan.pekerjaan}
        this.valuePendidikan = {value:response.data.pendidikan.id,label:response.data.pendidikan.name}       
      },(error)=>{
        console.log(error)
      })
    },

    simpan: function(){
      event.preventDefault()
      this.anggota.m_penerima_manfaat_id = this.$parent.$parent.$data.penerima_manfaat_id
      this.anggota.tgl_lhr = this.$moment(new Date(this.$refs.dp.parse())).format('YYYY-MM-DD')
      var self = this

      var data = this.anggota
      var url = this.$root.$config.API
      console.log(this.isAction)

      if(this.isAction=='add'){
          url = url + '/api/keluarga/'+this.anggota.m_penerima_manfaat_id+'/store'
      }else{
          url = url + '/api/keluarga/'+this.anggota.m_penerima_manfaat_id+'/'+this.anggota.id+'/update'
      }

      this.$http.post(url,data).then((response)=>{
        toastr.success('Data berhasil disimpan.', 'Save Data', {timeOut: 3000})
        this.cancel()
        this.$dispatch('fetchDataKeluarga')
      },(error)=>{
        if(error.data.error.code==23000){
          toastr.error('Duplikat data entry.', 'Error', {timeOut: 3000})
        }else{
          console.log(error)
          toastr.error('Gagal simpan data', 'Error', {timeOut: 3000})
        }
      })

    },

    cancel: function(){
      this.valueAgama = []
      this.valueStatus = []
      this.valueHubungan = []
      this.valueKartu = []
      this.valueDisabilitas = []
      this.valuePekerjaan = []
      this.valuePendidikan = []
      this.anggota = {id:0, m_penerima_manfaat_id:0, kepala:'', nik: '', nama: '', sex:'',tgl_lhr:'',tempat_lhr:'',agama:'',status:'',hubungan:'',hubungan_ket:'',akta_nikah:'',kartu_identitas:'',disabilitas_jenis:'',disabilitas_kategori:'',penyakit_kronis:'',pekerjaan:'',pendidikan_jenjang:'',nama_sekolah:''}
      this.$dispatch('cancel')
    },

  },
  components: {datepicker, Multiselect}
}
</script>

<style lang="css">
</style>
