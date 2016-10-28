<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SasaranIntervensi extends Model
{
    protected $table = 'm_sasaran_intervensi';

    public function intervensi()
    {
      return $this->hasMany('App\Models\Intervensi', 'm_sasaran_intervensi_id');
    }
}
