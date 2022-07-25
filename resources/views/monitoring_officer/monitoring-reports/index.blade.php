@extends('layouts.body')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-10">
      <h2>Semester</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                @elseif (Session::get('privilege')==4 && Session::get('authenticated') == true)
                <a class="text-black" href="{{ route('monitoring-dashboard')}}">Dashboard</a>
                @endif
             </li>
             <li class="breadcrumb-item-active">
                <a class="text-black">Semester</a>
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
          <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-calendar"></i>SEMESTER</a></li>
        </ul>
<div class="tab-content">
  <div id="tab-1" class="tab-pane active">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5 class="table-color">Semester</h5>
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
                <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead class="table-color">
                <tr>
                    <th>S/N</th>
                    <th>Semester Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                  </tr>
              </thead>
                @foreach ($semesters as $semester)
              <tr>
                @if(\Schema::hasTable('timetable_data_'.$semester->id) && \Schema::hasTable('monitoring_table_'.$semester->id))
                    <td>{{$count++}}</td>
                    <td class="tb">{{$semester->title}}</td>
                    <td>{{$semester->start->format('d')}}  {{date('F', strtotime($semester->start))}} {{$semester->start->format('Y')}}</td>
                    <td>{{$semester->end->format('d')}}  {{date('F', strtotime($semester->end))}} {{$semester->end->format('Y')}}</td>
                    <td class="lg-col-2 del">
                    @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <a href="{{ route('adminmonitoring.show',['monitoring'=>$semester])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    @elseif (Session::get('privilege')==4 && Session::get('authenticated') == true)
                    <a href="{{ route('monitoringmonitoring.show',['monitoring'=>$semester])}}" id="delete-approve" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    @endif
                  </td> 
                  @endif
                </tr>
                @endforeach
              <tfoot>
                <th>S/N</th>
                <th>Semester Title</th>
                <th>Start Date</th>
                <th>End Date</th>
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
<script src="{{ asset('assets/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
      $(document).ready(function(){
          $('.dataTables').DataTable({
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
