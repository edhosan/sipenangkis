<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = "m_desa";

    protected $fillable = ["name"];

    public function kecamatan()
    {
      return $this->belongsTo('App\Models\Kecamatan','m_kecamatan_id');
    }

    public function intervensi()
    {
      return $this->morphMany('App\Models\ProsesIntervensi','penerima');
    }
}
