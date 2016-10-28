<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{title}}
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <router-view class="view" keep-alive></router-view>
        <vue-progress-bar></vue-progress-bar>
    </section>
    <!-- /.content -->
  </div>
</template>

<script>

export default{
  data(){
    return{
    }
  },
  props:{
    title: String
  },
  ready:function(){
  }
}

</script>

<style lang="css">
.view {
  transition: all .5s ease;
}

.view-enter, .view-leave {
  opacity: 0;
  transform: translate3d(10px, 0, 0);
}

[v-cloak] {
  display: none;
}
</style>
