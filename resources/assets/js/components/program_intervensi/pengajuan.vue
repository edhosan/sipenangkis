<template lang="html">
  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary">
           <div class="box-header with-border">
             <h3 class="box-title">Sasaran Intervensi</h3>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
             <ul class="treeview">
               <li><a href="#"><span> Kawasan</span></a></li>
               <li><a href="#"><span> Kelompok</span></a></li>
               <li><a v-link="{ path: '/pengajuan/keluarga' }"><span> Keluarga</span></a></li>
               <li><a href="#"><span> Individu</span></a></li></li>
             </ul>
           </div>
           <!-- /.box-body -->
         </div>
    </div>
    <div class="col-md-9">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
var keluarga = require('./keluarga.vue');

export default {
  data () {
    return {

     }
  },
  computed: {},
  ready () {

  },
  attached () {},
  methods: {
    tabClick:function(tab){
      switch (tab) {
        case '2':
          break;
        case '3':

          break;
        default:
      }
    },

  },
  components: {
    keluarga
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
