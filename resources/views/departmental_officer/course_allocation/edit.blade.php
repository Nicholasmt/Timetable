@extends('layouts.body')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
        <h2>Update Course Allocation</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                @if (Session::get('privilege')==2 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                @endif
                </li>
                  <li class="breadcrumb-item-active">
                  @if (Session::get('privilege')==2 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('timetableAdmincourse-allocations.index')}}">Course Allocations</a>
                  @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('departmentalOfficercourse-allocations.index')}}">Course Allocations</a>
                  @endif
                </li>
            </ol>
       </div>
    <div id="confirm_delete"></div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="ibox-content">
           <div class="row">
             <div class="col-sm-12 b-r">
                <ul class="nav nav-tabs">
                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-edit"></i> UPDATE COURSE ALLOCATION</a></li>
                </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane active">
                  <h3 class="m-t-none m-b text-center table-color">UPDATE COURSE ALLOCATION</h3>
                    <form role="form" action="{{ route('departmentalOfficercourse-allocations.update',['course_allocation'=>$course_allocation])}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                            <label>Select Course</label>
                                 <select name="course" class="course">
                                      @foreach ($courses as $course)
                                      <option class="text-black" value="{{$course->id}}" {{$course_allocation->course_id==$course->id?"selected":null}}> {{$course->code}} {{$course->title}} </option>
                                      @endforeach
                                   </select>
                                 </div>

                                <div class="form-group">
                                <label>Select Semester</label>
                                 <select name="semester" class="select2_demo_3 form-control">
                                      @foreach ($semesters as $semester)
                                      <option value="{{$semester->id}}" {{$course_allocation->semester_id==$semester->id?"selected":null}}>{{$semester->title}}</option>
                                      @endforeach
                                   </select>
                                 </div>
                                <div class="form-group">
                                <label>Select Lecturer</label>
                                 <select name="lecturer" class="select2_demo_3 form-control">
                                      @foreach ($lecturers as $lecturer)
                                      <option value="{{$lecturer->id}}" {{$course_allocation->lecturer_id==$lecturer->id?"selected":null}}>{{$lecturer->title ." ". $lecturer->fullname}}</option>
                                      @endforeach
                                   </select>
                                 </div>
                             @if (Session::get('authenticated')==true && (Session::get('privilege')==1 ||Session::get('privilege')==2) )
                               <div class="form-group">
                                <label>Select Department</label>
                                 <select name="department" class="select2_demo_3 form-control">
                                      @foreach ($departments as $department)
                                      <option value="{{$department->id}}" {{$course_allocation->department_id==$department->id?"selected":null}}>{{$department->title}}</option>
                                      @endforeach
                                   </select>
                                 </div>
                              @endif
                             @if (Session::get('authenticated')==true && Session::get('privilege')==3 )
                              <div class="form-group">
                                <label>Lead Lecturer</label>
                                 <select name="lead_lecturer" class="select2_demo_3 form-control">
                                      <option value="1" {{$course_allocation->lead_lecturer==1?"selected":null}}>Yes</option>
                                      <option value="0" {{$course_allocation->lead_lecturer==0?"selected":null}}>No</option>
                                     </select>
                                 </div>
                                @endif
                               <div class="form-group">
                                <label>Select Status</label>
                                 <select name="active" class="select2_demo_3 form-control">
                                      <option value="1" {{$course_allocation->active==1?"selected":null}}>Active</option>
                                      <option value="0" {{$course_allocation->active==0?"selected":null}}>Inactive</option>
                                     </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Update Course Allocation">
                        </div>
                      </form>
                    </div>
                 </div>
             </div>
           </div>
         </div>
      </div>
    </div>

@endsection


@section('scripts')

          <script src="{{ asset('assets/js/delete.js')}}"></script>
          <script src="{{ asset('js/plugins/dataTables/datatables.min.js')}}"></script>
            <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
              <script>
                    $(document).ready(function(){

                        $('.dataTables-example').DataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                { extend: 'copy'},
                                {extend: 'csv'},
                                {extend: 'excel', title: 'ExampleFile'},
                                {extend: 'pdf', title: 'ExampleFile'},

                                {extend: 'print',
                                customize: function (win){
                                        $(win.document.body).addClass('white-bg');
                                        $(win.document.body).css('font-size', '10px');

                                        $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                }
                                }
                            ]

                        });

                    });
                    $('.course').chosen({width: "100%"});
            </script>


    @endsection
