<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Project_status;
use App\Project_type;
use App\Eod;
use App\Loan;
use Auth;
use App\Support_project;
use App\Fixed_project;
use App\Dedicated_developer;
use App\Project_Assignation;
use App\Project_log;
use App\Project_reminder;
use App\Emp_role;
use DB;

class AccountentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 

    public function dashboard(){
		$data = [];

	   $emp_id = Auth::user()->id;

       $data['loan'] = Loan::where('emp_id',$emp_id)->first();
       return view('accountent.dashboard',$data);
    }
}
