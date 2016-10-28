<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany('App\Models\Role');
    }

    public function prosesIntervensi()
    {
      return $this->hasMany('App\Models\ProsesIntervensi','userid');
    }

    public function stakeholder()
    {
      return $this->belongsTo('App\Models\Stakeholders','m_stakeholder_id');
    }
}
