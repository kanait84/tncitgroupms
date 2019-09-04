<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Subdepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmanagementController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}


    public function smViewSubdepartment(Request $request)
    {
        $curruid = Auth::user()->id;
        $users = User::where('sd_id', Auth::user()->sd_id)->whereRaw("id!= $curruid")->with('subdepartment')->get();
        $seldate = date('Y-m-d');
        $usercount = User::where('sd_id', Auth::user()->sd_id)->count();
        $ulist = array();
        foreach($users as $k=>$v){  $ulist[] = $v->id; }
        if (is_array($ulist) && count($ulist)>1){ $alluid = implode(',',$ulist); } else { $alluid = $ulist[0]; }
        $reports = Report::orWhereRaw('u_id', array($alluid))->with('user')->orderBy('created_at', 'DESC')->take(4)->get();

        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->orWhereRaw('u_id', array($alluid))->whereRaw('Date(created_at) = CURDATE()')->count();

        return view('submanagement.sm_stafflist', compact('users', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
    }


    public function smviewEmployee(Request $request, $id)
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
        return view('submanagement.sm_staffreport', compact('reports', 'user', 'user_details', 'uid',
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

        $report = Report::where('r_id', $request->r_id)->with('user', 'comments')->first();
        // echo "<pre>";print_r($report);
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
                    <img  src='/photo_storage/$emp_photo' class='img-circle' height='100px' width='100px'></p>
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
        //echo "<meta http-equiv='refresh' content='0'>";
        Comment::find($c_id)->delete();
        return redirect('/mviewemployee/'.$r_id );
    }

    public function updateProfile($u_id, Request $request)
    {
        if(isset($request->d)){
            $cdate = date('Y-m-d', strtotime($request->d));
            $reports = Report::where('u_id', Auth::user()->id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        } else {
            $cdate = date('Y-m-d');
            $reports = Report::where('u_id', Auth::user()->id)->where('date', $cdate)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        }
        $user = User::find($u_id);
        if(isset($request->name)){
            if($request->hasfile('emp_photo'))
            {
                $file = $request->file('emp_photo');
                $destinationPath = 'photo_storage/';
                $originalFile = $file->getClientOriginalExtension();
                $filename =  $user->email.'.'. $originalFile;
                $file->move($destinationPath, $filename);
                User::where('id',$u_id)->update(['emp_photo'=>$filename]);
            }
            User::where('id',$u_id)->update(['name'=>$request->name, 'mobile'=>$request->mobile]);
            return redirect('/home');
        }
        $seldate = isset($request->d) ? $request->d : date('Y-m-d');
        $allreports = Report::where('u_id', Auth::user()->id)->with('user', 'comments')->orderBy('date', 'DESC')->get();
        return view('updateprofile',compact('user', 'u_id', 'seldate', 'allreports'));
    }


}
