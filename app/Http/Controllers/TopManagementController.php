<?php

namespace App\Http\Controllers;

use App\Subdepartment;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Comment;
use App\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TopManagementController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function topmanagement()
	{
		$departments = Department::all();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $seldate = date('Y-m-d');
        $subdepartments = Subdepartment::where('sd_id', '=',3)->get();
        $managers = isset($subdepartments[0]) ? $subdepartments[0] : '';
		return view('topmanagement.topmanagement', compact('departments', 'managers', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
	}

	public function viewDepartment(Request $request, $d_id){

		$department = Department::where('d_id', $d_id)->with('subdepartment')->first();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $seldate = date('Y-m-d');

		return view('topmanagement.departmentlist', compact('department', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
	}


	public function viewSubdepartment(Request $request, $sd_id)
	{
		$users = User::where('sd_id', $sd_id)->with('subdepartment')->where('id', '!=',Auth::user()->id)->where('id', '!=',1)->get();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $seldate = date('Y-m-d');
		return view('topmanagement.stafflist', compact('users', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
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
            $user_details[$i]['emp_photo'] = $cuser->emp_photo;
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
            $user_details[$i]['emp_photo'] = $cuser->emp_photo;
            $user_details[$i]['comment'] = $v->comment;
            $user_details[$i]['commentid'] = $v->id;
            $user_details[$i]['rid'] = $v->r_id;
            $user_details[$i]['uid'] = $v->u_id;
            $user_details[$i]['created'] = $v->created_at;
            $i++;
        }
        return view('topmanagement.staffreportdetails', compact('report', 'user_details', 'uid'));
	}

    public function missedReport(Request $request)
    {
        $users = User::find(Auth::user()->id);
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $departments = Department::all();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $seldate = date('Y-m-d');
        return view('topmanagement.missedreport', compact('reports', 'users', 'departments',
            'usercount', 'todayreportcnt', 'seldate' ));
    }



}
