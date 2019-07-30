<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Report;

use DB;

class TopManagementController extends Controller
{


	public function __construct()
	{
		$this->middleware('auth');
	}
	public function topmanagement()
	{
		return view('topmanagement.topmanagement');
	}

	public function itDepartment(){

		$staffs = User::where('department', 'it_department')->groupBy('sub_department')->with('reports')->get();
		return view('topmanagement.subdepartment',compact('staffs'));
	}

	public function marketingDepartment(){

        $staffs = User::where('department', 'marketing_department')->groupBy('sub_department')->with('reports')->get();
		return view('topmanagement.subdepartment',compact('staffs'));
	}


	public function humanresourceDepartment(){
		$staffs = User::where('department', 'hr_department')->with('reports')->get();
		return view('topmanagement.department',compact('staffs'));
		
	}

	public function managementDepartment(){
		$staffs = User::where('department', 'management_department')->with('reports')->get();
		return view('topmanagement.department',compact('staffs'));

	}

	public function viewemployee(Request $request, $id)
	{
		$employee = User::where('id', $id)->with('reports')->first(); 
		return view('topmanagement.staffreport', compact('employee'));
	}

	    public function topReportDetails(Request $request, $r_id)
    {
        $report = Report::where('r_id', $r_id)->with('user')->first(); 
        // dd($report); 
  
        return view('topmanagement.staffreportdetails', compact('report'));
    }

}
