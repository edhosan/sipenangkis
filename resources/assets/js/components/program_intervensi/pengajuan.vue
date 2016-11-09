<template lang="html">
  <div class="row">
    <div class="col-md-12">
      <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
           <li class="active"><a href="#" @click="goPage('/pengajuan/kawasan')" data-toggle="tab"><span> Kawasan</span></a></li>
           <li><a href="#" @click="goPage('/pengajuan/kelompok')" data-toggle="tab"><span> Kelompok</span></a></li>
           <li><a href="#" @click="goPage('/pengajuan/keluarga')" data-toggle="tab"><span> Keluarga</span></a></li>
           <li><a href="#" @click="goPage('/pengajuan/individu')" data-toggle="tab"><span> Individu</span></a></li></li>
         </ul>
         <div class="tab-content">
            <router-view></router-view>
         </div>
      </div>
      
   
    </div>
  </div>
</template>

<script>

export default {
  data () {
    return {

     }
  },
  computed: {},
  ready () {
    this.$router.go({path: '/pengajuan/kawasan'})
  },
  attached () {},
  methods: {
    goPage: function(page){
      event.preventDefault()
      this.$router.go({path: page})
    }
  },
  components: {
    
  },
  route: {
      activate: function(t) {
          this.$parent.$parent.$data.title = 'Pengajuan Program Intervensi';
          t.next();
      }
  },
}
</script>

<style lang="css">
</style>
