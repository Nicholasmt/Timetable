<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Department;
use App\Models\User;
use App\Mail\AddUser_mails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $departments = Department::all();
        $users = User::whereIn('role_id',[2,3,4])->get();
        $css=[
            'css/plugins/dataTables/datatables.min.css'
          ];
          $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js'
            ];
         $count=1;
        return view('admin.users.index',compact('roles','departments','users','css','js','count'));
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
    public function store(Request $request,User $users)
    {
        $rules=['name'=>'required',
                 'role'=>'required',
                 'department'=>'required',
                 'email'=>'required'
                 ];
         $validate = Validator::make($request->all(), $rules);
         if($validate->fails())
         {
            return back()->withInput()->withErrors($validate->errors('error'));
         }
         else
         {
             $randomPass = Str::random(8);
             $users->name = $request->name;
             $users->role_id = $request->role;
             $users->department_id = $request->department;
             $users->email = $request->email;
             $users->password = Hash::make($randomPass);
             $users->save();
             Mail::to($users->email)->send(new AddUser_mails($users, $randomPass));
             return back()->with('success', 'Users Created');
       }
    }

public function delete_modal($user)
{
   $user = User::find("$user");
  return view('admin.users.confirm-delete',compact('user'))->render();
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request,$user)
    {
        
        $id = session()->get('id');
        $user_password = User::find("$id");

        if(Hash::check($request->confirm_password, $user_password->password))
        {
            User::where('id',$user)->delete();
            return back()->with('success','User Deleted');
        }
        else
        {
            return back()->with('error','Wrong Password');

        }

    }
}
