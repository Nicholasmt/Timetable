<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationSubmission extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id');
    }
}
