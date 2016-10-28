<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriIndikator extends Model
{
    protected $table = "m_kategori_indikator";

    protected $fillable = ["name"];

    public function indikator()
    {
      return $this->hasMany('App\Models\Indikator','m_kategori_indikator_id');
    }

    public function kluster()
    {
      return $this->belongsToMany('App\Models\Kluster','m_kluster_m_kategori','m_kategori_id','m_kluster_id');
    }

    public function jawaban()
    {
      return $this->hasManyThrough('App\Models\Jawaban','App\Models\Indikator','m_kategori_indikator_id','m_indikator_id','id');
    }
}
