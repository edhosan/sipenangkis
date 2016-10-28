<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pekerjaan;

class Pekerjaan extends Model
{
  protected $table = "m_pekerjaan";

  public function keluarga()
  {
    return $this->hasMany('App\Models\Keluarga', 'm_pekerjaan_id');
  }

}
