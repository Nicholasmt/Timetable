<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use App\Models\Bulletin;
use App\Models\DepartmentCourse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use \Session;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = [];
        $departments =  Department::all();
        $user_department=session()->get('department_id');
        $bulletins=Bulletin::where('active',1)->get();
        $css=[
            'css/plugins/dataTables/datatables.min.css'
          ];
        $js=[
            'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/ckeditor/ckeditor.js'
        ];
        $count=1;
        if(Session::get('authenticated') == true && Session::get('privilege')==1)
        {
            $courses=Course::all();
        }
        elseif(Session::get('authenticated') == true && Session::get('privilege')==3)
        {
            $courses=DepartmentCourse::where('department_id',$user_department)->get();
        }
        return view('admin.courses.index', compact('courses','bulletins','departments','css','js','count'));
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
        $id = session()->get('id');
        $department=session()->get('department_id');
        if($request->has('single_btn'))
        {
            $rules=['code'=>'required|unique:courses,code',
                    'title'=>'required',
                    'bulletin'=>'required',
                    'unit'=>'required|numeric',
                    'description'=>'required',
                    'department'=>'required'
                    ];
            $custom_message=['code.unique'=>'course code already exist'];
            $validate = Validator::make($request->all(), $rules, $custom_message);
            if($validate->fails())
            {
                return back()->withInput()->withErrors($validate->errors('error'));
            }
            else
            {
            if(session()->get('privilege') == 1 && session()->get('authenticated') == true)
            {
                $courses=[
                    'code'=>str_replace(" ","",$request->code),
                    'title'=>$request->title,
                    'unit'=>$request->unit,
                    'description'=>$request->description,
                    'department_id'=>$request->department,
                    'bulletin_id'=>$request->bulletin,
                    'active'=>$request->active
                ];

                $course=Course::create($courses);
                $department_course=[
                    'department_id'=>$request->department,
                    'course_id'=>$course->id,
                    'active'=>$request->active
                ];
                DepartmentCourse::create($department_course);
            }
            elseif(session()->get('privilege') == 3 && session()->get('authenticated') == true)
            {
                    $courses=[
                        'code'=>str_replace(" ","",$request->code),
                        'title'=>$request->title,
                        'unit'=>$request->unit,
                        'description'=>$request->description,
                        'department_id'=>$department,
                        'bulletin_id'=>$request->bulletin,
                        'active'=>$request->active
                    ];
                    $course=Course::create($courses);
                    $department_course=[
                        'department_id'=>$department,
                        'course_id'=>$course->id,
                        'active'=>$request->active
                    ];
                    DepartmentCourse::create($department_course);
           }

            return back()->with('success', 'Course Added');
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
                          1=>'required|integer',
                          2=>'required|unique:courses,code',
                          3=>'required',
                          'department'=>'required',
                          'bulletin'=>'required',
                      ];
                      $custom_messages=[
                        '0.required'=>'The serial number column is required',
                        '0.integer'=>'The serial number column must contain a non decimal number',
                        '1.required'=>'Course unit for s/n'.$items[0].' is required',
                        '2.required'=>'Course Code is required for s/n '.$items[0],
                        '2.unique'=>'Course code '.$items[2].'  already exists',
                        '2.required'=>'Course Code for question '.$items[0].' is required',
                        '3.required'=>'Course Title for s/n '.$items[0].' is required',
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
                         if(session()->get('privilege') == 1 && session()->get('authenticated') == true)
                         {
                                  $data=[
                                    'code'=>str_replace(" ","",$items[2]),
                                    'title'=>utf8_encode($items[3]),
                                    'unit'=>$items[1],
                                    'description'=>utf8_encode($items[4]),
                                    'department_id'=>$request->department,
                                    'bulletin_id'=>$request->bulletin,
                                    'active'=>$request->active,
                                  ];
                                  //$bulk_data[]=$data;
                                  $course=Course::create($data);
                                  $department_course=[
                                      'department_id'=>$request->department,
                                      'course_id'=>$course->id,
                                      'active'=>$request->active
                                  ];
                                  DepartmentCourse::create($department_course);
                                  DB::commit();
                        }
                        elseif(session()->get('privilege') == 3 && session()->get('authenticated') == true)
                        {
                            $data=[
                                'code'=>str_replace(" ","",$items[2]),
                                'title'=>utf8_encode($items[3]),
                                'unit'=>$items[1],
                                'description'=>utf8_encode($items[4]),
                                'department_id'=>$department,
                                'bulletin_id'=>$request->bulletin,
                                'active'=>$request->active,
                              ];
                              //$bulk_data[]=$data;
                              $course=Course::create($courses);
                              $department_course=[
                                    'department_id'=>$department,
                                    'course_id'=>$course->id,
                                    'active'=>$request->active
                                ];
                              DepartmentCourse::create($department_course);
                              DB::commit();
                          }
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
    public function edit(Course $course)
    {
        $departments = Department::all();
        //$course = Course::find("$course");
        $department_courses=DepartmentCourse::where('course_id',$course->id)->get();
        $bulletins=Bulletin::all();
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
          ];
        $js=[
            'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/ckeditor/ckeditor.js'
        ];
        return view('admin.courses.edit',compact('course','bulletins','departments','department_courses','css','js'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$course)
    {
        //dd($course);
        $rules=['code'=>'required',
                'title'=>'required',
                'unit'=>'required|numeric',
        ];
        $custom_message=['code.unique'=>'course code already exist'];
        $validate = Validator::make($request->all(), $rules, $custom_message);
        if($validate->fails())
        {
            return back()->withInput()->withErrors($validate->errors('error'));
        }
        else
        {
            $id = session()->get('id');
            $user_department = Session::get('department_id');
            if(session()->get('privilege') == 1 && session()->get('authenticated') == true)
            {
                Course::where('id',$course)->update(
                    [
                        'title'=>$request->title,
                        'code'=>$request->code,
                        'description'=>$request->description,
                        'bulletin_id'=>$request->bulletin,
                        'active'=>$request->active,
                    ]);
                    $update_data=[];
                    //DB::enableQueryLog();
                foreach($request->department as $department)
                {
                    DepartmentCourse::updateOrCreate(['course_id'=>$course, 'department_id'=>$department],[
                        'department_id'=>$department,
                         'course_id'=>$course,
                         'active'=>$request->active
                    ]);

                }
            }
            elseif(session()->get('privilege') == 3 && session()->get('authenticated') == true)
            {
                Course::where('id',$course)->update(['title'=>$request->title,
                                                        'code'=>$request->code,
                                                        'description'=>$request->description,
                                                        'department_id'=>$user_department,
                                                        'active'=>$request->active,
                                                    ]);
            }
                return back()->with('success', 'Course Updated');

        }

    }


    public function delete_modal($course)
    {
       $course = Course::find($course);
       return view('admin.courses.confirm-delete', compact('course'))->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$course)
    {
        $id = session()->get('id');
        $user=User::find("$id");
        if(Hash::check($request->confrim_password, $user->password))
        {
            Course::where('id',$course)->delete();
            return back()->with('success','Course Deleted');
        }

        else
        {
            return back()->with('error','Wrong Password');
       }
    }
}
