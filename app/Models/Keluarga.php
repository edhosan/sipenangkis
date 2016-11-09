<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
  const ISLAM = '1';
  const KRISTEN = '2';
  const PROTESTAN = '3';
  const HINDU = '4';
  const BUDHA = '5';
  const KONGHUCU = '6';

  public static $agama = [
    self::ISLAM => 'Islam',
    self::KRISTEN => 'Kristen',
    self::PROTESTAN => 'Protestan',
    self::HINDU => 'Hindu',
    self::BUDHA => 'Budha',
    self::KONGHUCU => 'Konghucu'
  ];

  protected $table = 'm_penerima_manfaat_keluarga';

  public function penerimaManfaat()
  {
    return $this->belongsTo('App\Models\PenerimaManfaat','m_penerima_manfaat_id');
  }

  public function pekerjaan()
  {
    return $this->belongsTo('App\Models\Pekerjaan','m_pekerjaan_id');
  }

  public function pendidikan()
  {
    return $this->belongsTo('App\Models\Pendidikan','m_pendidikan_id');
  }

  public function intervensi()
  {
    return $this->morphMany('App\Models\ProsesIntervensi','penerima');
  }
}
