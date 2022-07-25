<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'start' => 'datetime',
        'end'=>'datetime'
    ];

    public function allocation_submission()
    {
        return $this->hasOne('App\Models\AllocationSubmission','semester_id');
    }

    public function course_allocation()
    {
        return $this->hasMany('App\Models\CourseAllocation','semester_id');
    }
}
