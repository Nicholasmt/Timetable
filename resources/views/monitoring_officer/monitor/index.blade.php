@extends('layouts.body')
@section('content')
 <div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
	 <h2>Monitor Timetable</h2>
		<ol class="breadcrumb">
		   <li class="breadcrumb-item">
		       <a class="text-black"href="{{ route('monitoring-dashboard')}}">Dashboard</a>
		     </li>
			<li class="breadcrumb-item-active">
			   <a class="text-black">Monitor</a>
			</li>
           </ol>
	   </div>
    
  </div>
 <div class="wrapper wrapper-content animated fadeInRight">
   <div class="row">
     <div class="ibox-content">
        <div class="row">
           <div class="col-sm-12 b-r">
            <ul class="nav nav-tabs">
              <li><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-desktop"></i> MONITOR TIMETABLE</a></li>
               
             </ul>
               <div class="tab-content">
                 <div id="tab-1" class="tab-pane active">
                    <h3 class="text-black text-center ">SELECT SEMESTER  AND VENUE TO CONTINUE</h3>
                    <form action="{{ route('monitoring-loadTimetable')}}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="">Select Semesters</label>
						                <select name="semester" id="semester" class="select2_demo_3 form-control">
                            <option disabled selected> Current semesters</option>
						                 @foreach ($semesters as $semester )
                             @if(\Schema::hasTable('timetable_data_'.$semester->id) && \Schema::hasTable('monitoring_table_'.$semester->id))
                               <option value="{{$semester->id}}">{{$semester->title}}</option>
                               @endif
                             @endforeach
						               </select>
						              </div>
						
						<div class="form-group">
                        <label for="">Select Venue </label>
						 <select name="venue" id="venue" class="select2_demo_3 form-control">
                            <option disabled selected> Select Venue </option>
						     @foreach ($venues as $venue)
                                <option value="{{$venue->id}}">{{$venue->name}}</option>
                            @endforeach
						 </select>
						 </div>
					<div class="form-group">
                      <input type="submit" id="loadBtn" class="btn btn-primary" value="submit">
                    </div>
                    </form>
                   
                          <div id="load_timetable"></div>

                      </div>
				  </div>
				</div>
			  </div>
		   </div>
		</div>	

@endsection

@section('')
@section('scripts')
<script src="{{ asset('assets/js/loader.js')}}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
     $('.semester').chosen({width: "100%"});
</script>
 
@endsection
