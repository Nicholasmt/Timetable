@extends('layouts.body')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
        <h2>Update Course</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                  @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                  @endif
                </li>
                  <li class="breadcrumb-item-active">
                    @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('admincourses.index')}}">Courses</a>
                    @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('departmentalOfficercourses.index')}}">Courses</a>
                    @endif
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
                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-edit"></i> UPDATE COURSE</a></li>
                </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane active">
                  <h3 class="m-t-none m-b text-center table-color">UPDATE COURSE</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('admincourses.update',['course'=>$course])}}" method="POST">
                     @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                     <form role="form" action="{{ route('departmentalOfficercourses.update',['course'=>$course])}}" method="POST">
                       @endif
                            @csrf
                            @method('PATCH')
                          <div class="form-group">
                            <label>Course Title</label>
                            <input type="hidden" value="{{$course->id}}" name="id">
                               <input type="text" value="{{$course->title}}" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title')}}">
                                </div>
                               @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                            <div class="form-group">
                             <label>Course Code</label>
                             <input type="text" value="{{$course->code}}" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code')}}">
                                </div>
                               @error('code')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label>Course Unit</label>
                                    <input type="text" value="{{$course->unit}}" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit')}}">
                                       </div>
                                      @error('unit')
                                       <span class="invalid-feedback" role="alert">
                                               <strong class="text-danger">{{$message}}</strong>
                                           </span>
                                       @enderror
                          <div class="form-group">
                            <label>Description</label>
                              <textarea class="form-control" @error('description') is-invalid @enderror name="description" value="{{ old('description')}}"> {{$course->description}}</textarea>
                                </div>
                               @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                                <div class="form-group">
                                    <label for="">Department</label>
                                    @if(in_array("6",$department_courses->pluck('department_id')->toArray())) <strong>Present</strong> @endif
                                    <div class="form-group">
                                        <select name="department[]" class="department" data-placeholder="Select Departments(s)..." multiple style="width:350px;" tabindex="4">
                                            @foreach ($departments as $department)
                                            <option value="{{$department->id}}" {{in_array($department->id,$department_courses->pluck('department_id')->toArray())?"selected":""}} >{{$department->title}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="">Bulletin</label>
                                    <select name="bulletin" class="form-control" required>
                                        @foreach ($bulletins as $bulletin)
                                         <option value="{{$bulletin->id}}" {{$bulletin->id==$course->bulletin_id?"selected":""}}>{{$bulletin->bulletin}}</option>
                                         @endforeach
                                        </select>
                                   </div>
                                @endif
                               <div class="form-group">
                                <label for="">Status</label>
                                  <select name="active" class="form-control" required>
                                         <option value="1" {{$course->active==1?"selected":""}}>Active</option>
                                         <option value="0" {{$course->active==0?"selected":""}}>InActive</option>
                                      </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Update Course">
                        </div>
                      </form>
                    </div>
                    @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                     <h3>Departments that can access this course</h3>
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover courses" >
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $counter=1; ?>
                        @foreach ($department_courses as $department_course )
                        <tr class="gradeX">
                            <td>{{$counter++}}</td>
                            <td class="tb">{{$department_course->department->title}}</td>
                            <td>@if ($department_course->course->active == 1)
                                   Active
                                @else
                                   Inactive
                                @endif
                            </td>
                            <td class="lg-col-2 del">
                                <span>
                                <button id="delete-course" value="{{$course->id}}" type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal5" aria-hidden="true">
                                <i class="fa fa-trash"></i>
                                </button>
                                </span>
                           </td>
                            </tr>
                        @endforeach

                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>
                        </tfoot>
                      </table>
                    </div>
                    @endif
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
            CKEDITOR.config.autoParagraph = false;
            CKEDITOR.replace( 'description' );
            $('.department').chosen({width: "100%"});
        });
        </script>
     @endsection
