@extends('layouts.body')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
	 <h2>Dashboard</h2>
	<ol class="breadcrumb">
      <h2 class="text-black"> Welcome {{Session::get('username')}}</h2>
  </ol>
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
                     <a value="{{$semester->id}}" id="loadReport" class="btn btn-primary"> Monitoring Records</a> 
                    @endif  
                    @endforeach
                </div>
              </div>
        </div>
    </div>
    
  <div id="records"></div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/loader.js')}}"></script>

@endsection