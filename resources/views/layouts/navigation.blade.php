<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                 <img src="{{asset('assets/image/main_logo.png')}}" class="logo_img_2">
                     <a data-toggle="dropdown" class="link-hover" >
                        <span class="text-font_2">
                            <span class="block m-t-xs heading-padding">
                             <strong class="font-bold">{{Session::get('username')}} </strong><br>
                                 <strong class="font-bold">{{Session::get('email')}} </strong>
                              </span>
                       </a>
                   </div>
                <div class="logo-element">
                    <p class="logo_2"> Timetable</p>
                    <img src="{{asset('/assets/image/main_logo.png')}}" class="img_2">
                 </div>
              </li>
              @if (Session::get('privilege') == 1 && Session::get('authenticated') == true)
                <li class="#">
                <a href="{{ route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
               </li>
                <li class="#">
                    <a href="{{ route('admindepartments.index')}}"><i class="fa fa-university"></i> <span class="nav-label">Department</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('adminusers.index')}}"><i class="fa fa-users"></i> <span class="nav-label">Users</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('adminsemesters.index')}}"><i class="fa fa-calendar"></i> <span class="nav-label">Semester</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('admincourses.index')}}"><i class="fa fa-book"></i> <span class="nav-label">Courses</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('adminvenues.index')}}"><i class="fa fa-map-marker"></i> <span class="nav-label">Venues</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('adminlecturers.index')}}"><i class="fa fa-users"></i> <span class="nav-label">Lecturers</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('admintimetables.index')}}"><i class="fa fa-calendar"></i> <span class="nav-label">TimeTables</span></a>
                </li>
                
                <li class="#">
                    <a href="{{ route('admincourse-allocations.index')}}"><i class="fa fa-book"></i> <span class="nav-label">Course Allocations</span></a>
                </li>
                <li class="#">
                <a href="{{ route('admin-reports')}}"><i class="fa fa-desktop"></i> <span class="nav-label">Monitoring Reports</span></a>
                </li>
                <li class="#">
                    <a href="{{ route('adminprofile.show',['profile'=>Session::get('id')])}}"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a>
                </li>
                @elseif (Session::get('privilege') == 2 && Session::get('authenticated') == true)
                <li class="#">
                <a href="{{ route('timetableAdmin-dashboard')}}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
               </li>
               <li class="#">
                <a href="{{ route('timetableAdminsemesters.index')}}"><i class="fa fa-calendar"></i> <span class="nav-label">Semesters</span></a>
               </li>
               <li class="#">
                <a href="{{ route('timetableAdmincourse-allocations.index')}}"><i class="fa fa-book"></i> <span class="nav-label">Course Allocations</span></a>
               </li>
               <li class="#">
                <a href="{{ route('timetableAdminvenues.index')}}"><i class="fa fa-map-marker"> </i> <span class="nav-label"> Venues </span></a>
               </li>
               <li class="#">
                    <a href="{{ route('timetableAdmintimetables.index')}}"><i class="fa fa-calendar"></i> <span class="nav-label">TimeTables</span></a>
                </li>
               <li class="#">
                <a href="{{ route('timetableAdminprofile.show',['profile'=>Session::get('id')])}}"><i class="fa fa-user"> </i> <span class="nav-label"> Profile</span></a>
               </li>
                
              @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
              <li class="#">
                <a href="{{ route('departmentalOfficer-dashboard')}}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
              </li>
              <li class="#">
                <a href="{{ route('departmentalOfficerlecturers.index')}}"><i class="fa fa-users"></i> <span class="nav-label">Lecturers</span></a>
              </li>
              <li class="#">
                <a href="{{ route('departmentalOfficercourses.index')}}"><i class="fa fa-users"></i> <span class="nav-label">Courses</span></a>
              </li>
              <li class="#">
                <a href="{{ route('departmentalOfficervenues.index')}}"><i class="fa fa-map-marker"></i> <span class="nav-label">Venues</span></a>
              </li>
              <li class="#">
                <a href="{{ route('departmentalOfficercourse-allocations.index')}}"><i class="fa fa-book"></i> <span class="nav-label">Course Allocations</span></a>
              </li>
              <li class="#">
                    <a href="{{ route('departmentalOfficertimetables.index')}}"><i class="fa fa-calendar"></i> <span class="nav-label">TimeTables</span></a>
              </li>
            <li class="">
                <a href="{{ route('departmentalOfficerprofile.show',['profile'=>Session::get('id')])}}"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a>
            </li>
            @else
              <li class="#">
                <a href="{{ route('monitoring-dashboard')}}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
              </li>
              <li class="#">
                <a href="{{ route('monitoringmonitoring.index')}}"><i class="fa fa-desktop"></i> <span class="nav-label">Monitor</span></a>
              </li>
              <li class="#">
                <a href="{{ route('monitoring-reports')}}"><i class="fa fa-address-book-o"></i> <span class="nav-label">Monitoring Reports</span></a>
              </li>
              <li class="#">
                <a href="{{ route('monitoringprofile.show',['profile'=>Session::get('id')])}}"><i class="fa fa-gear"></i> <span class="nav-label">Profile</span></a>
              </li>
            @endif
         </ul>
    </div>
</nav>
