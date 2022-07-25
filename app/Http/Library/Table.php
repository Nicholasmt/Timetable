<?php
  namespace App\Http\Library;

  use App\Models\Timetable_Data;
  use App\Models\Monitoring_Table;
  use App\Models\CourseAllocation;
  use Carbon\Carbon;
  use DB;

  class Table
  {
    public $semester;
    public $table_type;
    public $table_model;

    function __construct($semester,$table_type)
    {
       $this->semester=$semester;
       if($table_type=="t" || $table_type=="T")
       {
        $this->table_type="timetable_data_";
       }
       elseif($table_type=="m" || $table_type=="M")
       {
        $this->table_type="monitoring_table_";
       }
    }

    function set_model()
    {
        $table_data="";
        if($this->table_type=="monitoring_table_")
        {
           $table_data=new Monitoring_Table();
           $table_data->semester=$this->semester;
        }
        elseif($this->table_type=="timetable_data_")
        {
           $table_data=new Timetable_Data();
           $table_data->semester=$this->semester;
        }
        //dd($table_data);

       $reflection = new \ReflectionClass($table_data);
       $property = $reflection->getProperty('table');
       $property->setAccessible(true);
       $property->setValue($table_data, $this->table_type.$this->semester);
       $this->table_model=$table_data;
       return $table_data;
    }

    function has_conflict($data)
    {
       $query=$this->table_model->where('venue_id',$data[0])
       ->where('week_day',$data[1])
       ->where(function($q) use ($data){
            $q->where(function($qa) use ($data){
              $qa->whereBetween('start_time',[$data[2],$data[3]]);})
            ->orWhere(function($qb) use ($data){
              $qb->whereBetween('end_time',[$data[2],$data[3]]);
           });
       })->get();
       if($query->count()>=1)
       {
        return true;
       }
       return false;
    }

    function has_reached_maximum_assignment($course_allocation, $start_time, $end_time)
    {
       $query=$this->table_model->where('course_allocation_id',$course_allocation)->get();

       $incoming_start = Carbon::parse($start_time);
       $incoming_end = Carbon::parse($end_time);
       $incoming_duration = $incoming_end->diffInMinutes($incoming_start);
       $incoming_duration=ceil($incoming_duration/60);
       $total_duration=0;
       if($query->count()<=0)
       {
          $unit=CourseAllocation::find($course_allocation)->course->unit;
          if($incoming_duration > $unit)
          {
           return (object)[
               'status'=>true,
               'message'=>'You cannot allocate this course for more than '.$unit.' Hour(s) on the timetable'
           ];
          }
          else
          {
            return (object)[
                'status'=>false,
                'message'=>'You can assign this course to the timetable'
            ];
          }
       }
       $unit=$query[0]->allocation->course->unit;
       if($query->count()>=2)
       {
        return (object)[
            'status'=>true,
            'message'=>'You cannot allocate this course more than twice a week on the time table'
        ];
       }
       foreach($query as $data)
       {
        $start = Carbon::parse($data->start_time);
        $end = Carbon::parse($data->end_time);
        $duration = $end->diffInMinutes($start);
        $duration=ceil($duration/60);
        $total_duration+=$duration;
        $total_expected_duration=$incoming_duration+$total_duration;
        if($total_expected_duration>$unit)
        {
            $excess=$total_expected_duration-$unit;
            return (object)[
                'status'=>true,
                'message'=>'Could not assign because this '.$unit.' unit course has been previously allocated for '.$duration.' Hour(s) on the timetable, it will exceed its expected duration by '.$excess.' Hour(s) if assigned'
            ];
        }
        elseif($total_expected_duration<=$unit)
        {
            return (object)[
                'status'=>false,
                'message'=>'You can assign this course to the timetable'
            ];
        }
       }
    }

  }

?>
