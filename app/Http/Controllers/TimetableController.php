<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Department;
use App\Models\CourseAllocation;
use App\Models\Venue;
use App\Models\Semester;
use App\Models\Timetable_Data;
use App\Models\VenueDepartment;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Library\Table;
use DB;
use \Session;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $venues = [];
        if(Session::get('authenticated') == true && (Session::get('privilege')==1||Session::get('privilege')==2))
        {
           $course_allocations=CourseAllocation::where('active',1)->get();
           $venues=VenueDepartment::all();
        }
        elseif(Session::get('authenticated') == true && Session::get('privilege')==3){
            $user_department=Session::get('department_id');
            $course_allocations=CourseAllocation::where(['department_id'=>$user_department,'active'=>1])->get();
            $venues=VenueDepartment::where(['department_id'=>$user_department])->get();
        }
        $course_allocations = CourseAllocation::all();
        $count = 1;
        $semesters = Semester::all();
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/switchery/switchery.css','css/plugins/chosen/bootstrap-chosen.css'
          ];
        $js=[
            'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/chosen/chosen.jquery.js'
        ];

        return view('departmental_officer.timetable.index',compact('departments','semesters','css','js','course_allocations','venues','count'));
    }

    public function set_timetable(Request $request)
    {
        if(session()->get('authenticated') == true && (session()->get('privilege') == 1 || session()->get('privilege') == 2))
        {
            $rules=[
                'semester'=>'required|exists:semesters,id,active,1',
            ];
            $custom_message=[
                'semester.exists'=>'Selected Semester is invalid'];
            $validate = Validator::make($request->all(), $rules,$custom_message);

            if($validate->fails())
            {
            //return back()->withErrors($validate->errors('error'));
            return [
                'status'=>false,
                'message'=>$validate->errors()->all()
            ];
            }
            else
            {
                try{
                    $semester_id=$request->semester;
                    $table_name="timetable_data_".$semester_id;
                    $monitoring_table_name="monitoring_table_".$semester_id;
                    if (!Schema::hasTable($table_name) && !Schema::hasTable($monitoring_table_name)) {
                        Schema::create($table_name, function (Blueprint $table) {
                            $table->id();
                            $table->bigInteger('course_allocation_id')->unsigned();
                            $table->bigInteger('venue_id')->unsigned();
                            $table->enum('week_day',['Mon','Tue','Wed','Thu','Fri','Sat','Sun']);
                            $table->time('start_time');
                            $table->time('end_time');
                            $table->bigInteger('department_id')->unsigned();
                            $table->bigInteger('created_by')->unsigned();
                            $table->bigInteger('last_updated_by')->unsigned()->nullable();
                            $table->smallInteger('active')->default(0);
                            $table->timestamps();

                            $table->foreign('department_id')
                            ->references('id')
                            ->on('departments')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('course_allocation_id')
                            ->references('id')
                            ->on('course_allocations')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('venue_id')
                            ->references('id')
                            ->on('venues')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('last_updated_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');
                        });

                        Schema::create($monitoring_table_name, function (Blueprint $table) use($semester_id) {
                            $table->id();
                            $table->bigInteger('timetable_data_id')->unsigned();
                            $table->bigInteger('monitored_by')->unsigned();
                            $table->bigInteger('venue_id')->unsigned();
                            $table->bigInteger('department_id')->unsigned();
                            $table->smallInteger('no_of_students');
                            $table->date('date_monitored');
                            $table->time('time_monitored');
                            $table->text('comments');
                            $table->enum('observation_key',['A','B','C','D']);
                            $table->timestamps();

                            $table->foreign('timetable_data_id')
                            ->references('id')
                            ->on('timetable_data_'.$semester_id)
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('venue_id')
                            ->references('id')
                            ->on('venues')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('department_id')
                            ->references('id')
                            ->on('departments')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                            $table->foreign('monitored_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade')
                            ->onUpdate('cascade');

                         });

                    }
                    return [
                        'status'=>true,
                        'message'=>'Timetable Set Successfully'
                    ];
                }
                catch(\Exception $e)
                {
                    return [
                        'status'=>false,
                        'message'=>'Timetable Not Set Successfully because: '.$e->getMessage()
                    ];
                }
            }
        }
        else
        {
            return [
                'status'=>false,
                'message'=>'Not authenticated'
            ];
        }
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
            $rules=[
                'course_allocation'=>'required',
                'venue'=>'required',
                'week_day'=>'required',
                'start_time'=>'required',
                'end_time'=>'required',
                'semester'=>'required',
                 'active'=>'required'
                ];

        $custom_message=['active.required'=>'Select Timetable Status'];
        $validate = Validator::make($request->all(), $rules,$custom_message);
        $timetable=new Table($request->semester,'T');
        $timetable->set_model();
        if($timetable->has_conflict([$request->venue,$request->week_day,$request->start_time,$request->end_time,$request->start_time,$request->end_time]))
        {
            $validate->errors()->add('Allocation','A course has been allocated to that venue at that time');
            return back()->withErrors($validate->errors('error'));
        }

        $maximum_assignment=$timetable->has_reached_maximum_assignment($request->course_allocation, $request->start_time, $request->end_time);
        if($maximum_assignment->status===true)
        {
            $validate->errors()->add('Allocation',$maximum_assignment->message);
            return back()->withErrors($validate->errors('error'));
        }

        if($validate->fails())
        {
        return back()->withErrors($validate->errors('error'));
        }
        else
        {
            $user = session()->get('id');
            if($request->start_time && $request->end_time)
            {
                DB::table('timetable_data_'.$request->semester)
                ->insert([
                            'course_allocation_id'=>$request->course_allocation,
                            'venue_id'=>$request->venue,
                            'department_id'=>$request->department,
                            'week_day'=>$request->week_day,
                            'start_time'=>$request->start_time,
                            'end_time'=>$request->end_time,
                            'department_id'=>Session::get('department_id'),
                            'created_by'=>$user,
                            'last_updated_by'=>$user,
                            'active'=>$request->active,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')
                        ]);

               return back()->with('success', 'Timetable Created');
            }
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($semester)
    {
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/switchery/switchery.css','css/plugins/chosen/bootstrap-chosen.css'
            ];
        $js=[
            'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/switchery/switchery.js','js/timetable.js','js/plugins/chosen/chosen.jquery.js'
            ];
        $count = 1;
        $course_allocations=[];
        $venues=[];
        if(Session::get('authenticated') == true && (Session::get('privilege')==1||Session::get('privilege')==2))
        {
           $course_allocations=CourseAllocation::where(['semester_id'=>$semester,'active'=>1])->get();
           $venues=Venue::where('active',1)->get();
        }
        elseif(Session::get('authenticated') == true && Session::get('privilege')==3){
            $user_department=Session::get('department_id');
            $course_allocations=CourseAllocation::where(['semester_id'=>$semester,'department_id'=>$user_department,'active'=>1])->get();
            $venues=VenueDepartment::where(['department_id'=>$user_department])->get();
        }
        $timetable_data=new Table($semester,'t');
        $timetable_model=$timetable_data->set_model();
        $timetables=$timetable_model->get();
        $semester_name=Semester::find($semester)->title;
        return view('departmental_officer.timetable.show', compact('timetables','count','css','js','course_allocations','venues','semester','semester_name'));
    }

    public function delete_timetable(Request $request)
    {
         $timetable_data=new Table($request->semester,'t');
         $timetable_model=$timetable_data->set_model();
         $Timetable=$timetable_model->where('id',$request->timetable)->first();
         return view('departmental_officer.timetable.confirm_delete',compact('Timetable'))->render();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($timetable)
    {
        return view('departmental_officer.timetable.edit');
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
    public function destroy(Request $request)
    {
    
        $id=session()->get('id');
        $user=User::find("$id");
        if(\Hash::check($request->confirm_password,$user->password))
        {
            $timetable_data = new Table($request->semester);
            $timetable_model = $timetable_data->set_model();
            $timetable_model->where('id',$request->timetable)->delete();
            return back()->with('success','Timetable Deleted');
        }
        else
        {
            return back()->with('error','Wrong Password');
        }
    }
    
}
