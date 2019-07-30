<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Report;
use Auth;

class ManagementController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function management()
	{
		if(Auth::user()->department == 'marketing_department' && (Auth::user()->type == 'management' || Auth::user()->type == 'topmanagement')){
            $staffs = User::where('department', 'marketing_department')->groupBy('sub_department')->with('reports')->get();
		}

        elseif(Auth::user()->department == 'management_department' && (Auth::user()->type == 'management' || Auth::user()->type == 'topmanagement')){
            $staffs = User::where('department', 'management_department')->groupBy('sub_department')->with('reports')->get();
        }

		elseif(Auth::user()->department == 'it_department' && (Auth::user()->type == 'management' || Auth::user()->type == 'topmanagement')){
			$staffs = User::where('department', 'it_department')->select('sub_department')->distinct()->with('reports')->get();
		}
		return view('management.management', compact('staffs'));
	}


    public function subdepartments(Request $request, $d_id)
    {
        $staffs = User::where('sub_department', $request->d_id)->get();
    	$d_id = $request->d_id;
      
        return view('management.sub_departments', compact('staffs', 'd_id'));
    }


}
