<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    function role()
    {
      return $this->belongsTo('App\Models\Role','role_id');
    }

    function department()
    {
      return $this->belongsTo('App\Models\Department','department_id');
    }
}
