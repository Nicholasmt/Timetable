@extends('layouts.body')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Department</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black">Department</a>
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
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW DEPARTMENT</a></li>
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i> VIEW ALL DEPARTMENT</a></li>
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">Manage Departments</h3>
                    <form role="form" action="{{ route('admindepartments.store')}}" method="POST">
                            @csrf
                          <div class="form-group">
                            <label>Department Name</label>
                               <input type="text" placeholder="Enter Department Name" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('name')}}">
                                </div>
                               @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                                  <select name="active" class="form-control">
                                      <option disabled selected>Select Status</option>
                                         <option value="1">Active</option>
                                         <option value="2">InActive</option>
                                      </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Add Department">
                        </div>
                      </form>
                     </div>
              <div id="tab-2" class="tab-pane active">

              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Department List</h5>
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
                        <th>Department name</th>
                        <th>Active</th>
                        <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($departments as $department )
                    <tr class="gradeX">
                         <td>{{$count++}}</td>
                         <td class="tb">{{($department->title)}}</td>
                         <td class="tb">
                           @if ($department->active == 1)
                             Active
                             @else
                             Inactive
                           @endif
                        </td>
                         <td class="lg-col-2 del">
                        <a href="{{route('admindepartments.edit',['department'=>$department])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                          <span>
                          <button id="delete" value="{{$department->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                          </button>
                        </span>
                         <div id="confrim-modal"></div>
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
<script src="{{ asset('assets/js/delete.js')}}"></script>
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
