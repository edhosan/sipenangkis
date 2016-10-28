<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kluster extends Model
{
    protected $table = 'm_kluster';

    public function kategoriIndikator()
    {
        return $this->belongsToMany('App\Models\KategoriIndikator','m_kluster_m_kategori','m_kluster_id','m_kategori_id');
    }
}
