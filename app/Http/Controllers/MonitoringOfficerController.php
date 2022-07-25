<?php

namespace App\Http\Controllers;
use App\Models\Semester;
use App\Http\Library\Table;
use App\Models\Monitoring_Table;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoringOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count=1;
        $semesters = Semester::where('active',1)->where('current', 1)->get();
        return view('monitoring_officer.dashboard',compact('semesters','count'));
    }

    public function load_report($id)
    {
        
        $user = session()->get('id');
        $monitoring_data = new Table($id,'m');
        $monitoring_model = $monitoring_data->set_model();
        $dialyReports = $monitoring_model->where('monitored_by',$user)->where('date_monitored',date('Y-m-d'))->get();
        $weeklyReports = $monitoring_model->where('monitored_by',$user)->where('date_monitored',[Carbon::now()->startOfWeek(Carbon::SUNDAY),Carbon::now()->endOfWeek(Carbon::SATURDAY)])->get();
        $allReports = $monitoring_model->where('monitored_by',$user)->get();
        return view('monitoring_officer.load-records',compact('dialyReports','allReports','weeklyReports'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
