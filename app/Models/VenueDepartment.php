<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueDepartment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function venue()
    {
        return $this->belongsTo('App\Models\Venue','venue_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id');
    }
}
