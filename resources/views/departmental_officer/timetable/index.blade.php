@extends('layouts.body')
@section('content')
  <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>TimeTable</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                        <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                        <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                        @endif
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black">TimeTables</a>
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
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> SET NEW TIMETABLE</a></li>
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i> VIEW ALL TIMETABLE</a></li>
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW TIMETABLE</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('admintimetables.store')}}" method="POST">
                     @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('timetableAdmintimetables.store')}}" method="POST">
                     @else
                    <form role="form" action="{{ route('departmentalOfficertimetables.store')}}" method="POST">
                      @endif
                        @csrf
                        <div class="form-group">
                         <label class="">Select Course Allocation</label>
                         <select name="course_allocation" class="course_allocation form-control">
                         <option  disabled selected> Select Course Allocation</option>
                            @foreach($course_allocations as $course_allocation)
                            <option value="{{$course_allocation->id}}" class="text-black">{{ $course_allocation->course->title }}</option>
                            @endforeach
                          </select>
                          </div>

                        @if(Session::get('authenticated') == true && (Session::get('privilege')==1||Session::get('privilege')==2))
                        <div class="form-group">
                            <label class="">Select Venue</label>
                           <select name="venue" class="venue form-control">
                            <option disabled selected> Select Venue</option>
                                @foreach($venues as $venue)
                                <option value="{{$venue->id}}" class="text-black">{{$venue->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @elseif(Session::get('authenticated') == true && Session::get('privilege')==3)
                        <div class="form-group">
                            <label class="">Select Venue</label>
                           <select name="venue" class="venue form-control">
                            <option disabled selected> Select Venue</option>
                                @foreach($venues as $venue)
                                <option value="{{$venue->venue->id}}" class="text-black">{{$venue->venue->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="form-group">
                            <label class="">Select Semester</label>
                           <select name="semester" class="semester form-control">
                              @foreach($semesters as $semester)
                                @if(\Schema::hasTable('timetable_data_'.$semester->id) && \Schema::hasTable('monitoring_table_'.$semester->id))
                                <option value="{{$semester->id}}" class="text-black">{{ $semester->title }}</option>
                                @else
                                <option value="" disabled selected class="text-black">{{ $semester->title }}</option>
                                 @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="">Select Department</label>
                           <select name="department" class="select2_demo_3 form-control">
                           <option value="" disabled selected> Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="">Select Weekdays</label>
                           <select name="week_day" class="select2_demo_3 form-control">
                                 <option value="Mon">MON</option>
                                 <option value="Tue">TUE</option>
                                 <option value="Wed">WED</option>
                                 <option value="Thu">THU</option>
                                 <option value="Fri">FRI</option>
                                 <option value="Sat">SAT</option>
                                 <option value="Sun">SUN</option>
                               </select>
                        </div>
                        <div class="form-group">
                        <label>Start Time</label>
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time')}}">
                          </div>
                        @error('start_time')
                        <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{$message}}</strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time')}}">
                         </div>
                        @error('end_time')
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-danger">{{$message}}</strong>
                        </span>
                        @enderror

                        <div class="form-group">
                            <label class="">Set Status</label>
                           <select name="active" class="select2_demo_3 form-control">
                            <option  disabled selected> Set Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                             </select>
                        </div>

                           <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Set Timetable">
                            </div>
                      </form>
                     </div>
       <div id="tab-2" class="tab-pane active">
          <div class="row">
             <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">TimeTable</h5>
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
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead class="table-color">
                    <tr>
                    <th>S/N</th>
                        <th>Semester Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                         <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($semesters as $semester)
                    <tr class="gradeX">
                    @if(\Schema::hasTable('timetable_data_'.$semester->id) && \Schema::hasTable('monitoring_table_'.$semester->id))
                         <td>{{$count++}}</td>
                         <td class="tb">{{$semester->title}}</td>
                         <td>{{$semester->start->format('d')}}  {{date('F', strtotime($semester->start))}} {{$semester->start->format('Y')}}</td>
                         <td>{{$semester->end->format('d')}}  {{date('F', strtotime($semester->end))}} {{$semester->end->format('Y')}}</td>
                          <td class="tb">
                           <i class="fa fa-check text-success"></i>
                        </td>
                        <td class="lg-col-2 del">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a href="{{ route('admintimetables.show',['timetable'=>$semester])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-eye"></i></a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a href="{{ route('timetableAdmintimetables.show',['timetable'=>$semester])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-eye"></i></a>
                         @else
                         <a href="{{ route('departmentalOfficertimetables.show',['timetable'=>$semester])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-eye"></i></a>
                         @endif
                        @else
                        <td>{{$count++}}</td>
                         <td class="tb">{{$semester->title}}</td>
                         <td>{{$semester->start->format('d')}}  {{date('F', strtotime($semester->start))}} {{$semester->start->format('Y')}}</td>
                         <td>{{$semester->end->format('d')}}  {{date('F', strtotime($semester->end))}} {{$semester->end->format('Y')}}</td>
                         <td class="tb"> Timetable Not Set</td>
                         <td><i class="fa fa-times text-danger"></i></td>



                        @endif

<!--
                        <td class="lg-col-2 del">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a href="{{ route('adminvenues.edit',['venue'=>$venue])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a href="{{ route('timetableAdminvenues.edit',['venue'=>$venue])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @else
                         <a href="{{ route('departmentalOfficervenues.edit',['venue'=>$venue])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @endif
                        <span>
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                           <button id="delete-venue" value="{{$venue->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                         </button>
                        @endif
                        </span>
                       </td> -->
                        </tr>
                    @endforeach
                    <tfoot>
                        <th>S/N</th>
                      <th>Semester Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
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
                    $('.course_allocation').chosen({width: "100%"});
                    $('.venue').chosen({width: "100%"});
                    $('.semester').chosen({width: "100%"});
            </script>

    @endsection
