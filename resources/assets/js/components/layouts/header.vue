<template>

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>PK</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SI</b>PENANGKIS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img :src="IMG_USER" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img :src="IMG_USER" class="img-circle" alt="User Image">

                <p>
                  {{ name }}
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" v-on:click="signout">Keluar</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

</template>

<script>

export default {
  data: function () {
    var image ={
      IMG_USER: this.$root.$config.API + '/bower_components/AdminLTE/dist/img/teacher.png',
      name: localStorage.getItem("name")
    }
    return image
  },
  computed: {},
  ready: function (){

  },
  attached () {},
  methods: {
    signout: function(){
      this.$parent.$data.login = true
      this.$parent.$data.body_class = "hold-transition login-page"
      localStorage.removeItem('id_token')
      localStorage.removeItem('userid')
      localStorage.removeItem('name')
    }
  },
  components: {}
}
</script>

<style lang="css">
</style>
