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
    Route::get('/designation', 'DesignationController@index');
    Route::any('/designation/edit', 'DesignationController@edit');
    

    // Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
});

Route::any('/pass', function() {
   return bcrypt('123456');
});

