<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Department;
use App\Notifications\ApproveRequest;
use App\Notifications\EditRequest;
use App\Notifications\RejectRequest;
use App\Notifications\ReportComment;
use App\OverTimeRequests;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Subdepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\OtAfterMgrApprove;
use App\Notifications\OtAfterMgrDisApprove;
use App\Notifications\OtAfterTopMgtApprove;
use App\Notifications\OtAfterTopMgtDisApprove;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\OtHRRequest;
use App\Notifications\OtHRApprove;
use App\Notifications\OtHRReject;

class ManagementController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function management()
	{
        if(Auth::user()->type == 'management'){
            $subdepartments = Subdepartment::where('d_id', Auth::user()->d_id)->where('sd_id', '!=',3)->get();
            $usercount = User::where('d_id', Auth::user()->d_id)->count();
            $curruid = Auth::user()->id;
            $users = User::where('d_id', Auth::user()->d_id)->whereRaw("id!= $curruid")->with('subdepartment')->get();
            $ulist = array();
            foreach($users as $k=>$v){  $ulist[] = $v->id; }
            if (is_array($ulist) && count($ulist)>1)
                { $alluid = implode(',',$ulist); } else { $alluid = $ulist[0]; }
            $reports = Report::WhereIn('u_id', array($alluid))
                ->with('user')->orderBy('created_at', 'DESC')->take(4)->get();

            $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
                ->orWhereRaw('u_id', [$alluid])->whereRaw('Date(created_at) = CURDATE()')->count();

            $seldate = date('Y-m-d');
            return view('management.management', compact('subdepartments', 'reports', 'usercount',
                'todayreportcnt', 'seldate'));
        }
        else {
            return redirect('/home');
        }
    }

    public function mViewSubdepartment(Request $request, $sd_id)
    {
        $users = User::where('sd_id', $sd_id)->with('subdepartment')->where('id', '!=',Auth::user()->id)->get();
        $usercount = User::where('d_id', Auth::user()->d_id)->count();
        $ulist = array();
        foreach($users as $k=>$v){  $ulist[] = $v->id; }
        if (is_array($ulist) && count($ulist)>1){ $alluid = implode(',',$ulist); } else { $alluid = $ulist[0]; }

        $reports = Report::orWhereRaw('u_id', array($alluid))->with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->orWhereRaw('u_id', array($alluid))->whereRaw('Date(created_at) = CURDATE()')->count();
        $seldate = date('Y-m-d');
        return view('management.m_stafflist', compact('users', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
    }

    public function mviewEmployee(Request $request, $id)
    {
        $currcomments = $allcomments = $user_details = $commentArr = array();
        $i=0;
        if(isset($request->d)){
            $cdate = date('Y-m-d', strtotime($request->d));
            $reports = Report::where('u_id', $id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        } else {
            $cdate = date('Y-m-d');
            $reports = Report::where('u_id', $id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        }
        $commentArr = isset($reports[0]['comments']) ? $reports[0]['comments']: array();
        foreach($commentArr as $k=>$v) {
                $cuser = User::find($v->u_id);
                $user_details[$i]['name'] = $cuser->name;
                $user_details[$i]['type'] = $cuser->type;
                $user_details[$i]['email'] = $cuser->email;
                $user_details[$i]['comment'] = $v->comment;
                $user_details[$i]['emp_photo'] = $cuser->emp_photo;
                $user_details[$i]['commentid'] = $v->id;
                $user_details[$i]['rid'] = $v->r_id;
                $user_details[$i]['uid'] = $v->u_id;
                $user_details[$i]['created'] = $v->created_at;
            $i++;
        }
        $user = User::where('id', $id)->with('reports','department')->first();
        $seldate = isset($request->d) ? $request->d : date('Y-m-d');
        $allreports = Report::where('u_id', $id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        return view('management.m_staffreport', compact('reports', 'user', 'user_details', 'uid',
            'currcomments', 'seldate', 'allreports'));
    }


    public function savecomments(Request $request)
    {
        $user = Auth::user();
        $uid = $user->id;
        $comment = new Comment;
        $comment->r_id = $request->r_id;
        $comment->u_id = $uid;
        $comment->comment = $request->comment;
        $comment->save();

        $user = User::find($uid);
        $d_id = $user->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $report = Report::where('r_id', $request->r_id)->with('user', 'comments')->first();
        if(Auth::user()->type == 'employee') {
            $mgr->notify(new ReportComment($user->name, $report->date, $uid, $report->r_id));
        } elseif(Auth::user()->type == 'management') {
            $ruser = User::find($report->u_id);
            $ruser->notify(new ReportComment($user->name, $report->date, $ruser->id, $report->r_id));
        }
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
        echo "<div id='all_posts'>";
        foreach($user_details as $k=>$v) {
            $cid = $v['commentid'];
            $rid = $v['rid'];
            $useremail = $v['email'];
            $emp_photo = $v['emp_photo'];
            echo "<div class='row'>
                    <div class='col-md-12 mb'>
                    <div class='message-p pn'>
                    <div class='row'>
                    <div class='col-md-1 centered'>
                    <div class='profile-pic pic-comment'>
                    <p style='margin-top: 20px'>
                    <img  src='/photo_storage/".$emp_photo."' class='img-circle' height='100px' width='100px'></p>
                    <p>
                    </p>
                    </div>
                    </div>
                    <div class='col-md-8'>
                    <p style='margin-top: 20px; margin-left: 25px;'> <strong> ".ucfirst($v['name'])."</strong></p>
                    <p class='p-bck' style='margin-left: 25px;'>
                    ".$v['comment']."
                    </p>
                    <p style='margin-left: 25px; color:#c9c9c9'>".$v['created']."</p>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    <div align='left' style=''>
                    </div>";
        }
        echo "</div>";
    }

    public function deletecomment($c_id, $r_id, Request $request)
    {
        Comment::find($c_id)->delete();
        return redirect('/mviewemployee/'.$r_id );
    }

    public function updateProfile(Request $request)
    {
        if(isset($request->d)){
            $cdate = date('Y-m-d', strtotime($request->d));
            $reports = Report::where('u_id', Auth::user()->id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        } else {
            $cdate = date('Y-m-d');
            $reports = Report::where('u_id', Auth::user()->id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        }
        $user = User::find(Auth::user()->id);
        if(isset($request->name)){
            if($request->hasfile('emp_photo'))
            {
                $file = $request->file('emp_photo');
                $destinationPath = 'photo_storage/';
                $originalFile = $file->getClientOriginalExtension();
                $filename =  $user->email.'.'. $originalFile;
                $file->move($destinationPath, $filename);
                User::where('id',Auth::user()->id)->update(['emp_photo'=>$filename, 'file_type'=>$originalFile]);
            }

            if($request->hasfile('emp_sign'))
            {
                $file2 = $request->file('emp_sign');
                $destinationPath2 = 'emp_sign/';
                $originalFile2 = $file2->getClientOriginalExtension();
                $filename2 =  $user->email.'.'. $originalFile2;
                $file2->move($destinationPath2, $filename2);
                User::where('id',Auth::user()->id)->update(['emp_sign'=>$filename2]);
            }

            User::where('id',Auth::user()->id)->update(['name'=>$request->name, 'mobile'=>$request->mobile]);
            return redirect('/home');
        }
        $seldate = isset($request->d) ? $request->d : date('Y-m-d');
        $u_id = Auth::user()->id;
        $allreports = Report::where('u_id', Auth::user()->id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        return view('updateprofile',compact('user', 'u_id', 'seldate', 'allreports'));
    }


    public function approvaledit($n_id, $u_id, $r_id, $r_date) {
        $notify = DB::table('notifications')
            ->where('id', $n_id)->get();
        $notifyArr = json_decode($notify[0]->data);
        $notify_r_id = $notifyArr->r_id;

	    if($u_id==Auth::user()->id){
            return redirect('/report/'.$r_id.'/'.$n_id);
        } elseif($notify_r_id==$r_id){
            $report = Report::where('r_id', $r_id)->get();
            $user = User::find($u_id);
            $d_id = $user->d_id;
            $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
            $mgr_id = $mgr->id;
            return view('approvalEditRequest', compact('report', 'mgr_id', 'u_id','r_id', 'n_id', 'r_date',
                'seldate', 'allreports', 'n_id'));
        } else {
            return redirect('/home');
        }
    }

    public function empapprovaledit($n_id, $u_id, $r_id, $r_date)
    {
        $notify = DB::table('notifications')
            ->where('id', $n_id)->get();
        $notifyArr = json_decode($notify[0]->data);
        $notify_r_id = $notifyArr->r_id;
        if($notify_r_id==$r_id){
            return redirect('/report/'.$r_id.'/'.$n_id);
        } else {
            return redirect('/home');
        }
    }

    public function approvedreq($r_id, $n_id) {
        $report = Report::where('r_id', $r_id)->get();
        $user = User::find($report[0]->u_id);
        $d_id = $user->d_id;
        $currdate = date('Y-m-d H:i:s');
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        Report::where('r_id',$r_id)->update(['edit_request'=> 1]);
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        $user->notify(new ApproveRequest($mgr->name, $report[0]->date, $report[0]->u_id, $r_id));
        return redirect('/home')->with('success','Report has been approved successfully!');
    }

    public function disapprovedreq($r_id, $n_id, Request $request) {
        $report = Report::where('r_id', $r_id)->get();
        $user = User::find($report[0]->u_id);
        $d_id = $user->d_id;
        $currdate = date('Y-m-d H:i:s');
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        $user->notify(new RejectRequest($mgr->name, $report[0]->date, $report[0]->u_id, $r_id));
        return redirect('/home')->with('warning','Edit Report has been rejected successfully!');
    }

    public function approvalreject($n_id) {
        DB::table('notifications')
            ->where('id', $n_id)
            ->delete();
        return redirect('/home')->with('warning','Edit Report has been rejected successfully!');
    }

    public function mgreportcmt($n_id, $u_id, $r_date) {
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/mviewemployee/'.$u_id."?d=".$r_date);
    }

    public function empreportcmt($n_id, $r_date) {
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/home?d='.$r_date);
    }

    public function otMgrApprovedreq($n_id, $ot_date, $u_id, $report_uid) {
        $user = User::find($u_id);
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));

        DB::table('overtimerequests')
            ->where('date', $ot_date)
            ->update(array('status' => 'ManagerApproved'));

        $reportUser = User::find($report_uid);
        $reportUser->notify(new OtAfterMgrApprove($user->name, $u_id, $report_uid, $ot_date));
        return redirect('/otmgmtrequests')->with('success','OverTime has been approved successfully!');
    }

    public function otMgrDisapprovedreq($n_id, $ot_date, $u_id, $mgr_id) {
        $user = User::find($u_id);
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        DB::table('overtimerequests')
            ->where('date', $ot_date)
            ->delete();
        $mgr = User::find($mgr_id);
        $user->notify(new OtAfterMgrDisApprove($mgr->name, $u_id, $mgr_id, $ot_date));
        return redirect('/otmgmtrequests')->with('warning','OverTime Request has been rejected successfully!');
    }

    public function otTopmgtApprovedreq($n_id, $ot_date, $u_id, $report_uid) {
        $user = User::find($u_id);
        $currdate = date('Y-m-d H:i:s');
        $hrusers = User::where('d_id', '4')->where('sd_id', 15)->first();
        $hrusers->notify(new OtHRRequest($user->name, $u_id, $report_uid, $ot_date));
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/alltopmtotrequests')->with('success','OverTime has been approved successfully!');
    }

    public function otTopmgtDisapprovedreq($n_id, $ot_date, $u_id, $report_uid) {
        $user = User::find($u_id);
        $currdate = date('Y-m-d H:i:s');
        $otdate = date('Y-m-d', strtotime($ot_date));
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        DB::table('overtimerequests')
            ->where('date', $ot_date)
            ->update(array('status' => 'Rejected'));
        $reportUser = User::find($report_uid);
        $user->notify(new OtAfterTopMgtDisApprove($reportUser->name, $u_id, $report_uid, $ot_date));
        return redirect('/alltopmtotrequests')->with('warning','OverTime has been rejected successfully!');
    }

    public function otmgmtrequests(Request $request){
        $monthval = isset($request->m) ? $request->m : '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($curruid);
        $cdate = date('m/d/Y');
        $resArr = $otUserArr = $pendingUsers = $copyPendingUid = array();
        $i= -1;
        $j=0; $countHrs = $countMins = 0; $countfewhrs = $AllcountMins = 0; $totalmins1 = $totalmins1 = 0;
        $totalhours1 = $totalhours2 = $countHrs2 = $countMins1 = $countMins2 = $totalmins2 = 0;
        $prevName = $tabclass = '';

        if(isset($monthval) && $monthval!=''){
            $otDetails = OverTimeRequests::where('mgr_id', $curruid)
                ->whereRaw("MONTH(date)='".$monthval."'")->orderBy('u_id', 'DESC')->get();
            $pendingUsers = OverTimeRequests::where('mgr_id', $curruid)->where("status","Pending")
                ->whereRaw("MONTH(date)='".$monthval."'")->orderBy('u_id', 'DESC')->get();
            foreach($pendingUsers as $k=>$v ){
                array_push($copyPendingUid, $v->u_id);
            }
        } else {
            $otDetails = OverTimeRequests::where('mgr_id', $curruid)
                ->orderBy('u_id', 'DESC')->get();
            $pendingUsers = OverTimeRequests::where('mgr_id', $curruid)->where("status","Pending")
                ->orderBy('u_id', 'DESC')->get();
            foreach($pendingUsers as $k=>$v ){
                array_push($copyPendingUid, $v->u_id);
            }
        }
        $countOt = count($otDetails);
        if($countOt!=''){
            $tabclass= 'id=hidden-table-info';
        }

        foreach($otDetails as $k=>$v){
            $OtUser = User::find($v['u_id']);
            if($prevName== $OtUser->id ) {
                $resArr[$i]['emp_name'] = $OtUser->name;
                $resArr[$i]['u_id'] = $v['u_id'];
                if (in_array($v['u_id'], $copyPendingUid))
                {
                    $resArr[$i]['is_pending'] = 1;
                    $resArr[$i]['pendingcls'] = "style=background-color:#f693b0;color:#fff";
                    $resArr[$i]['anchrcls'] = 'style=color:#fff;';
                }
                else{
                    $resArr[$i]['is_pending'] = 0;
                    $resArr[$i]['pendingcls'] = "";
                    $resArr[$i]['anchrcls'] = "";
                }
                $day1hours = strtotime($v['start_time']);
                $day2hours = strtotime($v['end_time']);
                if($day2hours < $day1hours) {
                    $day2hours += 24 * 60 * 60;
                }
                $totalhours1 = floor(($day2hours - $day1hours)/3600);
                $totalmins1 = (($day2hours - $day1hours) % 3600) / 60;
                $resArr[$i]['totalhours'] = $resArr[$i]['totalhours']+ $totalhours1;
                $resArr[$i]['totalmins'] = $resArr[$i]['totalmins'] +$totalmins1;

            } else {
                $i++;
                $resArr[$i]['emp_name'] = $OtUser->name;
                $resArr[$i]['u_id'] = $v['u_id'];
                if (in_array($v['u_id'], $copyPendingUid))
                {
                    $resArr[$i]['is_pending'] = 1;
                    $resArr[$i]['pendingcls'] = "style=background-color:#f693b0;color:#fff";
                    $resArr[$i]['anchrcls'] = 'style=color:#fff';
                }
                else{
                    $resArr[$i]['is_pending'] = 0;
                    $resArr[$i]['pendingcls'] = "";
                    $resArr[$i]['anchrcls'] = "";
                }
                $day1hours = strtotime($v['start_time']);
                $day2hours = strtotime($v['end_time']);
                if($day2hours < $day1hours) {
                    $day2hours += 24 * 60 * 60;
                }
                $totalhours2 = floor(($day2hours - $day1hours)/3600);
                $totalmins2 = (($day2hours - $day1hours) % 3600) / 60;
                $resArr[$i]['totalhours'] = $totalhours2;
                $resArr[$i]['totalmins'] = $totalmins2;
            }
            $prevName = $OtUser->id;
        }
        $countMins = array_sum(array_column($resArr, 'totalmins'));
        $countHrs = array_sum(array_column($resArr, 'totalhours'));
        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        }
        $AllcountHrs = $countHrs + $countfewhrs;
        return view('management.listotmgmtrequests', compact( 'userDetails',
           'cdate', 'resArr', 'AllcountHrs', 'AllcountMins', 'tabclass', 'monthval'));
    }

    public function otsubmgmtrequests(Request $request){
        $monthval = isset($request->m) ? $request->m : '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($curruid);
        $d_id = $userDetails->d_id;
        $sd_id = $userDetails->sd_id;
        $cdate = date('m/d/Y');
        $resArr = $otUserArr = $pendingUsers = $copyPendingUid = $fewUser =array();
        $i= -1;
        $j=0; $countHrs = $countMins = 0; $countfewhrs = $AllcountMins = 0; $totalmins1 = $totalmins1 = 0;
        $totalhours1 = $totalhours2 = $countHrs2 = $countMins1 = $countMins2 = $totalmins2 = 0;
        $prevName = '';

        $allusers = User::where('d_id', $d_id)->where('sd_id', '!=',3)->where('type', '!=','submanagement')
            ->where('sd_id', $sd_id)->get();
        $ui = 0;
        foreach($allusers as $k=>$v){
            $fewUser[$ui] = $v['id'];
            $ui++;
        }
        //echo "<pre>";print_r($fewUser); die;
        if(isset($monthval) && $monthval!=''){
            $otDetails = OverTimeRequests::whereIn('u_id', $fewUser)
                ->whereRaw("MONTH(date)='".$monthval."'")->orderBy('u_id', 'DESC')->get();
            $pendingUsers = OverTimeRequests::whereIn('u_id', $fewUser)->where("status","Pending")
                ->whereRaw("MONTH(date)='".$monthval."'")->orderBy('u_id', 'DESC')->get();
            foreach($pendingUsers as $k=>$v ){
                array_push($copyPendingUid, $v->u_id);
            }
        } else {
            $otDetails = OverTimeRequests::whereIn('u_id', $fewUser)
                ->orderBy('u_id', 'DESC')->get();
            $pendingUsers = OverTimeRequests::whereIn('u_id', $fewUser)->where("status","Pending")
                ->orderBy('u_id', 'DESC')->get();
            foreach($pendingUsers as $k=>$v ){
                array_push($copyPendingUid, $v->u_id);
            }
        }
        $countOt = count($otDetails);
        if($countOt!=''){
            $tabclass= 'id=hidden-table-info';
        } else {
            $tabclass = '';
        }

        foreach($otDetails as $k=>$v){
            $OtUser = User::find($v['u_id']);
            if($prevName== $OtUser->id ) {
                $resArr[$i]['emp_name'] = $OtUser->name;
                $resArr[$i]['u_id'] = $v['u_id'];
                if (in_array($v['u_id'], $copyPendingUid))
                {
                    $resArr[$i]['is_pending'] = 1;
                    $resArr[$i]['pendingcls'] = "style=background-color:#f693b0;color:#fff";
                    $resArr[$i]['anchrcls'] = 'style=color:#fff;';
                }
                else{
                    $resArr[$i]['is_pending'] = 0;
                    $resArr[$i]['pendingcls'] = "";
                    $resArr[$i]['anchrcls'] = "";
                }
                $day1hours = strtotime($v['start_time']);
                $day2hours = strtotime($v['end_time']);
                if($day2hours < $day1hours) {
                    $day2hours += 24 * 60 * 60;
                }
                $totalhours1 = floor(($day2hours - $day1hours)/3600);
                $totalmins1 = (($day2hours - $day1hours) % 3600) / 60;
                $resArr[$i]['totalhours'] = $resArr[$i]['totalhours']+ $totalhours1;
                $resArr[$i]['totalmins'] = $resArr[$i]['totalmins'] +$totalmins1;

            } else {
                $i++;
                $resArr[$i]['emp_name'] = $OtUser->name;
                $resArr[$i]['u_id'] = $v['u_id'];
                if (in_array($v['u_id'], $copyPendingUid))
                {
                    $resArr[$i]['is_pending'] = 1;
                    $resArr[$i]['pendingcls'] = "style=background-color:#f693b0;color:#fff";
                    $resArr[$i]['anchrcls'] = 'style=color:#fff';
                }
                else{
                    $resArr[$i]['is_pending'] = 0;
                    $resArr[$i]['pendingcls'] = "";
                    $resArr[$i]['anchrcls'] = "";
                }

                $day1hours = strtotime($v['start_time']);
                $day2hours = strtotime($v['end_time']);
                if($day2hours < $day1hours) {
                    $day2hours += 24 * 60 * 60;
                }
                $totalhours2 = floor(($day2hours - $day1hours)/3600);
                $totalmins2 = (($day2hours - $day1hours) % 3600) / 60;
                $resArr[$i]['totalhours'] = $totalhours2;
                $resArr[$i]['totalmins'] = $totalmins2;
            }
            $prevName = $OtUser->id;

        }
        $countMins = array_sum(array_column($resArr, 'totalmins'));
        $countHrs = array_sum(array_column($resArr, 'totalhours'));
        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        }
        $AllcountHrs = $countHrs + $countfewhrs;
        return view('management.otsubmgmtrequests', compact( 'userDetails',
            'cdate', 'resArr', 'AllcountHrs', 'AllcountMins', 'tabclass', 'monthval'));
    }

    public function downloadcsv(){
	    $monthval = '';
        $subdepartments = Subdepartment::where('d_id', Auth::user()->d_id)->where('sd_id', '!=',3)->get();
        return view('downloadcsv', compact( 'monthval', 'subdepartments'));
    }

    /**
     * @param array $columnNames
     * @param array $rows
     * @param string $fileName
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public static function getCsv($columnNames, $rows, $fileName = '') {
        $fileName = "Report_".date('ymdhis').".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function downloadReport(Request $request){
        $monthfilter = isset($request->monthfilter) ? $request->monthfilter : date('m');
        $sdidfilter = isset($request->sdidfilter) ? $request->sdidfilter : Auth::user()->sd_id;
        $d_id = Auth::user()->d_id;
        $resArr = array();
        $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description
                    FROM reports r JOIN users u
                    ON r.u_id = u.id AND u.d_id ="'.$d_id.'" AND u.sd_id ="'.$sdidfilter.'"
                      AND u.sd_id !="3" AND MONTH(r.date) ="'.$monthfilter.'"');
        $i=0;
        foreach ($reportFilterRes as $k=>$v){
            $resArr[$i]['UserId']= $v->UserId;
            $resArr[$i]['Name']= $v->Name;
            $resArr[$i]['Subdepartment']= $v->Subdepartment;
            $resArr[$i]['Date']= $v->Date;
            $resArr[$i]['Description']= $v->Description;
            $i++;
        }
        if(count($resArr)==0){
            return redirect('downloadcsv')->with('error','No Records Found!');
        } else {
            $columnNames = ['UserId', 'Name', 'Subdepartment', 'Date', 'Description'];//replace this with your own array of string column headers
            return self::getCsv($columnNames, $resArr);
        }
    }

    public function otempRequest($n_id, $u_id, $r_date, $report_uid) {
        $notify = DB::table('notifications')
            ->where('id', $n_id)->get();
        $notifiable_id =$notify[0]->notifiable_id;
        $reportuser = User::find($report_uid);
        $reportusername = $reportuser->name;

        if($notifiable_id==Auth::user()->id){
            $otdetail = OverTimeRequests::where('date', $r_date)->get();
            $user = User::find($u_id);
            $username = $user->name;
            $d_id = $user->d_id;
            $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
            $mgrname = $mgr->name;
            $mgr_id = $mgr->id;
            $seldate = date('Y-m-d');
            $allreports = Report::where('u_id', Auth::user()->id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
            return view('otempRequest', compact('otdetail','n_id', 'u_id', 'r_date', 'mgr_id',
                'seldate', 'allreports', 'username', 'reportusername', 'mgrname'));
        } else {
            return redirect('/home');
        }
    }

    public function otHRApprovedreq($n_id, $ot_date, $u_id, $report_uid) {
        $user = User::find($u_id);
        $currdate = date('Y-m-d H:i:s');
        $otdate = date('Y-m-d', strtotime($ot_date));
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        DB::table('overtimerequests')
            ->where('date', $otdate)
            ->update(array('status' => 'Approved'));
        $curUsername = Auth::user()->name;
        $user->notify(new OtHRApprove($curUsername, $u_id, $report_uid, $ot_date));
        return redirect('/otrequests')->with('success','OverTime has been approved successfully!');
    }

    public function otHRDisapprovedreq($n_id, $ot_date, $u_id, $report_uid) {
        $user = User::find($u_id);
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        DB::table('overtimerequests')
            ->where('date', $ot_date)
            ->update(array('status' => 'Rejected'));
        $curUsername = Auth::user()->name;
        $user->notify(new OtHRReject($curUsername, $ot_date, $u_id, $report_uid));
        return redirect('/otrequests')->with('warning','OverTime has been rejected successfully!');
    }

    public function otHRApproved($n_id) {
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/otrequests')->with('success','OverTime has been Approved successfully!');
    }

    public function otHRDisapproved($n_id) {
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/otrequests')->with('warning','OverTime Request has been rejected successfully!');
    }

    public function printfilterreport(Request $request) {
        $errempmsg = isset($request->erremp) ? $request->erremp : '';
        $errdeptmsg = isset($request->errdept) ? $request->errdept : '';
        $departments = Department::all();
        $subdepartments = Subdepartment::all();
        $allusers = User::whereRaw("id!= 1")->get();
        return view('printfilterovertime', compact( 'departments','subdepartments',
            'allusers', 'errempmsg', 'errdeptmsg'));
    }

    public function downloadReportEmp(Request $request){
        $empidfilter = isset($request->empidfilter) ? $request->empidfilter : '';
        $fromdate = isset($request->fromdate) ? $request->fromdate : '';
        $todate = isset($request->todate) ? $request->todate : '';
        $resArr = array();
        if(isset($empidfilter) && $empidfilter=='allemps'){
            $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description FROM reports r JOIN users u
                    ON r.u_id = u.id AND (r.date >="'.$fromdate.'" AND r.date <="'.$todate.'") ORDER BY u.id');
        } else {
            $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description FROM reports r JOIN users u
                    ON r.u_id = u.id AND u.id = "'.$empidfilter.'" AND
                    (r.date >="'.$fromdate.'" AND r.date <="'.$todate.'") ORDER BY u.id');
        }
        $i=0;
        foreach ($reportFilterRes as $k=>$v){
            $resArr[$i]['UserId']= $v->UserId;
            $resArr[$i]['Name']= $v->Name;
            $resArr[$i]['Subdepartment']= $v->Subdepartment;
            $resArr[$i]['Date']= $v->Date;
            $resArr[$i]['Description']= $v->Description;
            $i++;
        }
        if(count($resArr)==0){
            return redirect('printfilterreport?erremp=1');
        } else {
            $columnNames = ['UserId', 'Name', 'Subdepartment', 'Date', 'Description'];//replace this with your own array of string column headers
            return self::getCsv($columnNames, $resArr);
        }
    }

    public function downloadDeptReport(Request $request){
        $didfilter = isset($request->didfilter) ? $request->didfilter : '';
        $sdidfilter = isset($request->sdidfilter) ? $request->sdidfilter : '';
        $fromdate = isset($request->fromdate) ? $request->fromdate : '';
        $todate = isset($request->todate) ? $request->todate : '';
        $resArr = array();
        $i=0;
        if($didfilter=='alldepts' && $sdidfilter=='allsubdepts'){
            $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description FROM reports r JOIN users u
                    ON r.u_id = u.id AND (r.date >="'.$fromdate.'" AND r.date <="'.$todate.'") ORDER BY u.id');
        } else if($didfilter=='alldepts' && $sdidfilter!='allsubdepts'){
            $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description FROM reports r JOIN users u
                    ON r.u_id = u.id AND u.sd_id = "'.$sdidfilter.'" AND (r.date >="'.$fromdate.'" AND
                    r.date <="'.$todate.'") ORDER BY u.id');
        } else if($didfilter!='alldepts' && $sdidfilter=='allsubdepts'){
            $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description FROM reports r JOIN users u
                    ON r.u_id = u.id AND u.d_id = "'.$didfilter.'" AND (r.date >="'.$fromdate.'" AND
                    r.date <="'.$todate.'") ORDER BY u.id');
        } else {
            $reportFilterRes = DB::select('SELECT u.id as UserId, u.name as Name,
                    (SELECT sd_title from sub_departments WHERE sd_id = u.sd_id) as Subdepartment,
                    r.date as Date, r.description as Description FROM reports r JOIN users u
                    ON r.u_id = u.id AND u.d_id = "'.$didfilter.'" AND u.sd_id = "'.$sdidfilter.'" AND
                    (r.date >="'.$fromdate.'" AND r.date <="'.$todate.'") ORDER BY u.id');
        }
        foreach ($reportFilterRes as $k=>$v){
            $resArr[$i]['UserId']= $v->UserId;
            $resArr[$i]['Name']= $v->Name;
            $resArr[$i]['Subdepartment']= $v->Subdepartment;
            $resArr[$i]['Date']= $v->Date;
            $resArr[$i]['Description']= $v->Description;
            $i++;
        }
        if(count($resArr)==0){
            return redirect('printfilterreport?errdept=1');
        } else {
            $columnNames = ['UserId', 'Name', 'Subdepartment', 'Date', 'Description'];//replace this with your own array of string column headers
            return self::getCsv($columnNames, $resArr);
        }
    }

    public function selectAjax(Request $request)
    {
        if($request->ajax()){
            if($request->d_id=='alldepts'){
                $subdepartments = DB::table('sub_departments')->pluck("sd_title","sd_id")->all();
            } else {
                $subdepartments = DB::table('sub_departments')->where('d_id',$request->d_id)->pluck("sd_title","sd_id")->all();
            }
            $data = view('ajax-select',compact('subdepartments'))->render();
            return response()->json(['options'=>$data]);
        }
    }

}
