<?php

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
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/submitreport', 'HomeController@submitReport')->name('submitreport');
Route::post('/postReport', 'HomeController@postReport');

Route::get('reportdetails/{r_id}', 'HomeController@reportDetails')->name('reportdetails');

Route::get('/admin', 'AdminController@admin')    
->middleware('admin')    
->name('admin');


// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('admin')  ;
Route::post('register', 'Auth\RegisterController@register')->middleware('admin')  ;


// management
Route::get('/management', 'ManagementController@management')    
//->middleware('is_management')
->name('management');

Route::get('/management/subdept/{d_id}', 'ManagementController@subdepartments')
    ->name('subdept');

// topmanagement
Route::get('/topmanagement', 'TopManagementController@topmanagement')    
->middleware('is_topmanagement')    
->name('is_topmanagement');

Route::get('viewemployee/{id}', 'TopManagementController@viewemployee');


Route::get('/itdepartment', 'TopManagementController@itDepartment')    
->middleware('is_topmanagement')    
->name('is_topmanagement');

Route::get('/marketing', 'TopManagementController@marketingDepartment')    
->middleware('is_topmanagement')    
->name('is_topmanagement');

Route::get('/empreportdetails/{r_id}', 'TopManagementController@topReportDetails')->name('empreportdetails');





