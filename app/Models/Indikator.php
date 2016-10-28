<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $table = "m_indikator";

    protected $fillable = ["name","pil_1","bobot_1","pil_2","bobot_2","pil_3","bobot_3","pil_4","bobot_4"];

    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriIndikator','m_kategori_indikator_id');
    }

    public function jawaban()
    {
      return $this->hasMany('App\Models\Jawaban','m_indikator_id');
    }

    public function hasilIndikator()
    {
      return $this->hasMany('App\Models\IndikatorPenerimaManfaat','m_indikator_id');
    }
}
