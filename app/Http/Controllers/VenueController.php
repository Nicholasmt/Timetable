<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\User;
use App\Models\Department;
use App\Models\VenueDepartment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use \Session;

class VenueController extends Controller
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
            $count = 1;
            if(Session::get('authenticated') == true && (Session::get('privilege')==1 || Session::get('privilege')==2))
            {
                $venue_departments = VenueDepartment::all();
                $venues = Venue::where('active',1)->get();
                $departments=Department::where('active',1)->get();
                return view('admin.venue.index',compact('venue_departments','departments','css','js','count'));
            }
            elseif(Session::get('authenticated') == true && Session::get('privilege')==3)
            {
                $department_id=session()->get('department_id');
                $venue_departments = VenueDepartment::where('department_id',$department_id)->get();
                return view('admin.venue.index',compact('venue_departments','css','js','count'));
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
            'name'=>'required|unique:venues,name',
            'description'=>'required',
            'active'=>'required',
            'department'=>'required'
        ];

        $custom_message=[
            'active.required'=>'Select Status',
        ];
        $validate = Validator::make($request->all(), $rules,$custom_message);
        if($validate->fails())
        {
            return back()->withErrors($validate->errors('error'));
        }
        else
        {
            DB::beginTransaction();
            try{
                $department_venue_data=[
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'active'=>$request->active,
                ];
                $venue=Venue::create($department_venue_data);
                foreach($request->department as $department)
                {
                    VenueDepartment::create(
                        [
                            'venue_id'=>$venue->id,
                            'department_id'=>$department
                        ]
                    );
                }
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollback();
                return back()->withErrors('Could not add venue because: '.$e->getMessage());
            }

            return back()->with('success', 'Venues Added');
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
    public function edit($venue)
    {
        $css=[
            'css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
                'js/plugins/chosen/chosen.jquery.js'
            ];

        $departments = Department::where('active',1)->get();
        $DepartmentVenue = VenueDepartment::find("$venue");
        return view('admin.venue.edit',compact('departments','js','css','DepartmentVenue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$venue)
    {
        $id = VenueDepartment::find("$venue");

        Venue::where('id',$id->venue_id)->update(['name'=>$request->name,
                                                    'description'=>$request->description,
                                                    'active'=>$request->active
                                                 ]);
        VenueDepartment::where('id',$venue)->update(['department_id'=>$request->department]);
        return back()->with('success','Venue Updated');

    }

    public function delete_modal($venue)
    {
        $venue = Venue::find("$venue");
        return view('admin.venue.confirm-delete',compact('venue'))->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$venue)
    {
        $id=session()->get('id');
        $user=User::find("$id");
        if(Hash::check($request->confirm_password,$user->password))
        {
            Venue::where('id',$venue)->delete();
            return back()->with('success','Venue Deleted');
        }
        else
        {
            return back()->with('error','Wrong Password');
        }
    }
}
