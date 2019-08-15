<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Subdepartment;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}


	public function management()
	{
        if(Auth::user()->type == 'management'){
            $subdepartments = Subdepartment::where('d_id', Auth::user()->d_id)->get();

            return view('management.management', compact('subdepartments'));
        }
        else {
            return view('/home');
        }

    }


    public function mViewSubdepartment(Request $request, $sd_id)
    {
        $users = User::where('sd_id', $sd_id)->with('subdepartment')->get();
        return view('management.m_stafflist', compact('users'));
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
            echo "<div class='row'>
                    <div class='col-md-12 mb'>
                    <div class='message-p pn'>
                    <div class='row'>
                    <div class='col-md-1 centered'>
                    <div class='profile-pic pic-comment'>
                    <p style='margin-top: 20px'>
                    <img  src='/photo_storage/$useremail.png' class='img-circle' height='100px' width='100px'></p>
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


}
