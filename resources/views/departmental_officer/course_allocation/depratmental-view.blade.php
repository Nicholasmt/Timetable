@extends('layouts.body')
@section('content')
@section('title','Departmental Course Allocation')
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
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                          <a href="{{ route('admincourse-allocations.index')}}" class="text-black">Course Allocation</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a href="{{ route('timetableAdmincourse-allocations.index')}}" class="text-black">Course Allocation</a>
                        @else
                        <a href="{{ route('departmentalOfficercourse-allocations.index')}}" class="text-black">Course Allocation</a>
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

             <div class="tab-content">
		    <div id="tab-1" class="tab-pane active">
              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Departmental Course Allocations</h5>
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
                    <table class="table  table-bordered table-hover courses" >
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Course Title</th>
                        <th>Semester Title</th>
                        <th>Lecturer's Name</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($course_allocations as $course_allocation )
                    <tr class="gradeX">
                      <td>{{$count++}}</td>
                         <td class="tb"> <strong>{{($course_allocation->course->code)}}</strong> {{($course_allocation->course->title)}}</td>
                        <td class="tb">{{($course_allocation->semester->title)}}</td>
                        <td class="tb">{{($course_allocation->lecturer->fullname)}}</td>
                        <td class="tb">{{($course_allocation->department->title)}}</td>
                        <td>@if ($course_allocation->active == 1)
                               Active
                            @else
                               Inactive
                            @endif
                      </td>
                        <td class="lg-col-2 del">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a href="{{ route('admincourse-allocations.show', ['course_allocation'=>$course_allocation])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a href="{{ route('timetableAdmincourse-allocations.show', ['course_allocation'=>$course_allocation])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                         @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                         <a href="{{ route('departmentalOfficercourse-allocations.show', ['course_allocation'=>$course_allocation])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                         @endif
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

@section('')
@section('scripts')

            <script src="{{ asset('assets/js/delete.js')}}"></script>
          <script src="{{ asset('js/plugins/dataTables/datatables.min.js')}}"></script>
            <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
              <script>
                    $(document).ready(function(){
                        CKEDITOR.config.autoParagraph = false;
                        CKEDITOR.replace( 'description' );
                        $('.courses').DataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                { extend: 'copy'},
                                {extend: 'csv'},
                                {extend: 'excel', title: 'Course Allocation'},
                                {extend: 'pdf', title: 'Course Allocation'},

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
