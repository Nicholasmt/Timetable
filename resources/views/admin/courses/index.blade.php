@extends('layouts.body')
@section('content')
 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Courses</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')== 1 && Session::get('authenticated') == true)
                          <a class="text-black"href="{{ route('admin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')== 3 && Session::get('authenticated') == true)
                          <a class="text-black"href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                         @endif
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black">Course</a>
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
                                <li><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW COURSES</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-group"></i> ADD BULK COURSE</a></li>
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-3"><i class="fa fa-address-book"></i> VIEW ALL COURSES</a></li>
                            </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW COURSES</h3>
                    <form role="form" action="{{ route('admincourses.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Select Bulletin</label>
                                <select name="bulletin" class="select2_demo_3 form-control" required>
                                     <option value="">Select Bulletin</option>
                                     @foreach ($bulletins as $bulletin)
                                     <option value="{{$bulletin->id}}">{{$bulletin->bulletin}}</option>
                                     @endforeach
                                  </select>
                            </div>
                         <div class="form-group">
                            <label>Course Title</label>
                               <input type="text" placeholder="Enter Course Title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title')}}">
                                </div>
                               @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                          <div class="form-group">
                            <label>Course Code</label>
                               <input type="text" placeholder="Enter Course Code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code')}}">
                                </div>
                               @error('code')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label>Course Unit</label>
                                       <input type="text" placeholder="Enter Course Unit" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit')}}">
                                        </div>
                                       @error('unit')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="text-danger">{{$message}}</strong>
                                            </span>
                                        @enderror
                            <div class="form-group">
                                <label>Course Description</label>
                                <textarea placeholder="Enter Course Description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description')}}</textarea>
                                    </div>
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{$message}}</strong>
                                        </span>
                                    @enderror
                             @if (Session::get('privilege')== 1 && Session::get('authenticated') == true)
                               <div class="form-group">
                                 <select name="department" class="select2_demo_3 form-control">
                                      <option disabled selected>Select Department</option>
                                      @foreach ($departments as $d)
                                      <option value="{{$d->id}}">{{$d->title}}</option>
                                      @endforeach
                                   </select>
                                 </div>
                                 @endif
                             <div class="form-group">
                                 <select name="active" class="select2_demo_3 form-control">
                                      <option disabled selected>Select Status</option>
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                     </select>
                                 </div>

                         <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" name="single_btn" value="Add Courses">
                            </div>
                      </form>
                     </div>
              <div id="tab-2" class="tab-pane ">
                <div class="panel-body"><!--Panel Body 3-->
                    <div class="row"><!--Tab 3 Row-->
                        <div class="col-lg-12"><!--Tab 3 Col-->
                            <div class="ibox ">
                                <p style="font-weight: bold; color: red;">Use the image below as a guide</p>
                                <div class="form-group">
                                <img class="img-thumbnail" src="{{ asset('images/course_template.png') }}" alt="">
                                </div>
                                 <div class="form-group">
                                 <a href="{{ asset('template/course_template.csv') }}" class="btn btn-primary">Download Template</a>
                                 </div>
                                <div class="ibox-content">
                                   @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                                    <form class="m-t" role="form" method="POST" action="{{route('admincourses.store')}}" enctype="multipart/form-data">
                                    @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                                      <form class="m-t" role="form" method="POST" action="{{route('departmentalOfficercourses.store')}}" enctype="multipart/form-data">
                                        @endif
                                        @csrf
                                        <div class="form-group">
                                            <label>Select Department</label>
                                            <select name="department" class="select2_demo_3 form-control" required>
                                                 <option value="">Select Department</option>
                                                 @foreach ($departments as $department)
                                                 <option value="{{$department->id}}">{{$department->title}}</option>
                                                 @endforeach
                                              </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Bulletin</label>
                                            <select name="bulletin" class="select2_demo_3 form-control" required>
                                                 <option value="">Select Bulletin</option>
                                                 @foreach ($bulletins as $bulletin)
                                                 <option value="{{$bulletin->id}}">{{$bulletin->bulletin}}</option>
                                                 @endforeach
                                              </select>
                                        </div>
                                        <div class="form-group row">
                                            <label>Select File</label>
                                            <input type="file" name="bulk_file" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Set Status for all entries</label>
                                            <select name="active" class="select2_demo_3 form-control" required>
                                                 <option disabled selected>Select Status</option>
                                                 <option value="0">Inactive</option>
                                                 <option value="1">Active</option>
                                              </select>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-offset-2 col-lg-10">
                                                <button class="btn btn-sm btn-primary" type="submit" name="bulk_btn">Upload bulk Course</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!--End Tab 3 Col-->
                    </div><!--End Tab 3 Row-->
                </div><!--End Panel Body 3-->
              </div>
              <div id="tab-3" class="tab-pane active">
              <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Courses List</h5>
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
                        <th>Course Code</th>
                        <th>Course Unit</th>
                        <th>Department</th>
                        <th>Bulletin</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    @foreach ($courses as $course )
                    <tr class="gradeX">
                      <td>{{$count++}}</td>
                         <td class="tb">{{($course->title)}}</td>
                        <td class="tb">{{($course->code)}}</td>
                        <td class="tb">{{$course->unit }}</td>
                        <td class="tb">{{($course->department->title)}}</td>
                        <td>{{($course->bulletin->bulletin)}}</td>
                        <td>@if ($course->active == 1)
                               Active
                            @else
                               Inactive
                            @endif
                        </td>
                        <td class="lg-col-2 del">
                            <a href="{{ route('admincourses.edit', ['course'=>$course])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <span>
                            <button id="delete-course" value="{{$course->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                            <i class="fa fa-trash"></i>
                            </button>
                            </span>
                       </td>
                        </tr>
                    @endforeach
                    @elseif(Session::get('privilege')==3 && Session::get('authenticated') == true)
                    @foreach ($courses as $course )
                    <tr class="gradeX">
                      <td>{{$count++}}</td>
                         <td class="tb">{{($course->course->title)}}</td>
                        <td class="tb">{{($course->course->code)}}</td>
                        <td class="tb">{{$course->course->unit }}</td>
                        <td class="tb">{{($course->department->title)}}</td>
                        <td>{{($course->course->bulletin->bulletin)}}</td>
                        <td>@if ($course->active == 1)
                               Active
                            @else
                               Inactive
                            @endif
                        </td>
                        <td class="lg-col-2 del">
                            <a href="{{ route('departmentalOfficercourses.edit', ['course'=>$course->course])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <span>
                            </span>
                       </td>
                        </tr>
                    @endforeach
                    @endif
                    <tfoot>
                        <tr>
                            <th>S/N</th>
                            <th>Course Title</th>
                            <th>Course Code</th>
                            <th>Course Unit</th>
                            <th>Department</th>
                            <th>Bulletin</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
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
                        CKEDITOR.config.autoParagraph = false;
                        CKEDITOR.replace( 'description' );
                        $('.courses').DataTable({
                            pageLength: 10,
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
