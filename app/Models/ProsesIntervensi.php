<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesIntervensi extends Model
{
    protected $table = "t_intervensi";

    public function intervensi()
    {
      return $this->belongsTo('App\Models\Intervensi','m_intervensi_id');
    }

    public function rincianIntervensi()
    {
      return $this->hasMany('App\Models\RincianProsesIntervensi','t_intervensi_id');
    }

    public function penerima()
    {
      return $this->morphTo();
    }

    public function user()
    {
      return $this->belongsTo('App\Models\User','userid');
    }
}
