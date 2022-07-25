<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(session()->get('authenticated') == true && session()->get('privilege') == 1)
       {
         return redirect('admin/dashboard');
       }
       elseif(session()->get('authenticated') == true && session()->get('privilege') == 2)
       {
         return redirect('timetableAdmin/dashboard');
       }
       elseif(session()->get('authenticated') == true && session()->get('privilege') == 3)
       {
         return redirect('departmentalOfficer/dashboard');
       }
       else
       {
        return redirect('monitoring/dashboard');
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
       $rules=['email'=>'required',
               'password'=>'required'];

         $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
       return back()->withErrors($validator->errors());
        }
        else
        {
            $user = Users::where('email',$request->email)->first();

            if($user)
            {
               if(Hash::check($request->password, $user->password))
               {

                  $request->session()->put('id', $user->id);
                  $request->session()->put('username', $user->name);
                  $request->session()->put('email', $user->email);
                  $request->session()->put('privilege', $user->role_id);
                  $request->session()->put('role_title', $user->role->title);
                  $request->session()->put('department_id', $user->department_id);
                  $request->session()->put('authenticated',true);
                  return redirect('redirect_auth');
               }
               else
               {
                return back()->with('error','password Mismatch try again');
               }
            }

            else
            {
               return back()->with('error','user dont exist');
            }
        }

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

    public function logout (Request $request)
    {
       $request->session()->invalidate();
       return redirect('/');

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
