<?php

namespace App\Http\Controllers;
use App\Notifications\EditRequest;
use App\Notifications\RejectRequest;
use App\Notifications\ReportComment;
use App\Notifications\OverTimeRequest;
use App\OverTimeRequests;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Comment;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use File;
use DateTime;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $currcomments = $allcomments = $user_details = $commentArr = array();
        $i=0;
        if(isset($request->d)){
            $cdate = date('Y-m-d', strtotime($request->d));
            $reports = Report::where('u_id', Auth::user()->id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        } else {
            $cdate = date('Y-m-d');
            $reports = Report::where('u_id', Auth::user()->id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
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
        $user = User::where('id', Auth::user()->id)->with('reports','department')->first();
        $seldate = isset($request->d) ? $request->d : date('Y-m-d');
        $allreports = Report::where('u_id', Auth::user()->id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        $uid = Auth::user()->id;
        return view('home', compact('reports', 'user', 'user_details', 'uid', 'currcomments', 'seldate', 'allreports'));
    }

    public function reportDetails(Request $request, $r_id)
    {
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
        $user = Auth::user();
        $uid = $user->id;
        return view('reportdetails', compact('report', 'user_details', 'uid'));
    }

    public function submitReport(Request $request){
        return view('submitreport');
    }

    public function updateReport($r_id, $n_id, Request $request){
        $notified = DB::table('notifications')
            ->where('id', $n_id)->get();
        $report = Report::where('r_id', $r_id)->with('user')->first();
        $notifiable_id =$notified[0]->notifiable_id;
        $notifyArr = json_decode($notified[0]->data);
        $notify_u_id = $notifyArr->u_id;
        $notify_r_id = $notifyArr->r_id;
        $notify_r_date =  $notifyArr->reportdate;

        if($notify_r_id==$r_id){
            if(isset($notified) && (is_null($notified[0]->read_at))){
                if($request->description){
                    if($request->hasfile('attachment'))
                    {
                        $file = $request->file('attachment');
                        $destinationPath = 'report_attachment/';
                        $originalFile = $file->getClientOriginalExtension();
                        $filename =  $report->date .'-'. $report->u_id .'.'. $originalFile;
                        $file->move($destinationPath, $filename);
                        Report::where('r_id',$r_id)->update(['attachment'=>$request->attachment, 'file_type'=>$originalFile]);
                    }
                    Report::where('r_id',$r_id)->update(['description'=>$request->description, 'edit_request'=> 0]);
                    $currdate = date('Y-m-d H:i:s');
                    DB::table('notifications')
                        ->where('id', $n_id)
                        ->update(array('read_at' => $currdate));
                    return redirect('/home?d='.$report->date)->with('success','Your Report has been updated successfully!');
                }
            } else {
                return redirect('/home')->with('error','Notification of the Report has been expired!');
            }
        } else {
            return redirect('/home')->with('error','Wrong Report Update is not allowed!');
        }
        return view('updatereport', compact('report', 'n_id'));
    }

    public function postReport(Request $request){
        $curruid = Auth::user()->id;
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('date = "'.$request->date.'"')->whereRaw('u_id = '.$curruid.'')->count();
        if($todayreportcnt==0){
            $report = new Report;
            $report->u_id = Auth::user()->id;
            $report->date = $request->date;
            $report->description = $request->description;
            $report->attachment = $request->attachment;

            if ($request->attachment != null) {
                $file = $request->file('attachment');
                $destinationPath = 'report_attachment/';
                $originalFile = $file->getClientOriginalExtension();
                $filename =  $report->date .'-'. Auth::user()->id .'.'. $originalFile;
                $file->move($destinationPath, $filename);
                $report->file_type = $originalFile;
                $request->filename = $filename;
            }
            $report->save();
            return redirect('/home?d='.$report->date)->with('success','Your Report has been submitted successfully!');
        } else {
            return redirect('/submitreport')->with('error','Already submitted Report for the given date!');
        }
    }

    public function settings() {
        return view('settings');
    }

    public function editrequest($u_id, $r_id, $r_date) {
        $user = Auth::user();
        $d_id = $user->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgr->notify(new EditRequest($user->name, $r_date, $u_id, $r_id));
        return redirect('/home?d='.$r_date)->with('success','Your Request has been sent to your Manager successfully!');
    }

    public function mgrapprovaledit($n_id, $u_id, $r_id, $r_date) {
        $notify = DB::table('notifications')
            ->where('id', $n_id)->get();
        $notifiable_id =$notify[0]->notifiable_id;
        $notifyArr = json_decode($notify[0]->data);
        $notify_u_id = $notifyArr->u_id;
        $notify_r_id = $notifyArr->r_id;
        $notify_r_date =  $notifyArr->reportdate;
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

    public function submitnewreport(Request $request){
        $allusers = User::all();
        return view('submitnewreport', compact('allusers'));
    }

    public function postuserReport(Request $request){
        $curruid = $request->userid;
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('date = "'.$request->date.'"')->whereRaw('u_id = '.$curruid.'')->count();
        if($todayreportcnt==0){
            $report = new Report;
            $report->u_id = $request->userid;
            $report->date = $request->date;
            $report->description = $request->description;
            $report->attachment = $request->attachment;

            if ($request->attachment != null) {
                $file = $request->file('attachment');
                $destinationPath = 'report_attachment/';
                $originalFile = $file->getClientOriginalExtension();
                $filename =  $report->date .'-'. $request->userid .'.'. $originalFile;
                $file->move($destinationPath, $filename);
                $report->file_type = $originalFile;
                $request->filename = $filename;
            }
            $report->save();
            return redirect('/home')->with('success','Your Report has been submitted successfully!');
        } else {
            return redirect('/submitnewreport')->with('error','Already submitted Report for the given date!');
        }
    }

    public function overtimerequest(Request $request){
        $curruid = Auth::user()->id;
        $userDetails = User::find($curruid);
        $allusers = User::where('d_id', '3')->where('sd_id', '8')->where('id', '!=',Auth::user()->id)
            ->where('id', '!=',1)->with('subdepartment')->get();
        $d_id = $userDetails->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgrid = isset($mgr->id) ? $mgr->id : '';
        $mgrname = isset($mgr->name) ? $mgr->name : '';
        $mgrDetails = (object)array('id'=>$mgrid, 'name'=>$mgrname);
        $cdate = date('m/d/Y');
        return view('submtotrequest', compact('allusers', 'userDetails', 'mgrDetails', 'cdate'));
    }

    public function otrequests(Request $request){
        $monthval = isset($request->m) ? $request->m : '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($curruid);
        $allusers = User::where('d_id', '3')->where('sd_id', '8')->where('id', '!=',Auth::user()->id)
            ->where('id', '!=',1)->with('subdepartment')->get();
        $d_id = $userDetails->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgrId = isset($mgr->id) ? $mgr->id : '';
        $mgrName = isset($mgr->name) ? $mgr->name : '';
        $mgrDetails = (object)array('id'=>$mgrId, 'name'=>$mgrName);
        $cdate = date('m/d/Y');
        if(isset($monthval) && $monthval!=''){
            $otDetails = OverTimeRequests::where('u_id', $curruid)->whereRaw("MONTH(date)='".$monthval."'")->get();
        } else {
            $otDetails = OverTimeRequests::where('u_id', $curruid)->get();
        }
        $countOt = count($otDetails);

        if($countOt!=''){
            $tabclass= 'id=hidden-table-info';
        } else {
            $tabclass = '';
        }

        $resArr = array();
        $i=0; $countHrs = 0; $countMins = 0; $countfewhrs = 0; $AllcountMins = 0;
        foreach($otDetails as $k=>$v){
            $resArr[$i]['date'] = $v['date'];
            $resArr[$i]['start_time'] = $v['start_time'];
            $resArr[$i]['end_time'] = $v['end_time'];
            $resArr[$i]['reason'] = $v['reason'];
            $resArr[$i]['status'] = $v['status'];
            $day1hours = strtotime($v['start_time']);
            $day2hours = strtotime($v['end_time']);
            if($day2hours < $day1hours) {
                $day2hours += 24 * 60 * 60;
            }
            $resArr[$i]['totalhours'] = ($day2hours - $day1hours)/3600;
            $resArr[$i]['totalmins'] = (($day2hours - $day1hours) % 3600) / 60;
            $countHrs += floor($resArr[$i]['totalhours']);
            $countMins += ($resArr[$i]['totalmins']);
            $reportUser = User::find($v['report_uid']);
            $mgrUser = User::find($v['mgr_id']);
            if($v['status']=='Approved'){
                $resArr[$i]['report_name'] = $reportUser->name;
            } else if($v['status']=='ManagerApproved'){
                $resArr[$i]['status'] = "Progress";
                $resArr[$i]['report_name'] = $mgrUser->name;
            } else {
                $resArr[$i]['report_name'] = "Not Yet";
            }
            $i++;
        }

        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        } else {
            $AllcountMins = $countMins;
        }
        $AllcountHrs = $countHrs + $countfewhrs;
        return view('otrequests', compact('allusers', 'userDetails', 'mgrDetails',
            'cdate', 'resArr', 'AllcountHrs', 'AllcountMins', 'tabclass', 'monthval'));
    }

    public function alltopmtotrequests(Request $request){
        $allusers = $mgrDetails = $dateNotifiArr = array();
        $notifyurl = '';
        $monthval = isset($request->m) ? $request->m : '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($curruid);
        $cdate = date('m/d/Y');
        $resArr = $otUserArr = $pendingUsers = $copyPendingUid = $dataJsonArr = array();
        $i=0; $countHrs = 0; $countMins = 0; $countfewhrs = 0; $AllcountMins = 0;
        if(isset($monthval) && $monthval!=''){
            $otDetails = OverTimeRequests::where('report_uid', $curruid)->whereRaw("MONTH(date)='".$monthval."'")->get();
            $pendingUsers = OverTimeRequests::where('report_uid', $curruid)->where("status","ManagerApproved")
                ->whereRaw("MONTH(date)='".$monthval."'")->get();
            foreach($pendingUsers as $k=>$v ){
                array_push($copyPendingUid, $v->u_id);
            }
        } else {
            $otDetails = OverTimeRequests::where('report_uid', $curruid)->get();
            $pendingUsers = OverTimeRequests::where('report_uid', $curruid)->where("status","ManagerApproved")->get();
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
        $notification = DB::table('notifications')
            ->where('type', "App\Notifications\OtAfterMgrApprove")
            ->where('notifiable_id', $curruid)
            ->WhereNull("read_at")->get();
        $notify = $djson = 0;
        foreach($notification as $k=>$v){
            $dataJsonArr[$notify]['data']= json_decode($v->data);
            $dataJsonArr[$notify]['id']= $v->id;
            $notify++;
        }
        foreach($dataJsonArr as $k=>$v){
            $dateNotifiArr[$djson]['date'] = $v['data']->otdate;
            $dateNotifiArr[$djson]['id'] = $v['id'];
            $djson++;
        }
        foreach($otDetails as $k=>$v){
            $user = User::find($v['u_id']);
            $resArr[$i]['u_id'] = $v['u_id'];

            $resArr[$i]['emp_name'] = $user->name;
            $resArr[$i]['date'] = $v['date'];
            $resArr[$i]['start_time'] = $v['start_time'];
            $resArr[$i]['end_time'] = $v['end_time'];
            $resArr[$i]['reason'] = $v['reason'];
            $resArr[$i]['status'] = $v['status'];
            $day1hours = strtotime($v['start_time']);
            $day2hours = strtotime($v['end_time']);
            if($day2hours < $day1hours) {
                $day2hours += 24 * 60 * 60;
            }
            $resArr[$i]['totalhours'] = ($day2hours - $day1hours)/3600;
            $resArr[$i]['totalmins'] = (($day2hours - $day1hours) % 3600) / 60;
            $countHrs += floor($resArr[$i]['totalhours']);
            $countMins += ($resArr[$i]['totalmins']);
            $reportUser = User::find($v['report_uid']);
            $mgrUser = User::find($v['mgr_id']);
            if($v['status']=='Approved'){
                $resArr[$i]['report_name'] = $reportUser->name;
                $resArr[$i]['pendingcls'] = "style=background-color:#fff;";
                $resArr[$i]['anchrcls'] = "style=color:#fff;";
                $resArr[$i]['notifyurl'] = "";
            } else if($v['status']=='ManagerApproved'){
                $resArr[$i]['status'] = "Progress";
                $resArr[$i]['report_name'] = $mgrUser->name;
                $resArr[$i]['anchrcls'] = 'style=color:gray;';
                $noti = 0;
                foreach($dateNotifiArr as $vd){
                    if($v['date']===$vd['date']){
                        $notifyurl = '/topmgmtapproval/'.$vd['id'].'/'.$v['u_id'].'/'.$vd['date'];
                        break;
                    }
                    $noti++;
                }
                $resArr[$i]['notifyurl'] = $notifyurl;
            } else {
                $resArr[$i]['report_name'] = "Not Yet";
                $resArr[$i]['anchrcls'] = "";
                $resArr[$i]['notifyurl'] = "";
            }
            $i++;
        }

        //echo "<pre>";print_r($resArr); die;

        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        } else {
            $AllcountMins = $countMins;
        }
        $AllcountHrs = $countHrs + $countfewhrs;
        return view('alltopmtotrequests', compact('allusers', 'userDetails',
            'mgrDetails', 'cdate', 'resArr', 'AllcountHrs', 'AllcountMins', 'tabclass', 'monthval'));
    }

    public function allotempdetails($u_id,Request $request){
        $monthval = isset($request->m) ? $request->m : '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($u_id);
        $allusers = User::where('d_id', '3')->where('sd_id', '8')->where('id', '!=',Auth::user()->id)
            ->where('id', '!=',1)->with('subdepartment')->get();
        $d_id = $userDetails->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgrDetails = (object)array('id'=>$mgr->id, 'name'=>$mgr->name);
        $cdate = date('m/d/Y');

        if(isset($monthval) && $monthval!=''){
            $otDetails = OverTimeRequests::where('u_id', $u_id)->whereRaw("MONTH(date)='".$monthval."'")->get();
        } else {
            $otDetails = OverTimeRequests::where('u_id', $u_id)->get();
        }
        $countOt = count($otDetails);
        if($countOt!=''){
            $tabclass= 'id=hidden-table-info';
        } else {
            $tabclass = '';
        }

        $resArr = array();
        $i=0; $countHrs = 0; $countMins = 0; $countfewhrs = 0; $AllcountMins = 0;
        foreach($otDetails as $k=>$v){
            $resArr[$i]['date'] = $v['date'];
            $resArr[$i]['start_time'] = $v['start_time'];
            $resArr[$i]['end_time'] = $v['end_time'];
            $resArr[$i]['reason'] = $v['reason'];
            $resArr[$i]['status'] = $v['status'];
            $day1hours = strtotime($v['start_time']);
            $day2hours = strtotime($v['end_time']);
            if($day2hours < $day1hours) {
                $day2hours += 24 * 60 * 60;
            }
            $resArr[$i]['totalhours'] = ($day2hours - $day1hours)/3600;
            $resArr[$i]['totalmins'] = (($day2hours - $day1hours) % 3600) / 60;
            $countHrs += floor($resArr[$i]['totalhours']);
            $countMins +=  ($resArr[$i]['totalmins']);
            $reportUser = User::find($v['report_uid']);
            $mgrUser = User::find($v['mgr_id']);
            if($v['status']=='Approved'){
                $resArr[$i]['report_name'] = $reportUser->name;
                $resArr[$i]['pendingcls'] = "style=background-color:#48CFAD;color:#fff";
            } else if($v['status']=='ManagerApproved'){
                $resArr[$i]['status'] = "Progress";
                $resArr[$i]['report_name'] = $mgrUser->name;
                $resArr[$i]['pendingcls'] = "style=background-color:#84c7ff;color:#fff";
            } else {
                $resArr[$i]['report_name'] = "Not Yet";
                $resArr[$i]['pendingcls'] = "style=background-color:#f693b0;color:#fff";
            }
            $i++;
        }
        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        } else {
            $AllcountMins = $countMins;
        }
        $AllcountHrs = $countHrs + $countfewhrs;
        return view('allotempdetails', compact('allusers', 'userDetails',
            'mgrDetails', 'cdate', 'resArr', 'AllcountHrs', 'AllcountMins', 'monthval', 'tabclass', 'u_id'));
    }

    public function postOtUserRequest(Request $request){
        $curruid = Auth::user()->id;
        $cdate = date('Y-m-d', strtotime($request->date));
        $claimDatecnt = DB::table('overtimerequests')->select(DB::raw('*'))
            ->whereRaw('date = "'.$cdate.'"')->whereRaw('u_id = '.$curruid.'')->count();
        if($claimDatecnt==0){
            $otrequest = new OverTimeRequests();
            $otrequest->u_id = $curruid;
            $cdate = date('Y-m-d', strtotime($request->date));
            $otrequest->date = $cdate;
            $otrequest->start_time = $request->start_time;
            $otrequest->end_time = $request->end_time;
            $otrequest->mgr_id = $request->mgr_id;
            $otrequest->report_uid = $request->report_uid;
            $otrequest->reason = $request->reason;
            $customdate = date('Y-m-d', strtotime($otrequest->date));
            if ($request->ot_file != null) {
                $file = $request->file('ot_file');
                $destinationPath = 'OT_files/';
                $originalFile = $file->getClientOriginalExtension();
                $filename =  $customdate .'-'. $otrequest->u_id .'.'. $originalFile;
                $file->move($destinationPath, $filename);
                $otrequest->file_type = $originalFile;
                $otrequest->ot_file = $filename;
            }
            $otrequest->save();
            $user = Auth::user();
            $d_id = $user->d_id;
            $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
            $mgr->notify(new OverTimeRequest($user->name, $cdate, $curruid, $request->mgr_id, $request->report_uid));
            return redirect('/otrequests')->with('success','Your OverTime Request has been submitted successfully!');
        } else {
            return redirect('/otrequests')->with('error','Already submitted OverTime Request for the given date!');
        }
    }

    public function mgrotapproval($n_id, $u_id, $r_date, $mgr_id, $report_uid) {
        $notify = DB::table('notifications')
            ->where('id', $n_id)->get();
        $notifiable_id =$notify[0]->notifiable_id;
        $notifyArr = json_decode($notify[0]->data);
        $notify_u_id = $notifyArr->u_id;
        $notify_mgr_id = $notifyArr->mgr_id;
        $notify_report_uid = $notifyArr->report_uid;
        $notify_r_date =  $notifyArr->reportdate;
        if($notify_mgr_id==Auth::user()->id){
            $otdetail = OverTimeRequests::where('date', $r_date)->get();
            $user = User::find($u_id);
            $username = $user->name;
            $d_id = $user->d_id;
            $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
            $mgr_id = $mgr->id;
            $seldate = date('Y-m-d');
            $allreports = Report::where('u_id', Auth::user()->id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
            return view('approvalOTRequest', compact('otdetail','n_id', 'u_id', 'r_date', 'mgr_id',
                'seldate', 'allreports', 'username'));
        } else {
            return redirect('/otmgmtrequests')->with('success','OverTime has been Approved successfully!');
        }
    }

    public function topmgmtapproval($n_id, $u_id, $r_date) {
        $notify = DB::table('notifications')
            ->where('id', $n_id)->get();
        $notifiable_id =$notify[0]->notifiable_id;
        $notifyArr = json_decode($notify[0]->data);
        $notify_u_id = $notifyArr->u_id;
        $notify_report_uid = $notifyArr->report_uid;
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
            return view('topmgmtapproval', compact('otdetail','n_id', 'u_id', 'r_date', 'mgr_id',
                'seldate', 'allreports', 'username', 'mgrname'));
        } else {
            return redirect('/home');
        }
    }

    public function otapproved($n_id) {
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/otrequests')->with('success','OverTime has been Approved successfully!');
    }

    public function otrejected($n_id) {
        $currdate = date('Y-m-d H:i:s');
        DB::table('notifications')
            ->where('id', $n_id)
            ->update(array('read_at' => $currdate));
        return redirect('/otrequests')->with('warning','OverTime Request has been rejected successfully!');
    }

    public function otempDetails($u_id,Request $request){
        $monthval = isset($request->m) ? $request->m : '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($u_id);
        $allusers = User::where('d_id', '3')->where('sd_id', '8')->where('id', '!=',Auth::user()->id)
            ->where('id', '!=',1)->with('subdepartment')->get();
        $d_id = $userDetails->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgrDetails = (object)array('id'=>$mgr->id, 'name'=>$mgr->name);
        $cdate = date('m/d/Y');
        $i=0; $countHrs = 0; $countMins = 0; $countfewhrs = 0; $AllcountMins = 0;
        $resArr = $otUserArr = $pendingUsers = $copyPendingUid = $dataJsonArr =  $dateNotifiArr = array();
        $notifyurl = "";
        if(isset($monthval) && $monthval!=''){
            $otDetails = OverTimeRequests::where('u_id', $u_id)->whereRaw("MONTH(date)='".$monthval."'")->get();
            $pendingUsers = OverTimeRequests::where('u_id', $u_id)->where("status","Pending")
                ->whereRaw("MONTH(date)='".$monthval."'")->get();
            foreach($pendingUsers as $k=>$v ){
                array_push($copyPendingUid, $v->u_id);
            }
        } else {
            $otDetails = OverTimeRequests::where('u_id', $u_id)->get();
            $pendingUsers = OverTimeRequests::where('u_id', $u_id)->where("status","Pending")->get();
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
        $notification = DB::table('notifications')
            ->where('type', "App\Notifications\OverTimeRequest")
            ->where('notifiable_id', $curruid)
            ->WhereNull("read_at")->get();
        $notify = $djson = 0;
        foreach($notification as $k=>$v){
            $dataJsonArr[$notify]['data']= json_decode($v->data);
            $dataJsonArr[$notify]['id']= $v->id;
            $notify++;
        }
        foreach($dataJsonArr as $k=>$v){
            $dateNotifiArr[$djson]['date'] = $v['data']->reportdate;
            $dateNotifiArr[$djson]['id'] = $v['id'];
            $djson++;
        }
        foreach($otDetails as $k=>$v){
            $resArr[$i]['u_id'] = $v['u_id'];
            if ($v['status']=='Pending') {
                $noti = 0;
                foreach($dateNotifiArr as $vd){
                    //echo $v['date']."<br /> ".$vd['date']."<br />";
                    if($v['date']===$vd['date']){
                        $notifyurl = '/mgrotapproval/'.$vd['id'].'/'.$v['u_id'].'/'.$vd['date'].'/'.$curruid.'/'.$v['report_uid'];
                        break;
                    }
                    $noti++;
                }
                $resArr[$i]['notifyurl'] = $notifyurl;
                $resArr[$i]['anchrcls'] = 'style=color:#fff;';
            }
            else{
                $resArr[$i]['anchrcls'] = "";
                $resArr[$i]['notifyurl'] = '';
            }

            $resArr[$i]['date'] = $v['date'];
            $resArr[$i]['start_time'] = $v['start_time'];
            $resArr[$i]['end_time'] = $v['end_time'];
            $resArr[$i]['reason'] = $v['reason'];
            $resArr[$i]['status'] = $v['status'];
            $day1hours = strtotime($v['start_time']);
            $day2hours = strtotime($v['end_time']);
            if($day2hours < $day1hours) {
                $day2hours += 24 * 60 * 60;
            }
            $resArr[$i]['totalhours'] = ($day2hours - $day1hours)/3600;
            $resArr[$i]['totalmins'] = (($day2hours - $day1hours) % 3600) / 60;
            $countHrs += floor($resArr[$i]['totalhours']);
            $countMins +=  ($resArr[$i]['totalmins']);
            $reportUser = User::find($v['report_uid']);
            $mgrUser = User::find($v['mgr_id']);
            if($v['status']=='Approved'){
                $resArr[$i]['report_name'] = $reportUser->name;
            } else if($v['status']=='ManagerApproved'){
                $resArr[$i]['status'] = "Progress";
                $resArr[$i]['report_name'] = $mgrUser->name;
            } else {
                $resArr[$i]['report_name'] = "Not Yet";
            }
            $i++;
        }

        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        } else {
            $AllcountMins = $countMins;
        }
        $AllcountHrs = $countHrs + $countfewhrs;
       // echo "<pre>";print_r($resArr); die;
        return view('otempDetails', compact('allusers', 'userDetails',
            'mgrDetails', 'cdate', 'resArr', 'AllcountHrs', 'AllcountMins', 'monthval', 'tabclass', 'u_id'));
    }

    public function otselectrequests(Request $request){
        $i=0; $countHrs = 0; $countMins = 0; $countfewhrs = 0; $AllcountMins = 0;
        $cdate = $monthval = '';
        $curruid = Auth::user()->id;
        $userDetails = User::find($curruid);
        $allusers = User::where('d_id', '3')->where('sd_id', '8')->where('id', '!=',Auth::user()->id)
            ->where('id', '!=',1)->with('subdepartment')->get();
        $d_id = $userDetails->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgrDetails = (object)array('id'=>$mgr->id, 'name'=>$mgr->name);
        $resArr = array(); $dateduration = $ot_dateduration = '';
        $datedur = isset($request->datedur) ? $request->datedur : '';
        $otweekArr = explode(' - ', $datedur);
        $formDate = isset($otweekArr[0]) ? date('Y-m-d', strtotime($otweekArr[0])) : '';
        $toDate = isset($otweekArr[1]) ? date('Y-m-d', strtotime($otweekArr[1])) : '';
        if($formDate!='' && $toDate!=''){
            $dateduration = date('d F Y', strtotime($otweekArr[0]))." - ".date('d F Y', strtotime($otweekArr[1]));
            $ot_dateduration = date('Y-m-d', strtotime($otweekArr[0]))." - ".date('Y-m-d', strtotime($otweekArr[1]));
        }
        $otDetails = OverTimeRequests::where('u_id', $curruid)
            ->where('date','>=',$formDate)
            ->where('date','<=',$toDate)->get();
        $countOt = count($otDetails);
        if($countOt!=''){
            $tabclass= 'id=hidden-table-info';
            $displaytable = '';
        } else {
            $tabclass = '';
            $displaytable = 'style=display:none';
        }
        foreach($otDetails as $k=>$v){
            $resArr[$i]['date'] = $v['date'];
            $resArr[$i]['start_time'] = $v['start_time'];
            $resArr[$i]['end_time'] = $v['end_time'];
            $resArr[$i]['reason'] = $v['reason'];
            $resArr[$i]['status'] = $v['status'];
            $day1hours = strtotime($v['start_time']);
            $day2hours = strtotime($v['end_time']);
            if($day2hours < $day1hours) {
                $day2hours += 24 * 60 * 60;
            }
            $resArr[$i]['totalhours'] = ($day2hours - $day1hours)/3600;
            $resArr[$i]['totalmins'] = (($day2hours - $day1hours) % 3600) / 60;
            $countHrs += floor($resArr[$i]['totalhours']);
            $countMins += ($resArr[$i]['totalmins']);
            $reportUser = User::find($v['report_uid']);
            $mgrUser = User::find($v['mgr_id']);
            if($v['status']=='Approved'){
                $resArr[$i]['report_name'] = $reportUser->name;
            } else if($v['status']=='ManagerApproved'){
                $resArr[$i]['status'] = "Progress";
                $resArr[$i]['report_name'] = $mgrUser->name;
            } else {
                $resArr[$i]['report_name'] = "Not Yet";
            }
            $i++;
        }
        if($countMins>60){
            $AllcountMins = ($countMins % 60*60) / 60;
            $countfewhrs = floor($countMins / 60);
        } else {
            $AllcountMins = $countMins;
        }
        $AllcountHrs = $countHrs + $countfewhrs;
       if(count($resArr)==0 && $datedur=''){
            return redirect('/otselectrequests?datedur='.$datedur)->with('error','No Records Found');
        }

        return view('otselectrequests', compact('allusers', 'userDetails', 'mgrDetails', 'cdate',
            'resArr', 'AllcountHrs', 'AllcountMins', 'tabclass', 'monthval', 'displaytable', 'dateduration',
            'ot_dateduration', 'formDate', 'toDate'));
    }

    public function printotrequests($f_date, $t_date) {
        $i=0; $countHrs = $countMins = $countfewhrs = 0; $AllcountMins = $initialsum = $secondarysum = 0;
        $approvecnt =0; $approvesign= false; $approvemgrsign= false; $approvemgrcnt =0;
        $report_uid = '';
        $curruid = Auth::user()->id;
        $currdate = date('d/m/Y');
        $userDetails = User::find($curruid);
        $d_id = $userDetails->d_id;
        $mgr = User::where('d_id', $d_id)->where('sd_id', 3)->first();
        $mgrDetails = (object)array('id'=>$mgr->id, 'name'=>$mgr->name, 'emp_sign'=>$mgr->emp_sign);
        $resArr = array(); $dateduration = $ot_dateduration = '';
        $otDetails = OverTimeRequests::where('u_id', $curruid)
            ->where('date','>=',$f_date)
            ->where('date','<=',$t_date)->get();
        foreach($otDetails as $k=>$v){
            $resArr[$i]['date'] = $v['date'];
            $resArr[$i]['start_time'] = $v['start_time'];
            $resArr[$i]['end_time'] = $v['end_time'];
            $resArr[$i]['day'] = date('l', strtotime($v['date']));
            $resArr[$i]['reason'] = $v['reason'];
            $resArr[$i]['status'] = $v['status'];
            $report_uid = $v['report_uid'];
            $day1hours = strtotime($v['start_time']);
            $day2hours = strtotime($v['end_time']);
            if($day2hours < $day1hours) {
                $day2hours += 24 * 60 * 60;
            }
            $totTime = ($day2hours - $day1hours)/60;
            $totHours = floor($totTime/60);
            $totMins = $totTime/60 - $totHours;
            $resArr[$i]['totalhours'] = ($day2hours - $day1hours)/3600;
            $resArr[$i]['totalmins'] = (($day2hours - $day1hours) % 3600) / 60;
            $initialHours =  $secondaryHours = 0;
           if($totHours+$totMins<=3)
           {
               $initialHours = $totHours+$totMins;
               $resArr[$i]['initialHours'] = $initialHours;
               $resArr[$i]['secondaryHours'] = 0;
           } else {
               $initialHours = 3;
               $secondaryHours = $totHours+$totMins - 3;
               $resArr[$i]['initialHours'] = $initialHours;
               $resArr[$i]['secondaryHours'] = $secondaryHours;
           }
            $initialsum += $initialHours;
            $secondarysum += $secondaryHours;
            $i++;
        }

        for($k=0;$k<count($resArr);$k++) {
                if($resArr[$k]['status']=='Approved') {
                    $approvecnt++;
                } else if($resArr[$k]['status']=='ManagerApproved') {
                    $approvemgrcnt++;
                }
        }

        if($approvemgrcnt==count($resArr)){
            $approvemgrsign = true;
        } else if($approvecnt==count($resArr)){
            $approvesign = true;
            $approvemgrsign = true;
        }
        $resptUser = User::find($report_uid);
        $dateformat = date('His');
        $namepdf = "PrintOT_".$f_date."_".$t_date."_".$dateformat.".pdf";
        return view('printotrequests', compact('userDetails', 'mgrDetails', 'resptUser', 'currdate',
            'resArr', 'ot_dateduration', 'f_date', 't_date', 'initialsum', 'secondarysum', 'approvesign', 'approvemgrsign'));
        /*$pdf = PDF::loadView('printotrequests',
            compact('userDetails', 'mgrDetails', 'resptUser', 'currdate', 'resArr', 'ot_dateduration',
                'f_date', 't_date', 'initialsum', 'secondarysum', 'approvesign', 'approvemgrsign'));
        return $pdf->download($namepdf);*/
    }

}
