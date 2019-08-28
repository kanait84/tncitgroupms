<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Notifications\ApproveRequest;
use App\Notifications\EditRequest;
use App\Notifications\RejectRequest;
use App\Notifications\ReportComment;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Subdepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            if (is_array($ulist) && count($ulist)>1){ $alluid = implode(',',$ulist); } else { $alluid = $ulist[0]; }
            $reports = Report::whereIn('u_id', array($alluid))->with('user')->orderBy('created_at', 'DESC')->take(4)->get();
            $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
                ->whereIn('u_id', array($alluid))->whereRaw('Date(created_at) = CURDATE()')->count();
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

        $reports = Report::whereIn('u_id', array($alluid))->with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereIn('u_id', array($alluid))->whereRaw('Date(created_at) = CURDATE()')->count();
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
}
