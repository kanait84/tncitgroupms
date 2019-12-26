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

Route::get('missedreport', 'TopManagementController@missedReport')->name('missedreport');
Route::get('/empreportdetails/{r_id}', 'TopManagementController@topReportDetails')->name('empreportdetails');

Route::get('/post_comments', 'ManagementController@savecomments')->name('post_comments');
Route::post('/post_comments', 'ManagementController@savecomments')->name('post_comments');

Route::get('/profile/update', 'ManagementController@updateProfile')->name('profile_update');
Route::post('/profile/update', 'ManagementController@updateProfile')->name('profile_update');

Route::get('report/{r_id}/{n_id}', 'HomeController@updateReport')->name('report_update');
Route::post('report/{r_id}/{n_id}', 'HomeController@updateReport')->name('report_update');

Route::get('/editrequest/{u_id}/{r_id}/{r_date}', 'HomeController@editrequest');

Route::get('empapprovaledit/{n_id}/{u_id}/{r_id}/{r_date}', 'ManagementController@empapprovaledit')->name('empapprovaledit');
Route::post('empapprovaledit/{n_id}/{u_id}/{r_id}/{r_date}', 'ManagementController@empapprovaledit')->name('empapprovaledit');

Route::get('mgrapprovaledit/{n_id}/{u_id}/{r_id}/{r_date}', 'HomeController@mgrapprovaledit')->name('mgrapprovaledit');
Route::post('mgrapprovaledit/{n_id}/{u_id}/{r_id}/{r_date}', 'HomeController@mgrapprovaledit')->name('mgrapprovaledit');

Route::get('approvedreq/{r_id}/{n_id}', 'ManagementController@approvedreq');
Route::get('disapprovedreq/{r_id}/{n_id}', 'ManagementController@disapprovedreq');
Route::get('approvalreject/{n_id}', 'ManagementController@approvalreject');

Route::get('maskAsRead', function (){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markRead');

Route::get('listmissreports/{u_id}/{r_date}', 'TopManagementController@listmissreports');
Route::get('mgreportcmt/{n_id}/{u_id}/{r_date}', 'ManagementController@mgreportcmt')->name('mgreportcmt');
Route::get('empreportcmt/{n_id}/{r_date}', 'ManagementController@empreportcmt')->name('empreportcmt');

Route::get('allreports', 'AdminController@allReports')
    ->middleware('admin')
    ->name('allreports');

Route::get('/adminviewdepartment/{d_id}', 'AdminController@viewDepartment')
    ->middleware('admin')
    ->name('adminviewdepartment');

Route::get('adminviewsubdepartment/{id}', 'AdminController@viewSubdepartment')
    ->middleware('admin')
    ->name('adminviewsubdepartment');

Route::get('adminviewemployee/{id}', 'AdminController@viewEmployee')
    ->middleware('admin')
    ->name('adminviewemployee');

Route::get('/submitnewreport', 'HomeController@submitnewreport')->middleware('admin');
Route::post('/submitnewreport', 'HomeController@submitnewreport')->middleware('admin');

Route::get('/postuserReport', 'HomeController@postuserReport')->middleware('admin');
Route::post('/postuserReport', 'HomeController@postuserReport')->middleware('admin');

Route::get('overtimerequest', 'HomeController@overtimerequest');
Route::post('overtimerequest', 'HomeController@overtimerequest');
Route::get('/postOtUserRequest', 'HomeController@postOtUserRequest');
Route::post('/postOtUserRequest', 'HomeController@postOtUserRequest');

Route::get('mgrotapproval/{n_id}/{u_id}/{r_date}/{mgr_id}/{report_uid}', 'HomeController@mgrotapproval')->name('mgrotapproval');
Route::post('mgrotapproval/{n_id}/{u_id}/{r_date}/{mgr_id}/{report_uid}', 'HomeController@mgrotapproval')->name('mgrotapproval');
Route::get('otMgrApprovedreq/{n_id}/{r_date}/{u_id}/{report_uid}', 'ManagementController@otMgrApprovedreq');
Route::get('otMgrDisapprovedreq/{n_id}/{u_id}/{report_uid}/{ot_date}', 'ManagementController@otMgrDisapprovedreq');
Route::get('topmgmtapproval/{n_id}/{u_id}/{ot_date}', 'HomeController@topmgmtapproval');
Route::post('topmgmtapproval/{n_id}/{u_id}/{ot_date}', 'HomeController@topmgmtapproval');
Route::get('otTopmgtApprovedreq/{n_id}/{ot_date}/{u_id}/{report_uid}', 'ManagementController@otTopmgtApprovedreq');
Route::get('otTopmgtDisapprovedreq/{n_id}/{u_id}/{report_uid}/{ot_date}', 'ManagementController@otTopmgtDisapprovedreq');
Route::get('otapproved/{n_id}', 'HomeController@otapproved');
Route::get('otrejected/{n_id}', 'HomeController@otrejected');
Route::get('otrequests', 'HomeController@otrequests');
Route::get('otmgmtrequests', 'ManagementController@otmgmtrequests');
Route::get('otempdetails/{u_id}', 'HomeController@otempDetails');
Route::get('alltopmtotrequests', 'HomeController@alltopmtotrequests');
Route::get('allotempdetails/{u_id}', 'HomeController@allotempdetails');
Route::get('otsubmgmtrequests', 'ManagementController@otsubmgmtrequests');

Route::get('otselectrequests', 'HomeController@otselectrequests');
Route::get('printotrequests/{f_date}/{t_date}', 'HomeController@printotrequests')->name('printotrequests');

Route::get('downloadcsv', 'ManagementController@downloadcsv');
Route::get('downloadReport', 'ManagementController@downloadReport');
Route::post('downloadReport', 'ManagementController@downloadReport');

Route::get('otempRequest/{n_id}/{u_id}/{r_date}/{report_uid}', 'ManagementController@otempRequest');
Route::post('otempRequest/{n_id}/{u_id}/{r_date}/{report_uid}', 'ManagementController@otempRequest');

Route::get('otHRApprovedreq/{n_id}/{ot_date}/{u_id}/{report_uid}', 'ManagementController@otHRApprovedreq');
Route::get('otHRDisapprovedreq/{n_id}/{u_id}/{report_uid}/{ot_date}', 'ManagementController@otHRDisapprovedreq');

Route::get('otHRApproved/{n_id}', 'ManagementController@otHRApproved');
Route::get('otHRDisapproved/{n_id}', 'ManagementController@otHRDisapproved');

//Download Filtered Reports
Route::get('printfilterreport', 'ManagementController@printfilterreport')
    ->middleware('is_topmanagement')
    ->name('printfilterreport');
Route::get('downloadReportEmp', 'ManagementController@downloadReportEmp');
Route::post('downloadReportEmp', 'ManagementController@downloadReportEmp');
Route::get('downloadDeptReport', 'ManagementController@downloadDeptReport');
Route::post('downloadDeptReport', 'ManagementController@downloadDeptReport');
Route::post('select-ajax', ['as'=>'select-ajax','uses'=>'ManagementController@selectAjax']);
