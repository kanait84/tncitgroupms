<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Auth;
use File;
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
    public function index()
    {

        $reports = Report::where('u_id', Auth::user()->id)->with('user')->orderBy('date', 'ASC')->get();


        
        return view('home', compact('reports'));
    } 




    public function reportDetails(Request $request, $r_id)
    {
        $report = Report::where('r_id', $r_id)->first(); 

        return view('reportdetails', compact('report'));
    }



    public function submitReport(){

        return view('submitreport');
    }

    public function postReport(Request $request){

        $report = new Report;
        $report->u_id = Auth::user()->id;
        $report->date = $request->date;
        //$report->task_date = $request->task_date;

        $report->description = $request->description;
        $report->comment = $request->comment;
        //$report->overtime = $request->overtime;
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


        // dd($originalFile);
        

        $report->save();
        return redirect('/home'); 
    }
}
