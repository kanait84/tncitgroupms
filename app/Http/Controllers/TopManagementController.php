<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Comment;
use App\Department;
use Auth;

use DB;

class TopManagementController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function topmanagement()
	{

		$departments = Department::all();

		return view('topmanagement.topmanagement', compact('departments'));
	}


	public function viewDepartment(Request $request, $d_id){

		$department = Department::where('d_id', $d_id)->with('subdepartment')->first();

		return view('topmanagement.departmentlist', compact('department'));
	}


	public function viewSubdepartment(Request $request, $sd_id)
	{
		$users = User::where('sd_id', $sd_id)->with('subdepartment')->get();
		return view('topmanagement.stafflist', compact('users'));
	}

	public function viewEmployee(Request $request, $id)
	{
        $currcomments = $allcomments = $user_details = $commentArr = array();
        $i=0;
		if(isset($request->d)){
			$cdate = date('Y-m-d', strtotime($request->d));
			$reports = Report::where('u_id', $id)->where('date', $cdate)->with('user')->orderBy('date', 'DESC')->get();
		} else {
            $cdate = date('Y-m-d');
            $reports = Report::where('u_id', $id)->where('date', $cdate)->with('user')->orderBy('date', 'DESC')->get();
		}
        $commentArr = isset($reports[0]['comments']) ? $reports[0]['comments']: array();
        foreach($commentArr as $k=>$v) {
            $cuser = User::find($v->u_id);
            $user_details[$i]['name'] = $cuser->name;
            $user_details[$i]['type'] = $cuser->type;
            $user_details[$i]['email'] = $cuser->email;
            $user_details[$i]['comment'] = $v->comment;
            $user_details[$i]['commentid'] = $v->id;
            $user_details[$i]['rid'] = $v->r_id;
            $user_details[$i]['uid'] = $v->u_id;
            $user_details[$i]['created'] = $v->created_at;
            $i++;
        }
        $user = User::where('id', $id)->with('reports','department')->first();
        $seldate = isset($request->d) ? $request->d : date('Y-m-d');
        $allreports = Report::where('u_id', $id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
		return view('topmanagement.staffreport', compact('reports', 'user', 'user_details', 'uid',
            'currcomments', 'seldate', 'allreports'));
	}



	public function topReportDetails(Request $request, $r_id)
	{
        $user = Auth::user();
        $uid = $user->id;
        $report = Report::where('r_id', $r_id)->with('user', 'comments')->first();
        $i=0;
        $user_details = $commentArr = array();
        $commentArr = $report->comments;
        foreach($commentArr as $k=>$v) {
            $cuser = User::find($v->u_id);
            $user_details[$i]['name'] = $cuser->name;
            $user_details[$i]['type'] = $cuser->type;
            $user_details[$i]['email'] = $cuser->email;
            $user_details[$i]['comment'] = $v->comment;
            $user_details[$i]['commentid'] = $v->id;
            $user_details[$i]['rid'] = $v->r_id;
            $user_details[$i]['uid'] = $v->u_id;
            $user_details[$i]['created'] = $v->created_at;
            $i++;
        }
        return view('topmanagement.staffreportdetails', compact('report', 'user_details', 'uid'));
	}

}
