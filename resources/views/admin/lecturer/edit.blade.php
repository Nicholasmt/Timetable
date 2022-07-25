@extends('layouts.body')
@section('content')
  <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
        <h2>Update Lecturer</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                @endif
                </li>
                  <li class="breadcrumb-item-active">
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('adminlecturers.index')}}">lecturers</a>
                  @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('departmentalOfficerlecturers.index')}}">lecturers</a>
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
                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-edit"></i> UPDATE LECTURER</a></li>
                </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane active">
                  <h3 class="m-t-none m-b text-center table-color">UPDATE LECTURER</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('adminlecturers.update',['lecturer'=>$lecturer])}}" method="POST">
                  @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                    <form role="form" action="{{ route('departmentalOfficerlecturers.update',['lecturer'=>$lecturer])}}" method="POST">
                  @endif
                            @csrf
                            @method('PATCH')
                          <div class="form-group">
                            <label>Lecturer Title</label>
                            <input type="hidden" value="{{$lecturer->id}}" name="id">
                               <input type="text" value="{{$lecturer->title}}" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title')}}">
                                </div>
                               @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                            <div class="form-group">
                             <label>lecturer Full Name</label>
                             <input type="text" value="{{$lecturer->fullname}}" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname')}}">
                                </div>
                               @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                           <div class="form-group">
                             <label>lecturer Email Address</label>
                             <input type="text" value="{{$lecturer->email}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}">
                                </div>
                               @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                               <div class="form-group">
                                  <select name="department" class="form-control">
                                      <option value="{{$lecturer->department_id}}">{{$lecturer->department->title}}</option>
                                        @foreach ($departments as $department)
                                            <option value="{{$department->id}}">{{$department->title}}</option>
                                         @endforeach 
                                      </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Update Lecturer">
                        </div>
                      </form>
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
@endsection
