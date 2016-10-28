<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'm_kecamatan';

    protected $fillable = ["name"];

    public function desa()
    {
        return $this->hasMany('App\Models\Desa','m_kecamatan_id');
    }

    public function penerimaManfaat()
    {
      return $this->hasManyThrough('App\Models\PenerimaManfaat','App\Models\Desa','m_kecamatan_id','m_desa_id','id');
    }

}
