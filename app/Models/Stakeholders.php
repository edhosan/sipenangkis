<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stakeholders extends Model
{
    protected $table = "m_stakeholders";

    protected $fillable = ["name"];

    public function program()
    {
      return $this->belongsToMany('App\Models\Program','m_program_stakeholder','m_stakeholders_id','m_program_id');
    }

    public function user()
    {
      return $this->hasMany('App\Models\User','m_stakeholders_id');
    }
}
