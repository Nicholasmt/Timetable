<div class=""> 
    <h2>Records</h2>
</div>
<div class="row">
 <div class="col-lg-4">
    <div class="ibox ">
        <div class="ibox-title">
            <span class="label_primary float-right">Daily </span>
         </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{$dialyReports->count()}}</h1>
            <div class="stat-percent font-bold label_primary">Monitoring <i class="fa fa-address-book"></i></div>
          </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="ibox ">
        <div class="ibox-title">
            <span class="label_secondary float-right">Weekly </span>
         </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{$weeklyReports->count()}}</h1>
            <div class="stat-percent font-bold label_secondary">Monitoring <i class="fa fa-address-book"></i></div>
             
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="ibox ">
        <div class="ibox-title">
            <span class="label_primary float-right">All </span>
         </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{$allReports->count()}}</h1>
            <div class="stat-percent font-bold label_primary">Monitoring <i class="fa fa-address-book"></i></div>
      </div>
</div>
</div>
