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

Route::group(['middleware' => 'acl'], function () {
    Route::get('/organization/', 'OrganizationController@show');
    Route::any('/organization/edit', 'OrganizationController@edit');
    Route::get('/branch', 'BranchController@index');
    Route::any('/branch/edit', 'BranchController@edit');
    Route::get('/department', 'DepartmentController@index');
    Route::any('/department/edit', 'DepartmentController@edit');
    Route::get('/department/json/{branch_id}', 'DepartmentController@getLists')->where('id', '[0-9]+');

    Route::get('/designation', 'DesignationController@index');
    Route::any('/designation/edit', 'DesignationController@edit');

    Route::get('/section', 'SectionController@index');
    Route::any('/section/edit', 'SectionController@edit');
    Route::get('/section/json/{department_id}', 'SectionController@getLists')->where('id', '[0-9]+');

    Route::get('/employee', 'EmployeeController@index');
    Route::any('/employee/edit', 'EmployeeController@edit');
    Route::get('/employee/json/{department_id}','EmployeeController@getLists')->where('id', '[0-9]+');
    
    Route::get('/line', 'LineController@index');
    Route::any('/line/edit', 'LineController@edit');


    // Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');



});

Route::any('/pass', function() {
   return bcrypt('123456');
});

Route::any('/test/branch', function() {
   $branch =  \App\Model\Branch::where(['id'=>1])->with('departments')->get();
   print_r(array_pluck($branch[0]->departments->toArray(), 'id'));
});

