@extends('layouts.body')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>USERS</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black" >Users</a>
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
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW USER</a></li>
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i> VIEW ALL USERS</a></li>
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW USER</h3>
                    <form role="form" action="{{ route('adminusers.store')}}" method="POST">
                            @csrf
                          <div class="form-group">
                            <label>Full Name</label>
                               <input type="text" placeholder="Enter Full Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
                                </div>
                               @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                              <div class="form-group">
                                 <select name="role" class="select2_demo_3 form-control">
                                      <option disabled selected>Select Role</option>
                                      @foreach ($roles as $role)
                                      <option value="{{$role->id}}">{{$role->title}}</option>
                                      @endforeach
                                   </select>
                                 </div>

                               <div class="form-group">

                                  <select name="department" class="form-control">
                                      <option disabled selected>Select Department</option>
                                      @foreach ($departments as $department )
                                      <option value="{{$department->id}}">{{$department->title}}</option>
                                      @endforeach
                                     </select>
                                 </div>

                            <div class="form-group">
                              <label>Email Address</label>
                              <input type="email" placeholder="Enter Email"  class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email')}}">
                                  </div>
                                  @error('email')
                              <span class="invalid-feedback" role="alert">
                                      <strong class="text-danger">{{$message}}</strong>
                                  </span>
                              @enderror
                         <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Add User">
                            </div>
                      </form>
                     </div>
              <div id="tab-2" class="tab-pane active">

              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Users List</h5>
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
                    <table class="table table-bordered table-hover users" >
                    <thead class="table-color">
                    <tr>
                         <th>S/N</th>
                        <th>Full name</th>
                        <th>Email Address</th>
                        <th>Privilege</th>
                        <th>Department</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user )
                    <tr class="gradeX">
                        <td>{{$count++}}</td>
                        <td class="tb">{{($user->name)}}</td>
                        <td class="tb">{{($user->email)}}</td>
                        <td class="tb">{{($user->role->title)}}</td>
                        <td class="tb">{{($user->dept->title)}}</td>
                        <td class="lg-col-2 del">
                       <!-- <a href="{{ route('adminusers.edit',['user'=>$user]) }}" value="{{$user->id}}" id="delete-approve" class="btn btn-danger"><i class="fa fa-trash"></i></a> -->
                          <button id="delete-user" value="{{$user->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                          </button>
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
                        $('.users').DataTable({
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
