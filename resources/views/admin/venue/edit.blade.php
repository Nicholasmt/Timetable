@extends('layouts.body')
@section('content')
 
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
        <h2>Update Venue</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                 @else
                <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                  @endif
                </li>
                  <li class="breadcrumb-item-active">
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('adminvenues.index')}}">Venues</a>
                  @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('timetableAdminvenues.index')}}">Venues</a>
                   @else
                  <a class="text-black" href="{{ route('departmentalOfficervenues.index')}}">Venues</a>
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
                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-edit"></i> UPDATE VENUE</a></li>
                </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane active">
                  <h3 class="m-t-none m-b text-center table-color">UPDATE VENUE</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                     <form role="form" action="{{ route('adminvenues.update',['venue'=>$DepartmentVenue])}}" method="POST">
                    @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                      <form role="form" action="{{ route('timetableAdminvenues.update',['venue'=>$DepartmentVenue])}}" method="POST">
                      @else
                      <form role="form" action="{{ route('departmentalOfficervenues.update',['venue'=>$DepartmentVenue])}}" method="POST">
                        @endif
                           @csrf
                            @method('PATCH')
                          <div class="form-group">
                            <label>Venue Name</label>
                            <input type="hidden" value="{{$DepartmentVenue->venue->id}}" name="id">
                               <input type="text" value="{{$DepartmentVenue->venue->name}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
                                </div>
                               @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                            <div class="form-group">
                             <label>Venue Description</label>
                             <input type="text" value="{{$DepartmentVenue->venue->description}}" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description')}}">
                                </div>
                               @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror

                                 <div class="form-group">
                                    <label class="">Select Department</label>
                                    <select name="department" multiple class="department form-control" data-placeholder="Select Department">
                                     @foreach($departments as $department)
                                        <option class="text-black" value="{{$department->id}}" @if(isset($DepartmentVenue)) @if($DepartmentVenue->department_id==$department->id) selected @endif @endif>{{ $department->title }}</option>
                                      @endforeach
                                    </select>
                                 
                                <div class="form-group">
                                  <select name="active" class="form-control" required>
                                      <option Value="{{$DepartmentVenue->venue->active}}">
                                        @if($DepartmentVenue->venue->active==1)
                                          Active
                                        @else
                                          Inactive  
                                        @endif
                                      </option>
                                         <option value="1">Active</option>
                                         <option value="2">InActive</option>
                                      </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Update Venue">
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
<script>

 
        
  $('.chosen-container').on('click', '.no-results', function(){
      add_new_diagnosis($(this).find('span').text());
      $('.department').val('').trigger('chosen:updated');
    });
  
       
 
   $('.department').chosen({width: "100%"});
</script>
    @endsection
