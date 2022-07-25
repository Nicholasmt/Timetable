<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function users()
    {
       return $this->belongsTo('App\Models\Users', 'monitored_by');
    }
}
