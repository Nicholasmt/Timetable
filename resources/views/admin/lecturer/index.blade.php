@extends('layouts.body')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Lecturer</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                            <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                           @endif
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black">Lecturers</a>
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
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW LECTURER</a></li>
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i> VIEW ALL LECTURER</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3"><i class="fa fa-address-book"></i> ADD BULK LECTURERS</a></li>
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW LECTURER</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('adminlecturers.store')}}" method="POST">
                  @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('departmentalOfficerlecturers.store')}}" method="POST">
                  @endif
                            @csrf
                            <div class="form-group">
                                <label>Lecturer's Title</label>
                                <select name="title" class="chosen-select form-control" data-placeholder="Select title ..">
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                </select>
                            </div>
                          <div class="form-group">
                            <label>Lecturer's Full Name</label>
                               <input type="text" placeholder="Enter Lecturer's Full Name" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname')}}">
                                </div>
                               @error('fullname')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                            <label>Lecturer Email</label>
                               <input type="email" placeholder="Enter Lecturer Email" class="form-control @error('name') is-invalid @enderror" name="email" value="{{ old('email')}}">
                                </div>
                               @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                @if(Session::get('authenticated') == true && (Session::get('privilege')==1))
                            <div class="form-group">
                                 <select name="department" class="select2_demo_3 form-control">
                                      <option disabled selected>Select Department</option>
                                     @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->title}}</option>
                                     @endforeach
                                      </select>
                                 </div>
                                 @elseif(Session::get('authenticated') == true && (Session::get('privilege')==3))
                                  <input type="hidden" name="department" value="{{$departments}}">
                                 @endif
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" name="single_btn" type="submit" value="Add Lecturer">
                            </div>
                      </form>
                     </div>
              <div id="tab-2" class="tab-pane active">
               <div class="row">
                <div class="col-lg-12">
                  <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Lecturer List</h5>
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
                        <th>Lecturer's Title</th>
                        <th>Lecturer's Full Name</th>
                        <th>Lecturer's Email</th>
                        <th>Lecturer's Department</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($lecturers as $lecturer)
                    <tr class="gradeX">
                        <td>{{$count++}}</td>
                         <td class="tb">{{($lecturer->title)}}</td>
                        <td class="tb">{{($lecturer->fullname)}}</td>
                        <td class="tb">{{($lecturer->email)}}</td>
                        <td class="tb">{{($lecturer->department->title)}}</td>
                         <td class="lg-col-2 del">
                         @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                          <a href="{{ route('adminlecturers.edit',['lecturer'=> $lecturer])}}"   class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                          <a href="{{ route('adminlecturers.edit',['lecturer'=> $lecturer])}}"   class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @endif
                        <span>
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <button id="delete-lecturer" value="{{$lecturer->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                         </button>
                         @endif
                        </span>
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
    <div id="tab-3" class="tab-pane ">
        <div class="row">
            <div class="col-lg-12">
              <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="table-color">Add Bulk Lecturers</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                         </ul>
                     </div>
                </div>
                <div class="ibox-content">
                    <p style="font-weight: bold; color: red;">Use the image below as a guide</p>
                                <div class="form-group">
                                <img class="img-thumbnail" src="{{ asset('images/lecturer_template.png') }}" alt="">
                                </div>
                                 <div class="form-group">
                                 <a href="{{ asset('template/lecturer_template.csv') }}" class="btn btn-primary">Download Template</a>
                                 </div>
                    @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                        <form role="form" action="{{ route('adminlecturers.store')}}" method="POST" enctype="multipart/form-data">
                    @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                        <form role="form" action="{{ route('departmentalOfficerlecturers.store')}}" method="POST" enctype="multipart/form-data">
                    @endif
                                @csrf

                    @if(Session::get('authenticated') == true && (Session::get('privilege')==1))
                    <div class="form-group">
                    <select name="department" class="department form-control">
                        <option disabled selected>Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{$department->id}}" class="text-black">{{$department->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    @elseif(Session::get('authenticated') == true && (Session::get('privilege')==3))
                    <input type="hidden" name="department" value="{{$departments}}">
                    @endif

                    <div class="form-group row">
                        <label>Select File</label>
                        <input type="file" name="bulk_file" class="form-control" required>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="submit" name="bulk_btn">Upload bulk Lecturer</button>
                        </div>
                    </div>
                    </form>
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
                    $('.department').chosen({width: "100%"});
            </script>

    @endsection
