@extends('layouts.body')
@section('content')
 
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Monitoring Reports</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-back" href="{{ route('admin-dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-back">Reports</a>
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
                              <li>
                                  <a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i>All REPORT</a>
                             </li>
                            </ul>
             <div class="tab-content">
               
				 
              <div id="tab-2" class="tab-pane active">
               
              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Monitoring Report List</h5>
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
                        <th>TimeTable Title</th>
                        <th>Monitored By</th>
                        <th>Time monitored</th>
                        <th>Date</th>
                        <th>Actions</th>
                   </tr>
                    </thead>
                    <tbody>
                    @foreach ($monitoring_report as $reports)
                    <tr class="gradeX">
                         <td class="tb">{{($reports->timetable_name)}}</td>
                         <td>{{$reports->users->name}}</td>
                         <td>{{$reports->time_monitored}}</td>
                         <td>{{$reports->created_at->format('d')}}  {{date('F', strtotime($reports->created_at))}} {{$reports->created_at->format('Y')}}</td>
                           <td class="lg-col-2 del">
                        <a value="{{$reports->id}}" id="delete-approve" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        
                       </td>
                        </tr>
                    @endforeach 
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

            <script src="{{ asset('js/delete.js')}}"></script>
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
            </script>
            

    @endsection
