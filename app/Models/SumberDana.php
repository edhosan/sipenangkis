<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    protected $table = "m_sumber_dana";

    protected $fillable = ["name"];

    public function program()
    {
      return $this->belongsToMany('App\Models\Program','m_sumber_dana_program','m_sumber_dana_id','m_program_id');
    }
}
