<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login_auth.login');
});

Route::post('auth', [App\Http\Controllers\IndexController::class, 'store'])->name('auth');
Route::get('redirect_auth', [App\Http\Controllers\IndexController::class, 'index'])->name('redirect_auth');
Route::get('logout', [App\Http\Controllers\IndexController::class, 'logout'])->name('logout');
Route::post('/timetable/set',[App\Http\Controllers\TimeTableController::class,'set_timetable'])->name('set_time_table');


Route::group(['prefix'=>'admin', 'as'=>'admin', 'middleware'=>'admin'],function()
{
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('-dashboard');
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('semesters', App\Http\Controllers\SemesterController::class);
    Route::resource('courses', App\Http\Controllers\CourseController::class);
    Route::resource('venues', App\Http\Controllers\VenueController::class);
    Route::resource('lecturers', App\Http\Controllers\LecturerController::class);
    Route::resource('timetables', App\Http\Controllers\TimetableController::class);
    Route::resource('monitoring-reports', App\Http\Controllers\MonitoringController::class);
    Route::resource('course-allocations', App\Http\Controllers\CourseAllocationController::class);
    Route::resource('profile', App\Http\Controllers\DepartmentalOfficerController::class);
    Route::resource('monitoring', App\Http\Controllers\MonitoringController::class);
    Route::get('/monitoring-report', [App\Http\Controllers\MonitoringController::class, 'monitoring_report'])->name('-reports');
    Route::post('/fliter-report', [App\Http\Controllers\MonitoringController::class, 'fliter_report'])->name('-fliterReport');
    Route::post('/update-password', [App\Http\Controllers\DepartmentalOfficerController::class, 'update_Password'])->name('-updatePassword');
    // delete modal
    Route::get('/confirm-department-delete/{department}', [App\Http\Controllers\DepartmentController::class, 'delete_modal'])->name('-confirmDepartmentDelete');
    Route::get('/confirm-user-delete/{user}', [App\Http\Controllers\UserController::class, 'delete_modal'])->name('-confirmUserDelete');
    Route::get('/confirm-semester-delete/{semester}', [App\Http\Controllers\SemesterController::class, 'delete_modal'])->name('-confirmSemesterDelete');
    Route::get('/confirm-course-delete/{course}', [App\Http\Controllers\CourseController::class, 'delete_modal'])->name('-confirmCourseDelete');
    Route::get('/confirm-venue-delete/{venue}', [App\Http\Controllers\VenueController::class, 'delete_modal'])->name('-confirmVenueDelete');
    Route::get('/confirm-lecturer-delete/{lecturer}', [App\Http\Controllers\LecturerController::class, 'delete_modal'])->name('-confirmLecturerDelete');
    Route::get('/departmental-view/{id}', [App\Http\Controllers\CourseAllocationController::class, 'departmental_view'])->name('-departmentalView');
    Route::post('allocation/unblock',[App\Http\Controllers\CourseAllocationController::class, 'unblock'])->name('unblock-allocation');

    Route::get('/delete-timetable', [App\Http\Controllers\TimetableController::class, 'delete_timetable'])->name('-deleteTimetable');

});


Route::group(['prefix'=>'departmentalOfficer', 'as'=>'departmentalOfficer', 'middleware'=>'departmentalOfficer'],function()
{

    Route::get('/dashboard', [App\Http\Controllers\DepartmentalOfficerController::class, 'index'])->name('-dashboard');
    Route::resource('course-allocations', App\Http\Controllers\CourseAllocationController::class);
    Route::resource('profile', App\Http\Controllers\DepartmentalOfficerController::class);
    Route::resource('lecturers', App\Http\Controllers\LecturerController::class);
    Route::resource('courses', App\Http\Controllers\CourseController::class);
    Route::resource('venues', App\Http\Controllers\VenueController::class);
    Route::resource('timetables', App\Http\Controllers\TimetableController::class);
    Route::get('/confirm-courseAllocation-delete/{course_allocation}', [App\Http\Controllers\CourseAllocationController::class, 'delete_modal'])->name('-confirmCourseAllocationDelete');
    Route::get('/departmental-view/{id}', [App\Http\Controllers\CourseAllocationController::class, 'departmental_view'])->name('-departmentalView');
    Route::post('/update-password', [App\Http\Controllers\DepartmentalOfficerController::class, 'update_Password'])->name('-updatePassword');
    Route::post('allocation/submit',[App\Http\Controllers\CourseAllocationController::class, 'submit'])->name('submit-allocation');
    Route::get('/delete-timetable', [App\Http\Controllers\TimetableController::class, 'delete_timetable'])->name('-deleteTimetable');

});

Route::group(['prefix'=>'timetableAdmin', 'as'=>'timetableAdmin', 'middleware'=>'timetableAdmin'],function()
{

    Route::get('/dashboard', [App\Http\Controllers\TimetableAdminController::class, 'index'])->name('-dashboard');
    Route::resource('semesters', App\Http\Controllers\SemesterController::class);
    Route::resource('course-allocations', App\Http\Controllers\CourseAllocationController::class);
    Route::resource('venues', App\Http\Controllers\VenueController::class);
    Route::resource('profile', App\Http\Controllers\DepartmentalOfficerController::class);
    Route::resource('timetables', App\Http\Controllers\TimetableController::class);
    Route::post('/update-password', [App\Http\Controllers\DepartmentalOfficerController::class, 'update_Password'])->name('-updatePassword');
    Route::get('/departmental-view/{id}', [App\Http\Controllers\CourseAllocationController::class, 'departmental_view'])->name('-departmentalView');
    Route::get('/delete-timetable', [App\Http\Controllers\TimetableController::class, 'delete_timetable'])->name('-deleteTimetable');


});
Route::group(['prefix'=>'monitoring', 'as'=>'monitoring', 'middleware'=>'monitoring'],function()
{
    Route::get('/dashboard', [App\Http\Controllers\MonitoringOfficerController::class, 'index'])->name('-dashboard');
    Route::get('/Report-data/{id}', [App\Http\Controllers\MonitoringOfficerController::class, 'load_report'])->name('-loadData');
    Route::resource('profile', App\Http\Controllers\DepartmentalOfficerController::class);
    Route::resource('monitoring', App\Http\Controllers\MonitoringController::class);
    Route::get('/load-timetable', [App\Http\Controllers\MonitoringController::class, 'load_timetable'])->name('-loadTimetable');
    Route::post('/fliterd-report', [App\Http\Controllers\MonitoringController::class, 'fliter_report'])->name('-fliterReport');
    Route::get('/monitoring-report', [App\Http\Controllers\MonitoringController::class, 'monitoring_report'])->name('-reports');
    Route::get('/show-timetable/{timetable_id}/{tableData}', [App\Http\Controllers\MonitoringController::class, 'show_timetable'])->name('-showTimetable');
    Route::post('/update-password', [App\Http\Controllers\DepartmentalOfficerController::class, 'update_Password'])->name('-updatePassword');

});
