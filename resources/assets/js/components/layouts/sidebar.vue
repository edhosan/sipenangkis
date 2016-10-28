<template>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img :src="IMG_USER" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>TKPKD Kab. Berau</p>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <li class="treeview" v-for="row in menus | filterBy 'admin' in 'roles'">
          <a v-link="{ path: row.link }">
            <i class="fa {{ row.icon }}"></i>
            <span>{{ row.name }}</span>
            <i v-show="row.child" class="fa fa-angle-left pull-right" ></i>
          </a>
          <ul v-show="row.child" class="treeview-menu" >
            <li v-for="child in row.child | filterBy 'admin' in 'roles'">
              <a v-link="{ path: child.link }">
                <i class="fa {{ child.icon }}" ></i>{{ child.name }}
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
</template>

<script>

export default{
  data(){
    return{
      IMG_USER: this.$root.$config.API + '/bower_components/AdminLTE/dist/img/logo.png',
      menus:[]
    }
  },

  methods:{

  },

  ready: function(){
    this.$set('menus',this.$parent.menus)
  }
}

</script>

<style>
.v-link-active {
  color: orange !important;
}
</style>
