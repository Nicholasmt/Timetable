@extends('layouts.body')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
        <h2>Update Semester</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                     <a class="text-black" href="{{ route('admin-dashboard')}}">Dashboard</a>
                     @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                     <a class="text-black" href="{{ route('timetableAdmin-dashboard')}}">Dashboard</a>
                     @endif
                </li>
                  <li class="breadcrumb-item-active">
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                    <a class="text-black" href="{{ route('adminsemesters.index')}}">Semesters</a>
                  @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                  <a class="text-black" href="{{ route('timetableAdminsemesters.index')}}">Semesters</a>
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
                <li class="clor"><a class="nav-link" data-toggle="tab" href="#tab-1"><i class="fa fa-edit"></i> UPDATE SEMESTER</a></li>
                </ul>
             <div class="tab-content">
               <div id="tab-1" class="tab-pane active">
                  <h3 class="m-t-none m-b text-center table-color">UPDATE SEMESTER</h3>
                  @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                     <form role="form" action="{{ route('adminsemesters.update',['semester'=>$semester])}}" method="POST">
                  @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                      <form role="form" action="{{ route('timetableAdminsemesters.update',['semester'=>$semester])}}" method="POST">
                        @endif
                            @csrf
                            @method('PATCH')
                          <div class="form-group">
                            <label>Semester Title</label>
                            <input type="hidden" value="{{$semester->id}}" name="id">
                               <input type="text" value="{{$semester->title}}" class="form-control @error('title') is-invalid @enderror" name="title">
                                </div>
                               @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                            <div class="form-group">
                             <label>Start Date</label>
                             <input type="datetime" value="{{date('Y-m-d',strtotime($semester->start))}}" class="form-control @error('start') is-invalid @enderror" name="start">
                                </div>
                               @error('start')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                          <div class="form-group">
                            <label>End Date</label>
                              <input type="datetime" value="{{date('Y-m-d',strtotime($semester->end))}}" class="form-control @error('end') is-invalid @enderror" name="end">
                                </div>
                               @error('end')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{$message}}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label><i class="fa fa-clock"></i> Current Semester</label>
                                    <input type="checkbox" name="current" {{$semester->current==1?"checked":""}} class="js-switch_3"/>
                                 </div>
                                <div class="form-group">
                                  <select name="active" class="form-control" required>
                                      <option value="1" {{$semester->active==1?"selected":""}}>Active</option>
                                      <option value="0" {{$semester->active==0?"selected":""}}>Inactive</option>
                                    </select>
                                 </div>
                          <div class="form-group" >
                            <input class="btn btn-ms btn-primary float-right m-t-n-xs" type="submit" value="Update Semester">
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
          <script src="{{ asset('asset/js/plugins/switchery/switchery.js')}}"></script>
          <script>
            var elem_3 = document.querySelector('.js-switch_3');
            var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });
          </script>
      @endsection
