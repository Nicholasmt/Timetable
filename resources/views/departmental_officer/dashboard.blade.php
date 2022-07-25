@extends('layouts.body')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
	 <h2>Dashboard</h2>
	<ol class="breadcrumb">
         
    </ol>
</div>

<div class=""> 
    <h2> Welcome - {{Session::get('username')}}</h2>
</div>
<div class="row">
 
<div class="col-lg-4">
    <div class="ibox ">
        <div class="ibox-title">
            <span class="label_secondary float-right">All </span>
         </div>
        <div class="ibox-content">
            <h1 class="no-margins"> {{$courses->count()}}</h1>
            <div class="stat-percent font-bold label_secondary">Courses <i class="fa fa-book"></i></div>
             
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="ibox ">
        <div class="ibox-title">
            <span class="label_primary float-right">All </span>
         </div>
        <div class="ibox-content">
            <h1 class="no-margins"> {{$lecturers->count()}} </h1>
            <div class="stat-percent font-bold label_primary">Lecturers <i class="fa fa-users"></i></div>
      </div>
</div>
</div>
	
	<div class="col-lg-4">
    <div class="ibox ">
        <div class="ibox-title">
            <span class="label_secondary float-right">All </span>
         </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{$course_allocated->count()}}</h1>
            <div class="stat-percent font-bold label_secondary">Course Allocated <i class="fa fa-book"></i></div>
      </div>
   </div>
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
     <div class="ibox ">
         <div class="ibox-title">
                <h2>Current Sessions</h2>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                         <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                     </div>
                    </div>
                    <div class="ibox-content">
                    @foreach ($semesters as $semester)
                    @if(\Schema::hasTable('timetable_data_'.$semester->id) && \Schema::hasTable('monitoring_table_'.$semester->id))
                      <h3>{{$count++}}). {{$semester->title}} Session
                        <div class="stat-percent text-header font-bold"> Starts: <i class="text-line"> {{$semester->start->format('d')}}  {{date('F', strtotime($semester->start))}} {{$semester->start->format('Y')}}</i>
                        <br>
                            <p class="text-header font-bold"> Ends: <i class="text-line"> {{$semester->end->format('d')}}  {{date('F', strtotime($semester->end))}} {{$semester->end->format('Y')}} </i></p>
                        </div>
                     </h3>  
                     
                    @endif  
                    @endforeach
                   
               </div>
               
            </div>
        </div>
    </div>
    
  
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/loader.js')}}"></script>

@endsection