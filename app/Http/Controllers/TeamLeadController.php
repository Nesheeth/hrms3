<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceData;
use App\Project_Assignation;
use App\Leave_tracking;
use App\TeamMember;
use App\Loan;
use App\User;
use Auth;

class TeamLeadController extends Controller
{

	public function getDashboard(){

		// print_r(Auth::User()->id);
		//  die();
		 $emp_id = Auth::user()->id;

       	$data['loan'] = Loan::where('emp_id',$emp_id)->first();

		$data['assignprojects'] = Project_Assignation::get();



		return view('teamLead.dashboard', $data);
	}

	public function leave_list(Request $request){ 
         //$leaves = Leave_tracking::get();
        
         if(!empty($request->leave_type)){

           $data['l_type'] = $request->leave_type; 

           $leaves = Leave_tracking::whereStatus($request->leave_type); 
       	  }  

    

    $data['leaves'] = User::join('team_members', 'team_members.team_member_id', '=', 'users.id')
				    ->join('leave_trackings', 'leave_trackings.user_id', '=', 'users.id')
				    ->where('user_id','!=', Auth::user()->id)
				    ->where('team_leader_id', Auth::user()->id)
				    ->where('department','development')
                    ->get();
		
                  //  print_r($data['leaves']);die();

      
        return View('teamLead.leaves.leave_list',$data);     
   }

}