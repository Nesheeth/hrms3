<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\Leave_tracking;
use App\Project;
use App\Project_reminder;
use App\Fixed_project;
use App\Setting;
use App\PayRoll;
use App\Resignation;
use App\User;
use Auth;
class AdminController extends Controller{



	public function dashboard(){

/*--------------------------Project reminder---------------*/
 
		$data['total_project']    = Project::count('id');
       $data['handover_project'] = Project::whereProject_status(3)->count('id');
       $data['daily_reminders']  = Project_reminder::whereReminder_type(2)->get();
       $data['reminders']        = Project_reminder::where('reminder_type','!=', 2)
                                     ->whereBetween('reminder_date',[ date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks"))])
                                     ->orWhere('reminder_day', date('l'))
                                     ->get();
                                     //->whereDate('reminder_date','<=',date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks")))
       $data['timelines'] = Fixed_project::whereBetween('delivery_date',[ date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks"))])
                                       ->distinct()->get(['project_id','delivery_date']);   
                                      //whereDate('delivery_date','<=', date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks")))
       $data['expired']  = Project::whereNotNull('mile_expiry')->orWhereNotNull('rem_hours')->get();

       /*--------------------------Project reminder---------------*/

         $data['activeemp'] = \App\User::where('role','!=',1)->where('is_active',1)->with('personal_profile','cb_profile')->count('id');
		 $data['pendleave'] = Leave_tracking::where('status',3)->count('id'); 
		 $data['is_requested_approved'] = \App\User::where('request_json','!=',null)->where('role','!=',1)->count('id'); 

		 /*-----------------------------Employees Count--------------*/
		 $data['developer'] = \App\User::where('role',6)->where('department','development')->where('is_active',1)->count('id');
		 $data['designer'] = \App\User::join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')->where('designation','designer')->orWhere('designation','Designer')
		 					->count('employee_id');

		 					

		 $data['tl'] = \App\User::where('role',4)->where('is_active',1)->count('id');

		 $data['ba'] = \App\User::where('role',7)->where('is_active',1)->count('id');

		 $data['it'] = \App\User::where('role',5)->where('is_active',1)->count('id');

		 $data['hr'] = \App\User::where('role',2)->where('is_active',1)->count('id');
		

		/*---------------------------Projects Count------------------*/
		$data['project'] = Project::count('id');

		$data['project_status'] = Project::where('project_status',1)->count('id');

		$data['pending'] = Project::where('project_status',2)->count('id');

		$ongoing = Project::where('project_status',1)->count('id');
		$pending = Project::where('project_status',2)->count('id');
		$accomplished = Project::where('project_status',3)->count('id');
		$total = Project::count('id');

		$data['active'] = round(($ongoing/$total)*100, 2);
		$data['hold'] = round(($pending/$total)*100 , 2);
		$data['completed'] = round(($accomplished/$total)*100, 2);

		//check Hr salary status
		$m = date('m')-1;
		$y = date('Y')-1;
		$salary_status_of_month = PayRoll::where(['salary_month'=>$m,'salary_year'=>$y])->first();
		$data['salary_status_of_month']= $salary_status_of_month;

		return view('admin.dashboard',$data);
	}

	public function teams(){

		$team_leaders = array();
		$data = array();
		$team_leaders = \App\User::where('role',4)->with('personal_profile','cb_profile')->orderBy('id','DESC')->get();



		$data['team_leaders'] = $team_leaders;



		return view('admin.teams.teams',$data);



	}



	public function teamMembers($id)



	{

		$response = array();



		$team_members = \App\TeamMember::where('team_leader_id',$id)->orderBy('id','DESC')->get();



		if(count($team_members) > 0){



			$response['flag'] = true;



			$response['team_members'] = $team_members;



		}else{



			$response['flag'] = false;



		}



		return response()->json($response);



	}







	public function removeTeamMember($id)



	{



		$response = array();



		$team_member = \App\TeamMember::where('team_member_id',$id)->first();



		if(!is_null($team_member)){



			if($team_member->delete()){



				$response['flag'] = true;



			}else{



				$response['flag'] = false;



			}



		}else{



			$response['flag'] = false;



		}



		return response()->json($response);



	}



	



	public function getAddAssignTeam()



	{



		//$team_members = \App\User::where('role',6)->with('personal_profile','cb_profile')->get();

         $team_members = DB::select('SELECT * FROM users WHERE role = 6 and users.id NOT IN (SELECT team_member_id FROM team_members)');

		$team_leaders = \App\User::where('role',4)->with('personal_profile','cb_profile')->get();



		$data['team_members'] = $team_members;



		$data['team_leaders'] = $team_leaders;



		return view('admin.teams.assign-team-members',$data);



	}



	public function postAddAssignTeam(Request $request)



	{



		$validator = \Validator::make($request->all(),



			array(



				'team_leader' =>'required',



				'team_members' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect('/admin/assign-team-members')



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$old = false;



			if(count($request->team_members) > 0) {



				$members = "";



				for ($i=0; $i < count($request->team_members) ; $i++) { 



					$team_member = new \App\TeamMember();



					$team_member->team_leader_id = $request->team_leader;



					$team_member->team_member_id = $request->team_members[$i];



					$old_team_member =  \App\TeamMember::where('team_member_id',$request->team_members[$i])->first();



					if(is_null($old_team_member)){



						$team_member->save();







						/*---------------------------------Send notification--------------------------*/



						$receiver = array($request->team_members[$i]);



						$title = "Admin Assigned You Team Leader ("." ".getUserById($request->team_leader)->first_name.')';



						$message = "Admin Assigned You Team Leader ("." ".getUserById($request->team_leader)->first_name.')';



						NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



						/*---------------------------------Send notification--------------------------*/







						/*---------------------------------Send notification--------------------------*/



						$receiver = array($request->team_leader);



						$title = "Admin Assigned You Team Member ("." ".getUserById($request->team_members[$i])->first_name.')';



						$message = "Admin Assigned You Team Member ("." ".getUserById($request->team_members[$i])->first_name.')';



						NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



						/*---------------------------------Send notification--------------------------*/







					}else{



						$members .= " ".getUserById($request->team_members[$i])->first_name.',';



						$old = true;



					}



				}



				if($old){



					$msg = "Operation executed successfully But Skipped some members(".$members.") because they are already Assigned.";



				}else{



					$msg = "Assigned Successfully";



				}



			}



			return redirect('/admin/assign-team-members')->with('success',$msg);



		}



	}







	public function resignations(Request $request){
       $table=DB::table('resignations')
       			->leftjoin('knowledge_transfers','resignations.user_id','=','knowledge_transfers.user_id')
       			->select('resignations.*','knowledge_transfers.is_actived')->distinct('resignations.id')
       			->orderBy('id','DESC')->get();
		$data['resignations'] = $table;
		//print_r($table);die();
	    //$data['kt_status'] = \App\KnowledgeTransfer::where('user_id',$resignation->user_id)->first();
		return view('admin.resignation.resignations',$data);
	}



	public function resignationsaccepted($id){

       $resignations = \App\Resignation::find($id);

       $user = \App\User::where('id','=',$resignations->user_id)->first();
        if(is_null($resignations)){
       		return redirect()->back()->with('error','Error');

        }else{
       		$resignation = DB::table('resignations')->where('id',$id)->update(['is_active'=> 1]);
       		$resignation_details = DB::table('resignations')->where('id',$id)->first();
       		$resignation_date = $resignation_details->date_of_resign;
       		$newDate = date("d-m-Y", strtotime($resignation_details->date_of_resign));
       		$leaves_details = DB::table('leaves')->where('user_id',$resignation_details->user_id)->where('date_from','>=',$newDate)->get();

       		//On notice period
       			$user->is_active = 4;
       			$user->save();
       		//end
       		//print_r($leaves_details);
       		if(!isset($leaves_details)){
       			 $leave_id = $leaves_details[0]->id;
       			 $leave_info  = DB::table('leaves')->where('id',$leave_id)->update(['is_approved'=>-1]);
       			 //      $receiver = array($resignations->user_id); 
       			 // $title = "Admin Discarted Your leave.";
       			 // $message = "Admin Discarted Your leave ";

				// $admins = \App\User::where('role','1')->get();

				// NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------leave discarted Send ----*/
			}
			$templateData['user1'] = \App\User::where('id',$resignations->user_id)->with('personal_profile','cb_profile')->first();

				/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($resignations->user_id);

				$title = "Admin Accepted Your Resignation.";

				$message = "Admin Accepted Your Resignation Request ";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------Send notification-------------------------------------------*/



				$MailData = new \stdClass();

				$MailData->subject ='Resignation Accepted - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;

				$MailData->sender_email = \Auth::user()->email;

				$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;

				$MailData->receiver_email = $user->email;

				$MailData->receiver_name = $user->first_name.' '.$user->last_name;

		          //print_r($templateData."".$MailData);
				  MailController::sendMail('accepted_resignation',$templateData,$MailData);  
		          return redirect()->back()->with('success','Successfully Accepted Resignation');
	    }
    }

      public function resignationsrejected($id)

	 {

        $resignations = \App\Resignation::find($id);

       $user = \App\User::where('id','=',$resignations->user_id)->first();



       if(is_null($resignations)){



			 return redirect()->back()->with('error','Error');

       }

       else{

       $resignation = DB::table('resignations')->where('id',$id)->update(['is_active'=> -1]);

       $templateData['user1'] = \App\User::where('id',$resignations->user_id)->with('personal_profile','cb_profile')->first();

      

       



				/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($resignations->user_id);

				$title = "Admin Rejected Your Resignation.";

				$message = "Admin Rejected Your Resignation Request";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------Send notification-------------------------------------------*/



				$MailData = new \stdClass();

		$MailData->subject ='Resignation Rejected - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;

		$MailData->sender_email = \Auth::user()->email;

		$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;

		$MailData->receiver_email = $user->email;

		$MailData->receiver_name = $user->first_name.' '.$user->last_name;

      //  print_r($templateData."".$MailData);

		MailController::sendMail('rejected_resignation',$templateData,$MailData);  

       return redirect()->back()->with('success','Successfully Rejected Resignation');



     }

  }



 public function restract()

        {

        	$retracts = \App\Retract::where('user_id','!=',\Auth::user()->id)->orderBy('id','DESC')->get();



		$data['retracts'] = $retracts;

		//print_r($data['id']);

        

		return view('admin.restracts.retracts',$data);

        }



    public function restractaccepted($id){
    	$retracts = \App\Retract::find($id);
    	
    	$user = \App\User::where('id','=',$retracts->user_id)->first();
    	if(is_null($retracts)){
    		return redirect()->back()->with('error','Error');
    	}else{
    		$retract = DB::table('retracts')->where('id',$id)->update(['is_active'=> 1]);
    		$user->is_active = 1;
    		$user->save();
    		$retract1 = DB::table('retracts')->where('id',$id)->first();
    		$retract1_user = $retract1->user_id;
    		// for status retracted
    			$resignation_update = Resignation::where('user_id',$retract1->user_id)->update(['is_retracted'=> 1]);
    		//end
    		$resignation_details = DB::table('resignations')->where('user_id',$retract1_user )->first();
    		$resignation_date = $resignation_details->date_of_resign;

    		$newDate = date("d-m-Y", strtotime($resignation_details->date_of_resign));

    		$leaves_details = DB::table('leaves')->where('user_id',$resignation_details->user_id)->where('date_from','>=',$newDate)->get();

    		// print_r($leaves_details);
    		if(!isset($leaves_details)){
    			$leave_id = $leaves_details[0]->id;
    			$leave_info  = DB::table('leaves')->where('id',$leave_id)->update(['is_approved'=>1]);
    		}
    		//dd(  $leave_info);
    		$templateData['user1'] = \App\User::where('id',$retracts->user_id)->with('personal_profile','cb_profile')->first();
    		/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($retracts->user_id);

				$title = "Admin Accepted Your Retract.";

				$message = "Admin Accepted Your Retract Request ";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------Send notification-------------------------------------------*/



				$MailData = new \stdClass();

			$MailData->subject ='Retract Accepted - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;

			$MailData->sender_email = \Auth::user()->email;

			$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;

			$MailData->receiver_email = $user->email;

			$MailData->receiver_name = $user->first_name.' '.$user->last_name;

       		// print_r($MailData);

			MailController::sendMail('accepted_retract',$templateData,$MailData);  

       		return redirect()->back()->with('success','Successfully Accepted Retract');
       	}

    }

        public function restractrejected($id)

	 {

        $retracts = \App\Retract::find($id);

       $user = \App\User::where('id','=',$retracts->user_id)->first();



       if(is_null($retracts)){



			 return redirect()->back()->with('error','Error');

       }

       else{

       $retract = DB::table('retracts')->where('id',$id)->update(['is_active'=> -1]);

       $templateData['user1'] = \App\User::where('id',$retracts->user_id)->with('personal_profile','cb_profile')->first();

      

       



				/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($retracts->user_id);

				$title = "Admin Rejected Your Resignation.";

				$message = "Admin Rejected Your Resignation Request";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------Send notification-------------------------------------------*/



				$MailData = new \stdClass();

		$MailData->subject ='Retract Rejected - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;

		$MailData->sender_email = \Auth::user()->email;

		$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;

		$MailData->receiver_email = $user->email;

		$MailData->receiver_name = $user->first_name.' '.$user->last_name;

     // dd($MailData);

		MailController::sendMail('rejected_retract',$templateData,$MailData);  

       return redirect()->back()->with('success','Successfully Rejected Retract');



     }

  }



    public function ktassign_confirm($id)

     {

     	$retracts = \App\Resignation::find($id);

     	$kt = \App\KnowledgeTransfer::where('user_id',$retracts->user_id)->get();

     	

       $user = \App\User::where('id','=',$retracts->user_id)->first();



       if(is_null($retracts)){



			 return redirect()->back()->with('error','Error');

       }

       else{

      // $retract = DB::table('retracts')->where('id',$id)->update(['is_active'=> -1]);

         $kt_confirm = new \App\KnowledgeTransferConfirm();

   

         for($k=0; $k<count($kt); $k++){

                  $th=['user_id' => $kt[$k]->user_id,

		    		'project_id' => $kt[$k]->project_id,

		    		'project_name' => $kt[$k]->project_name,

		    		 'kt_given_to' => $kt[$k]->kt_given_to,

		    		  'kt_given_to_name' => $kt[$k]->kt_given_to_name,

		    		 'is_actived' =>  $kt[$k]->is_actived,

		    		 ];

		        

		         $tn = \App\KnowledgeTransferConfirm::insert($th);

        }

         $retract = DB::table('knowledge_transfers')->where('user_id',$retracts->user_id)->update(['is_actived'=> 2]);

         $assign_user = \App\User::where('id',$th['kt_given_to'])->get();

         $assign_user1 = \App\User::where('id',$th['user_id'])->get();

       $templateData['user1'] = \App\User::where('id',$retracts->user_id)->with('personal_profile','cb_profile')->first();

             

				/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($retracts->user_id);

				$title = "Admin Accepted Your Knowledge Transfer.";

				$message = "Admin Accepted Your Knowledge Transfer";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



				/*----------------notification send to assign user---------------------------------*/

				

				$receiver = array($assign_user[0]->id);



				$title = "A New knowledge Transfer Assign To You";



				$message = "<p>"."A  project ".$th['project_name']." assigned you by ".$assign_user1[0]->first_name.   "</p>";



				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



				

 

       return redirect()->back()->with('success','Knowledge transfer status confirm successfully');



     }





     }

    public function kt_list(){

		

        $data['kt'] = User::join('resignations', 'resignations.user_id', '=', 'users.id')

				    ->where('user_id','!=', Auth::user()->id)
				    ->where('department','development')
				    ->orderBy('users.created_at','DESC')
                    ->get();

        // print_r($data['kt']);die();
        
        return view('common.kt.index',$data);

    }

    public function ktassign_rejected($id){		

	

     	$retracts = \App\Resignation::find($id);

     	$kt = \App\KnowledgeTransfer::where('user_id',$retracts->user_id)->get();     	

		$user = \App\User::where('id','=',$retracts->user_id)->first();



		if(is_null($retracts)){

			return redirect()->back()->with('error','Error');

		}else{

			// $retract = DB::table('retracts')->where('id',$id)->update(['is_active'=> -1]);

			$kt_confirm = new \App\KnowledgeTransferConfirm();

   

        

			$retract = DB::table('knowledge_transfers')->where('user_id',$retracts->user_id)->update(['is_actived'=> -1]);

			$templateData['user1'] = \App\User::where('id',$retracts->user_id)->with('personal_profile','cb_profile')->first();

      

			/*-----------------------------------Send notification-------------------------------------------*/

			$receiver = array($retracts->user_id);

			$title = "Admin Rejected Your Knowledge Transfer.";

			$message = "Admin Rejected Your Knowledge Transfer";

			$admins = \App\User::where('role','1')->get();

			NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

			return redirect()->back()->with('success','Knowledge transfer status Rejected successfully');

		}

	 

	}

	// View All Notification 

	public function view_notification(){

		$id= \Auth::user()->id;

		$all_notification = \App\Notification::where('receiver_id','=',$id)->orderBy('id', 'desc')->paginate(15);

		return view('admin.notification',['all_notifications'=>$all_notification]);

		

	}

	// Settings

	public function settings(){

		return view('admin.setting');
	}

	public function setting_post(Request $request){


		$data['esi_employee'] = Setting::where('key_name','esi_employee')->update(['value'=>$request->data['esi_employee']]);
		$data['esi_employer'] = Setting::where('key_name','esi_employer')->update(['value'=>$request->data['esi_employer']]);
		$data['hra'] = Setting::where('key_name','hra')->update(['value'=>$request->data['hra']]);
		$data['basic'] = Setting::where('key_name','basic')->update(['value'=>$request->data['basic']]);
		$data['da'] = Setting::where('key_name','da')->update(['value'=>$request->data['da']]);
		$data['ta'] = Setting::where('key_name','ta')->update(['value'=>$request->data['ta']]);
		$data['pf'] = Setting::where('key_name','pf')->update(['value'=>$request->data['pf']]);
		$data['employer_pf'] = Setting::where('key_name','employer_pf')->update(['value'=>$request->data['employer_pf']]);
		$data['tds'] = Setting::where('key_name','tds')->update(['value'=>$request->data['tds']]);

		return redirect()->back()->with('success','Data Updated successfully');
		
	}

	public function getProfileEdit()
{
	$data = array();
	$data['employee'] = \App\User::where('id',\Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();

//	print_r($data['employee']);die();

	return view('admin.profile.edit',$data);
}

}