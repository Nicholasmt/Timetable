<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header nav-fit">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="/">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search" />
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right nav-size nav-fit_2">
          <li class="dropdown">
 	   
             <!-- new notifiaction starts here -->
            <!-- <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary"> 6</span>
                    </a>
	               <ul class="dropdown-menu dropdown-alerts">
                         <li>
                            <a href="#" class="dropdown-item">
                                <div  class="top-nav-color">
                                    <i class="fa fa-envelope fa-fw"></i>  message
                                    <span class="float-right text-muted small"> </span>
                                </div>
                            </a>
                         </li>
                        <li class="dropdown-divider"></li>
                      </ul>
	                </li> -->

                <!-- new notification ends here -->
                <li>
                @if (Session::get('privilege')==1 && Session::get('authenticated') == true)
                <a href="{{ route('adminprofile.edit',['profile'=>Session::get('id')])}}">
                @elseif (Session::get('privilege')==2 && Session::get('authenticated') == true)
                <a href="{{ route('timetableAdminprofile.edit',['profile'=>Session::get('id')])}}">
                @elseif (Session::get('privilege')==3 && Session::get('authenticated') == true)
                <a href="{{ route('departmentalOfficerprofile.edit',['profile'=>Session::get('id')])}}">
                @else
                <a href="{{ route('monitoringprofile.edit',['profile'=>Session::get('id')])}}">
                @endif

                    <i class="fa fa-gear"></i> Settings
                </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
        </ul>
    </nav>
</div>

<style>
  
    
  
  

</style>

 