<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianProsesIntervensi extends Model
{
    protected $table = "t_rincian_intervensi";

    public function prosesIntervensi()
    {
      return $this->belongsTo('App\Models\ProsesIntervensi','t_intervensi_id');
    }
}
