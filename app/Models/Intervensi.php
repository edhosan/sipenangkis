<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervensi extends Model
{
    protected $table = "m_intervensi";

    protected $fillable = ["name"];

    public function tujuan()
    {
      return $this->hasMany('App\Models\TujuanIntervensi','m_intervensi_id');
    }

    public function program()
    {
      return $this->belongsTo('App\Models\Program','m_program_id');
    }

    public function sasaran()
    {
      return $this->belongsTo('App\Models\SasaranIntervensi', 'm_sasaran_intervensi_id');
    }

    public function prosesIntervensi()
    {
      return $this->hasMany('App\Models\ProsesIntervensi','m_intervensi_id');
    }
}
