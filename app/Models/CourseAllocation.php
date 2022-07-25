<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAllocation extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function semester()
    {
        return$this->belongsTo('App\Models\Semester','semester_id');
    }
    public function course()
    {
        return$this->belongsTo('App\Models\Course','course_id');
    }
    public function lecturer()
    {
        return$this->belongsTo('App\Models\Lecturer','lecturer_id');
    }
    public function department()
    {
        return$this->belongsTo('App\Models\Department','department_id');
    }

}
