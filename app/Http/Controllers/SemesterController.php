<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Hash;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $semesters = Semester::all();
            $css=[
                'css/plugins/dataTables/datatables.min.css','css/plugins/switchery/switchery.css'
              ];
            $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/switchery/switchery.js','js/timetable.js'
            ];
            $count = 1;
            return view('admin.semester.index',compact('semesters','css','js','count'));

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
    public function store(Request $request, Semester $semester)
    {
        $rules=[
                'semester_title'=>'required|unique:semesters,title',
                'start_date'=>'required',
                'end_date'=>'required',
                'active'=>'required'
                ];

        $custom_message=['status.required'=>'Select Semester Status'];

        $validate = Validator::make($request->all(), $rules,$custom_message);

        if($validate->fails())
        {
          return back()->withErrors($validate->errors('error'));
        }
        else
        {
            //dd($request);
            $current=0;
            if(isset($request->current) && !empty($request->current))
            {
                if($request->current=="on" || $request->current=="ON")
                {
                    $current=1;
                }
                else
                {
                    $current=0;
                }
            }
            /*if($current==1)
            {
                //DB::enableQueryLog();
                Semester::query()->update(['current'=>0]);
                //dd(DB::getQueryLog());
            }*/
            $semester->title = $request->semester_title;
            $semester->start = $request->start;
            $semester->end = $request->end;
            $semester->current = $current;
            $semester->active = $request->status;
            $semester->save();
            return back()->with('success', 'Semester Created');
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
    public function edit(Semester $semester)
    {

      $css=[
             'css/plugins/switchery/switchery.css'
          ];
        $js=[
             'js/plugins/switchery/switchery.js'
        ];
        //$semester = Semester::find("$id");
        return view('admin.semester.edit',compact('semester','js','css'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$semester)
    {
        $rules=[
                'start'=>'required',
                'end'=>'required',
               ];
        // $custom_message=['status.required'=>'Select Semester Status',
        //                  ];
        $validate = Validator::make($request->all(), $rules);

        if($validate->fails())
        {
        return back()->withErrors($validate->errors('error'));
        }
        else
        {
            $current=0;
            if($request->has('current') && !empty($request->current))
            {
                if($request->current=="on" || $request->current=="ON")
                {
                    $current=1;
                }
                else
                {
                    $current=0;
                }
            }
            Semester::where('id',$semester)->update(['title'=>$request->title,
                                                         'start'=>$request->start,
                                                         'end'=>$request->end,
                                                         'active'=>$request->active,
                                                         'current'=>$current,
                                                       ]);
            return back()->with('success','Semester Updated');
        }
    }

    public function delete_modal($semester)
    {
      $semester = Semester::find("$semester");
      return view('admin.semester.confirm-delete',compact('semester'))->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$semester)
    {
        $id = session()->get('id');
        $user = Users::find("$id");
       if(Hash::check($request->confirm_password, $user->password))
       {
        Semester::where('id',$semester)->delete();
       }
    }
}
