@extends('layouts.body')
@section('content')
  <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>TimeTable For {{$semester_name}}</h2>
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
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('admintimetables.index')}}">Timetables</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('timetableAdmintimetables.index')}}">Timetables</a>
                        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('departmentalOfficertimetables.index')}}">Timetables</a>
                         @endif
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
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW TIMETABLE</a></li>
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-plus active"></i> SHOW TIMETABLE</a></li>
                            </ul>
             <div class="tab-content">

            <div id="tab-1" class="tab-pane">
                <h3>Set Timetable</h3>
                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('admintimetables.store')}}" method="POST">
                     @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('timetableAdmintimetables.store')}}" method="POST">
                     @else
                    <form role="form" action="{{ route('departmentalOfficertimetables.store')}}" method="POST">
                      @endif
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="semester" value="{{$semester}}">
                         <label class="">Select Course Allocation</label>
                         <select name="course_allocation" class="course_allocation form-control">
                         <option  disabled selected> Select Course Allocation</option>
                            @foreach($course_allocations as $course_allocation)
                            <option value="{{$course_allocation->id}}" class="text-black"> {{$course_allocation->course->code}} - {{ $course_allocation->course->title }} - {{$course_allocation->lecturer->fullname()}}</option>
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
                            <label class="">Select Weekdays</label>
                           <select name="week_day" class="select2_demo_3 form-control">
                                 <option value="Sun">SUN</option>
                                 <option value="Mon">MON</option>
                                 <option value="Tue">TUE</option>
                                 <option value="Wed">WED</option>
                                 <option value="Thu">THU</option>
                                 <option value="Fri">FRI</option>
                                 <option value="Sat">SAT</option>
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
                        <h5 class="table-color">TimeTable For {{$semester_name}}</h5>
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
                        <th>Course</th>
                        <th>Lecturer</th>
                        <th>Venue</th>
                        <th>Weekdays</th>
                        <th>Department</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Created By</th>
                        <th>last Updated by</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($timetables as $timetable)
                    <?php $timetable->semester=$semester; ?>
                    <tr class="gradeX">
                          <td>{{$count++}}</td>
                          <td>{{$timetable->allocation->course->get_full_title()}}</td>
                          <td>{{$timetable->allocation->lecturer->fullname()}}</td>
                          <td class="tb">{{$timetable->venue->name}}</td>
                          <td class="tb">{{$timetable->week_day}}</td>
                          <td>{{$timetable->department->title}}</td>
                          <td>{{$timetable->start_time}}</td>
                          <td>{{$timetable->end_time}}</td>
                          <td>{{$timetable->who_created->name}}</td>
                          <td>{{$timetable->who_updated->name}}</td>
                        <td class="lg-col-2 del">

                        <span>
                        <form>
                            @csrf
                            <input type="hidden" id="semester" value="{{$timetable->allocation->semester->id}}">
                            <input type="hidden" id="timetable" value="{{$timetable->id}}">
                            @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                            <button id="delete-timetable"  type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                              <i class="fa fa-trash"></i>
                            </button>
                            @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                            <button id="delete-timetable_2"  type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                              <i class="fa fa-trash"></i>
                            </button>
                            @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                            <button id="delete-timetable_3"  type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                              <i class="fa fa-trash"></i>
                            </button>
                            @endif
                        </form>
                         
                        </span>
                       </td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <th>S/N</th>
                        <th>Course</th>
                        <th>Lecturer</th>
                        <th>Venue</th>
                        <th>Weekdays</th>
                        <th>Department</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Created By</th>
                        <th>last Updated by</th>
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
                                {extend: 'csv', title: 'Timetable for {{$semester_name}}'},
                                {extend: 'excel', title: 'Timetable for {{$semester_name}}' },
                                {extend: 'pdf', title: 'Timetable for {{$semester_name}}' },

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
                    $('.chosen-select').chosen({width: "100%"});
                    $('.course_allocation').chosen({width: "100%"});
                    $('.venue').chosen({width: "100%"});
            </script>

    @endsection
