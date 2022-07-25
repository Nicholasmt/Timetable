    @extends('layouts.body')
    @section('content')
    <div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                      <h2>Monitor Timetable</h2>
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                         <a class="text-black"href="{{ route('monitoring-dashboard')}}">Dashboard</a>
                         </li>
                        <li class="breadcrumb-item-active">
                         <a href="{{ route('monitoringmonitoring.index')}}" class="text-black">Monitor</a>
                         </li>
                     </ol>
                    </div>
                 </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <dl class="row mb-0">
                        <div class="col-sm-5 text-sm-right"><dt>Timetable Status:</dt> </div>
                        @if ($timetable->active==1)
                        <div class="col-sm-7 text-sm-left"><dd class="mb-1"><span class="label label-primary">Active</span></dd></div>
                        @else
                        <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-warning">INActive</span></dd></div>
                        @endif
                     </dl>

                    <div class="col-sm-12 text-sm-right text-padding"><dt>LECTURER</dt> </div>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right"> <dt>Full Name:</dt></div>
                        <div class="col-sm-8 text-sm-left"> <dd class="mb-1">{{$timetable->allocation->lecturer->title .". ". $timetable->allocation->lecturer->fullname}}</dd></div>
                    </dl>

                  <div class="col-sm-12 text-sm-right text-padding"><dt>VENUE</dt></div>
                  <dl class="row mb-0">
                     <div class="col-sm-4 text-sm-right"><dt>Location:</dt></div>
                     <div class="col-sm-8 text-sm-left"> <dd class="mb-1"> {{$timetable->venue->name}} </dd></div>
                 </dl>
                 <dl class="row mb-0">
                     <div class="col-sm-4 text-sm-right"><dt>Description:</dt></div>
                     <div class="col-sm-8 text-sm-left"> <dd class="mb-1"> {{$timetable->venue->description}} </dd></div>
                 </dl>
               </div>

                <div class="col-lg-6" id="cluster_info">
                  <div class="col-sm-12 text-sm-right text-padding"><dt>DEPARTMENT</dt> </div>
                      <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right"><dt>Name:</dt></div>
                        <div class="col-sm-8 text-sm-left"> <dd class="mb-1"> {{$timetable->department->title}} </dd></div>
                      </dl>

                    <div class="col-sm-12 text-sm-right text-padding"><dt>TIMETABLE</dt> </div>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Course Code:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->allocation->course->code}}</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Courese Title:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->allocation->course->title}}</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Week Day:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->week_day}}</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Start Time:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->start_time}}</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>End Time:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->end_time}}</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Created By:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->who_created->name}}</dd>
                        </div>
                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>Last Updated:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                         <dd class="mb-1">{{$timetable->who_updated->name}}</dd>
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
                             <li><a class="nav-link active" href="#tab-1" data-toggle="tab"> ADD COMMENT</a></li>
                        </ul>
                    </div>
                </div>

            <div class="panel-body">
              <div class="tab-content">
                <div class="tab-pane" id="tab-2">
                   <div class="form-group"> </div>
                </div>
                <div class="tab-pane active" id="tab-1">
             <form action="{{ route('monitoringmonitoring.store')}}" class="" method="POST">
                @csrf
                <div class="form-group">
                    <label for=""> Number of Student</label>
                    <input type="hidden" value="{{$semester_id}}" name="semester">
                    <input type="hidden" value="{{$timetable->id}}" name="timetable_data_id">
                    <input type="text" class="form-control" name="no_of_student">
                </div>
                <div class="form-group">
                    <label for="">Comments</label>
                    <textarea type="text" class="form-control" name="comments"></textarea>
                </div>

                <div class="form-group">
                <label for="">Observation</label>
                   <select name="observation_key" class="select2_demo_3 form-control">
                        <option value="A">Very Good</option>
                        <option value="B">Good</option>
                        <option value="C">Fair</option>
                        <option value="D">Bad</option>
                  </select>
                </div>
                <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                </form>
                   </div>
                   </div>

                  </div>
                </div>
                </div>
            </div>

 @endsection


