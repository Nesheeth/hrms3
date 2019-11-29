<?php







namespace App\Http\Controllers;







use Illuminate\Http\Request;







class EmployeeLeaveController extends Controller



{



	public function myLeaves(Request $request)



	{



		if($request->type){



			if($request->type == 'approved'){



				$is_approved = 1;



			}



			elseif($request->type == 'pending'){



				$is_approved = 0;



			}



			elseif($request->type == 'rejected'){



				$is_approved = -1;



			}



			$leaves = \App\Leaves::where('user_id',\Auth::user()->id)->where('is_approved',$is_approved)->with('leave_type')->orderBy('id','DESC')->get();



		}else{



			$leaves = \App\Leaves::where('user_id',\Auth::user()->id)->with('leave_type')->orderBy('id','DESC')->get();



		}



		$data['leaves'] = $leaves;

		 //$data['leave_created'] = strtotime($leaves['created_at']);

	   // $data['current_date'] = strtotime(date('Y-m-d h:m:s'));

     //dd($leaves);

		return view('employee.leaves.index',$data);



	} 



	public function getAddLeave()



	{



		$leave_types = \App\LeaveType::all();



		$data['leave_types'] = $leave_types;



		return view('employee.leaves.apply-leave',$data);



	} 



	public function postAddLeave(Request $request){
		$validator = \Validator::make($request->all(),
			array(
				'leave_type' =>'required',
				'date_from' =>'required',
				'date_to' =>'required',
				'contact_number' =>'required|digits:10',
				'reason' =>'required',
			)
		);



		if($validator->fails())
		{
			return redirect('/employee/apply-leave')
			->withErrors($validator)
			->withInput();
		}
		else
		{    
			$leave_knoldge = \App\Leaves::where('user_id',\Auth::user()->id)->get();
                $val = array();
	            foreach($leave_knoldge as $key => $value)
	            {     

	            	   array_push($val, $value->date_from);
	            	 // if($value->date_from == $request->date_from)

	            	 // {

	            	 // 	return redirect()->back()->with('error','You Already Taken Leave For This Day');

	            	 // }

               }

	           if(in_array($request->date_from, $val))

	           {

	           	return redirect()->back()->with('error','You Already Applied Leave For This Day');

	           }

	           else{



			$leave =  new \App\Leaves();



			$leave->user_id = \Auth::user()->id;



			$leave->leave_type_id = $request->leave_type;



			$leave->date_from = $request->date_from;



			$leave->date_to = $request->date_to;



			$leave->days = $request->days;



			$leave->contact_number = $request->contact_number;



			$leave->reason = $request->reason;



			$url = url('role/leave-listing?type=pending');   



			if($leave->save()){ 



				/*-----------------------------------Send notification-------------------------------------------*/



				$user = \App\User::where('id',\Auth::user()->id)->first();
				$receiver = array();
				$title = $user->first_name." ".$user->last_name." "."Requested for Leave";
				$message = "<p>".$user->first_name." ".$user->last_name." "."Requested for Leave."."</p>"."<br>";
				$message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";     
				$admins = \App\User::where('role','1')->get();

				foreach ($admins as $admin) {
					array_push($receiver,$admin->id);
				}

				$hrs = \App\User::whereIn('role',[2,4])->get();

				foreach ($hrs as $hr) {
					array_push($receiver,$hr->id);   
				}

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



				/*-----------------------------------Send notification-------------------------------------------*/



				return redirect('/employee/my-leaves')->with('success',"Successfully Submitted Leave Wait For Admin Approval.");



			}else{



				return redirect('/employee/my-leaves')->with('error',"Something Went Wrong.");



			}

		}



		}







	}

	Public function getRetractApplyLeave()

	{

		return view('employee/retracts/apply-retract');

	}

	public function submitretarctleave(Request $request , $id)

	{

		$validator = \Validator::make($request->all(),



			array(



				'reason_retract' =>'required',



				'message_retract' =>'required',



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

		   $retr_leave = \App\RetractLeave::where('leave_id','=',$id)->first();

           // print_r($retr_leave);

        if(!is_null($retr_leave)){

        	return redirect()->back()->with('error',"Sorry , You already send the meassge of retract. ");

        }

        else{

		$retract_leave =  new \App\RetractLeave();

        $retract_leave->leave_id = $id;

         $retract_leave->user_id = \Auth::user()->id;

          $retract_leave->reason = $request->reason_retract;

           $retract_leave->message = $request->message_retract;

            $retract_leave->is_accept = 0;

            if($retract_leave->save())

            {

            	  // $leaves  = \App\Leaves::find($id);

               //    $leaves->is_approved = 2;

               //    $leaves->save();

             /*-----------------------------------Send notification-------------------------------------------*/



				$user = \App\User::where('id',\Auth::user()->id)->first();



				$receiver = array();



				$title = $user->first_name." ".$user->last_name." "."Requested for Retract Leave";



				$message = "<p>".$user->first_name." ".$user->last_name." "."Requested for Retract Leave."."</p>"."<br>";



				



				$admins = \App\User::where('role','1')->get();



				foreach ($admins as $admin) {



					array_push($receiver,$admin->id);



				}



				$hrs = \App\User::where('role','2')->get();



				foreach ($hrs as $hr) {



					array_push($receiver,$hr->id);



				}



				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



				/*-----------------------------------Send notification-------------------------------------------*/





            	return redirect()->back()->with('success',"Waiting for Admin Reply");

            }

            else

            {

            	return redirect()->back()->with('error',"Something Went Wrong.");

            }

	}

}

}





}



