@extends('layouts.body')
@section('content')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Monitoring Reports</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
              <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
              @elseif (Session::get('privilege')==1 && Session::get('authenticated') == true)
              <a class="text-black" href="{{ route('monitoring-dashboard')}}">Dashboard</a>
              @endif
              </li>
            <li class="breadcrumb-item-active">
            @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
            <a class="text-black" href="{{ route('admin-reports')}}">Monitoring Reports</a>
            @else (Session::get('privilege')==1 && Session::get('authenticated') == true)
            <a class="text-black" href="{{ route('monitoring-reports')}}">Monitoring Reports</a>
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
                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i>REPORTS</a></li>
			     	</ul>
              <div class="tab-content">
		        <div id="tab-1" class="tab-pane active">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="ibox ">
                       <div class="ibox-title">
                         <h2 class="table-color">FILTER REPORT</h2><br>
						  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
						  <form action="{{ route('admin-fliterReport')}}" method="POST">
						  @elseif (Session::get('privilege')==4 && Session::get('authenticated') == true)
						  <form action="{{ route('monitoring-fliterReport')}}" method="POST">
						   @endif
						   @csrf
                           <div class="col-sm-3 text-sm-right"><dt class="padding-2">Department <span class="text-style"> (check the box)</span></dt> 
						    <dl class="row mb-0">
                               <div class="col-sm-2 text-sm-right">
                                <dt> 
                                  <div class="form-group"> 
                                    <input type="hidden" value="{{$monitoring}}" name="monitoring_table_id">
                                    <select name="semester" class="padding-1">
                                      @foreach ($departments as $department)
                                      <option value="{{$department->id}}">{{$department->title}}</option>
                                      @endforeach
                                    </select>
                                    </div>
                                  </dt>
                                  </div>
                                  <div class="col-sm-1 set-button text-sm-left">
                                    <dd class="mb-1">
                                      <input type="checkbox" class="padding-1 checkbox" name="byDepartment">
                                    </dd> 
                                  </div>
                                 </dl>
                              </div>
                              <div class="col-sm-3 text-sm-right"><dt class="padding-2">Venue<span class="text-style"> (check the box)</span></dt> 
                                <dl class="row mb-0 ">
                                  <div class="col-sm-2 text-sm-right">
                                <dt> 
                              <div class="form-group">
                                 <select name="semester" class="padding-1">
                                    @foreach ($venues as $venue)
                                    <option value="{{$venue->id}}">{{$venue->name}}</option>
                                    @endforeach
                                  </select>
                                  </div>
                                  </dt>
                                </div>
                                <div class="col-sm-1 set-button text-sm-left">
                                  <dd class="mb-1">
                                    <input type="checkbox" class="padding-1 checkbox" name="byVenue">
                                  </dd> 
                                </div>
                             </dl>
                          </div>
                          <div class="col-sm-3 text-sm-right"><dt class="padding-2">Date <span class="text-style"> (check the box)</span></dt> 
                            <dl class="row mb-0">
                                  <div class="col-sm-2 text-sm-right">
                                      <dt> 
                                      <div class="form-group">
                                         <input type="date" class="padding-1" name="date">
                                    </div>
                                    </dt>
                                  </div>
                                  <div class="col-sm-1 set-button text-sm-left">
                                    <dd class="mb-1">
                                      <input type="checkbox" class="padding-1 checkbox" name="byDate">
                                  </dd> 
                                  </div>
                                </dl>
                            </div>
                            <div class="col-sm-3 text-sm-right"><dt class="padding-2">Today <span class="text-style"> (check the box)</span></dt> 
                              <dl class="row mb-0">
                                  <div class="col-sm-2 text-sm-right">
                                    <dt> 
                                      <div class="form-group">
                                        <input type="hidden" value="{{$monitoring}}" name="monitoring_table_id">
                                        <input type="checkbox" class="padding-1 checkbox" name="today">
                                      </div>
                                      </dt>
                                  </div>
                                  <div class="col-sm-0 set-button text-sm-left">
                                    <dd class="mb-1">
                                      <input type="submit" class="btn btn-primary btn-button" value="GO"> 
                                    </dd> 
                                 </div>
                              </dl>
                            </div>
						              </form>	
                          </div>
                        </div>
                        <div class="ibox-content">
                          <h2 class="text-align">Monitoring Reports</h2>
                            <div class="table-responsive">
                               <table class="table table-striped table-bordered table-hover dataTables-example" >
                                  <thead class="table-color">
                                     <tr>
                                        <th>S/N</th>
                                        <th>Monitored By</th>
                                        <th>Number Of Student</th>
                                        <th>Date Monitored</th>
                                        <th>Time Monitored</th>
                                        <th>Comments</th>
                                        <th>Obsersvation</th>
                                     </tr>
                                   </thead>
                                    <tbody>
                                      @if($fliterd_reports)
                                      @foreach ($fliterd_reports as $report)
                                        <tr class="gradeX">
                                            <td>{{$count++}}</td>
                                            <td class="tb">{{$report->monitored_by}}</td>
                                            <td class="tb">{{$report->no_of_students}}</td>
                                            <td>{{$report->date_monitored->format('d')}}  {{date('F', strtotime($report->date_monitored))}} {{$report->date_monitored->format('Y')}}</td>
                                            <td class="tb">{{$report->time_monitored}}</td>
                                            <td class="tb">{{$report->comments}}</td>
                                            <td class="tb">{{$report->observation_key}}</td> 
                                        </tr>
                                        @endforeach
                                        @else
                                        @foreach ($reports as $report)
                                        <tr class="gradeX">
                                            <td>{{$count++}}</td>
                                            <td class="tb">{{$report->monitored_by}}</td>
                                            <td class="tb">{{$report->no_of_students}}</td>
                                            <td>{{$report->date_monitored}} </td>
                                            <td class="tb">{{$report->time_monitored}}</td>
                                            <td class="tb">{{$report->comments}}</td>
                                            <td class="tb">{{$report->	observation_key}}</td> 
                                         </tr>
                                          @endforeach
                                          @endif
                                          <tfoot>
                                            <th>S/N</th>
                                            <th>Monitored By</th>
                                            <th>Number Of Student</th>
                                            <th>Date Monitored</th>
                                            <th>Time Monitored</th>
                                            <th>Comments</th>
                                            <th>Obsersvation</th>
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
            $('.chosen-select').chosen({width: "100%"});
    </script>
@endsection
