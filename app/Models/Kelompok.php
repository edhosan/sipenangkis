<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model {

	protected $table = 'm_kelompok';

	public function penerima()
    {
        return $this->hasMany('App\Models\KelompokPenerima','m_kelompok_id');
    }

    public function desa()
    {
      return $this->belongsTo('App\Models\Desa','m_desa_id');
    }

    public function intervensi()
    {
      return $this->morphMany('App\Models\ProsesIntervensi','penerima');
    }

}
