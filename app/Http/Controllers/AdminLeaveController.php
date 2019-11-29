<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use DB;



class AdminLeaveController extends Controller

{

	public function leave_listing(Request $request)

	{

		if($request->type == "approved"){

			$leaves = \App\Leaves::where('is_approved',1)->with('leave_type')->paginate(10);

		}else if($request->type == "discarded"){

			$leaves = \App\Leaves::where('is_approved',-1)->with('leave_type')->paginate(10);

		}

		else if($request->type == "pending"){

			$leaves = \App\Leaves::where('is_approved',0)->with('leave_type')->paginate(10);

		}else{

			$leaves = \App\Leaves::OrderBy('id', 'DESC')->paginate(10);

		}
       
		$data['leaves'] = $leaves;
	     
	     
		return view('admin.leaves.leaves',$data);

	} 

	public function leave_types()

	{

		$leave_types = \App\LeaveType::all();

		$data['leave_types'] = $leave_types;

		return view('admin.leaves.leave_types',$data);

	} 

	public function getAddLeaveType()

	{

		return view('admin.leaves.create_leaves_type');

	} 

	public function postAddLeaveType(Request $request){

		$validator = \Validator::make($request->all(),

			array(

				'leave_type' =>'required',

				'description' =>'required',

			)

		);

		if($validator->fails())

		{

			return redirect('/admin/add-leave-type')

			->withErrors($validator)

			->withInput();

		}

		else

		{

			$leave_type =  new \App\LeaveType();

			$leave_type->leave_type = $request->leave_type;

			$leave_type->description = $request->description;

			if($leave_type->save()){ 

				return redirect('/admin/leave-types')->with('success',"Added Successfully.");

			}else{

				return redirect('/admin/leave-types')->with('error',"Something Went Wrong.");

			}

		}



	}



	public function getEditLeaveType($id)

	{

		$leave_type = \App\LeaveType::where('id',$id)->first();

		if(is_null($leave_type)){

			return redirect('/admin/leave-types')->with('error',"leave_type Not found");

		}else{

			$data['leave_type'] = $leave_type;

			return view('admin.leaves.edit_leaves_type',$data);

		}

	} 

	public function postEditLeaveType(Request $request){

		$validator = \Validator::make($request->all(),

			array(

				'leave_type' =>'required',

				'description' =>'required',

			)

		);

		if($validator->fails())

		{

			return redirect()->back()

			->withErrors($validator)

			->withInput();

		}

		else

		{

			$leave_type =  \App\LeaveType::find($request->id);

			$leave_type->leave_type = $request->leave_type;

			$leave_type->description = $request->description;

			if($leave_type->save()){

				return redirect('/admin/leave-types')->with('success',"Updated Successfully");

			}else{

				return redirect('/admin/leave-types')->with('error',"Something Went Wrong.");

			}

		}

	}



	public function deleteLeaveType($id)

	{

		$leave_type = \App\LeaveType::find($id);

		if(is_null($leave_type)){

			return redirect('/admin/leave-types')->with('error','leave type Not Found');

		}else{

			if($leave_type->delete()){

				return redirect('/admin/leave-types')->with('success','leave type Removed Successfully.');

			}else{

				return redirect('/admin/leave-types')->with('error','Something Went Wrong');

			}

		}

	}



	public function approveLeave($id)

	{

		$leave = \App\Leaves::find($id);
		$leave_date = $leave->date_from;
		$current_date = date('Y-m-d');
         $last_date = date('Y-m-t');
		$leave_user = $leave->user_id;
		$leave_type = $leave->leave_type_id;
		$newDate = date("Y-m-d", strtotime($leave_date));


		if(is_null($leave)){

			return redirect('/admin/leave-listing')->with('error','Leave Not Found');

		}else{

			$leave->is_approved = 1;

			$employee_cb_profile =   \App\EmployeeCbProfile::where('user_id',$leave->user_id)->first();
             
           




			// $remainDays = ($employee_cb_profile->avail_leaves - $leave->days);

			// if($remainDays < 0){

			// 	$employee_cb_profile->avail_leaves = 0;

			// 	$employee_cb_profile->leaves_taken =  ($employee_cb_profile->leaves_taken + abs($remainDays));

			// }else{

			// 	$employee_cb_profile->avail_leaves = $remainDays;

			// }

			

			if($leave->save()){
				$emp_code = \App\EmployeeCbProfile::where('user_id',$leave_user)->value('employee_id');
				if($leave_type == 14){
					$date = strtotime("+0 day", strtotime($leave_date));
                $aa  = date("Y-m-d", $date);
				$leave_name = \App\LeaveType::where('id',$leave_type)->value('leave_type');
				
				$attendance = DB::table('attendance_data')->insert(['attendance_date' => $aa ,'employee_id'=> $emp_code,'status' => 'HD' ,'created_at' => $newDate]);

                  

			     
			     }

				//$employee_cb_profile->save();

				if($leave->days == 'Half day leave')
			       {
				// $data['halfdays'] = \App\AttendanceData::where('employee_id','=',$employee_cb_profile['employee_id'])->where('status','HD')->count();
				 $data['halfdays'] = \App\AttendanceData::where('employee_id','=',$employee_cb_profile["employee_id"])->where('attendance_date','>=',$current_date)->where('attendance_date','<=',$last_date)->where('status','HD')->count();
				 
				 if($data['halfdays'] == '2' || $data['halfdays'] == '4'|| $data['halfdays'] == '6' || $data['halfdays'] == '8' )
                   
                   {
                      $remainDays = ($employee_cb_profile->avail_leaves - 1);
                     // print_r($data['halfdays'] ." ===" .$leave->days .'==='.$remainDays);
			          if($remainDays < 0){
			          //	print_r('if');
				       $employee_cb_profile->avail_leaves = 0;
				       $employee_cb_profile->leaves_taken =  ($employee_cb_profile->leaves_taken + abs($remainDays));
			             }    
			           else
			               {
				         $employee_cb_profile->avail_leaves = $remainDays;
			               }
			               $employee_cb_profile->save();

                   }
                  

			     }

			     else
			     {
                   $remainDays = ($employee_cb_profile->avail_leaves - $leave->days);

			 if($remainDays < 0){

			 	$employee_cb_profile->avail_leaves = 0;

			 	$employee_cb_profile->leaves_taken =  ($employee_cb_profile->leaves_taken + abs($remainDays));

			 }else{

			 	$employee_cb_profile->avail_leaves = $remainDays;

			 }

                      $employee_cb_profile->save();

			     }

				/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($leave->user_id);

				$title = "Admin Accepted You leave request.";

				$message = "Admin Accepted You leave request.";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------Send notification-------------------------------------------*/

				return redirect()->back()->with('success','Leave Status Updated Successfully.');

			}else{

				return redirect()->back()->with('error','Something Went Wrong');

			}

		}

	}



	public function discardLeave($id)

	{

		$leave = \App\Leaves::find($id);

		if(is_null($leave)){

			return redirect('/admin/leave-listing')->with('error','Leave Not Found');

		}else{

			$leave->is_approved = -1;

			if($leave->save()){

				/*-----------------------------------Send notification-------------------------------------------*/

				$receiver = array($leave->user_id);

				$title = "Admin Discarded You leave request.";

				$message = "Admin Discarded You leave request.";

				$admins = \App\User::where('role','1')->get();

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

				/*-----------------------------------Send notification-------------------------------------------*/

				return redirect()->back()->with('success','Leave Status Updated Successfully.');

			}else{

				return redirect()->back()->with('error','Something Went Wrong');

			}

		}

	}

 public function discardLeavewithreason(Request $request,$id)
    {
    	
     $leave = \App\Leaves::find($id);
		$user = \App\User::where('id',$leave->user_id)->first();
		
		if(is_null($leave)){
			return redirect('/admin/leave-listing')->with('error','Leave Not Found');
		}else{
			$leave->is_approved = -1;	
			$leave->not_approve_reason = $request->not_approve_reason;
			$templateData['user'] = \App\User::where('id',$leave->user_id)->with('personal_profile','cb_profile')->first();
			$templateData['not_approve_reason'] = $request->not_approve_reason;
			$templateData['leavemsg']	= $leave->reason;	
            // echo $request->reason;
            // dd($request->reason);
            $leave->save();
			if($leave->save()){
				/*-----------------------------------Send notification-------------------------------------------*/
				$receiver = array($leave->user_id);
				$title = "Admin Discarded You leave request.";
				$message ="Admin Discarded You leave request."."<br>"."<b>"."Reason:-"."
				</b>".$templateData['not_approve_reason'];
				$admins = \App\User::where('role','1')->get();
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
				/*-----------------------------------Send notification-------------------------------------------*/

				$MailData = new \stdClass();
		$MailData->subject ='Leave Not Approve - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;
		$MailData->sender_email = \Auth::user()->email;
		$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;
		$MailData->receiver_email = $user['email'];
		$MailData->receiver_name = \Auth::user()->email;
      
		MailController::sendMail('notapproveleave',$templateData,$MailData);
		   
				return redirect('/admin/leave-listing')->with('success','Leave Status Updated Successfully.');
			}else{
				return redirect('/admin/leave-listing')->with('error','Something Went Wrong');
			}
		}


    }

	public function deleteLeave($id)

	{

		$leave = \App\Leaves::find($id);

		if(is_null($leave)){

			return redirect()->back()->with('error','Leave Not Found');

		}else{

			if($leave->delete()){

				return redirect()->back()->with('success','Leave Removed Successfully.');

			}else{

				return redirect()->back()->with('error','Something Went Wrong');

			}

		}

	}
	public function retract_leave_list()
       { 
       	   $data['leave_types'] = \App\RetractLeave::all();
          return view('admin/retract_leave/retract-leave',$data);
       }
       public function previewRetract_leave($id)

     {
     	$response = array();

		$retracts = \App\RetractLeave::where('leave_id',$id)->first();
		
		if(is_null($retracts)){

			$response['flag'] = false;

			$response['message'] = "Resignation not Found";

		}else{

			$response['flag'] = true;

			$response['retracts'] = $retracts;

		}
       
		return response()->json($response);
     }
     public function restractleaveaccepted($id)
         
         {
        	 $retracts = \App\RetractLeave::where('leave_id',$id)->first();
       $user = \App\User::where('id','=',$retracts['user_id'])->first();
        $current_date = date('Y-m-d');
         $last_date = date('Y-m-t');
       $leave = \App\Leaves::find($id);
      $employee_cb_profile =   \App\EmployeeCbProfile::where('user_id',$leave->user_id)->first();
        $leave_date = $leave->date_from;

      // dd($leave." -- ". $id. " ---  ".$leave_date);
		//$originalDate = "2010-03-21";
        $newDate = date("Y-m-d", strtotime($leave_date));
		$leave_user = $leave->user_id;
		$leave_type = $leave->leave_type_id;

       if(is_null($retracts)){

			 return redirect()->back()->with('error','Error');
       }
       else{
       $retract = DB::table('retract_leaves')->where('leave_id',$id)->update(['is_accept'=> 1]);
       $leave = \App\Leaves::find($id);
         $leave_day = $leave->days;
       if(!is_null($leave))
       {
        //if($leave->delete())
        //{
       	if($leave->days == 'Half day leave')
			       {
         $emp_code = \App\EmployeeCbProfile::where('user_id',$leave_user)->value('employee_id');
             $id11 = DB::table('attendance_data')->where('attendance_date',$newDate)->where('employee_id',$emp_code)->value('id');
                  $attendance = \App\AttendanceData::find($id11);
                 //dd($attendance+'--'+ $id11+'--' +$emp_code );
                 $attendance->delete();
               
               
				// $data['halfdays'] = \App\AttendanceData::where('employee_id','=',$emp_code)->where('status','HD')->count();
				 $data['halfdays'] = \App\AttendanceData::where('employee_id','=',$emp_code)->where('attendance_date','>=',$current_date)->where('attendance_date','<=',$last_date)->where('status','HD')->count();
				 // print_r($data['halfdays'] ." ===" .$leave->days .'===');
				 if($data['halfdays'] == '2' || $data['halfdays'] == '4'|| $data['halfdays'] == '6' || $data['halfdays'] == '8' )
                   
                   {
                      $remainDays = ($employee_cb_profile->avail_leaves + 1);
                    //  print_r($data['halfdays'] ." ===" .$leave->days .'==='.$remainDays);
			          if($remainDays < 0){
			          //	print_r('if');
				       $employee_cb_profile->avail_leaves = 0;
				       $employee_cb_profile->leaves_taken =  ($employee_cb_profile->leaves_taken + abs($remainDays));
			             }    
			           else
			               {
				         $employee_cb_profile->avail_leaves = $remainDays;
			               }
			               $employee_cb_profile->save();

                   }
                  

			     }

               

                $leave->delete();
                $retracts->delete();



       	   $cpprofile  = \App\EmployeeCbProfile::where('user_id',$leave->user_id)->first();
       	   
       	   if($cpprofile->avail_leaves > 0)
       	   {
       	   	 $cpprofile->avail_leaves = $cpprofile->avail_leaves+$leave_day;
       	   	 $cpprofile->save();
       	   } 
       	   else
       	   {
       	   	if($cpprofile->leaves_taken > 0)
       	   	  {
       	   		$cpprofile->leaves_taken = $cpprofile->leaves_taken-$leave_day;
       	   		$cpprofile->save();
       	   	  }
       	   }

       // }
        }
      
     $templateData['user1'] = \App\User::where('id',$retracts->user_id)->with('personal_profile','cb_profile')->first();
        

				/*-----------------------------------Send notification-------------------------------------------*/
				$receiver = array($retracts->user_id);
				$title = "Admin Accepted Your Retract Leave.";
				$message = "Admin Accepted Your Retract Request Leave ";
				$admins = \App\User::where('role','1')->get();
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
				/*-----------------------------------Send notification-------------------------------------------*/
             return redirect()->back()->with('success','Successfully submitted');
         }
     }
      public function restractleaverejected($id)
         
         {
        	 $retracts = \App\RetractLeave::where('leave_id',$id)->first();
       $user = \App\User::where('id','=',$retracts['user_id'])->first();

       if(is_null($retracts)){

			 return redirect()->back()->with('error','Error');
       }
       else{
       $retract = DB::table('retract_leaves')->where('leave_id',$id)->update(['is_accept'=> -1]);
      
     $templateData['user1'] = \App\User::where('id',$retracts->user_id)->with('personal_profile','cb_profile')->first();
        

				/*-----------------------------------Send notification-------------------------------------------*/
				$receiver = array($retracts->user_id);
				$title = "Admin Rejected Your Retract Leave.";
				$message = "Admin Rejected Your Retract Request Leave ";
				$admins = \App\User::where('role','1')->get();
				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
				/*-----------------------------------Send notification-------------------------------------------*/
             return redirect()->back()->with('success','Successfully Rejected Retract Leave');
         }
     }
       

}

