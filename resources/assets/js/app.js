
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

 var Vue = require('vue');
 var Router = require('vue-router');
 var App = require('./components/container.vue');
 const vueConfig = require('vue-config');
 var Resource = require('vue-resource');
 var moment = require('vue-moment');
 var VuetablePagination = require('vuetable/src/components/VuetablePaginationBootstrap.vue')
 import VueProgressBar from 'vue-progressbar'


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

var base_url = document.querySelector('#base_url').getAttribute('value');
const configs = {
  API:  base_url
}

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

 Vue.use(vueConfig, configs)
 Vue.use(Router)
 Vue.use(Resource)
 Vue.use(moment)

 Vue.component('vuetable-pagination', VuetablePagination)

 Vue.http.options.root = '/root';
 Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token');

Vue.http.interceptors.push((request, next) => {
    next((response)=>{
    });
});

 var router = new Router();

 router.map({
   '/':{
      component: require('./components/dashboard.vue')
   },
   '/users':{
      component: require('./components/auth/users.vue')
   },
   '/roles':{
      component: require('./components/auth/roles.vue')
   },
   '/permission':{
      component: require('./components/auth/permission.vue')
   },
   '/kecamatan':{
      component: require('./components/datamaster/kecamatan.vue')
   },
   '/indikator':{
      component: require('./components/datamaster/kategori_indikator.vue')
   },
   '/stakeholder':{
      component: require('./components/datamaster/Stakeholders.vue')
   },
   '/sumber_dana':{
      component: require('./components/datamaster/sumber_dana.vue')
   },
   '/intervensi':{
      component: require('./components/datamaster/intervensi.vue')
   },
   '/sasaran':{
      component: require('./components/datamaster/sasaran_intervensi.vue')
   },'/pekerjaan':{component: require('./components/datamaster/pekerjaan.vue')},
   '/pendidikan':{
      component: require('./components/datamaster/pendidikan.vue')
   },
   '/program':{
      component: require('./components/datamaster/program.vue')
   },
   '/rtm/:action/:id':{
      component: require('./components/penerima_manfaat/penerima_manfaat.vue')
   },
   '/kluster':{
      component: require('./components/datamaster/kluster.vue')
   },
   '/updating':{
      component: require('./components/penerima_manfaat/updating.vue')
   },
   '/pengajuan':{
     component: require('./components/program_intervensi/pengajuan.vue'),
     subRoutes:{
       '/keluarga': { component: require('./components/program_intervensi/keluarga.vue') },
       '/detail_keluarga/:id': { component: require('./components/program_intervensi/detail_keluarga.vue') },
       '/form_intervensi/:id': { component: require('./components/program_intervensi/form_intervensi.vue') }

     }
    },
    '/export':{component: require('./components/tools/import.vue') },
 })

router.start(App, '#app');
