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
        if(Auth::user()->type == 'employee') {
            return redirect('/home');
        } else {
        $users = User::find(Auth::user()->id);
        $d_id = $users->d_id;
        $sd_id = $users->sd_id;
        $departments = Department::all();
            if(Auth::user()->type == 'management') {
                $ausers = User::where('d_id', Auth::user()->d_id)
                    ->whereRaw("id!= $users->id")->with('subdepartment')->get();
                $usercount = User::where('d_id', Auth::user()->d_id)->with('subdepartment')->count();
            } elseif(Auth::user()->type == 'submanagement') {
                $ausers = User::where('d_id', Auth::user()->d_id)->where('sd_id', Auth::user()->sd_id)
                    ->whereRaw("id!= $users->id")->with('subdepartment')->get();
                $usercount = User::where('d_id', Auth::user()->d_id)->where('sd_id', Auth::user()->sd_id)
                    ->with('subdepartment')->count();
            } elseif(Auth::user()->type == 'topmanagement') {
                $ausers = User::whereRaw("id!= $users->id")->with('subdepartment')->get();
                $usercount = User::all()->count();
            }
        $ulist = array();
        foreach($ausers as $k=>$v){  $ulist[] = $v->id; }
        if (is_array($ulist) && count($ulist)>1){ $alluid = implode(',',$ulist); } else { $alluid = $ulist[0]; }

        if(Auth::user()->type == 'topmanagement') {
            $recentreports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
            $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
                ->whereRaw('Date(created_at) = CURDATE()')->count();
        } else {
            $recentreports = Report::whereIn('u_id', array($alluid))->with('user')->orderBy('created_at', 'DESC')->take(4)->get();
            $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
                ->whereIn('u_id', array($alluid))->whereRaw('Date(created_at) = CURDATE()')->count();
        }

        $seldate = date('Y-m-d');
        $yesterday = date("Y-m-d", mktime(0, 0, 0, date("m") ,
            date("d")-1,date("Y")));
        $lweek = date("Y-m-d", mktime(0, 0, 0, date("m") ,
            date("d")-7,date("Y")));
        $lmonth = date("Y-m-d", strtotime('-1 month', time()));

            if(isset($request->d)){
                $cdate = date('Y-m-d', strtotime($request->d));
                //Convert the date string into a unix timestamp.
                $unixTimestamp = strtotime($cdate);
                $filterdate = $request->d;
                $dayOfWeek = date("l", $unixTimestamp);
                $uid_Arr = $alluid_Arr = $filteredusers = array();
                if($dayOfWeek=='Saturday' || $dayOfWeek=='Friday'){
                    $reports = $listusers = array();
                } else {
                    $reports = DB::table('reports')->select('u_id')
                        ->where('date', $cdate)
                        ->whereRaw("DAYNAME(date) NOT IN ('Saturday', 'Friday')")
                        ->orderBy('date', 'DESC')->get();
                    foreach($reports as $k=>$v){ $uid_Arr[] = $v->u_id; }
                    if(Auth::user()->type == 'management') {
                        $allusers = User::where('d_id', $d_id)->whereRaw("id!= $users->id")->get();
                    } elseif(Auth::user()->type == 'submanagement') {
                        $allusers = User::where('d_id', $d_id)->where('sd_id', $sd_id)->whereRaw("id!= $users->id")->get();
                    } elseif(Auth::user()->type == 'topmanagement') {
                        $allusers = User::whereRaw("id!= $users->id")->get();
                    }
                    foreach($allusers as $k=>$v){ $alluid_Arr[] = $v->id; }
                    $filteredusers = array_diff($alluid_Arr, $uid_Arr);
                    $listusers = User::whereIn('id', $filteredusers)->with('department', 'subdepartment')->get();
                }
                return view('topmanagement.missedreport', compact('reports', 'users', 'departments',
                    'usercount', 'todayreportcnt', 'recentreports','seldate', 'listusers', 'filterdate',
                    'yesterday', 'lweek', 'lmonth'));
            }
            elseif(isset($request->dweek)){
                $cdate = date('Y-m-d', strtotime($request->dweek));
                $filterdate = $dweek = isset($request->dweek) ? $request->dweek : '';
                $uid_Arr = $alluid_Arr = $filteredusers = array();
                $reports = DB::table('reports')->select('u_id', 'date')
                    ->whereBetween('date', [$cdate, $seldate])
                    ->whereRaw("DAYNAME(date) NOT IN ('Saturday', 'Friday')")
                    ->orderBy('date', 'DESC')->get();
                foreach($reports as $k=>$v){
                    $uid_Arr[] = $v->u_id;
                    $reportdates[] = $v->date;
                    }

                if(Auth::user()->type == 'management') {
                    $allusers = User::where('d_id', $d_id)->whereRaw("id!= $users->id")->get();
                } elseif(Auth::user()->type == 'submanagement') {
                    $allusers = User::where('d_id', $d_id)->where('sd_id', $sd_id)->whereRaw("id!= $users->id")->get();
                } elseif(Auth::user()->type == 'topmanagement') {
                    $allusers = User::whereRaw("id!= $users->id")->get();
                }

                foreach($allusers as $k=>$v){ $alluid_Arr[] = $v->id; }
                $date_from = strtotime($cdate); // Convert date to a UNIX timestamp
                $date_to = strtotime($seldate); // Convert date to a UNIX timestamp
                for ($i=$date_from; $i<$date_to; $i+=86400) {
                    $dayofweek = date("l", $i);
                    if($dayofweek!='Friday' && $dayofweek!='Saturday'){
                        $alldates[] = date("Y-m-d", $i);
                    }
                }
                $listusers = User::whereIn('id', $alluid_Arr)
                    ->with('department', 'subdepartment')->get();
                foreach ($listusers as $k=>$v){
                    $reportcounts = Report::where('u_id',$v->id)
                        ->where('date','>=',$cdate)
                        ->where('date','<=',$seldate)
                             ->count();
                    $ureports = Report::where('u_id',$v->id)
                        ->where('date','>=',$cdate)
                        ->where('date','<=',$seldate)
                         ->get();
                    $countaldates = count($alldates);
                    $countureports = count($ureports);
                    if($reportcounts==0){
                        $v->missdates = $countaldates;
                    }
                    if($countureports!=0){
                        $v->missdates = ($countaldates - $countureports);
                    }
                }
                return view('topmanagement.missedreport', compact('reports', 'users', 'departments',
                    'usercount', 'todayreportcnt', 'recentreports','seldate', 'listusers', 'filterdate',
                    'yesterday', 'lweek', 'lmonth'));
            }
            else {
                return redirect('/home');
            }
        }
    }

    public function allmissedReports($u_id, $r_date)
    {
        $seldate = date('Y-m-d');
        $reports = DB::table('reports')
            ->where('u_id', $u_id)
            ->where('date','>=',$r_date)
            ->where('date','<=',$seldate)
            ->whereRaw("DAYNAME(date) NOT IN ('Saturday', 'Friday')")
            ->orderBy('date', 'DESC')->get();
        return $reports;
    }

    public function listmissreports($u_id, $r_date)
    {
        $users = User::find(Auth::user()->id);
        $d_id = $users->d_id;
        $sd_id = $users->sd_id;
        $recentreports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $departments = Department::all();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $alldates = $filterdates = $reportdates = array();
        $seldate = date('Y-m-d');
        $reports = $this->allmissedReports($u_id, $r_date);
        $misseduser = User::find($u_id)->name;
        foreach($reports as $k=>$v){
            $reportdates[] = $v->date;
        }
        $date_from = strtotime($r_date); // Convert date to a UNIX timestamp
        $date_to = strtotime($seldate); // Convert date to a UNIX timestamp
        for ($i=$date_from; $i<$date_to; $i+=86400) {
            $unixTimestamp = strtotime($i);
            $dayofweek = date("l", $i);
            if($dayofweek!='Friday' && $dayofweek!='Saturday'){
                $alldates[] = date("Y-m-d", $i);
            }
        }
        $filterdates = array_diff($alldates, $reportdates);
        $datediff = ($date_to - $date_from)/60/60/24;
        return view('topmanagement.listmissreports', compact('datediff','misseduser','filterdates',
            'users', 'departments', 'usercount', 'todayreportcnt', 'recentreports','seldate'));
    }
}
