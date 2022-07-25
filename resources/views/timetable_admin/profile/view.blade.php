@extends('layouts.body')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-black" href="{{ route('timetableAdmin-profile')}}" >Profile</a>
                </li>
                <a href="{{ route('timetableAdmin-editProfile')}}" class="btn btn-primary link-margin"> <i class="fa fa-gear"></i> Profile</a>
                </ol>
             </div>
         <div class="col-lg-1">
       </div>
    </div>
 
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">

        <div class="profile-image">
        <img class="rounded-circle circle-border m-b-md" src="{{asset('image/ofice_2.jpg')}}" class="img" alt="profile">
        </div>
        <div class="profile-info">
        <div class="">
        <div>
            <h2 class="no-margins">
                  </h2>
            <h4>{{($user->name)}}</h4>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-3">
         </div>
        <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
        <div class="ibox-title">
        <h5>Your Profile Infomations</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
         </div>
        </div>
        <div class="ibox-content">
         
            <div class="form-group  row"><label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <h2 class="no-margins">{{($user->name)}}</h2>
                </div>
            </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Privilege</label>
                <div class="col-sm-10">
                    <h2 class="no-margins">{{($user->role->title)}} </h2>
                </div>
               </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <h2 class="no-margins">{{($user->email)}}</h2>
                </div>
            </div>
                <div class="hr-line-dashed"></div>
                    
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Department</label>
                <div class="col-sm-10">
                    <h2 class="no-margins">{{($user->dept->name)}} </h2>
                </div>
               </div>
                
        </div>
    </div>
 </div>
</div>
            
 
@endsection