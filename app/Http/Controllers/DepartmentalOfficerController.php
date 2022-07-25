<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Department;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Semester;
use App\Models\CourseAllocation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DepartmentalOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = session()->get('id');
        $user = User::find("$id");
        $courses = Course::where('active',1)->get();
        $course_allocated = CourseAllocation::where('active',1)->where('department_id',$user->department_id)->get();
        $lecturers = Lecturer::all();
        $semesters = Semester::where('active',1)->where('current', 1)->get();
        $count=1;
        return view('departmental_officer.dashboard',compact('courses','course_allocated','lecturers','semesters','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($profile)
    { 
        $id = session()->get('id');
        $user =  User::find("$id");
        return view('departmental_officer.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = session()->get('id');
        $user =  User::find("$id");
        $departments = Department::where('active',1)->get();
        return view('departmental_officer.profile.edit',compact('user','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = session()->get('id');
      $user = User::find("$id");
      if(Hash::check($request->password, $user->password))
      {
          User::where('id',$user->id)->update(['name'=>$request->name]);
          return back()->with('success', 'User Updated');
      }
      else
      {
        return back()->with('error', 'Wrong Password');

      }
    }

    public function update_Password(Request $request)
    {
        $id = session()->get('id');
        $user = User::find("$id");

        $rules=['old_password'=>'required',
                 'password'=>'required',
                 'confirm_password'=>'required|same:password'
                 ];
        //$custom_message=['confirm_password.confirmed'=>'Password and confirm Password Must be thesame'];
        $validate = Validator::make($request->all(), $rules);
        if($validate->fails())
        {
            return back()->withErrors($validate->errors('error'));
        }  
        else
        {
            if(Hash::check($request->old_password,$user->password))
            {
                User::where('id',$user->id)->update(['password'=>$request->password]);
                return back()->with('success', 'Password Updated');

            }
            else
            {
                return back()->with('error', 'Wrong Password');
            }
           
        }
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
