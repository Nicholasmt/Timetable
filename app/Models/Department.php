<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function venue()
    {
        return $this->hasMany('App\Models\Venue','department_id');
    }

    public function department_course()
    {
        return $this->hasMany('App\Models\DepartmentCourse');
    }
}
