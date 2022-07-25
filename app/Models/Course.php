<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function department()
    {
    return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function department_course()
    {
        return $this->hasMany('App\Models\DepartmentCourse');
    }

    public function get_full_title()
    {
        return $this->code." ".$this->title;
    }

    public function bulletin()
    {
        return $this->belongsTo('App\Models\Bulletin','bulletin_id');
    }
}
