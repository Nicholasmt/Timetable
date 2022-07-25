@extends('layouts.body')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Update Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('timetableAdmin-profile')}}" class="text-black">Profile</a>
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

                               <form role="form" method="POST" action="{{ route('timetableAdmin-updateEdit')}}">
                                  @csrf
                                     <div class="form-group">
                                   
                                         <label>name</label> 
                                         <input type="text" value="{{($user->name)}}" class="form-control" name="name">
                                           </div>

                                           <div class="form-group">
                                         <label>Email</label> 
                                         <input type="email" value="{{($user->email)}}" class="form-control" readonly name="email">
                                             </div>
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
                            <form method="post" action="{{ route('timetableAdmin-updatePassword')}}">
                                @csrf
                                @method('POST')
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