
  <h3 class="text-black">Time Table </h5>
    <div class="table-responsive">
     <table class="table table-striped table-bordered table-hover dataTables-example" >
     <thead>
        <tr>
            <th>S/N</th>
            <th>Venue</th>
            <th>Course</th>
            <th>Lecturer</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Actions</th>
         </tr>
        </thead>
        <tbody>
        @if ($timetables->count() == null)
            <tr>
            <td>  <span class="label label-primary">No Timetable Found</span></td>
           </tr>
           @else
           @foreach ($timetables as $timetable)
             <tr>
               <td><span class="">{{$count++}} </span></td>
                <td> {{$timetable->venue->name}} </td>
                <td>{{$timetable->allocation->course->get_full_title()}}</td>
                <td> {{$timetable->allocation->lecturer->fullname()}}</td>
                <td>{{$timetable->start_time}}</td>
                <td>{{$timetable->end_time}}</td>
                <td>
                  <a  href="{{ route('monitoring-showTimetable',[$timetable->id,$timetable->allocation->semester_id])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                </td>
             </tr>
            @endforeach
            @endif
            <tfoot>
                <th>S/N</th>
                <th>Venue</th>
                <th>Course</th>
                <th>Lecturer</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
             </tfoot>
        </tbody>
       </table>
     </div>

     <script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });

    });

</script>
