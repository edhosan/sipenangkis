<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorPenerimaManfaat extends Model
{
    protected $table = 't_pm_indikator';

    public function hasilIndikator()
    {
      return $this->belongsTo('App\Models\PenilaianPenerimaManfaat','t_pmp_id');
    }

    public function indikator()
    {
      return $this->belongsTo('App\Models\Indikator','m_indikator_id');
    }
}
