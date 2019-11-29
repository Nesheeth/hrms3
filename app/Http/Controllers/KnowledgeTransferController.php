<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Mail; 
use Session;
use App\KnowledgeTransfer;
use App\User;
use App\Project_Assignation;
use App\Resignation;
use DB;


class KnowledgeTransferController extends Controller
{ 

	public function kt_view(){

		$data['kt'] = User::join('team_members', 'team_members.team_member_id', '=', 'users.id')
					
				    ->join('resignations', 'resignations.user_id', '=', 'users.id')
				    
				    ->where('user_id','!=', Auth::user()->id)
				    ->where('team_leader_id', Auth::user()->id)
				    ->where('department','development')
				    ->orderBy('users.created_at','DESC')
                    ->get();


                   
		return view('common.kt.index',$data);
	}

	public function assign_kt_to_emp($id){

		$data['id'] =$id;
		$data['resign'] = Resignation::where('user_id',$id)->first();
		$data['user'] = User::where('id',$id)->first();
		$data['kt'] = KnowledgeTransfer::where('user_id', $id)->first();

		$data['projects'] = Project_Assignation::where('employee_id',$id)->where('assign_status',0)->count(['project_id']);

		$data['kt_status'] = KnowledgeTransfer::where('user_id', $id)->get();
		$data['project_count'] = $data['kt_status']->count('project_id');
		$kt_projects = KnowledgeTransfer::where('user_id',$id)->count('project_id');
		$kt_status = KnowledgeTransfer::where('user_id',$id)->where('status','2')->count('project_id');

		if($data['kt'])
		{
			$data['kt_percent'] = ($kt_status/$kt_projects)*100;
			if($data['kt_percent'] == '1')
			{
				$data['kt_percent'] = 100;
			}
		
		}else
		{
			$data['kt_percent'] = 0;
		}
		
	
		$data['employees'] = User::with('kt_project') 
							->where(function($query) use ($id){
							        $query->where('id','!=',$id)
							            ->orWhere('id','!=',Auth::user()->id);
							    })
							->where('role',6)
							->where('is_active', 1)
							->get();

		// $data['current_projects'] = KnowledgeTransfer::with('project')->where('user_id',$id)->orderBy('id','DESC')->get();

		//print_r($data['current_projects']);die();
			
		if($data['kt']){

			

			$data['current_projects'] = Project_Assignation::leftJoin('knowledge_transfers',function($join) {
		      	$join->on('project_assignation.project_id', '=', 'knowledge_transfers.project_id');
		    })->select('project_assignation.project_id','project_assignation.employee_id','knowledge_transfers.kt_given_to','knowledge_transfers.kt_given_to_name','knowledge_transfers.user_id','knowledge_transfers.emp_remark','knowledge_transfers.res_emp_remark','knowledge_transfers.is_actived','project_assignation.emp_role','project_assignation.start_date','project_assignation.end_date','project_assignation.assign_percentage','project_assignation.assign_status','project_assignation.performance_notes','project_assignation.assign_by','project_assignation.update_by','knowledge_transfers.status')->where('employee_id',$id)->where('assign_status',0)->orderBy('project_assignation.id','DESC')->get();
		  
		}else
		{
			$data['current_projects'] = Project_Assignation::where('employee_id',$id)->where('assign_status',0)->orderBy('id','DESC')->get();
		}				
		

		return view('common.kt.assign',$data);
	}

	public function assignkt(Request $request){
		
		
		if($request->konwledge_transfer_to == null || $request->konwledge_transfer_to == "" || $request->konwledge_transfer_to == "0"){
			return redirect()->back()->with('error','Please Select Employee');
		}else
		{
			$kt = \App\KnowledgeTransfer::where('user_id',$request->id)->where('project_id',$request->ktproject)->get();
			if(count($kt) <= 0)
			{
				$knowledgetransfer = new \App\KnowledgeTransfer();

				$knowledgetransfer->user_id = $request->id;
				$knowledgetransfer->project_id =$request->ktproject;
				$knowledgetransfer->project_name =\App\Project::where('id',$request->ktproject)->value('project_name');
				$knowledgetransfer->project_id =$request->ktproject;
				$knowledgetransfer->kt_given_to =$request->konwledge_transfer_to;
				$knowledgetransfer->kt_given_to_name = \App\User::where('id',$request->konwledge_transfer_to)->value('first_name','Last_name');
			
				$knowledgetransfer->save();

			    $user = User::where('id',$request->id)->first();
			    $resign = Resignation::where('user_id',$request->id)->first();

	
				$dateDiff= dateDiff($resign->date_of_resign,$resign->last_working_day);

				$receiver = array();
				$receiver_email = array();
				$url = url('see-kt-transfer/'.$request->id);   
				$title = $user->first_name." ".$user->last_name." "."Assign Knowledge Transfer";
				$message = "<p>".$user->first_name." ".$user->last_name." "."Assign Knowledge Transfer.". $dateDiff." Days Left.</p>";
				 $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";
				 $type = '3';

				$admins = \App\User::where('role','1')->get();
				foreach ($admins as $admin) {
					array_push($receiver,$admin->id);
					array_push($receiver_email,$admin->email);
				}
				if($user->role != 2){
					$hrs = \App\User::where('role','2')->get();
					foreach ($hrs as $hr) {
						array_push($receiver,$hr->id);
						array_push($receiver_email,$hr->email);
					}
				}

				$users = DB::table('users')
            			->join('knowledge_transfers', 'users.id', '=', 'knowledge_transfers.user_id')->where('user_id',$request->id)->get();

            	foreach($users as $user) {
            		$emp = User::where('id',$user->kt_given_to)->first();
            		if($emp->role == 6){
            			$message = "<p>".$user->first_name." ".$user->last_name." "."Assigned Knowledge Transfer to You.".$dateDiff." Days Left.</p>";
            			 $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";
            			array_push($receiver,$user->kt_given_to);
            		}else{
            			array_push($receiver,$user->kt_given_to);
            		}
            		
            	}

            			array_push($receiver, $request->id);

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message,$type,$request->id);

				return back()->with('success','Knowledge Transfer Assigned Successfully!!');


			}
			else
			{
				$knowledgetransfer = \App\KnowledgeTransfer::where('user_id',$request->id)->where('project_id',$request->ktproject)->first();
		      		 
		    		$th=[
		    	
		    			'project_id' => $request->ktproject,
		    		'project_name' => \App\Project::where('id',$request->ktproject)->value('project_name'),
		    		 'kt_given_to' => $request->konwledge_transfer_to,
		    		 'kt_given_to_name' => \App\User::where('id',$request->konwledge_transfer_to)->value('first_name','Last_name'),
		    		
		    		 'is_actived' => 1];


		    	if(['kt_given_to'] != null )
		    	{	
		    		if(isset($knowledgetransfer)){
		    			$tn = \App\KnowledgeTransfer::where('id',$knowledgetransfer->id)->update($th);
		    		}
		    		
		    		 $user = \App\User::where('id',$request->id)->first();

				$receiver = array();
				$receiver_email = array();
				$url = url('see-kt-transfer/'.$request->id);   
				$resign = Resignation::where('user_id',$request->id)->first();
				
				$dateDiff= dateDiff($resign->date_of_resign,$resign->last_working_day);
				$title = $user->first_name." ".$user->last_name." "."Assign Knowledge Transfer";
				$message = "<p>".$user->first_name." ".$user->last_name." "."Assign Knowledge Transfer.".$dateDiff." Days Left.</p>";
				 $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";
				 $type = '3';
				$admins = \App\User::where('role','1')->get();
				foreach ($admins as $admin) {
					array_push($receiver,$admin->id);
					array_push($receiver_email,$admin->email);
				}
				if($user->role != 2){
					$hrs = \App\User::where('role','2')->get();
					foreach ($hrs as $hr) {
						array_push($receiver,$hr->id);
						array_push($receiver_email,$hr->email);
					}
				}

				$users = DB::table('users')
            			->join('knowledge_transfers', 'users.id', '=', 'knowledge_transfers.user_id')->where('user_id',$request->id)->get();

            	foreach($users as $user) {
            		$emp = User::where('id',$user->kt_given_to)->orwhere('id','!=', Auth::user()->id)->first();
            		if($emp->role == 6){
            			$message = "<p>".$user->first_name." ".$user->last_name." "."Assigned Knowledge Transfer to You.".$dateDiff." Days Left.</p>";
            			 $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";
            			array_push($receiver,$user->kt_given_to);
            		}else{
            			array_push($receiver,$user->kt_given_to);
            		}
            		
            	}

            	array_push($receiver, $request->id);

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message,$type,$request->id);

		    		return back()->with('success','Knowledge Transfer Updated Successfully!!');
		         
		        }
		    	else
		    	{
		    		return back()->with('error','Please assign the knowledge transfer to employee..');
		    	}  	
			}


		}
	}

	public function emp_remark(Request $request){

		// dd($request->all());
		if($request->status == "0"){
			return redirect()->back()->with('error','Please Select the status');
		}
		else
		{
			$knowledgetransfer = \App\KnowledgeTransfer::where('user_id',$request->id)->where('project_id',$request->ktproject)->first();

			
			$th=[
		    	
		    			'project_id' => $request->ktproject,
		    		'project_name' => \App\Project::where('id',$request->ktproject)->value('project_name'),
		    		 'kt_given_to' => $request->konwledge_transfer_to,
		    		 'kt_given_to_name' => \App\User::where('id',$request->konwledge_transfer_to)->value('first_name','Last_name'),
		    		 'status' => $request->status,
		    		 'emp_remark' => $request->remark1,
		    		 'res_emp_remark' => $request->remark2,
		    		 'is_actived' => 1];

			$tn = \App\KnowledgeTransfer::where('id',$knowledgetransfer->id)->update($th);

			return redirect()->back()->with('success','Remark has been successfully submitted!!');
		}
	}
	
	public function see_kt_of_emp($id){

		
		$data['id'] =$id;
		$data['resign'] = Resignation::where('user_id',$id)->first();
		
		$data['resignation'] = Resignation::where('user_id',Auth::user()->id)->first();
		$data['user'] = User::where('id',$id)->first();
		$data['kt'] = KnowledgeTransfer::where('user_id', $id)->first();
		if($data['kt']->user_id == Auth::user()->id)
		{
			$data['current_projects'] = KnowledgeTransfer::where('user_id',$id)->orderBy('id','DESC')->get();
		}
		else
		{
			$data['current_projects'] = KnowledgeTransfer::where('user_id',$id)->where('kt_given_to',Auth::user()->id)->orderBy('id','DESC')->get();
		}
		
		$data['kt_status'] = KnowledgeTransfer::where('user_id', $id)->get();

		if(!is_null($data['kt']))
		{
			$kt_projects = KnowledgeTransfer::where('user_id',$id)->count('project_id');
			$kt_status = KnowledgeTransfer::where('user_id',$id)->where('status','2')->count('project_id');

			$data['kt_percent'] = ($kt_status/$kt_projects)*100;
			if($data['kt_percent'] == '1')
			{
				$data['kt_percent'] = 100;
			}
		}
		
		if($data['kt'])
		 {

			if($data['kt']->kt_given_to == Auth::user()->id)
			{

				$data['employees'] = DB::table('users')
		            			->join('knowledge_transfers', 'users.id', '=', 'knowledge_transfers.user_id')
		            			
		            			->where('user_id',$id)
		            			->where('kt_given_to',Auth::user()->id)
		            			->get();
			}
			else
			{
				$data['employees'] = DB::table('users')
		            			->join('knowledge_transfers', 'users.id', '=', 'knowledge_transfers.user_id')
		            			
		            			->where('user_id',$id)
		            			
		            			->get();
			}

		 
		 	return view('common.kt.show',$data);
		 }
		 else
		 {
		 	return redirect()->back()->with('error','Knowledge Transfer is not initialized for this user yet!!');
		 }
		

	}
}