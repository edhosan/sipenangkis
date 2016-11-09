<template>
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>SI</b>PENANGKIS</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Silahkan masukkan user dan password anda.</p>

      <form  v-on:submit.prevent="login()">
        <div class="form-group has-feedback" v-bind:class="{ 'has-error':!validation.userid }">
          <input type="text" class="form-control" placeholder="User id" v-model="credential.userid">
          <span class="glyphicon ion-person form-control-feedback"></span>
          <span class="help-block" v-if="!validation.userid">User id harus diisi.</span>
        </div>
        <div class="form-group has-feedback" v-bind:class="{ 'has-error':!validation.password }">
          <input type="password" class="form-control" placeholder="Password" v-model="credential.password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          <span class="help-block" v-if="!validation.password">Password harus diisi.</span>
        </div>
        <div class="row">         
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" :disabled="!isValid">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
</template>

<script>

module.exports = {
    name: 'Login',
    data: function() {
        return {
            credential:{
              userid:'',
              password:''
            },
            error: false
        }
    },
    computed:{
      validation: function(){
        return{
          userid:!!this.credential.userid.trim(),
          password:!!this.credential.password.trim()
        }
      },

      isValid: function(){
        var validation = this.validation
        return Object.keys(validation).every(function(key){
          return validation[key]
        })
      }
    },

    methods: {
        login: function() {
            event.preventDefault()
            var user = this.credential
            this.$Progress.start()

            this.$http.post(this.$root.$config.API + '/api/signin',user).then((response)=>{
              this.$parent.$data.login = false
              this.$parent.$data.body_class = "hold-transition skin-green sidebar-mini"
              localStorage.setItem('id_token', response.data.meta.token)
              localStorage.setItem('userid', response.data.data.user.userid)
              localStorage.setItem('name', response.data.data.user.name)
              this.$Progress.finish()
            },(error)=>{
              toastr.error('User id atau password anda salah.', 'Error', {timeOut: 3000})
              console.log(error)
              this.$Progress.fail()
            })

        }
    }
}
</script>
