@extends('layouts.body')
@section('content')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                      <h2>Course Allocation</h2>
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                          <a class="text-black"href="{{ route('admin-dashboard')}}">Dashboard</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                        <a class="text-black"href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                        @else
                        <a class="text-black"href="{{ route('departmentalOfficer-dashboard')}}">Dashboard</a>
                        @endif
                        </li>
                        <li class="breadcrumb-item-active">
                        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                          <a href="{{ route('admincourse-allocations.index')}}" class="text-black">Course Allocation</a>
                        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                          <a href="{{ route('timetableAdmincourse-allocations.index')}}" class="text-black">Course Allocation</a>
                        @else
                         <a href="{{ route('departmentalOfficercourse-allocations.index')}}" class="text-black">Course Allocation</a>
                        @endif
                        </li>
                     </ol>
                    </div>
                 </div>             
            </div>
           <div class="row">
                <div class="col-lg-6">
                    <dl class="row mb-0">
                        <div class="col-sm-5 text-sm-right"><dt>Course Allocation Status:</dt> </div>
                        @if ($course_allocation->active==1)
                        <div class="col-sm-7 text-sm-left"><dd class="mb-1"><span class="label label-primary">Active</span></dd></div>
                        @else
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-warning">INActive</span></dd></div>
                        @endif 
                     </dl>

                    <div class="col-sm-12 text-sm-right text-padding"><dt>COURSE DETAILS</dt> </div>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right"> <dt>Title:</dt></div>
                        <div class="col-sm-8 text-sm-left"> <dd class="mb-1">{{$course_allocation->course->title}}</dd></div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right"><dt>Unit:</dt> </div>
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1">{{$course_allocation->course->unit}}</dd> </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right"><dt>Description:</dt> </div>
                        <div class="col-sm-8 text-sm-left"> <dd class="mb-1">{{$course_allocation->course->created_at}}</dd></div>
                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right"><dt>Status:</dt></div>
                        @if ($course_allocation->course->active==1)
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-primary">Active</span></dd></div>
                        @else
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-warning">INActive</span></dd></div>
                        @endif 
                    </dl>
                    
                <div class="col-sm-12 text-sm-right text-padding"><dt>DEPARTMENT DETAILS</dt> </div>
                  <dl class="row mb-0">
                     <div class="col-sm-4 text-sm-right"><dt>Name:</dt> </div>
                     <div class="col-sm-8 text-sm-left"> <dd class="mb-1"> {{$course_allocation->course->department->title}} </dd></div>
                     <div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>
                      @if ($course_allocation->course->department->active==1)
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-primary">Active</span></dd></div>
                        @else
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-warning">INActive</span></dd></div>
                        @endif 
                  </dl>
               </div>

                <div class="col-lg-6" id="cluster_info">
                  <div class="col-sm-12 text-sm-right text-padding"><dt>SEMESTER DETAILS</dt> </div>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Title:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">{{$course_allocation->semester->title}}</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Starts:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">{{$course_allocation->semester->start}}</dd>
                        </div>
                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Ends:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">{{$course_allocation->semester->end}}</dd>
                        </div>
                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Current</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            @if ($course_allocation->semester->current==0)
                            <dd class="label label-warning">None</dd> 
                            @elseif ($course_allocation->semester->current == 1) 
                            <dd class="mb-1">FIRST</dd> 
                            @else
                            <dd class="mb-1">SECOND</dd> 
                            @endif
                          </div>
                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Status:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            @if ($course_allocation->semester->active)
                            <dd class="label label-primary">Active</dd>
                            @else
                            <dd class="label label-warning">INactive</dd>
                             @endif
                          </div>
                    </dl>

                    <div class="col-sm-12 text-sm-right text-padding"><dt>LECTURER'S DETAILS</dt> </div>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Title:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$course_allocation->lecturer->title}}</dd> 
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Name:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$course_allocation->lecturer->fullname}}</dd> 
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Email:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$course_allocation->lecturer->email}}</dd> 
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Department:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$course_allocation->lecturer->department->title}}</dd> 
                        </div>
                    </dl>


                  </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <dl class="row mb-0">
                         <div class="col-sm-10 text-sm-left">
                             
                        </div>
                    </dl>
                 </div>
            </div>

            <div class="row m-t-sm">
                <div class="col-lg-12">
                <div class="panel blank-panel">
                <div class="panel-heading">
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                             <!-- <li><a class="nav-link active" href="#tab-2" data-toggle="tab">  </a></li> -->
                        </ul>
                    </div>
                </div>

            <div class="panel-body">
              <div class="tab-content">
                <div class="tab-pane" id="tab-1">
                   <div class="form-group"> </div>
                </div>
                <div class="tab-pane" id="tab-2">
                <!-- <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Approver Staffs</th>
                            <th>Comments</th>
                            <th>Date</th>
                             <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                         <tr>
                            <td>  <span class="label label-primary">No Activity Found</span></td>
                        </tr>
                         <tr>
                            <td><span class="">  </span></td>
                            <td> </td>
                            <td> </td>
                            <td>
                            </td>
                            </tr>
                        </tbody>
                    </table> -->

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
 

