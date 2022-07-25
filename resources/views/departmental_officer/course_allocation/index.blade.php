@extends('layouts.body')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Course Allocations</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                          <a class="text-black"href="{{ route('admin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a class="text-black"href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                        @else
                        <a class="text-black"href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                        @endif

                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black">Course Allocation</a>
                        </li>

                    </ol>
                </div>
       <div id="confirm-modal"></div>
     </div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="ibox-content">
        <div class="row">
           <div class="col-sm-12 b-r">
              <ul class="nav nav-tabs">
                                 <li><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW COURSE ALLOCATION</a></li>
								 <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-book"></i> VIEW ALL COURSE ALLOCATIONS</a></li>
								 <li><a class="nav-link" data-toggle="tab" href="#tab-3"><i class="fa fa-book"></i> DEPARTMENTAL VIEW</a></li>
                                 @if ((Session::get('privilege')==1 || Session::get('privilege')==2 )&& Session::get('authenticated') == true)
								 <li><a class="nav-link" data-toggle="tab" href="#tab-4"><i class="fa fa-book"></i>SUBMITTED COURSE ALLOCATION</a></li>
                                 @endif
                                 @if ((Session::get('privilege')==3 )&& Session::get('authenticated') == true)
								 <li><a class="nav-link" data-toggle="tab" href="#tab-5"><i class="fa fa-book"></i>SUBMIT COURSE ALLOCATION</a></li>
                                 @endif
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW COURSE ALLOCATION</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('admincourse-allocations.store')}}" method="POST">
                  @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                  <form role="form" action="{{ route('timetableAdmincourse-allocations.store')}}" method="POST">
                  @else
                  <form role="form" action="{{ route('departmentalOfficercourse-allocations.store')}}" method="POST">
                  @endif
                            @csrf
                            <div class="form-group">
                                <select name="semester" class="select2_demo_3 form-control">
                                     <option disabled selected>Select Semester</option>
                                     @foreach ($semesters as $semester)
                                     <option value="{{$semester->id}}">{{$semester->title}}</option>
                                     @endforeach
                                  </select>
                                </div>

                             <div class="form-group">
                                 <select name="course" class="course">
                                      <option disabled selected>Select Course</option>
                                      @foreach ($courses as $course)
                                      <option class="text-black" value="{{$course->id}}">{{$course->title}} - {{$course->code}}</option>
                                      @endforeach
                                   </select>
                                 </div>

                                <div class="form-group">
                                 <select name="lecturer[]" class="lecturer" data-placeholder="Select Lecturer(s)..." multiple style="width:350px;" tabindex="4">
                                      @foreach ($lecturers as $lecturer)
                                      <option class="text-black" value="{{$lecturer->id}}">{{$lecturer->title." ". $lecturer->fullname}}</option>
                                      @endforeach
                                   </select>
                                </div>

                           @if (Session::get('privilege')==1 && Session::get('authenticated') == true || Session::get('privilege')==2)
                                <div class="form-group">
                                 <select name="department" class="chosen-select">
                                      <option disabled selected>Select Department</option>
                                      @foreach ($departments as $department)
                                      <option class="text-black" value="{{$department->id}}">{{$department->title}}</option>
                                      @endforeach
                                   </select>
                                 </div>
                            @elseif(Session::get('privilege')==3 && Session::get('authenticated') == true)
                            <div class="form-group">

                              <input type="hidden" name="department" value="{{$department_id}}">
                             </div>

                             @endif
                              <div class="form-group">
                                 <select name="active" class="select2_demo_3 form-control">
                                      <option disabled selected>Select Status</option>
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                     </select>
                                 </div>

                         <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit"  value="Add Course Allocation">
                        </div>
                      </form>
                    </div>

		    <div id="tab-2" class="tab-pane active">
              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Course Allocation List</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                             </ul>
                         </div>
                    </div>
                    <div class="ibox-content">
                   <div class="table-responsive">
                    <table class="table  table-bordered table-hover all_allocations" >
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Course Title</th>
                        <th>Semester Title</th>
                        <th>Lecturer's Name</th>
                        <th>Department</th>
                        <th>Lead Lecturer</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($course_allocations as $course_allocation )
                    <tr class="gradeX">
                      <td>{{$count++}}</td>
                         <td class="tb"><strong>{{($course_allocation->course->code)}}</strong> {{($course_allocation->course->title)}}</td>
                        <td class="tb">{{($course_allocation->semester->title)}}</td>
                        <td class="tb">{{($course_allocation->lecturer->fullname)}}</td>
                        <td class="tb">{{($course_allocation->department->title)}}</td>
                        <td>
                            @if ($course_allocation->lead_lecturer == 1)
                               <i class="fa fa-check text-success"></i>
                            @else
                               <i class="fa fa-times text-danger"></i>
                            @endif
                        </td>
                        <td>@if ($course_allocation->active == 1)
                               Active
                            @else
                               Inactive
                            @endif
                      </td>
                        <td class="lg-col-2 del">
                        @if (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a href="{{ route('timetableAdmincourse-allocations.edit', ['course_allocation'=>$course_allocation])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                        <a href="{{ route('departmentalOfficercourse-allocations.edit', ['course_allocation'=>$course_allocation])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        @endif
                        <span>
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                        <a href="{{ route('admincourse-allocations.show', ['course_allocation'=>$course_allocation])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a href="{{ route('timetableAdmincourse-allocations.show', ['course_allocation'=>$course_allocation])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        @else
                        <a href="{{ route('departmentalOfficercourse-allocations.show', ['course_allocation'=>$course_allocation])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        @endif

                        @if (Session::get('privilege')==3 && Session::get('authenticated') == true)
                        <button id="delete-courseAllocation" value="{{$course_allocation->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                        </button>
                        @endif
                        </span>
                        </td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <th>S/N</th>
                        <th>Course Title</th>
                        <th>Semester Title</th>
                        <th>Lecturer's Name</th>
                        <th>Department</th>
                        <th>Lead Lecturer</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tfoot>
			      </table>
			    </div>
			   </div>
			</div>
		 </div>
	 </div>
    </div>

		   <div id="tab-3" class="tab-pane">
              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Departmental List</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                             </ul>
                         </div>
                    </div>
                    <div class="ibox-content">
                   <div class="table-responsive">
                    <table class="table table-bordered table-hover departments" >
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Departments</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $counter=1; ?>
                    @foreach ($departments as $department )
                    <tr class="gradeX">
                      <td>{{$counter}}</td>
                         <td class="tb">{{($department->title)}}</td>
                          <td>@if ($department->active == 1)
                               Active
                            @else
                               Inactive
                            @endif
                        </td>
                        <td class="lg-col-2 del">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                        <a href="{{ route('admin-departmentalView',$department)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a href="{{ route('timetableAdmin-departmentalView',$department)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        @else
                        <a href="{{ route('departmentalOfficer-departmentalView',$department)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        @endif
                        </td>
                        </tr>
                        <?php $counter++; ?>
                    @endforeach
			      </table>
			    </div>
			   </div>
			</div>
		 </div>
	 </div>
    </div>

    @if((Session::get('privilege')==1 )&& Session::get('authenticated') == true)
    <div id="tab-4" class="tab-pane">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="table-color">Submitted Course Allocations</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover submitted_allocations" >
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Semester Title</th>
                            <th>Department</th>
                            <th>Number of Allocations</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php $counter=1; ?>

                        @foreach ($submitted_course_allocations as $allocation)
                        <tr class="gradeX">
                          <td>{{$counter++}}</td>
                          <td class="tb">{{$allocation->semester->title}}</td>
                          <td>{{$allocation->department->title}}</td>
                          <td class="tb">{{$allocation->semester->course_allocation->where('department_id',$allocation->department_id)->count()}}</td>
                          <td>
                                @if($allocation->submitted==1)
                                  Submitted <i class="fa fa-check text-success"></i>
                                @else
                                  Not Submitted <i class="fa fa-times text-warning"></i>
                                @endif
                            </td>
                            <td class="lg-col-2">
                                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                                    <button id="unblock_allocation" data-caid="{{$allocation->id}}" type="button"  class="btn btn-primary"  aria-hidden="true">
                                     Unblock <i class="fa fa-check"></i>
                                    </button>
                                  @endif
                            </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <th>S/N</th>
                            <th>Semester Title</th>
                            <th>Department</th>
                            <th>Number of Allocations</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tfoot>
                      </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    @endif

    @if((Session::get('privilege')==3 )&& Session::get('authenticated') == true)
    <div id="tab-5" class="tab-pane">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="table-color">Semester Allocations</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover submitted_allocations" >
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Semester Title</th>
                            <th>Number of Allocations</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php $counter=1; ?>
                        @foreach ($semesters as $semester )
                        <tr class="gradeX">
                          <td>{{$counter++}}</td>
                          <td class="tb">{{$semester->title}}</td>
                          <td class="tb">{{$semester->course_allocation->where('department_id',$department_id)->count()}}</td>
                          <td>
                                @if($semester->allocation_submission!=null && $semester->allocation_submission->submitted==1)
                                  Submitted <i class="fa fa-check text-success"></i>
                                @else
                                  Not Submitted <i class="fa fa-times text-warning"></i>
                                @endif
                            </td>
                            <td class="lg-col-2">
                                @if (Session::get('privilege')==3 && Session::get('authenticated') == true)
                                  @if($semester->allocation_submission!=null && $semester->allocation_submission->submitted==1)
                                      <strong>Submitted</strong>
                                  @else
                                    <button id="submit_allocation" data-sem="{{$semester->id}}" data-dept="{{$department_id}}" type="button"  class="btn btn-primary"  aria-hidden="true">
                                     Submit <i class="fa fa-check"></i>
                                    </button>
                                  @endif
                                @endif
                            </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <th>S/N</th>
                            <th>Semester Title</th>
                            <th>Number of Allocations</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tfoot>
                      </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    @endif

   </div>
  </div>
 </div>
</div>
</div>
</div>

@endsection

@section('')
@section('scripts')
            <script src="{{ asset('assets/js/delete.js')}}"></script>
              <script>
                    $(document).ready(function(){

                        $('.all_allocations').DataTable({
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

                        $('.submitted_allocations').DataTable({
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


                        $('.departments').DataTable({
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
                    $('.lecturer').chosen({width: "100%"});
                    $('.chosen-select').chosen({width: "100%"});
            </script>

    @endsection
