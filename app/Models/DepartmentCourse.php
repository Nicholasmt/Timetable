<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCourse extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function course()
    {
       return $this->belongsTo('App\Models\Course','course_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id');
    }
}
