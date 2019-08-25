<?php

namespace App\Http\Controllers;
use App\Notifications\EditRequest;
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

}
