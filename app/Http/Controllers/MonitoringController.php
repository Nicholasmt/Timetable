<?php

namespace App\Http\Controllers;
use App\Models\Venue;
use App\Models\Semester;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Library\Table;
use App\Http\Library\Util;
use App\Models\Monitoring_Table;


use DB;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
            ];
          $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/chosen/chosen.jquery.js'
             ];
        $semesters = Semester::where(['active'=>1,'current'=>1])->get();
        $venues = Venue::where('active',1)->get();
        return view('monitoring_officer.monitor.index',compact('venues','semesters','css','js'));
    }

    public function show_timetable($timetable_id, $semester_id)
    {
        $timetable_data=new Table($semester_id,'t');
        $timetable_model=$timetable_data->set_model();
        $timetable=$timetable_model->where('id',$timetable_id)->first();
        return view('monitoring_officer.monitor.show',compact('timetable','semester_id'));
    }

    public function load_timetable(Request $request)
    {
        $count = 1;
        $timetable_data=new Table($request->semester,'t');
        $timetable_model=$timetable_data->set_model();
        $weekday=Util::week_day(date('w'));
        $timetables=$timetable_model->where(['venue_id'=>$request->venue,'week_day'=>$weekday])->get();
         return view('monitoring_officer.monitor.load-timetable',compact('timetables','count'))->render();
    }

    public function monitoring_report()
    {
        $css=[
            'css/plugins/dataTables/datatables.min.css'
            ];
          $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js'
             ];
          $count = 1;
          $semesters = Semester::where('active',1)->get();
          return view('monitoring_officer.monitoring-reports.index',compact('semesters','count','js','css'));

    }

 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $rules=[
                'no_of_student'=>'required',
                'comments'=>'required',
                'observation_key'=>'required'
                ];
        $validate = Validator::make($request->all(), $rules);
        if($validate->fails())
        {
        return back()->withErrors($validate->errors('error'));
        }
        else
        {
            $monitoring_data=new Table($request->semester,'m');
            $monitoring_model=$monitoring_data->set_model();
            $monitoring_data_model=$monitoring_model->where('timetable_data_id',$request->timetable_data_id)->where('date_monitored',date('Y-m-d'))->first();

            if($monitoring_data_model!=null && $monitoring_data_model->count()>=1)
            {
                return back()->withErrors("This Venue and Class has been monitored today");
            }

            $monitored_by = session()->get('id');
            $timetable_data=new Table($request->semester,'t');
            $timetable_model=$timetable_data->set_model();
            $timetable_data_model=$timetable_model->where('id',$request->timetable_data_id)->first();
            $data=[
                'timetable_data_id'=>$request->timetable_data_id,
                'monitored_by'=>$monitored_by,
                'no_of_students'=>$request->no_of_student,
                'venue_id'=>$timetable_data_model->venue_id,
                'department_id'=>$timetable_data_model->department_id,
                'date_monitored'=>date('Y-m-d'),
                'time_monitored'=>date('h:i:s'),
                'comments'=>$request->comments,
                'observation_key'=>$request->observation_key,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ];
            //dd($data);
            DB::table('monitoring_table_'.$request->semester)->insert($data);
            return back()->with('success','submitted!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($monitoring)
    {
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
             ];
          $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/chosen/chosen.jquery.js'
            ];
         $count =1;
         $fliterd_reports = null;
         $departments = Department::where('active',1)->get();
         $venues = Venue::where('active',1)->get();
         $monitoring_data=new Table($monitoring,'m');
         $monitoring_model=$monitoring_data->set_model();
         $timetable_data=new Table($monitoring,'t');
         $timetable_model=$timetable_data->set_model();
         $reports=$monitoring_model->get();
          return view('monitoring_officer.monitoring-reports.show',compact('reports','fliterd_reports','departments','css','js','count','venues','monitoring'));
    }

    public function fliter_report(Request $request)
    {
         $departments = Department::where('active',1)->get();
         $venues = Venue::where('active',1)->get();
         $count =1;
         $reports = null;
         $monitoring = $request->monitoring_table_id;
         $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
             ];
          $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/chosen/chosen.jquery.js'
            ];

        if($request->has('byDepartment') || ($request->has('byVenue')) || ($request->has('byDate')) || ($request->has('today')))
        {
            $monitoring_data=new Table($request->monitoring_table_id,'m');
            $monitoring_model=$monitoring_data->set_model();
            $fliterd_reports=$monitoring_model->get();
            $fliterd_reports = DB::table('monitoring_table_'.$request->monitoring_table_id)
                                 ->where('department_id','LIKE', '%'.$request->department.'%')->get();
            $fliterd_reports = DB::table('monitoring_table_'.$request->monitoring_table_id)
                                 ->where('venue_id','LIKE', '%'.$request->venue.'%')->get();
            $fliterd_reports = DB::table('monitoring_table_'.$request->monitoring_table_id)
                                 ->where('date_monitored','LIKE', '%'.$request->date.'%')->get();
            $fliterd_reports = DB::table('monitoring_table_'.$request->monitoring_table_id)
                                 ->where('date_monitored','LIKE', '%'.date('Y-m-d').'%')->get();

            return view('monitoring_officer.monitoring-reports.show',compact('fliterd_reports','departments','venues','css','js','monitoring','count','reports'));
        }
         else
        {
           return back()->with('error','Noting to Fliter...');
        }
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
