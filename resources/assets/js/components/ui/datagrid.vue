<template lang="html">
<table class="table table-bordered table-striped dataTable">
  <thead>
    <tr>
      <th class="sorting" v-for="column in grid.header">
        {{ column }}
      </th>
    </tr>
  </thead>
</table>
</template>

<script>
export default {
  data () {
    return {}
  },
  props:{
    grid: Object,
    url: String
  },
  computed: {},
  ready () {},
  attached () {},
  methods: {
    fetchData: function(page){
      this.$Progress.start()
      this.$http.get(url).then((response)=>{
        this.$set('items', response.data.data)
      //  this.$set('pagination', response.data)
        this.$Progress.finish()
      },(error)=>{
        console.log(error)
        this.$Progress.fail()
      })
    }
  },
  components: {}
}
</script>

<style lang="css">
th.active {
  color: #fff;
}

th.active .arrow {
  opacity: 1;
}

.arrow {
  display: inline-block;
  vertical-align: middle;
  width: 0;
  height: 0;
  margin-left: 5px;
  opacity: 0.66;
}

.arrow.asc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-bottom: 4px solid #fff;
}

.arrow.dsc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #fff;
}
</style>
