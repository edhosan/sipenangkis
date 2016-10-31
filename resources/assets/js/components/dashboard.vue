<template>
<div class="row">
  <template v-for="total in totalKluster">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon {{ total.class }}"><i class="{{ total.icon }}"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">{{ total.name }}</span>
          <span class="info-box-number">{{ total.total }} <small>KK</small></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </template>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Jumlah Keluarga Miskin Per Wilayah</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </div>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="chart">
              <canvas id="barChart" style="height:300px"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

</template>

<script>

module.exports = {
    name: "Dashboard",
    data: function() {
        return {
          totalKluster:[]
        }
    },
    ready: function(){
      this.fetchData()
      
    },
    component:{ 
    
    },
    methods:{
      fetchData: function(page) {
        this.$Progress.start()
        var url = this.$root.$config.API + '/api/dashboard'
        this.$http.get(url).then((response)=>{
          this.$set('totalKluster', response.data)
          this.$Progress.finish()
        },(error)=>{
          console.log(error)
          this.$Progress.fail()
        })
      },
    },
    route: {
        activate: function(t) {
            this.$parent.$parent.$data.title = 'Dashboard';
            t.next();
        }
    }
}
</script>
