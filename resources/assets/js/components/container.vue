<template>
<div v-if="!login" class="wrapper">
  <app-header></app-header>
  <app-sidebar></app-sidebar>
  <app-content :title="title"></app-content>
  <app-footer></app-footer>
  <app-rightbar></app-rightbar>

</div>

<div v-if='login'>
    <app-login></app-login>
</div>
</template>

<script>

module.exports = {
    name: 'Container',
    data: function(){
      return {
        login: true,
        title: null,
        body_class: 'hold-transition login-page',
        menus: require('./config/menus.js')
      }
    },
    replace: false,
    components: {
      'app-header' : require('./layouts/header.vue'),
      'app-sidebar' : require('./layouts/sidebar.vue'),
      'app-content' : require('./content.vue'),
      'app-footer' : require('./layouts/footer.vue'),
      'app-rightbar' : require('./layouts/rightbar.vue'),
      'app-login': require('./auth/login.vue')
    },
    ready: function(){
      if(localStorage.getItem('id_token')){
        this.login = false
        this.body_class = "hold-transition skin-green sidebar-mini "
      }

    }
}
</script>
