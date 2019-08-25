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

Route::get('/welcomeold', function () {
    return view('welcomeold');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/submitreport', 'HomeController@submitReport')->name('submitreport');

Route::get('/postReport', 'HomeController@postReport');
Route::post('/postReport', 'HomeController@postReport');

Route::get('reportdetails/{r_id}', 'HomeController@reportDetails')->name('reportdetails');

Route::get('settings', 'HomeController@settings')->name('settings');

//administrator
Route::get('/admin', 'AdminController@admin')
->middleware('admin')
->name('admin');

Route::get('/department', 'AdminController@department')
->middleware('admin')
->name('department');

Route::get('/adddepartment', 'AdminController@addDepartment')
->middleware('admin')
->name('adddepartment');

Route::post('/postdepartment', 'AdminController@postDepartment')
->middleware('admin')
->name('postdepartment');


Route::get('/subdepartment', 'AdminController@subDepartment')
->middleware('admin')
->name('subdepartment');

Route::get('/addsubdepartment', 'AdminController@addSubDepartment')
->middleware('admin')
->name('addsubdepartment');

Route::post('/postsubdepartment', 'AdminController@postSubDepartment')
->middleware('admin')
->name('postsubdepartment');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('admin')  ;
Route::post('register', 'Auth\RegisterController@register')->middleware('admin')  ;

Route::get('/deletecomment/{c_id}/{r_id}', 'ManagementController@deletecomment')->name('deletecomment');

Route::get('/deleteuser/{uid}','AdminController@deleteuser')->name('deleteuser');

// management
Route::get('/management', 'ManagementController@management')
//->middleware('is_management')
->name('management');

Route::get('/mviewdepartment/{d_id}', 'ManagementController@mViewSubdepartment')
->middleware('is_management')
->name('mviewdepartment');

Route::get('mviewemployee/{id}', 'ManagementController@mviewEmployee')
->middleware('is_management')
->name('mviewemployee');

Route::get('smviewemployee/{id}', 'SubmanagementController@smviewEmployee')
    ->middleware('is_submanagement')
    ->name('smviewemployee');

Route::get('/management/subdept/{d_id}', 'ManagementController@subdepartments')
    ->name('subdept');

// topmanagement
Route::get('/topmanagement', 'TopManagementController@topmanagement')
->middleware('is_topmanagement')
->name('is_topmanagement');

//submanagement
Route::get('/submanagement', 'SubmanagementController@smViewSubdepartment')
    ->middleware('is_submanagement')
    ->name('submanagement');

Route::get('/viewdepartment/{d_id}', 'TopManagementController@viewDepartment')
->middleware('is_topmanagement')
->name('viewdepartment');

Route::get('viewsubdepartment/{id}', 'TopManagementController@viewSubdepartment')
->middleware('is_topmanagement')
->name('viewsubdepartment');

Route::get('viewemployee/{id}', 'TopManagementController@viewEmployee')
->middleware('is_topmanagement')
->name('viewemployee');

Route::get('missedreport', 'TopManagementController@missedReport')
    ->middleware('is_topmanagement')
    ->name('missedreport');

Route::get('/empreportdetails/{r_id}', 'TopManagementController@topReportDetails')->name('empreportdetails');

Route::get('/post_comments', 'ManagementController@savecomments')->name('post_comments');
Route::post('/post_comments', 'ManagementController@savecomments')->name('post_comments');

Route::get('/profile/update', 'ManagementController@updateProfile')->name('profile_update');
Route::post('/profile/update', 'ManagementController@updateProfile')->name('profile_update');

Route::get('report/{r_id}/{n_id}', 'HomeController@updateReport')->name('report_update');
Route::post('report/{r_id}/{n_id}', 'HomeController@updateReport')->name('report_update');

Route::get('/editrequest/{u_id}/{r_id}/{r_date}', 'HomeController@editrequest');

Route::get('approvaledit/{n_id}/{u_id}/{r_id}/{r_date}', 'ManagementController@approvaledit')->name('approvaledit');
Route::post('approvaledit/{n_id}/{u_id}/{r_id}/{r_date}', 'ManagementController@approvaledit')->name('approvaledit');

Route::get('approvedreq/{r_id}/{n_id}', 'ManagementController@approvedreq');
Route::get('disapprovedreq/{r_id}/{n_id}', 'ManagementController@disapprovedreq');

Route::get('approvalreject/{n_id}', 'ManagementController@approvalreject');

Route::get('maskAsRead', function (){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markRead');

