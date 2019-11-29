<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\AttendanceData;
use App\AttendanceLog;
use App\User;

class AttendanceController extends Controller{
	
	
	
	public function get_daily_attendance(Request $request){
		
		$current_date = $request->at_date;
	 	$emptype      = $request->type;
		$attendanceDone = DB::table('users')->join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')
		->join('attendance_data','attendance_data.employee_id','=','employee_cb_profiles.employee_id')
		->select('users.first_name','users.last_name','employee_cb_profiles.employee_id','attendance_data.status','attendance_data.id','attendance_data.in_time','attendance_data.out_time')
		->where('users.department','=',$emptype)
		->where('users.role','<>',1)
		->where('users.is_active','=',1)
		->where('attendance_data.attendance_date',$current_date)->get();
		//print_r($attendanceDone);die();  
		$allemployees = DB::table('users')->join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')
		->select('users.first_name','users.last_name','employee_cb_profiles.employee_id')
		->where('users.department','=',$emptype)->where('users.role','<>',1)->where('users.is_active','=',1)->get();
		$allData = []; 
		
		foreach ($allemployees as $key => $value) {
			$allData[$key]['first_name'] = $value->first_name;
			$allData[$key]['last_name'] = $value->last_name;
			$allData[$key]['employee_id'] = $value->employee_id;
			$isMatch = false;
			foreach ($attendanceDone as $key1 => $value1) {	
				if($value->employee_id == $value1->employee_id){
					$allData[$key]['status']  = $value1->status;
					$allData[$key]['attendance_id']  = $value1->id; 
					$allData[$key]['in_time']  = date('h:i:s A',strtotime($value1->in_time));
					$allData[$key]['out_time'] = date('h:i:s A',strtotime($value1->out_time));         
					$isMatch = true;
				}
			}
			if($isMatch == false){
				$allData[$key]['status'] = "no";
				$allData[$key]['in_time']  = "";
				$allData[$key]['out_time'] = "";
				$allData[$key]['attendance_id'] = "";
			}
		}
		$dayTypes = DB::table('dayType')->get();
		$data = ['success'=>true,'current_date'=>$current_date,'attendance'=> $allData, 'dayTypes'=>$dayTypes];
		return view('common.daily_attendance', $data); 
	}
	
	public function update_daily_attendance(Request $request){
          // $preattendance = AttendanceData::where('attendance_data',$request->at_date)->get();
		    $emp_ids = [];
		   
		    foreach($request['attendance'] as $key=>$at){ 
			   if(!empty($at['employee_id'])){ 
				    $atendance = AttendanceData::whereEmployee_id($at['employee_id'])->whereDate('attendance_date',$at['attendance_date'])->first(); 
                    
					if(empty($atendance)){
						$atendance = new AttendanceData(); 
						$atendance->attendance_date = $at['attendance_date'];
						$atendance->employee_id     = $at['employee_id'];
					}
					//print_r($atendance); 
					$atendance->late_login =  $at['latelogin'];
					$atendance->status     =  $at['status'];
					$atendance->save();

					if(!empty($at['remark'])){ 
					     AttendanceLog::create(['attendance_id'=> $at['attendance_id'], 'reason'=> $at['remark']]);
					   $emp_ids[$key] = substr($atendance->employee_id,3);
					}
				}
		    }
					//dd($atendance->employee_id);
            foreach ($emp_ids as $emp_id) {
				$user = \App\User::where('id','=',$emp_id)->first();
				/*-----------Mail ---------*/
				 $templateData['user1'] = \App\User::with('personal_profile','cb_profile')->where('id','=',$emp_id)->first();
				 $templateData['attendance'] = $atendance;
			
				$MailData = new \stdClass();
				$MailData->subject ='Attendance Update - '.\Auth::user()->first_name.' '.\Auth::user()->last_name;
				$MailData->sender_email = \Auth::user()->email;
				$MailData->sender_name = \Auth::user()->first_name.' '.\Auth::user()->last_name;
				$MailData->receiver_email = $user->email;
				$MailData->receiver_name = $user->first_name.' '.$user->last_name;
				 // print_r($templateData."".$MailData);
				MailController::sendMail('attendance_accepted',$templateData,$MailData);  
			}
			
	} 
	
	public function attendance(Request $request){
		if($request->month == ""){
			$m = date('m');
		}else{
			$m = $request->month;
		}
		if($request->year == ""){
			$y = date('Y');
		}else{
			$y = $request->year ;
		}
		if($request->type == ""){
			$type = "development";
		}else{
			if($request->type == "development"){
				$type = "development";
			}elseif($request->type == "sales"){
				$type = "sales";
			}else{
				$type = "development";
			}
		}		
		$employees =   DB::table('users')->join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')
										 ->select('users.first_name','users.last_name','employee_cb_profiles.employee_id')
										 ->whereIn('users.is_active',[1,4])
										 ->where('users.role','<>',1)
										 ->where('users.department',$type)->get();
		$data['current_year'] = date('Y');
		$data['search_year'] = $y;
		$data['emp_type'] = $type;
		$data['current_month'] = $m;
		$data['day_in_month'] = cal_days_in_month(CAL_GREGORIAN,$m,$y);
		$data['employees'] = $employees;
		$data['type'] = $type;
		$data['dayTypes'] = DB::table('dayType')->get();
		return view('admin.attendance.attendance',$data);
	}
	
	public function submitAttendance(Request $request){
		$attendance = $request->attendance;
		foreach ($attendance as $key => $value) {	
			$is_added = AttendanceData::where('attendance_date',$request->attendanceDate)->where('employee_id',$value['employee_id'])->first(); 
			if(!empty($is_added) == 1){
				$attendance_data = AttendanceData::find($is_added->id);	
			}else{
				$attendance_data = new AttendanceData();				
			}	
			$attendance_data->attendance_date = $request->attendanceDate;
			$attendance_data->status = $value['status'];
			$attendance_data->employee_id = $value['employee_id'];
			$attendance_data->save();	
		}
		return json_encode(['success'=>true]);
	}
	
	public function exportAttendanceExcel()
	{
		$holidayExcel = AttendanceData::all();
		\Excel::create('AttendanceExcel', function($excel) use($holidayExcel) {
			$excel->sheet('Sheet 1', function($sheet) use($holidayExcel) {
				$sheet->fromArray($holidayExcel);
			});
		})->export('xls');
	}
	
	public function importAttendanceExcel(Request $request){
		$response = array();
		if($request->hasFile('attendanceFile'))
		{
			$extension = \File::extension($request->file('attendanceFile')->getClientOriginalName());
			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
				\Excel::load($request->file('attendanceFile'), function($reader) {
					$reader->each(function ($sheet)
					{
						$attendance_data = AttendanceData::find($sheet->id);
						if(is_null($attendance_data)){
							$attendance_data = new AttendanceData();
						}				
						$attendance_data->attendance_date = $sheet->attendance_date;
						$attendance_data->status = $sheet->status;
						$attendance_data->employee_id = $sheet->employee_id;
						$attendance_data->save();	
					});
				});
				$response['flag'] = true;
				$response['message'] = "Uploaded Successfully.";
			}else {
				$response['flag'] = false;
				$response['error'] = 'Invalid file';
			}
			return response()->json($response);
		}
	}
	
	public function getcurentAttendance(Request $request){ 
		$current_date = $request->muydate;
	 	$emptype = $request->emptype;
		$attendanceDone = DB::table('users')->join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')
		->join('attendance_data','attendance_data.employee_id','=','employee_cb_profiles.employee_id')
		->select('users.first_name','users.last_name','employee_cb_profiles.employee_id','attendance_data.status','attendance_data.in_time','attendance_data.out_time')
		->where('users.department','=',$emptype)
		->where('users.role','<>',1)
		->where('users.is_active','=',1)
		->where('attendance_data.attendance_date',$current_date)->get();
		//print_r($attendanceDone);die();  
		$allemployees = DB::table('users')->join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')
		->select('users.first_name','users.last_name','employee_cb_profiles.employee_id')
		->where('users.department','=',$emptype)->where('users.role','<>',1)->where('users.is_active','=',1)->get();
		$allData = array();
		
		foreach ($allemployees as $key => $value) {
			$allData[$key]['first_name'] = $value->first_name;
			$allData[$key]['last_name'] = $value->last_name;
			$allData[$key]['employee_id'] = $value->employee_id;
			$isMatch = false;
			foreach ($attendanceDone as $key1 => $value1) {	
				if($value->employee_id == $value1->employee_id){
					$allData[$key]['status']  = $value1->status;
					$allData[$key]['intime']  = date('h:i:s A',strtotime($value1->in_time));
					$allData[$key]['outtime'] = date('h:i:s A',strtotime($value1->out_time));         
					$isMatch = true;
				}
			}
			if($isMatch == false){
				$allData[$key]['status'] = "no";
			}
		}
		$dayTypes = DB::table('dayType')->get();
		//print_r($allData);
		return json_encode(['success'=>true,'current_date'=>$current_date,'employees'=>$allData,'dayTypes'=>$dayTypes]);
	}


	public function viewAttendanceData(Request $request){
		
		if(date('m')!=1){
			$y = date('Y');
			$m = date('m')-1;
		}
		else{
			$y = date('Y')-1;
			$m=12;
		}
		

		$employees =   DB::table('users')->join('employee_cb_profiles','employee_cb_profiles.user_id','=','users.id')
										 ->select('users.id','users.first_name','users.last_name','employee_cb_profiles.employee_id')
										 ->where('users.is_active','=',1)
										 ->where('users.role','<>',1)->get();

		$type = "development";
		$data['current_year'] = date('Y');
		$data['search_year'] = $y;
		$data['emp_type'] = $type;
		$data['current_month'] = $m;
		$data['day_in_month'] = cal_days_in_month(CAL_GREGORIAN,$m,$y);
		$data['employees'] = $employees;
		$data['type'] = $type;
		$data['dayTypes'] = DB::table('dayType')->get();
		return view('common.viewAttendance',$data);
	}
	
}