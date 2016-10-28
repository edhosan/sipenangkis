export default {
  data(){
    return{
      storage: {
        token:'',
        userid:'',
        name:''
      }
    }
  },

  login(userid, password, cb){
    cb = arguments[arguments.length - 1]
    if(this.storage){
      if(cb) cb(true)
      this.onChange(true)
      return
    }
    console.log(this)
    setTimeout(()=>{
      this.$http.post(Vue.root.$config.API + '/api/signin',user).then((response)=>{
        cb({
          authenticated: true,
          token: response.data.meta.token,
          userid: response.data.data.user.userid,
          name: response.data.data.user.name
        })
      },(error)=>{
        cb({authenticated: false})
        console.log(error)
      })
    }, 0)
    pretendRequest(userid, password, (res) =>{
      if(res.authenticated){
        localStorage.setItem('storage', this.storage | json)
        if(cb) cb(true)
        this.onChange(true)
      }else{
        if(cb) cb(false)
        this.onChange(false)
      }

    })


  },

  getToken(){
    return this.storage
  },

  logout(cb){
    localStorage.removeItem('storage')
  },

  loggedIn(){
    return !!this.storage
  },

  onChange(){}
}

function pretendRequest(userid, password, cb){
  /**
   *
   setTimeout(()=>{
     this.vm.http.post(Vue.root.$config.API + '/api/signin',user).then((response)=>{
       cb({
         authenticated: true,
         token: response.data.meta.token,
         userid: response.data.data.user.userid,
         name: response.data.data.user.name
       })
     },(error)=>{
       cb({authenticated: false})
       console.log(error)
     })
   }, 0)

   */
}
