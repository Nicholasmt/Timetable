<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = [];
        $lecturers=[];
        if(Session::get('authenticated') == true && (Session::get('privilege')==1))
        {
            $departments=Department::all();
            $lecturers = Lecturer::all();
        }
        elseif(Session::get('authenticated') == true && (Session::get('privilege')==3))
        {
            $departments=Session::get('department_id');
            $lecturers=Lecturer::where('department_id',$departments)->get();
        }

        $id = session()->get('id');
        $user = User::find("$id");
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/chosen/chosen.jquery.js'
            ];
            $count =1;
        return view('admin.lecturer.index', compact('lecturers','departments','css','js','user','count'));

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
        if($request->has('single_btn')){
            $rules=[
                'title'=>'required',
                'fullname'=>'required',
                'email'=>'required|unique:lecturers,email',
                'department'=>'required'
                      ];
                $custom_message=['email.unique'=>'email address already exist'];
                $validate = Validator::make($request->all(), $rules, $custom_message);
                if($validate->fails())
                {
                return back()->withInput()->withErrors($validate->errors('error'));
                }
                else
                {
                    $lecturer=[
                        'title'=>$request->title,
                        'fullname'=>$request->fullname,
                        'email'=>$request->email,
                        'department_id'=>$request->department
                             ];
                    Lecturer::create($lecturer);
                    return back()->with('success','Lecturer Added');
                }
        }
        elseif($request->has('bulk_btn'))
        {
            if($request->hasFile('bulk_file') && $request->file('bulk_file')->getClientOriginalExtension()=="csv")
            {
              $error_lines=[];
              $file=$request->bulk_file->getRealPath();
              $handle=fopen($file, 'r');
              $bulk_data=[];
              $count=0;
              while(($fileops = fgetcsv($handle, 1000, ",")) !== false)
              {
                  $items=$fileops;
                  if($count==0)
                  {
                    $count++;
                     continue;
                  }
                  $items=array_merge($items, $request->all());
                  //dd($items);
                  (object)$items;
                  //dd($request->test_code);
                      $rules=[
                          0=>'required|integer',
                          1=>'required',
                          2=>'required',
                          3=>'required|unique:lecturers,email',
                          'department'=>'required'
                      ];
                      $custom_messages=[
                        '0.required'=>'The serial number column is required',
                        '0.integer'=>'The serial number column must contain a non decimal number',
                        '1.required'=>'Title s/n: '.$items[0].' is required',
                        '2.required'=>'Fullname of the Lecturer has not specified for s/n '.$items[0],
                        '3.required'=>'Lecturer email is required for s/n: '.$items[0].'',
                        '3.unique'=>'Lecturer email for s/n: '.$items[0].' already exists',
                      ];
                      $validator=Validator::make($items, $rules, $custom_messages);
                      if($validator->fails())
                      {
                          $error_lines[]=$validator->messages()->get('*');
                      }
                      else
                      {
                        DB::beginTransaction();

                              try{
                                  $lecturer=[
                                    'title'=>$items[1],
                                    'fullname'=>$items[2],
                                    'email'=>$items[3],
                                    'department_id'=>$request->department
                                         ];
                                Lecturer::create($lecturer);
                                DB::commit();
                              }

                              catch(\Exception $e)
                              {
                                $error_lines[]=$e->getMessage();
                                DB::rollback();
                                return back()->with('val_errors',$error_lines);
                              }
                              catch (Illuminate\Database\QueryException $e) {
                                $error_lines[]=$e->errorInfo;
                                DB::rollback();
                                return back()->with('val_errors',$error_lines);
                              }
                      }
                  }

                  if(count($error_lines)>=1)
                  {
                      return back()->with('val_errors',$error_lines);
                  }
                  return back()->with('success','Bulk file uploaded Successfully');
            }
            else
            {
              return back()->with('error','please attach a CSV file');
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
    public function edit($lecturer)
    {

     if(session()->get('authenticated') == true && session()->get('privilege') == 1)
     {
        $lecturer = Lecturer::find("$lecturer");
        $departments = Department::all();
        return view('admin.lecturer.edit',compact('lecturer','departments'));
     }
     elseif(session()->get('authenticated') == true && session()->get('privilege') == 3)
     {
        $lecturer = Lecturer::find("$lecturer");
        $id = session()->get('id');
        $user = User::find("$id");
        return view('departmental_officer.lecturers.edit',compact('lecturer','user'));
     }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$lecturer)
    {
        $rules=[ 'department'=>'required'];
        $custom_message=['department.required'=>'Select Department'];
        $validate = Validator::make($request->all(), $rules, $custom_message);
        if($validate->fails())
        {
        return back()->withErrors($validate->errors('error'));
        }
        else
        {
            Lecturer::where('id',$lecturer)->update(['title'=>$request->title,
                                                        'fullname'=>$request->fullname,
                                                        'email'=>$request->email,
                                                        'department_id'=>$request->department,
                                                      ]);
           return back()->with('success', 'Lecturer Updated');
        }
    }
   public function delete_modal($lecturer)
    {
      $lecturer = Lecturer::find("$lecturer");
      return view('admin.lecturer.confirm-delete',compact('lecturer'))->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$lecturer)
    {
       $id = session()->get('id');
       $user = User::find("$id");
       if(Hash::check($request->confirm_password, $user->password))
       {
          Lecturer::where('id',$lecturer)->delete();
          return back()->with('success','Lecturer Deleted');
       }
       else
       {
          return back()->with('error','Wrong Password');

       }
    }
}
