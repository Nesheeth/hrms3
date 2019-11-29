<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\HrEod; 
use App\Eod; 
use App\It_eod; 
use App\User; 
use App\Project_Assignation;
use Auth;
use App\Project;
use App\SalesEod;
use App\Support_project;


class EODController extends Controller{

    public function send_eods(){
		if(Auth::user()->role==5){
			return view('itExecutive.eods.sent');  
		}else{
			$data['projects'] =  Project_Assignation::whereEmployee_id(Auth::user()->id)->whereAssign_status(0)->get();
			
			
			return view('common.eods.sent',$data); 
		}
	}

	public function save_eods(Request $request){
		//print_r($request->all()); 
		$projects = []; 
		for($i=0; $i<sizeof($request->project); $i++){
			$row['user_id']      = Auth::user()->id; 
			$row['project_id']   = $request->project[$i];
			$row['date']         = $request->date;
			$row['task_name'] 	 = $request->task_name[$i];
			$row['description']  = $request->description[$i];
			$row['es_hours'] 	 = $request->es_hours[$i];
			$row['today_hours'] 	 = $request->today_hours[$i]; 
			$row['total_hours']  = $request->total_hours[$i];
			$row['delivery_date'] = $request->delivery_date[$i];
			$row['task_status']   = $request->task_status[$i];
			//print_r($row);
			Eod::create($row); 
			$projects[] = $request->project[$i];
		} 
    
        $date = date('Y-m-d', strtotime($request->date));
		$templateData['user'] = User::where('id',Auth::user()->id)->with('personal_profile','cb_profile')->first();
		$templateData['eods'] = Eod::where('user_id', Auth::user()->id)->whereDate('date', $date)->get();
		$templateData['date_of_eod'] = $date;  
		$receiver_email = array();
		$admins = \App\User::where('role','1')->get();
		foreach ($admins as $admin) { 
			array_push($receiver_email, $admin->email);
		}
		
		$team_leaders = Project_Assignation::join('users','users.id','project_assignation.employee_id')
		                                     ->where('project_assignation.emp_role',1)
		                                     ->whereIn('project_assignation.project_id',$projects)
		                                     ->select('users.id','users.email')->distinct()->get();

		foreach ($team_leaders as $team_leader) { 
			array_push($receiver_email, $team_leader->email); 
		}
        array_push($receiver_email, 'codingbrains8@gmail.com');
       
		$MailData = new \stdClass();
		$MailData->subject ='EOD Report '.$date; 
		$MailData->sender_email = Auth::user()->email;
		$MailData->sender_name  = Auth::user()->first_name.' '.Auth::user()->last_name;
		$MailData->receiver_email = $receiver_email;
		$MailData->receiver_name  = 'Team Lead & Admin';  
		$MailData->subject = 'EOD Report '.date('d-M-Y', strtotime($request->date)).' '.Auth::user()->first_name.' '.Auth::user()->last_name;
		MailController::sendMail('eod', $templateData, $MailData);

		/*Update Support......*/
		   $supports = Support_project::whereIn('project_id', $projects)->get();
			    foreach ($supports as  $sp){
			       $eod_hr = Eod::whereProject_id($sp->project_id)->sum('today_hours');
			       $total  = Support_project::whereProject_id($sp->project_id)->sum('total_hours');
                   $rem = $total - $eod_hr;
                   $per = ($total*10)/100;
                   if($rem < $per){
                      $project  = Project::findOrFail($sp->project_id);
                      $project->mile_expiry = $sp->expiry_date;
                      $project->rem_hours = $rem;
                      $project->save(); 
                   }
			   }
		/*Update Support......*/ 
		return redirect()->back()->with('success',"Eod Send Successfully.");  
	}
	
	
	public function save_it_eods(Request $request){
		for($i=0; $i<sizeof($request->task_id); $i++){
			$row['user_id']      		= Auth::user()->id; 
			$row['shift']        		= $request->shift;
			$row['eod_date']         	= $request->date;
			$row['task_id'] 	 		= $request->task_id[$i];
			$row['issue_type']  		= $request->issue_type[$i];
			$row['cbpc_no'] 	 		= $request->cbpc_no[$i];
			$row['issue_details'] 	 	= $request->issue_details[$i]; 
			$row['resolution_provided']  = $request->resolution_provided[$i];
			$row['resolution_status'] 	= $request->resolution_status[$i];
			$row['comment']   			= (@$request->comment[$i]) ? $request->comment[$i] : null;
			//print_r($row);
			It_eod::create($row); 
		}
		return redirect()->back()->with('success',"Eod Send Successfully.");  
	}
    
	public function it_eods(){
		$data['iode'] = It_eod::whereUser_id(Auth::user()->id)->orderBy('id','DESC')->get();
		return view('itExecutive.eods.list',$data); 
	}
	
	public function it_eod_list(){
		 $data['eods'] = It_eod::orderBy('id','DESC')->paginate(15);
		 return view('admin.eod.it_eod',$data); 
	}

	public function sales_eod_list(){
		 $data['eods'] = SalesEod::orderBy('id','DESC')->paginate(15);
		 return view('admin.eod.sales_eod',$data); 
	}


	public function getSeeTeamEOD(){
		$team_member_id = \App\TeamMember::whereTeam_leader_id(Auth::user()->id)->pluck('team_member_id');
		$project_id = Project_Assignation::whereIn('employee_id',$team_member_id)
		                                  ->pluck('project_id'); 

		$data['eods_filter'] = Project::whereIn('id',$project_id)->orderBy('id','project_name')->get();
		if(empty($request->filter)){
		     $data['eods'] = Eod::whereIn('user_id',$team_member_id)->orderBy('id','DESC')->get(); 
        }else{
        	$data['eods'] = Eod::where('project_id',$request->filter)->whereIn('user_id',$team_member_id)->orderBy('id','DESC')->get();
        }
		return view(getRoleStr().'.eod.index', $data);

	}

	/* ===========================================         OLD Code       =================================== */ 

	public function hr_eod_list(){
		 $data['eods'] = HrEod::orderBy('id','DESC')->paginate(10);
		 return view('admin.eod.hr_eod',$data); 
	}



	public function hr_eod_details(Request $request){
      $eod = HrEod::whereId($request->id)->first();     
      $html = "";
      $html.="<p> <b> Employee : </b>".$eod->user->first_name."</p>";   
      $html.="<p> <b> EOD Date : </b> $eod->date_of_eod</p>";
      $html.="<p> <b> Recruitment : </b> $eod->recruitment</p>";
      $html.="<p> <b> Generalist  : </b> $eod->generalist</p>"; 
      $html.="<p> <b> Comment : </b> $eod->comment</p>";
      return $html;
	}
	
	public function it_eod_details(Request $request){
      $eod = It_eod::whereId($request->id)->first();     
      $html = "";
      $html.="<p> <b> Employee 			: </b>".$eod->user->first_name.$eod->user->last_name."</p>";   
      $html.="<p> <b> EOD Date 			: </b>".date('d M-Y', strtotime($eod->eod_date))."</p>";
      $html.="<p> <b> Shift  			: </b> $eod->shift</p>";
      $html.="<p> <b> Task ID 			: </b> $eod->task_id</p>";
      $html.="<p> <b> Issue Type  		: </b> $eod->issue_type</p>"; 
      $html.="<p> <b> CBPC NO.  		: </b> $eod->cbpc_no</p>"; 
      $html.="<p> <b> Issue Details  	: </b> $eod->issue_details</p>"; 
      $html.="<p> <b> Resolution Provided  : </b> $eod->resolution_provided</p>"; 
      $html.="<p> <b> Resolution Status  : </b> $eod->resolution_status</p>"; 
      $html.="<p> <b> Comments  		: </b> $eod->comment</p>"; 
      return $html;
	}

	public function sales_eod_details(Request $request){
      $eod = SalesEod::whereId($request->id)->first();     
      $html = "";
      $html.="<p> <b> Employee : </b>".$eod->user->first_name."</p>";   
      $html.="<p> <b> EOD Date : </b>".date('d M-Y', strtotime($eod->eod_date))."</p>";
      $html.="<p> <b> Task 1 : </b> $eod->task_1</p>";
      $html.="<p> <b> Task 2 : </b> $eod->task_2</p>";
      $html.="<p> <b> Task 3 : </b> $eod->task_3</p>";
      $html.="<p> <b> Task 4 : </b> $eod->task_4</p>";
      $html.="<p> <b> Comments  : </b> $eod->comment</p>"; 
      return $html;
	}



	public function eod_details(Request $request){ 
      $eod = Eod::whereId($request->id)->first();      
      $html = ""; 
      $html.="<p> <b> Employee : </b>".$eod->user->first_name." ".$eod->user->last_name."</p>";   
      $html.="<p> <b> EOD Date : </b> ".date('d M-Y', strtotime($eod->date))."</p>";
      $html.="<p> <b> Project Name : </b> ".$eod->project->project_name."</p>"; 
      $html.="<p> <b> Task Name  : </b> $eod->task_name </p>"; 
      $html.="<p> <b> Task Description  : </b> $eod->description </p>"; 
      $html.="<p> <b> ES Hours  : </b> $eod->es_hours </p>"; 
      $html.="<p> <b> Total Hours  : </b> $eod->total_hours </p>"; 
      $html.="<p> <b> Delivery Date : </b> ".date('d M-Y', strtotime($eod->delivery_date))." </p>"; 
      $html.="<p> <b> Status : </b>  $eod->task_status </p>"; 

      return $html;
	}


	public function deleteHR_EOD($id){
		HrEod::whereId($id)->delete();   
		return redirect()->back()->with('success',"EOD delete Successfully.");; 
	}
	
	public function deleteIT_EOD($id){
		It_eod::whereId($id)->delete(); 
		return redirect()->back()->with('success',"EOD delete Successfully.");; 
	}

	public function deleteSALES_EOD($id){
		SalesEod::whereId($id)->delete(); 
		return redirect()->back()->with('success',"EOD delete Successfully.");; 
	}

     

	public function eod_list(){
		$project_id = Project_Assignation::pluck('project_id'); 
        $data['eods_filter'] = Project::whereIn('id',$project_id)->orderBy('project_name','asc')->get();
        $data['eods'] = Eod::orderBy('id','desc')->get();
		return view(getRoleStr().'.eod.index',$data); 
	} 

	public function eod_list_filter(Request $request){
		$project_id = Project_Assignation::pluck('project_id'); 
		   $data['eods_filter'] = Project::whereIn('id',$project_id)->orderBy('project_name','asc')->get();
		   $data['eods'] = Eod::orderBy('id','desc')->where('project_id',$request->filter)->get();
		   $data['req']  = $request->filter;
           return view(getRoleStr().'.eod.index',$data); 
	}

	public function sent_eod(){
		$data['eods']  = Eod::where('user_id',Auth::user()->id)->whereSoft_delete(0)->orderBy('id','DESC')->get();
		 	return view('common.eods.list',$data);
	} 


	public function getSendEOD(){
		$data = array();
		//$data['projects'] = \App\Project::all();

		 $data['projects'] = \App\EmployeeProject::where('user_id',\Auth::user()->id)->get();
		return view('employee.eod.send-eod',$data);
	} 



	public function postSendEOD(Request $request){
		$date = '';
		if(count($request->project) > 0) {
			for ($i=0; $i < count($request->project) ; $i++) { 
				$eod = new \App\Eod();
				$eod->user_id = \Auth::user()->id;
				$eod->date_of_eod = $request->date_of_eod;
				$date = $request->date_of_eod;
				$eod->project_id = $request->project[$i];
				$eod->hours_spent = $request->hours_spent[$i];
				$eod->task = $request->task[$i];
				if($request->comment){
					$eod->comment = $request->comment;
				}
				$eod->save();
			}
		}

		$templateData['user'] = \App\User::where('id',\Auth::user()->id)->with('personal_profile','cb_profile')->first();
		$templateData['eods'] = \App\Eod::where('user_id',\Auth::user()->id)->where('date_of_eod',$date)->get();
		$templateData['date_of_eod'] = $date;
		$receiver_email = array();
		$admins = \App\User::where('role','1')->get();
		foreach ($admins as $admin) {
			array_push($receiver_email,$admin->email);
		}

		$team_leaders = \App\TeamMember::where('team_member_id',\Auth::user()->id)->get();
		foreach ($team_leaders as $team_leader) {
			$user = \App\User::where('id',$team_leader->team_leader_id)->first();
			array_push($receiver_email,$user->email);
		}
		$MailData = new \stdClass();
		$MailData->subject ='EOD - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;
		$MailData->sender_email = \Auth::user()->email;
		$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;
		$MailData->receiver_email = $receiver_email;
		$MailData->receiver_name = \Auth::user()->email;
		$MailData->subject = 'EOD Report '.$date.' -'.\Auth::user()->first_name.' '.\Auth::user()->last_name;
		MailController::sendMail('eod',$templateData,$MailData);
		return redirect('/employee/sent-eods')->with('success',"Sent Successfully.");
	}



	public function getEODToAdmin($id)
	{
		$eod = \App\Eod::where('id',$id)->first();
		if(is_null($eod)){
			return redirect('/admin/eods')->with('error',"EOD Not found");
		}else{
			$data['eod'] = $eod;
			return view('admin.eod.edit',$data);

		}
	} 



	public function getEOD($id)
	{
		$eod = \App\Eod::where('id',$id)->first();
		if(is_null($eod)){
			return redirect('/employee/sent-eods')->with('error',"eod Not found");
		}else{
			$data['eod'] = $eod;
			return view('employee.eod.edit',$data);
		}
	} 

	public function deleteEOD($id)
	{
		$eod = \App\Eod::find($id);
		if(is_null($eod)){
			return redirect('/admin/eods')->with('error','EOD Not Found');
		}else{
			if($eod->delete()){
				return redirect('/admin/eods')->with('success','Removed Successfully.');
			}else{
				return redirect('/admin/eods')->with('error','Something Went Wrong');
			}
		}
	}

    public function sales_eods(){
	   $data['eods'] = SalesEod::whereUser_id(\Auth::user()->id)->orderBy('eod_date','desc')->get(); 
	  // print_r( $data['eods']);die();
		return view('sales.eod_list', $data);    
	}

	public function send_sales_eods(){
		$data['project'] = ['id'=>1, 'name'=>'Demo Project'];  
		return view('sales.send_eod', $data);  
	}

	public function send_sales_eods_save(Request $request){

		$this->validate($request,[
			'project' 		=> 'required',
			'date_of_eod' 	=> 'required',
			'task_1' 		=> 'required',
		]);

		$eods =  SalesEod::whereUser_id(\Auth::user()->id)->whereDate('eod_date',date('Y-m-d',strtotime($request->date_of_eod)))->first();
		if(empty($eods)){   
		   $eods = new SalesEod(); 
           $eods->user_id = \Auth::user()->id;    
           $eods->eod_date = date('Y-m-d', strtotime($request->date_of_eod)); 
		} 
		$eods->project_id = $request->project ; 
		$eods->task_1  =  $request->task_1 ;
		$eods->task_2  = ($request->task_2)  ? $request->task_2  : null ;
		$eods->task_3  = ($request->task_3)  ? $request->task_3  : null ;
		$eods->task_4  = ($request->task_4)  ? $request->task_4  : null ;
		$eods->comment = ($request->comment) ? $request->comment : null ;
		$eods->save();     
		return redirect()->back()->with('success','Eod Send and save Successfully.');   
	}

	public function edit_eod_details(Request $request){
		
       $eod = Eod::with('project')->whereId($request->id)->first();
       $assign_project_id    = Project_Assignation::whereEmployee_id(Auth::user()->id)
		                                  ->pluck('project_id');
	   $assign_projects  = Project::whereIn('id',$assign_project_id)->get();	                                  
       //dd($assign_projects);
      // echo $eod->date;
       $html='<div class="table-responsive pro"><table class="table">
                    <thead>
                    <tr>
                                    <th>EOD Date</th>
                                    <th>Project</th>
                                    <th>Task Name</th>
                                    <th>Description</th>
                                    <th>ES Time </th>
                                    <th>Total Time </th>
                                    <th>Today Time </th>
                                    <th>Delivery Date </th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                </tr>
                    </thead>
                    <tbody>
                    <tr>
										<td><input type="hidden" id="id" value="'.$eod->id.'"/><span id="date">'.$eod->date.'</span></td><td><select id="project_id_edit" >';

							foreach ($assign_projects as $assign_project) {
											# code...
													
								$html.='
                                            <option '.($eod->project_id == $assign_project->id ? 'selected' : '').' value="'.$assign_project->id.'">'.$assign_project->project_name.'</option>
										';
										}

							$html.=	'	</select></td>	<td><input type="text" name="" id="task_name_edit" value='.$eod->task_name.'></td>
										<td><input type="text" name="" id="description_edit" value='.$eod->description.'></td>
										<td><input type="number" name=""  id="es_hours_edit" value='.$eod->es_hours.'></td>
										<td><input type="number" name="" id="total_hours_edit" value='.$eod->total_hours.'></td>
										<td><input type="number" onkeyup="calculateHour()" name="" id="today_hours_edit" value='.$eod->today_hours.'></td>
										<td><input class="datepicker" id="delivery_date_edit" type="text" name="" value="'.date('Y-m-d',strtotime($eod->delivery_date)).'"></td>
										<td><input type="text" name="" id="task_status_edit" value="'.$eod->task_status.'"></td>
										<td><input type="text" name="" id="edit_reason" value="'.$eod->eod_reason.'" placeholder="reason..."></td>
										
										</tr>
										</tbody>
										</div>';
           
            //dd($html);
            return $html; 
	}

	public function edit_save_eods(Request $request){
		//dd($request->all()); 
		$eod_edit = Eod::find($request->eod_id);
		$projects = []; 
		//for($i=0; $i<sizeof($request->project); $i++){
			$row['user_id']      = Auth::user()->id; 
			$row['project_id']   = $request->project_id_edit;
			$row['date']         = $request->date_edit;
			$row['task_name'] 	 = $request->task_name_edit;
			$row['description']  = $request->description_edit;
			$row['es_hours'] 	 = $request->es_hours_edit;
			$row['today_hours']  = $request->today_hours_edit; 
			$row['total_hours']  = $request->total_hours_edit;
			$row['delivery_date'] = $request->delivery_date_edit;
			$row['task_status']   = $request->task_status_edit;
			//$row['edit_reason']   = $request->edit_reason;
			//print_r($row);
			Eod::create($row); 
			$projects[] = $request->project;
			$eod_edit->soft_delete = 1;
			$eod_edit->eod_reason = $request->edit_reason;;
			$eod_edit->save();
		//} 
    
        $date = date('Y-m-d', strtotime($request->date));
		$templateData['user'] = User::where('id',Auth::user()->id)->with('personal_profile','cb_profile')->first();
		$templateData['eods'] = Eod::where('user_id', Auth::user()->id)->whereDate('date', $date)->get();
		$templateData['date_of_eod'] = $date;  
		$receiver_email = array();
		$admins = \App\User::where('role','1')->get();
		foreach ($admins as $admin) { 
			array_push($receiver_email, $admin->email);
		}
		
		$team_leaders = Project_Assignation::join('users','users.id','project_assignation.employee_id')
		                                     ->where('project_assignation.emp_role',1)
		                                     ->whereIn('project_assignation.project_id',$projects)
		                                     ->select('users.id','users.email')->distinct()->get();

		foreach ($team_leaders as $team_leader) { 
			array_push($receiver_email, $team_leader->email); 
		}
        array_push($receiver_email, 'codingbrains8@gmail.com');
       
		$MailData = new \stdClass();
		$MailData->subject ='EOD Report '.$date; 
		$MailData->sender_email = Auth::user()->email;
		$MailData->sender_name  = Auth::user()->first_name.' '.Auth::user()->last_name;
		$MailData->receiver_email = $receiver_email;
		$MailData->receiver_name  = 'Team Lead & Admin';  
		$MailData->subject = 'EOD Report '.date('d-M-Y', strtotime($request->date)).' '.Auth::user()->first_name.' '.Auth::user()->last_name;
		MailController::sendMail('eod', $templateData, $MailData);

		/*Update Support......*/
		   $supports = Support_project::whereIn('project_id', $projects)->get();
			    foreach ($supports as  $sp){
			       $eod_hr = Eod::whereProject_id($sp->project_id)->sum('today_hours');
			       $total  = Support_project::whereProject_id($sp->project_id)->sum('total_hours');
                   $rem = $total - $eod_hr;
                   $per = ($total*10)/100;
                   if($rem < $per){
                      $project  = Project::findOrFail($sp->project_id);
                      $project->mile_expiry = $sp->expiry_date;
                      $project->rem_hours = $rem;
                      $project->save(); 
                   }
			   }
		/*Update Support......*/ 
		return redirect()->back()->with('success',"Eod Send Successfully.");  
	}

    public function edit_eod(Request $request,$id){
         
          $edit_eod = Eod::whereId($request->id)->first();
          $edit_eod->edit_eod_request = 1;
          if($edit_eod->save()){
          	$data['status'] = true;
          }
          /*-----------------------------------Send notification-----------------------*/
				$receiver = array();
				$teamleads = \App\TeamMember::where('team_member_id',Auth::user()->id)->first();
					array_push($receiver,$teamleads->team_leader_id);
					
				$title = "Eod edit request By  -.".' '.Auth::user()->first_name ." ".Auth::user()->last_name;
				$message = "Eod edit request By -.".' '.Auth::user()->first_name ." ".Auth::user()->last_name;
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
				/*-----------------------------------Send notification----------------------*/
				 /*-----------------------------------Send notification-----------------------*/
				$receiver = array();
				
				$users = User::where('role',1)->get();
				 foreach ($users as $user) {
					array_push($receiver,$user->id);
				  }
				$title = "Eod edit request By  -.".' '.Auth::user()->first_name ." ".Auth::user()->last_name;
				$message = "Eod edit request By -.".' '.Auth::user()->first_name ." ".Auth::user()->last_name;
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
				/*-----------------------------------Send notification----------------------*/
          return response()->json($data);
    }

    public function edit_eod_update_request_accept(Request $request){
    	//dd($request->id);
         $edit_eod =Eod::whereId($request->id)->first();
         $edit_eod->edit_eod_request =2;
         if($edit_eod->save()){
         	$data['status'] = true;
         }
         /*-----------------------------------Send notification-----------------------*/
				$receiver = array();
				//$teamleads = \App\TeamMember::where('team_member_id',Auth::user()->id)->first();
					array_push($receiver,$edit_eod->user_id);
					
				$title =  " Your edit request was accepted by ".getRoleStr();
				$message = " Your edit request was accepted by ".getRoleStr();
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
		/*-----------------------------------Send notification----------------------*/
         return response()->json($data);
    }
        public function edit_eod_update_request_reject(Request $request){
         $edit_eod =Eod::whereId($request->id)->first();
         $edit_eod->edit_eod_request =3;
         if($edit_eod->save()){
         	$data['status'] = true;
         }
          /*-----------------------------------Send notification-----------------------*/
				$receiver = array();
				//$teamleads = \App\TeamMember::where('team_member_id',Auth::user()->id)->first();
					array_push($receiver,$edit_eod->user_id);
					
				$title =  " Your edit request was rejected by ".getRoleStr();
				$message = " Your edit request was rejected by ".getRoleStr();
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
				/*-----------------------------------Send notification----------------------*/
         return response()->json($data);
    }
}



