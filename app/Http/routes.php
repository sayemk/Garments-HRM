<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('/home',function(){
    return redirect('/dashboard');
});

Route::group(['middleware' => 'acl'], function () {

    Route::get('/dashboard','DashboardController@index');
    
    Route::get('/organization/', 'OrganizationController@show');
    Route::any('/organization/edit', 'OrganizationController@edit');
    Route::get('/branch', 'BranchController@index');
    Route::any('/branch/edit', 'BranchController@edit');
    Route::get('/department', 'DepartmentController@index');
    Route::any('/department/edit', 'DepartmentController@edit');
    Route::get('/department/json/{branch_id}', 'DepartmentController@getLists')->where('id', '[0-9]+');

    Route::get('/designation', 'DesignationController@index');
    Route::any('/designation/edit', 'DesignationController@edit');
    Route::get('/designation/json/{section_id}','DesignationController@getLists')->where('id', '[0-9]+');

    Route::get('/section', 'SectionController@index');
    Route::any('/section/edit', 'SectionController@edit');
    Route::get('/section/json/{department_id}', 'SectionController@getLists')->where('id', '[0-9]+');

    Route::get('/employee', 'EmployeeController@index');
    Route::any('/employee/edit', 'EmployeeController@edit');
    Route::get('/employee/json/{department_id}','EmployeeController@getLists')->where('id', '[0-9]+');
    
    Route::get('/line', 'LineController@index');
    Route::any('/line/edit', 'LineController@edit');
    Route::get('/line/json/{section_id}','LineController@getLists')->where('id', '[0-9]+');


    Route::get('/grade/', 'GradeController@index');
    Route::any('/grade/edit', 'GradeController@edit');
    Route::get('/grade/json/{designation_id}','GradeController@getLists')->where('id', '[0-9]+');

    Route::get('/leavetype', 'LeaveTypeController@index');
    Route::any('/leavetype/edit', 'LeaveTypeController@edit');
    Route::get('/leavetype/json/{leavetype_id}','LeaveTypeController@getLists')->where('id', '[0-9]+');

    Route::get('/leaveemployee', 'EmployeeLeaveController@index');
    Route::any('/leaveemployee/edit', 'EmployeeLeaveController@edit');
    Route::get('/leaveemployee/json/{leavetype_id}','EmployeeLeaveController@getLists')->where('id', '[0-9]+');

    Route::get('/leaveapplication','LeaveController@index');
    Route::get('/leaveapplication/create','LeaveController@create');
    Route::post('/leaveapplication','LeaveController@store');
    Route::any('/leaveapplication/edit',function(){

        $show = \Input::get('show');
        if (!empty($show)) {
           return \Redirect::action('LeaveController@show', array($show));
        }

        $modify = \Input::get('modify');
        if (!empty($modify)) {
           return \Redirect::action('LeaveController@edit', array($modify));
        }
        return redirect('/leaveapplication');
    });
    Route::get('/leaveapplication/{id}','LeaveController@show');
    Route::get('/leaveapplication/{id}/edit','LeaveController@edit');
    Route::PUT('/leaveapplication/{id}','LeaveController@update');
    Route::get('/leave/summary/json/{employee_id}','LeaveController@summary')->where('id', '^EMP-[0-9]*');

    Route::get('/holiday/destroy','HolidayController@destroy');
    Route::resource('/holiday', 'HolidayController');
    // Registration routes...
	Route::get('auth/register','Auth\AuthController@getRegister');
	Route::post('auth/register','Auth\AuthController@postRegister');


    //Salary Structure
    Route::get('/salary/structure', 'SalaryStructureController@index');
    Route::any('/salary/structure/edit', 'SalaryStructureController@edit');
    Route::get('/salary/structure/{id}/edit', 'SalaryStructureController@update');
    Route::get('/salary/register', 'SalaryController@index');
    Route::any('/salary/register/edit', 'SalaryController@edit');
    Route::get('/salary/create','SalaryController@create');
    Route::post('/salary/store','SalaryController@store');

    //Attendance
    Route::get('/attendance','AttendanceController@index');
    Route::any('/attendance/edit','AttendanceController@edit');
    Route::get('/attendance/upload','AttendanceController@create');
    Route::post('/attendance/store','AttendanceController@store');

    Route::get('/setting','SettingController@index');
    Route::any('/setting/edit','SettingController@edit');

    Route::group(['prefix' => 'report'], function () {
        Route::get('salary', 'Reports\SalaryController@index');
        Route::get('salary/download', 'Reports\SalaryController@download');
        Route::get('payslip','Reports\PayslipController@index');
        Route::get('payslip/download', 'Reports\PayslipController@download');
        Route::get('attendance','Reports\AttendanceController@index');
        Route::get('attendance/download', 'Reports\AttendanceController@download');
        Route::get('extra-ot','Reports\ExtraOtController@index');
        Route::get('extra-ot/download', 'Reports\ExtraOtController@download');
    });


    Route::controller('user', 'UserController');



});

Route::any('/pass', function() {
   return bcrypt('123456');
});

Route::any('/test/branch', function() {
   $branch =  \App\Model\Branch::where(['id'=>1])->with('departments')->get();
   print_r(array_pluck($branch[0]->departments->toArray(), 'id'));
});

