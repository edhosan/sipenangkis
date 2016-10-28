module.exports = [
  {
      name: 'Dashboard',
      link: '/',
      icon: 'fa-home',
      roles: [
        {name: 'admin'},
        {name: 'manager'}
      ]
  }, {
      name: 'Manajemen User',
      link: '#',
      icon: 'fa-user',
      roles: [
        {name: 'admin'},
        {name: 'manager'}
      ],
      child: [
        {
          name: 'Pengguna',
          link: '/users',
          icon: 'fa-users',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Tipe Pengguna',
          link: '/roles',
          icon: 'fa-gavel',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Hak Akses',
          link: '/permission',
          icon: 'fa-warning',
          roles: [
            {name: 'admin'}
          ]
        }
      ]
  }, {
      name: 'Data Master',
      link: '#',
      icon: 'fa-database',
      roles: [
        {name: 'admin'},
        {name: 'manager'}
      ],
      child: [
        {
          name: 'Kecamatan/Desa',
          link: '/kecamatan',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Indikator',
          link: '/indikator',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Stakeholders',
          link: '/stakeholder',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Program',
          link: '/program',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Sumber Dana',
          link: '/sumber_dana',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Intervensi',
          link: '/intervensi',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Sasaran Intervensi',
          link: '/sasaran',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Pekerjaan',
          link: '/pekerjaan',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Pendidikan',
          link: '/pendidikan',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        },
        {
          name: 'Kluster',
          link: '/kluster',
          icon: 'fa-circle-o',
          roles: [
            {name: 'admin'}
          ]
        }
      ]
  },
  {
    name: 'Penerima Manfaat',
    link: '#',
    icon: 'fa-street-view',
    roles: [
      {name: 'admin'},
      {name: 'manager'}
    ],
    child:[
      {
        name: 'Entry Baru - RTM',
        link: '/rtm/add_rtm/0',
        icon: ' fa-plus-square-o',
        roles: [
          {name: 'admin'}
        ]
      },
      {
        name: 'Pembaharuan Data - RTM',
        link: '/updating',
        icon: ' fa-plus-square-o',
        roles: [
          {name: 'admin'}
        ]
      },
    ]
  },
  {
    name: 'Program Intervensi',
    link: '#',
    icon: 'fa-shield',
    roles: [
      {name: 'admin'},
      {name: 'manager'}
    ],
    child:[
      {
        name: 'Pengajuan Intervensi',
        link: '/pengajuan',
        icon: 'fa-plus-circle',
        roles: [
          {name: 'admin'}
        ]
      }
    ]
  }
]
