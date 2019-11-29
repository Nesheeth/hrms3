<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\EmpAttendance;
use App\AttendanceData;
use App\EmployeeCbProfile;

class ApiController extends Controller
{
    public function attendence(Request $request){
		
		if(!empty($request->Jsondata)){
				$attendence = json_decode($request->Jsondata); 
			  
				foreach($attendence as $att){
					//$check = EmpAttendance::whereEmp_id($att->Emp_id)->whereDate('attendance_date',date('Y-m-d',strtotime($att->CurrentDate)))->first();
					$check = AttendanceData::whereAttendance_id($att->Card_Number)->whereDate('attendance_date',date('Y-m-d',strtotime($att->CurrentDate)))->first();
					if(empty($check)){
						$user =  EmployeeCbProfile::whereAttendance_id($att->Card_Number)->first();
						$check = new AttendanceData();
						$check->attendance_date = date('Y-m-d',strtotime($att->CurrentDate));
						$check->attendance_id 	= $att->Card_Number;
						$check->employee_id 	= !empty($user) ? $user->employee_id : null;
					}  
						//$check->dep_id 				= $att->Dev_Id;
						$check->in_time 			= date('Y-m-d H:i:s', strtotime($att->In_Time));
						$check->out_time 			= date('Y-m-d H:i:s', strtotime($att->Out_Time));
						
						$check->status 			    = ($att->Aprved_Tag=='D') ? (($att->day_status=='Full Day') ? 'P' : 'HD') : "AB" ;
						$check->save();
				}
				
				Mail::raw($request->Jsondata, function($message){   
					$message->from('codingbrains123@gmail.com', 'Coding Brains');
					$message->to('codingbrains21@gmail.com')->cc('codingbrains8@gmail.com')->subject('Attendance from Dev!'); 
				}); 
				
				return json_encode(['status'=>200]); 
		}else{
			return json_encode(['status'=>404,'message'=>'Parameters Missing.']);
		}	
	}
     
}
