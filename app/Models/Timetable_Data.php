<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable_Data extends Model
{
    use HasFactory;

    public $semester;

    function __construct()
    {
      $this->semester;
      $this->table="timetable_data_".$this->semester;
    }

    function allocation()
    {
        return $this->belongsTo('App\Models\CourseAllocation','course_allocation_id');
    }

    function venue()
    {
        return $this->belongsTo('App\Models\Venue','venue_id');
    }

    function department()
    {
        return $this->belongsTo('App\Models\Department','department_id');
    }

    function who_created()
    {
        return $this->belongsTo('App\Models\User','created_by');
    }

    function who_updated()
    {
        return $this->belongsTo('App\Models\User','last_updated_by');
    }


}
