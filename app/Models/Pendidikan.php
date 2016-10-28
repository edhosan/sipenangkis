<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'm_pendidikan';

    public function keluarga()
    {
      return $this->hasMany('App\Models\Keluarga','m_pendidikan_id');
    }
}
