@extends('layouts.body')
@section('content')
  <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Venue</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                           <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                        @else
                           <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                        @endif
                        </li>
                        <li class="breadcrumb-item-active">
                            <a class="text-black">Venues</a>
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
                                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> ADD NEW VENUE</a></li>
                                @endif
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><i class="fa fa-address-book"></i> VIEW ALL VENUE</a></li>
                            </ul>
             <div class="tab-content">
                @if ((Session::get('privilege')==1 || Session::get('privilege')==2) && Session::get('authenticated') == true)
               <div id="tab-1" class="tab-pane ">
                  <h3 class="m-t-none m-b text-center table-color">ADD NEW VENUE</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('adminvenues.store')}}" method="POST">
                     @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('timetableAdminvenues.store')}}" method="POST">
                     @endif
                        @csrf
                         <div class="form-group">
                            <label>Venue Name</label>
                               <input type="text" placeholder="Enter Venue Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
                                </div>
                               @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                          <div class="form-group">
                            <label>Venue Description</label>
                               <input type="text" placeholder="Enter Venue Description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description')}}">
                                </div>
                               @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror

                                <div class="form-group">
                                    <label class="">Select Department</label>
                                    <select name="department[]" multiple class="department form-control" data-placeholder="Select Department">
                                       @foreach($departments as $department)
                                        <option value="{{$department->id}}" class="text-black">{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            <div class="form-group">
                                 <select name="active" class="select2_demo_3 form-control">
                                      <option disabled selected>Select Status</option>
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                     </select>
                                 </div>

                         <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Add Venue">
                            </div>
                      </form>
                     </div>
                   @endif
              <div id="tab-2" class="tab-pane active">

              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="table-color">Venue List</h5>
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
                        <th>Venue Name</th>
                        <th>Venue Description</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($venue_departments as $venue)
                     <tr class="gradeX">
                          <td>{{$count++}}</td>
                          <td class="tb">{{($venue->venue->name)}}</td>
                          <td class="tb">{{($venue->venue->description)}}</td>
                          <td>{{$venue->department->title}}</td>
                          <td>@if ($venue->venue->active == 1)
                               Active
                            @else
                               Inactive
                            @endif
                         </td>
                        <td class="lg-col-2 del">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a href="{{ route('adminvenues.edit',['venue'=>$venue])}}"  class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a href="{{ route('timetableAdminvenues.edit',['venue'=>$venue])}}"  class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @else
                         <a href="{{ route('departmentalOfficervenues.edit',['venue'=>$venue])}}"  class="btn btn-info"><i class="fa fa-edit"></i></a>
                         @endif
                        <span>
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                           <button id="delete-venue" value="{{$venue->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                          <i class="fa fa-trash"></i>
                         </button>
                        @endif
                        </span>
                       </td>
                  </tr>
                    @endforeach
					</tbody>
                    <tfoot>
                        <th>S/N</th>
                        <th>Venue Name</th>
                        <th>Venue Description</th>
                        <th>Department</th>
                        <th>Status</th>
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
