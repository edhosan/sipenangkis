<template lang="html">
<div class="row">
  <div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#" @click="goPage('/rtm/tempat/'+$route.params.action+'/'+$route.params.id)" data-toggle="tab">Domisili</a></li>
        <li><a href="#" @click="goPage('/rtm/anggota/'+$route.params.action+'/'+$route.params.id)" data-toggle="tab">Anggota Keluarga</a></li>
        <li><a href="#tab_3" data-toggle="tab" v-on:click="tabClick('3')">Indikator</a></li>
        <li class="pull-right"><a href="#" v-on:click="tabClick('4')" class="text"><i class="fa fa-file"></i>&nbsp;&nbsp;Entry Data Baru</a></li>
      </ul>
      <div class="tab-content">
         <router-view></router-view>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
</template>

<script>

export default {
  data () {
    return {
      isFreeze: false,
      penerima_manfaat_id:null,
      penilaian_id: null,
      isActiveTab: false
    }
  },
  computed: {

  },
  ready () {
   this.$router.go({path: page})
  },
  attached () {},
  methods: {
    goPage: function(page){
      event.preventDefault()
      this.$router.go({path: '/rtm/tempat/'+$route.params.action+'/'+$route.params.id})
    },
  },
  components: {
  },
  route: {
      activate: function(t) {        
          this.$parent.$parent.$data.title = 'Rumah Tangga Penerima Manfaat';
          t.next();
      }
  },
}
</script>

<style lang="css">
</style>
