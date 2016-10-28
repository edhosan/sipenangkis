<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'm_jawaban';

    public function indikator()
    {
      return $this->belongsTo('App\Models\Indikator','m_indikator_id');
    }
}
