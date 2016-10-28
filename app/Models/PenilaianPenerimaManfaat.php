<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianPenerimaManfaat extends Model
{
  protected $table = 't_pm_penilaian';

  public function penerimaManfaat()
  {
    return $this->belongsTo('App\Models\PenerimaManfaat','m_pm_id');
  }

  public function rincianIndikator()
  {
    return $this->hasMany('App\Models\IndikatorPenerimaManfaat','t_pmp_id');
  }


}
