<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokPenerima extends Model {

	protected $table = 'm_kelompok_penerima';

	public function kelompok()
    {
        return $this->belongsTo('App\Models\Kelompok','m_kelompok_id');
    }

    public function keluarga()
    {
        return $this->belongsTo('App\Models\Keluarga','penerima_id');
    }

}
