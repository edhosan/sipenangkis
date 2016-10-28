<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanIntervensi extends Model
{
    protected $table = "m_tujuan_intervensi";

    protected $fillable = ["name"];

    public function intervensi()
    {
      return $this->belongsTo('App\Model\Intervensi','m_intervensi_id');
    }
}
