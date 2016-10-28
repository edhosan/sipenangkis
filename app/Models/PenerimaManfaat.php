<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaManfaat extends Model
{
  protected $table = 'm_penerima_manfaat';

  public function desa()
  {
    return $this->belongsTo('App\Models\Desa','m_desa_id');
  }

  public function kecamatan()
  {
    return $this->desa()->kecamatan();
  }

  public function anggotaKeluarga()
  {
    return $this->hasMany('App\Models\Keluarga','m_penerima_manfaat_id');
  }

  public function hasilIndikator()
  {
    return $this->hasMany('App\Models\PenilaianPenerimaManfaat','m_pm_id');
  }

  public function intervensi()
  {
    return $this->morphMany('App\Models\ProsesIntervensi','penerima');
  }
}
