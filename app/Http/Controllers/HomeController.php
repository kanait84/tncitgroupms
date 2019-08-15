<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use File;
use DateTime;
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

    public function submitReport(){
        return view('submitreport');
    }

    public function postReport(Request $request){
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
        return redirect('/home');
    }

    public function settings() {
        return view('settings');
    }
}
