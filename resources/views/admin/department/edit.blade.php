@extends('layouts.body')
@section('content')
 
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
        <h2>Update Department</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                     <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                </li>
                  <li class="breadcrumb-item-active">
                    <a class="text-black" href="{{ route('admindepartments.index')}}">Department</a>
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
                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-edit"></i> UPDATE DEPARTMENT</a></li>
                </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane active">
                  <h3 class="m-t-none m-b text-center table-color">UPDATE DEPARTMENT</h3>
                    <form role="form" action="{{ route('admindepartments.update',['department'=>$department])}}" method="POST">
                            @csrf
                            @method('PATCH')
                          <div class="form-group">
                            <label>Department Name</label>
                            <!-- <input type="hidden" value="{{$department->id}}" name="id"> -->
                               <input type="text" value="{{$department->title}}" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title')}}">
                                </div>
                               @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                                  <select name="active" class="form-control" required>
                                      <option disabled selected>Select Status</option>
                                         <option value="1">Active</option>
                                         <option value="2">InActive</option>
                                      </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Update Department">
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
