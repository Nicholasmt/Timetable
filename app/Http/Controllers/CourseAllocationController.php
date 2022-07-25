<?php

namespace App\Http\Controllers;

use App\Models\CourseAllocation;
use App\Models\AllocationSubmission;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Semester;
use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;

class CourseAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters = Semester::where(['current'=>1,'active'=>1])->get();
        $lecturers = Lecturer::all();
        $courses = [];
        $course_allocations=[];
        $departments=[];
        $count = 1;
        $css=[
            'css/plugins/select2/select2.min.css','css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
        ];
        if(Session::get('authenticated') == true && (Session::get('privilege')==1 || Session::get('privilege')==2))
        {
            $js=[
                'js/plugins/select2/select2.full.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/admin.js','js/unblock.js'
            ];
            $courses=Course::all();
            $submitted_course_allocations=AllocationSubmission::where('submitted',1)->whereHas('semester',function($query){
                $query->where('current',1)->where('active',1);
            })->get();
            //dd($submitted_course_allocations);
            $course_allocations = CourseAllocation::whereHas('semester',function($query){
                $query->where('current',1)->where('active',1);;
            })->get();
            //dd($course_allocations);
            $departments = Department::all();
            return view('departmental_officer.course_allocation.index',compact('semesters','departments','css','js','count','lecturers','courses','submitted_course_allocations','course_allocations'));
        }
        elseif(Session::get('authenticated') == true && Session::get('privilege')==3)
        {
            $js=[
                'js/plugins/select2/select2.full.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/admin.js','js/timetable.js'
            ];
            $department_id=Session::get('department_id');
            $courses=Course::whereHas('department_course',function($query) use($department_id){
                $query->where('department_id',$department_id)->where('active',1);
            })->get();
            //dd($courses);
            //$department = Department::find("$department_id");
            $departments = Department::where('id',$department_id)->get();
            $course_allocations=CourseAllocation::where('department_id', $department_id)->whereHas('semester',function($query){
                $query->where('current',1)->where('active',1);;
            })->get();
            return view('departmental_officer.course_allocation.index',compact('semesters','departments', 'department_id','css','js','count','lecturers','courses','course_allocations'));
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

    public function submit(Request $request)
    {
        $rules=[
            'semester'=>'required|exists:semesters,id',
            'department'=>'required|exists:departments,id',
                ];

        $custom_message=[
            'semester.exists'=>'Selected Semester does not exist',
            'department.exists'=>'Department does not exist'
        ];

        $validate = Validator::make($request->all(), $rules,$custom_message);

        if($validate->fails())
        {
          return back()->withErrors($validate->errors('error'));
        }
        else
        {
            $exists=AllocationSubmission::where(['department_id'=>$request->department,'semester_id'=>$request->semester])->first();
            if($exists->count()>=1)
            {
                $exists->update([
                    'submitted'=>1
                ]);
                return [
                    'status'=>true,
                    'message'=>'Course Allocation Updated'
                ];
            }
            $data=[
                'semester_id'=>$request->semester,
                'department_id'=>$request->department,
                'submitted'=>1
            ];
            $submitted=AllocationSubmission::create($data);
            if($submitted)
            {
                return [
                    'status'=>true,
                    'message'=>'Course Allocation Submitted'
                ];
            }
            else{
                return [
                    'status'=>false,
                    'message'=>'Course Allocation Not Submitted'
                ];
            }
        }
    }

    public function unblock(Request $request)
    {
        $rules=[
            'caid'=>'required|exists:allocation_submissions,id',
                ];

        $custom_message=[
            'caid.exists'=>'Invalid Selection',
        ];

        $validate = Validator::make($request->all(), $rules,$custom_message);

        if($validate->fails())
        {
          return back()->withErrors($validate->errors('error'));
        }
        else
        {
            $exists=AllocationSubmission::find($request->caid);
            if($exists->count()>=1)
            {
                $exists->update([
                    'submitted'=>0
                ]);
                return [
                    'status'=>true,
                    'message'=>'Course Allocation Unblocked'
                ];
            }
            else{
                return [
                    'status'=>false,
                    'message'=>'Selected Course Allocation is invalid'
                ];
            }
        }
    }

    public function departmental_view($id)
    {
            $css=[
                'css/plugins/dataTables/datatables.min.css'
            ];
            $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/ckeditor/ckeditor.js'
            ];
            $count = 1;
            $course_allocations = CourseAllocation::where(['department_id'=>$id,'lead_lecturer'=>1])->whereHas('semester',function($query){
                $query->where('current',1)->where('active',1);
            })->get();
            return view( 'departmental_officer.course_allocation.depratmental-view',compact('course_allocations','js','css','count'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->lecturer);
        $rules=[
            'course'=>'required',
            'semester'=>'required',
            'lecturer'=>'required',
             'active'=>'required'
            ];


        $custom_message=[
            'course.required'=>'Select Course',
            'semester.required'=>'Select Semester',
            'lecturer.required'=>'Select Lecturer',
            'active.required'=>'Select Course Allocation Status',
            'lecturer.unique'=>'Lecturer has already been assigned to that course for the semester'
            ];
    $validate = Validator::make($request->all(), $rules, $custom_message);
    foreach($request->lecturer as $lecturer)
        {
            //$rules['lecturer']='unique:course_allocations,course_id,NULL,id,lecturer_id,'.$lecturer;
            $check_allocation=CourseAllocation::where(['course_id'=>$request->course,'semester_id'=>$request->semester,'lecturer_id'=>$lecturer])->first();
            if($check_allocation)
            {
                $validate->errors()->add('lecturer','Course Allocation exists for '.$check_allocation->lecturer->title.' '.$check_allocation->lecturer->fullname);
                //throw new \Exception('Course Allocation exists for '.$check_allocation->lecturer->fullname());
                return back()->withErrors($validate->errors('error'));
            }
        }
    if($validate->fails())
    {
        return back()->withErrors($validate->errors('error'));
    }
    else
    {
        $allocation_submitted=AllocationSubmission::where(['semester_id'=>$request->semester,'department_id'=>$request->department])->first();
        if($allocation_submitted!=null&&$allocation_submitted->count()>=1)
        {
            return back()->withErrors('Allocation for this department has already been submitted, Contact Academic Planning');
        }
        DB::beginTransaction();
        try{
            $count=1;
            foreach($request->lecturer as $lecturer)
            {
                //dd($count);
                if($count==1)
                {
                    $lead_lecturer=1;
                }
                else
                {
                    $lead_lecturer=0;
                }
                $course_allocation_data=[
                    'course_id'=>$request->course,
                    'semester_id'=>$request->semester,
                    'lecturer_id'=>$lecturer,
                    'department_id'=>$request->department,
                    'lead_lecturer'=>$lead_lecturer,
                    'active'=>$request->active,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
                CourseAllocation::insert($course_allocation_data);
                DB::commit();
                $count++;
            }
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('Could not add allocation because: '.$e->getMessage());
        }
        return back()->with('success', 'Course Allocation Added');
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseAllocation  $courseAllocation
     * @return \Illuminate\Http\Response
     */
    public function show($course_allocation)
    {
        $course_allocation = CourseAllocation::find("$course_allocation");
        return view('departmental_officer.course_allocation.show' ,compact('course_allocation'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseAllocation  $courseAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseAllocation $course_allocation)
    {
        //dd($course_allocation);
        $semesters = Semester::all();
        $lecturers = Lecturer::all();
        $courses = Course::all();
        $departments = Department::all();

        $css=[
            'css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
            'js/plugins/chosen/chosen.jquery.js'
        ];
        //$course_allocation = CourseAllocation::find("$course_allocation");
        return view('departmental_officer.course_allocation.edit',compact('course_allocation','departments','semesters','courses','lecturers','css','js'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseAllocation  $courseAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseAllocation $course_allocation)
    {
       $id = session()->get('id');
       $user = User::find("$id");
        if(session()->get('privilege') == 2 && session()->get('authenticated') == true)
        {
            $course_allocation->update(['course_id'=>$request->course,
                                                                    'semester_id'=>$request->semester,
                                                                    'lecturer_id'=>$request->lecturer,
                                                                    'department_id'=>$request->department,
                                                                    'active'=>$request->active,
                                                                    ]);

            return back()->with('success', 'Course Allocation Updated');
        }
        elseif(session()->get('privilege') == 3 && session()->get('authenticated') == true)
        {
            if($request->lead_lecturer==1)
            {
                $allocations=CourseAllocation::where(['course_id'=>$request->course,'semester_id'=>$request->semester,'department_id'=>$user->department_id,'lead_lecturer'=>1])->update([
                    'lead_lecturer'=>0
                ]);

            }
           $course_allocation->update(['course_id'=>$request->course,
                                                                    'semester_id'=>$request->semester,
                                                                    'lecturer_id'=>$request->lecturer,
                                                                    'department_id'=>$user->department_id,
                                                                    'lead_lecturer'=>$request->lead_lecturer,
                                                                    'active'=>$request->active,
                                                                    ]);

            return back()->with('success', 'Course Allocation Updated');
        }
    }

    public function delete_modal($id)
    {
        $course_allocation = CourseAllocation::find("$id");
        return view('departmental_officer.course_allocation.confirm-delete',compact('course_allocation'))->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseAllocation  $courseAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$course_allocation)
    {
        $id = session()->get('id');
        $user = User::find("$id");

      if(Hash::check($request->confirm_password, $user->password))
      {
        CourseAllocation::where('id',$course_allocation)->delete();
        return back()->with('success','Department Deleted');
      }
      else
      {
          return back()->with('error','Wrong Password');
      }

    }
}
