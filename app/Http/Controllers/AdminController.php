<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Comment;
use App\Department;
use App\Subdepartment;


class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function admin()
	{

		$employee = User::all();

		return view('admin.admin', compact('employee'));
	}



//department
	public function department(){

		$departments = Department::all();

		return view('admin.department',compact('departments'));
	}

	public function addDepartment(){

		$managers = User::where('type', 'management')->get();

		return view('admin.adddepartment',compact('managers'));
	}

	public function postDepartment(Request $request){

		$this->validate($request,[
			'd_description'=>'required',
			'd_title'=>'required',
		]);

		$department = new Department;
		$department->d_description = $request->d_description;
		$department->d_title = $request->d_title;
	

		$department->save();
		return redirect('/department'); 
	}





//subdepartment
		public function subDepartment(){

		$subdepartments = Subdepartment::all();

		return view('admin.subdepartment',compact('subdepartments'));
	}

		public function addSubDepartment(){

		$managers = User::where('type', 'management')->get();
		$departments = Department::all();

		return view('admin.addsubdepartment',compact('managers', 'departments'));
	}


		public function postSubDepartment(Request $request){


		$this->validate($request,[
			'sd_title'=>'required',
			'sd_description'=>'required',
		]);

// dd($request);
		$subdepartment = new Subdepartment;
		$subdepartment->sd_description = $request->sd_description;
		$subdepartment->sd_title = $request->sd_title;
		$subdepartment->d_id = $request->d_id;


		$subdepartment->save();

		return redirect('/subdepartment'); 
	}

}

