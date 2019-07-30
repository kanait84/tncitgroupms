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

		if(Auth::user()->department == 'marketing_department' && Auth::user()->type == 'management'){
			$staffs = User::where('department', 'marketing_department')->with('reports')->get();
		}

		elseif(Auth::user()->department == 'it_department' && Auth::user()->type == 'management'){

			$staffs = User::where('department', 'it_department')->with('reports')->get();

		}




		return view('management.management', compact('staffs'));
	}
}
