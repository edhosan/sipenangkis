var mixin = {
  methods:{
    sexLabel: function(value){
      if(value=='L'){
        return 'Laki-laki'
      }else if(value == 'P'){
        return 'Perempuan'
      }
    },
    hubLabel: function(value){
      var label = ''

      switch (value) {
        case '01':
          label = 'Kepala Keluarga'
          break;
        case '02':
          label = 'Suami'
          break;
        case '03':
          label = 'Istri'
          break;
        case '04':
          label = 'Anak'
          break;
        case '05':
          label = 'Menantu'
          break;
        case '06':
          label = 'Cucu'
          break;
        case '07':
          label = 'Orangtua'
          break;
        case '08':
          label = 'Mertua'
          break;
        case '09':
          label = 'Famili Lain'
          break;
        case '10':
          label = 'Pembantu'
          break;
        case '11':
          label = 'Lainnya'
          break;
        default:
          label = ''
      }

      return label
    },
    agamaLabel: function(val){
      var label = ''
      switch (val) {
        case '1':
          label = 'Islam'
          break;
        case '2':
          label = 'Kristen'
          break;
        case '3':
          label = 'Protestan'
          break;
        case '4':
          label = 'Hindu'
          break;
        case '5':
          label = 'Budha'
          break;
        case '6':
          label = 'Konghucu'
          break;
        default:
          label = ''
      }

      return label
    },
    statusLabel: function(val){
      var label = ''
      switch (val) {
        case '1':
          label = 'Belum Kawin'
          break;
        case '2':
          label = 'Kawin'
          break;
        case '3':
          label = 'Cerai Hidup'
          break;
        case '4':
          label = 'Cerai Mati'
          break;
        case '5':
          label = 'Hidup Bersama'
          break;
        default:
          label = ''
      }
      return label
    },
    kartuLabel: function(val){
      var label = ''
      switch (val) {
        case '0':
          label = 'Tidak Ada'
          break;
        case '1':
          label = 'KTP'
          break;
        case '2':
          label = 'SIM'
          break;
        case '3':
          label = 'Kartu Pelajar'
          break;
        case '4':
          label = 'Akta Lahir'
          break;
        default:
          label = ''
      }
      return label
    },
    disabilitasLabel: function(val){
      var label = ''
      switch (val) {
        case '00':
          label = 'Tidak Disabilitas'
          break;
        case '01':
          label = 'Penglihatan'
          break;
        case '02':
          label = 'Pendengaran'
          break;
        case '03':
          label = 'Komunikasi'
          break;
        case '04':
          label = 'Cacat Tubuh'
          break;
        case '05':
          label = 'Cacat Mental'
          break;
        default:
          label = ''
      }
      return label
    }
  }
};
export default mixin;
