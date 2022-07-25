<div class="row">
<div class="modal inmodal" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header modal-bg">
            <button type="button" class="close-tab" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title text-white">Delete <span class="text-capitalize">{{$Timetable->allocation->course->title}}</span> TimeTable</h4>
                <h3 class="font-bold"></h3>
            </div>
        @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
        <form action="{{ route('admintimetables.destroy',['timetable'=>$Timetable])}}" method="POST">
        @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
        <form action="{{ route('timetableAdmintimetables.destroy',['timetable'=>$Timetable])}}" method="POST">
        @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
        <form action="{{ route('departmentalOfficertimetables.destroy',['timetable'=>$Timetable])}}" method="POST">
        @endif
        @csrf
        @method('DELETE')
            <div class="modal-body form-group">
               <h4 class="text-black font-bold text-center">Are you sure, You want To Delete?</h4>
               <h5 class="text-danger text-center"> Note! Once Deleted, It can not be Retrived</h5>
                <label for="">Enter Password To Proceed <span > </span></label>
                <input type="hidden" value="{{$Timetable->allocation->semester->id}}" name="semester">
                <input type="hidden" value="{{$Timetable->id}}" name="timetable">
                <input type="password" class="form-control" name="confirm_password">
               </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        </form>
    </div>
</div>
</div>
</div>   

<script>
$("#myModal5").modal('show');
</script>
 