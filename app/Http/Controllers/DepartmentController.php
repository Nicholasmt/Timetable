<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $departments = Department::where('active',1)->get();
      $departments = Department::where('active',1)->get();
      $css=[
        'css/plugins/dataTables/datatables.min.css'
      ];
      $js=[
            'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js'
        ];
        $count = 1;
      return view('admin.department.index', compact(['css','js','departments','count']));
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
    public function store(Request $request, Department $department)
    {
            $rules=['title'=>'required'];

            $validate = Validator::make($request->all(), $rules);

            if($validate->fails())
            {
            return back()->withInput()->withErrors($validate->errors('error'));
            }

            else
            {
                $department->title = $request->title;
                $department->active = $request->active;
                $department->save();

                return back()->with('success', 'Department Added');

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
       return view('admin.department.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $department)
    {
      $rule=['active'=>'required'];
       $custom_message=['status.required'=>'Please Select Department Status'];
       $validate=Validator::make($request->all(),$rule,$custom_message);
       if($validate->fails())
       {
           return back()->withErrors($validate->errors('error'));
       }
       else
       {
        Department::where('id',$department)->update(['title'=>$request->title,'active'=>$request->active]);
        return back()->with('success','Department Updated');
       }

    }


    public function delete_modal($department)
    {
        $department = Department::find("$department");
       return view('admin.department.confirm-delete',compact('department'))->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$department)
    {
        $id = session()->get('id');
        $user = User::find("$id");

      if(Hash::check($request->confirm_password, $user->password))
      {
        Department::where('id',$department)->delete();
        return back()->with('success','Department Deleted');
      }
      else
      {
          return back()->with('error','Wrong Password');
      }

    }
}
