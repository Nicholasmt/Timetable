<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Library\Table;

class Monitoring_Table extends Model
{
    use HasFactory;

    public $semester;

    function __construct()
    {
      //$this->semester=$semester;
      parent::__construct();
      $this->table="timetable_data_".$this->semester;
    }

    function timetable()
    {
      return $this->belongsTo(\App\Models\Timetable_Data::class,'timetable_data_id','id');
    }

    function timetable2()
    {
        $semester=explode('_',$this->getTable());
        $timetable_data=new Table($semester[2],'t');
        $timetable_model=$timetable_data->set_model();
        return $timetable_model->where('id',$this->timetable_data_id)->first();

    }

    function who_monitored()
    {
        return $this->belongsTo('App\Models\User','monitored_by');
    }

    protected $casts = [
      'date_monitored' => 'date',
       
  ];

}
