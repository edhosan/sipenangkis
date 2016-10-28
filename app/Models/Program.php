<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = "m_program";

    protected $fillable = ["name"];

    public function stakeholders()
    {
      return $this->belongsToMany('App\Models\Stakeholders','m_program_stakeholder','m_program_id','m_stakeholders_id');
    }

    public function sumberDana()
    {
      return $this->belongsToMany('App\Models\SumberDana','m_sumber_dana_program','m_program_id','m_sumber_dana_id');
    }

    public function intervensi()
    {
      return $this->hasMany('App\Models\Intervensi','m_program_id');
    }
}
