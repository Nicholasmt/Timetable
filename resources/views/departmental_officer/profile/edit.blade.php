@extends('layouts.body')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Update Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                         <a class="text-black" href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                         @else
                         <a class="text-black" href="{{ route('monitoring-dashboard')}}">Dashboard</a>
                        @endif
                        </li>
                        <li class="breadcrumb-item">
                         @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                         <a href="{{ route('adminprofile.create')}}" class="text-black">Profile</a>
                         @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <a href="{{ route('timetableAdminprofile.create')}}" class="text-black">Profile</a>
                         @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                         <a href="{{ route('departmentalOfficerprofile.create')}}" class="text-black">Profile</a>
                         @else
                         <a href="{{ route('monitoringprofile.create')}}" class="text-black">Profile</a>
                         @endif
                        </li>
                        
                    </ol>
                </div>
                
            </div>
   
       <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-7">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Personal information</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                              </a>
                            <ul class="dropdown-menu dropdown-user">
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-10 b-r"><h3 class="m-t-none m-b">Update Personal information</h3>
                            @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                              <form role="form" method="POST" action="{{ route('adminprofile.update',['profile'=>$user])}}">
                            @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                             <form role="form" method="POST" action="{{ route('timetableAdminprofile.update',['profile'=>$user])}}">
                             @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                             <form role="form" method="POST" action="{{ route('departmentalOfficerprofile.update',['profile'=>$user])}}">
                             @else
                             <form role="form" method="POST" action="{{ route('monitoringprofile.update',['profile'=>$user])}}">
                             @endif
                                  @csrf
                                  @method('PATCH')
                                     <div class="form-group">
                                       <label>name</label> 
                                       <input type="text" value="{{($user->name)}}" class="form-control" name="name">
                                     </div>
                                        <div class="form-group">
                                            <label>Email</label> 
                                            <input type="email" value="{{($user->email)}}" class="form-control" readonly name="email">
                                        </div>
                                       @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                                       <div class="form-group">
                                         <label for="">Select Department</label>
                                          <select name="semester" id="semester" class="select2_demo_3 form-control">
                                            <!-- <option disabled selected> Current semesters</option> -->
                                            @foreach ($departments as $department)
                                            <option value="{{$department->id}}">{{$department->title}}</option>
                                             @endforeach
                                         </select>
						               </div>
                                      @endif
                                         <div class="form-group">
                                            <label>Password</label> 
                                            <input type="password" placeholder="Enter Password" class="form-control" name="password">
                                        </div>
                                        <div>
                                        <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Save Change"> 
                                     </div>
                                </form>
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-lg-5">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Update Password</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                            <ul class="dropdown-menu dropdown-user">
                            </ul>
                            </div>
                        </div>
                        <div class="ibox-content">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                          <form method="POST" action="{{ route('admin-updatePassword')}}">
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                         <form method="POST" action="{{ route('timetableAdmin-updatePassword')}}">
                        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                         <form method="POST" action="{{ route('departmentalOfficer-updatePassword')}}">
                        @else
                        <form method="POST" action="{{ route('monitoring-updatePassword')}}">
                         @endif
                                @csrf
                              <p>fill the fieds</p>
                                <div class="form-group row"><label class="col-lg-2 col-form-label">Old Password</label>
                                  <div class="col-lg-10">
                                  <input type="password" placeholder="Enter Old Password" class="form-control" name="old_password"> 
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-lg-2 col-form-label"> New Password</label>
                                         <div class="col-lg-10">
                                        <input type="password" placeholder="Enter New Password" class="form-control" name="password">
                                    </div>
                                </div>
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group row">
                                <label class="col-lg-2 col-form-label"> Confirm Password</label>
                                    <div class="col-lg-10">
                                      <input type="password" placeholder="confirm Password" class="form-control" name="confirm_password">
                                    </div>
                                </div>
                                @error('confrim_password')
                                <span class="invalid-feedback" role="alert">
                                   <strong class="text-danger">{{$message}}</strong>
                                </span>
                                @enderror
                               <div class="form-group row">
                                 </div>
                                <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn btn-primary" type="submit" value="Save Change">
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
      </div>
@endsection