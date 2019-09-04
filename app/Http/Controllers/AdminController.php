<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Comment;
use App\Department;
use App\Subdepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function admin()
	{
		$employee = User::with('department','subdepartment')->get();
		return view('admin.admin', compact('employee'));
	}

    //department
	public function department(){
		$departments = Department::all();
		return view('admin.department',compact('departments'));
	}

	public function addDepartment()
    {
		$managers = User::where('type', 'management')->get();
		return view('admin.adddepartment',compact('managers'));
	}

	public function postDepartment(Request $request)
    {
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

    public function deleteuser($uid)
    {
        Report::where('u_id', $uid)->delete();
        User::find($uid)->delete();
        return redirect('/admin' );
    }

    //subdepartment
    public function subDepartment(){
        $subdepartments = Subdepartment::all();
        return view('admin.subdepartment',compact('subdepartments'));
	}

	public function addSubDepartment()
    {
		$managers = User::where('type', 'management')->get();
		$departments = Department::all();
		return view('admin.addsubdepartment',compact('managers', 'departments'));
	}

	public function postSubDepartment(Request $request)
    {
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

    public function allReports()
    {
        $departments = Department::all();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $seldate = date('Y-m-d');
        $subdepartments = Subdepartment::where('sd_id', '=',3)->get();
        $managers = isset($subdepartments[0]) ? $subdepartments[0] : '';
        return view('admin.allreports', compact('departments', 'managers', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
    }


    public function viewDepartment(Request $request, $d_id){

        $department = Department::where('d_id', $d_id)->with('subdepartment')->first();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $seldate = date('Y-m-d');
        return view('admin.departmentlist', compact('department', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
    }


    public function viewSubdepartment(Request $request, $sd_id)
    {
        $users = User::where('sd_id', $sd_id)->with('subdepartment')->where('id', '!=',Auth::user()->id)->where('id', '!=',1)->get();
        $usercount = User::all()->count();
        $todayreportcnt = DB::table('reports')->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')->count();
        $reports = Report::with('user')->orderBy('created_at', 'DESC')->take(4)->get();
        $seldate = date('Y-m-d');
        return view('admin.stafflist', compact('users', 'reports', 'usercount', 'todayreportcnt', 'seldate'));
    }

    public function viewEmployee(Request $request, $id)
    {
        $currcomments = $allcomments = $user_details = $commentArr = array();
        $i=0;
        if(isset($request->d)){
            $cdate = date('Y-m-d', strtotime($request->d));
            $reports = Report::where('u_id', $id)->where('date', $cdate)->with('user')->orderBy('date', 'DESC')->get();
        } else {
            $cdate = date('Y-m-d');
            $reports = Report::where('u_id', $id)->where('date', $cdate)->with('user')->orderBy('date', 'DESC')->get();
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
        return view('admin.staffreport', compact('reports', 'user', 'user_details', 'uid',
            'currcomments', 'seldate', 'allreports'));
    }

}

