@extends('layouts.body')
@section('content')
 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Semesters</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                           @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                           @endif
                         </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black" >Semester</a>
                        </li>

                    </ol>
                </div>
       <div id="confrim-modal"></div>
     </div>
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                   <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12 b-r">
                             <ul class="nav nav-tabs">
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW SEMESTER</a></li>
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i> VIEW ALL SEMESTER</a></li>
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW SEMESTER</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('adminsemesters.store')}}" method="POST">
                    @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                       <form role="form" action="{{ route('timetableAdminsemesters.store')}}" method="POST">
                        @endif
                            @csrf
                          <div class="form-group">
                            <label>Semester Name</label>
                               <input type="text" placeholder="Enter Semester Title" class="form-control @error('semester_title') is-invalid @enderror" name="semester_title" value="{{ old('semester_title')}}">
                                </div>
                               @error('semester_title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror

                          <div class="form-group">
                            <label>Start Date</label>
                               <input type="date" placeholder="Enter Start Date" class="form-control @error('start') is-invalid @enderror" name="start" value="{{ old('start')}}">
                                </div>
                               @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror


                            <div class="form-group">
                               <label><i class="fa fa-clock"></i>End Date</label>
                               <input type="date" placeholder="Enter End Date" class="form-control @error('end') is-invalid @enderror" name="end" value="{{ old('end')}}">
                            </div>
                               @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror

                                <div class="form-group">
                                    <label><i class="fa fa-clock"></i>Current Semester</label>
                                    <input type="checkbox" name="current" class="js-switch_3"/>
                                 </div>


                          <div class="form-group">
                             <select name="active" class="form-control">
                               <option disabled selected> Select Status</option>
                               <option value="1">Set Active</option>
                               <option value="2">Set Inactive</option>
                               </select>
                            </div>

                           <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Add Semester">
                        </div>
                      </form>
                     </div>
              <div id="tab-2" class="tab-pane active">

              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Semester List</h5>
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
                        <th>Current</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($semesters as $semester)
                    <tr class="gradeX" id="semester_{{$semester->id}}">
                        <td>{{$count++}}</td>
                         <td class="tb">{{($semester->title)}}</td>
                         <td>{{$semester->start->format('d')}}  {{date('F', strtotime($semester->start))}} {{$semester->start->format('Y')}}</td>
                         <td>{{$semester->end->format('d')}}  {{date('F', strtotime($semester->end))}} {{$semester->end->format('Y')}}</td>
                        <td class="tb">
                           @if ($semester->active == 1)
                           <div class="text-primary"> Active</div>
                             @else
                            <div class="text-danger"> Inactive</div>
                           @endif
                        </td>
                        <td class="tb">
                           @if ($semester->current == 0)
                            <div class="text-primary">None</div>
                             @else
                            <div class="text-success">Current</div>
                           @endif
                        </td>
                         <td class="lg-col-2 del">
                         @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a href="{{ route('adminsemesters.edit',['semester'=>$semester])}}"  class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a href="{{ route('timetableAdminsemesters.edit',['semester'=>$semester])}}"  class="btn btn-info"><i class="fa fa-edit"></i></a>
                          @endif
                        <span>
                          @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                           <button id="delete-semester" value="{{$semester->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                          </button>
                          @endif
                        </span>
                        @if(\Schema::hasTable('timetable_data_'.$semester->id) && \Schema::hasTable('monitoring_table_'.$semester->id))
                        <div class="text-success">Timetable Set</div><i class="fa fa-check"></i>
                        @else
                        <button id="set_timetable" value="{{$semester->id}}" class="btn btn-primary" data-toggle="modal"> <i class="fa fa-cogs"></i> Set Timetable</button>
                        @endif
                       </td>

                        </tr>

                    @endforeach
                     <tfoot>
                        <th>S/N</th>
                        <th>Semester Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Current</th>
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


@section('scripts')
   <script src="{{ asset('assets/js/delete.js')}}"></script>
          <script src="{{ asset('js/plugins/dataTables/datatables.min.js')}}"></script>
            <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
              <script>
                    $(document).ready(function(){
                        var current = document.querySelector('.js-switch_3');
                        var switchery_3 = new Switchery(current, { color: '#1AB394' });
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
            </script>


    @endsection
