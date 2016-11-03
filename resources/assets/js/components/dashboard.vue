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
          <h3 class="box-title">Jumlah Keluarga Penerima Manfaat Per Wilayah</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="chart">
              <canvas id="bar" width="400" height="400"></canvas>
            </div>              
          </div>
        </div>
      </div>
    </div>
</div>

</template>

<script>

var Chart = require('chart.js')

export default {

    data(){
      return {
        totalKluster:[],
        kecamatan:[],
        datasets:[],
        data_chart:{ label:'', backgroundColor:'', borderWidth: 1, data:[] }
      }      
    },
    computed: {
    },
    ready: function(){
      this.fetchData()      
    },
    component:{ 

    },
    methods:{
      fetchData: function(page) {
        var self = this
        this.$Progress.start()
        var url = this.$root.$config.API + '/api/dashboard'
        this.$http.get(url).then((response)=>{
          this.$set('totalKluster', response.data.total_miskin)

          var kec = response.data.chart_wilayah.data['Sangat Miskin']    
          self.kecamatan = []
          for(var k in kec){
            self.kecamatan.push(k)
          }

          var chart_data = response.data.chart_wilayah.data
          this.datasets = []
          var r = 0
          var g = 0
          var b = 0
          for(var d in chart_data){
            this.data_chart.label = d

            r = Math.floor((Math.random() * 255) + 1)
            g = Math.floor((Math.random() * 255) + 1)
            b = Math.floor((Math.random() * 255) + 1)
            this.data_chart.backgroundColor = "rgba("+r+","+g+","+b+",0.5)"

            for(var data in chart_data[d]){
              var kriteria = chart_data[d]
              this.data_chart.data.push(kriteria[data])
            }

            this.datasets.push(this.data_chart)
            this.data_chart = { label:'', backgroundColor:'', data:[] }
          }

          this.chartWilayah(self.kecamatan, this.datasets)

          this.$Progress.finish()
        },(error)=>{
          console.log(error)
          this.$Progress.fail()
        })
      },

      chartWilayah: function(kec_list, ds){

        var ctx = document.getElementById("bar")
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: kec_list,
                datasets: ds
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:false
                        }
                    }]
                }
            }
          })
      }
    },
    route: {
        activate: function(t) {
            this.$parent.$parent.$data.title = 'Dashboard';
            t.next();
        }
    }
}
</script>
