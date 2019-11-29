<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\AttendanceData;
use App\EmployeeCbProfile;
use App\EmployeeExtraDetail;
use App\Leave_tracking;
use App\Resignation;
use DB;  

class ProfileController extends Controller{

	public function getRole(){
		if(Auth::check()){
			if(Auth::user()->role == 1){
				return "admin";
			}
			if(Auth::user()->role == 2){
				return "hrManager";
			}
			if(Auth::user()->role == 3){
				return "hrExecutive";
			}
			if(Auth::user()->role == 4){
				return "employee";
			}
			if(Auth::user()->role == 5){
				return "itExecutive";
			}

			if(Auth::user()->role == 6 || Auth::user()->role == 7 ){
				return "employee";
			}
		}
	}



	/*public function profile(){

         $current_date = date('Y-m-d');

         $last_date = date('Y-m-t');

		$profile = \App\User::where('id',Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();

		$data['employee'] = $profile;
		$userid = Auth::user()->id;
	    $employeeid = \App\EmployeeCbProfile::select('employee_id')->where('user_id','=',$userid)->first();
	    $data['halfdays'] = \App\AttendanceData::where('employee_id','=',$employeeid["employee_id"])->where('attendance_date','>=',$current_date)->where('attendance_date','<=',$last_date)->where('status','HD')->count();
    
     //   if($data['halfdays'] == 2 || $data['halfdays'] == 4)
	    // {
	    // 	$cbprofile = \App\EmployeeCbProfile::where('user_id',Auth::user()->id)->first();
     //        $update_avail_leaves = $cbprofile->avail_leaves-1;
     //        \App\EmployeeCbProfile::where('user_id',Auth::user()->id)->update(['avail_leaves'=>$update_avail_leaves]);
	    // }
	    // else
	    //   {
            
	    //   }

	  $data['ui'] = \App\AttendanceData::where('employee_id','=',$employeeid["employee_id"])->where('status','UI')->count();
	  $data['employee_extra_details'] = \App\EmployeeExtraDetail::where('user_id',$userid)->get();
		return view($this->getRole().'.profile',$data);
	}

	public function profile(){
		 $current_date = date('Y-m-d');
         $last_date    = date('Y-m-t');
         $data['employee'] = User::whereId(Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();
         $employeeid = EmployeeCbProfile::select('employee_id')->whereUser_id(Auth::user()->id)->first();
         $data['halfdays'] = AttendanceData::where('employee_id','=',$employeeid["employee_id"])->where('attendance_date','>=',$current_date)->where('attendance_date','<=',$last_date)->where('status','HD')->count();

         $data['ui'] = AttendanceData::where('employee_id','=',$employeeid["employee_id"])->where('status','UI')->count();
	     $data['employee_extra_details'] = EmployeeExtraDetail::whereUser_id(Auth::user()->id)->get(); 
         return view($this->getRole().'.profile',$data);
	}*/
	
	public function profile(){
		$start = date('Y-m-d', strtotime(date('Y').'-01-01'));
		$end   = date('Y-m-d', strtotime(date('Y').'-12-31'));  
        $profile = User::where('id',Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();
		$data['employee'] = $profile; 
		$userid           = Auth::user()->id;
        $employeeid = \App\EmployeeCbProfile::select('employee_id')->where('user_id','=',$userid)->first();
	    $data['employee_extra_details'] = \App\EmployeeExtraDetail::where('user_id',$userid)->get();
		$data['pending']  =   Leave_tracking::where('user_id', Auth::user()->id)
											->whereDate('date_from','>=',$start)->whereDate('date_from','<=',$end)
											->where('status',3)->count('id'); 
        $data['rejected'] = Leave_tracking::where('user_id', Auth::user()->id)->whereDate('date_from','>=',$start)->whereDate('date_from','<=',$end)->where('status',2)->count('id'); 
        $data['approved'] = Leave_tracking::where('user_id', Auth::user()->id)->whereDate('date_from','>=',$start)->whereDate('date_from','<=',$end)->where('status',1)->count('id'); 
		$data['ui']       = AttendanceData::where('employee_id',$employeeid["employee_id"])->whereDate('attendance_date','>=',$start)->whereDate('attendance_date','<=',$end)->where('status','UI')->count('id');
		$data['hd']       = AttendanceData::where('employee_id',$employeeid["employee_id"])->whereDate('attendance_date','>=',$start)->whereDate('attendance_date','<=',$end)->where('status','HD')->count('id');
		// $data['ab']       = AttendanceData::where('employee_id',$employeeid["employee_id"])->whereDate('attendance_date','>=',$start)->whereDate('attendance_date','<=',$end)->where('status','AB')->count('id'); 
        //$data['rejected '] = Leave_tracking::where('status',3)->count('id'); 
        $data['ab'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(1)->sum('days');
        $data['resignation'] = Resignation::where('user_id',\Auth::user()->id)->where('is_active','!=',4)->first();
        //print_r( $data['resignation']);die();
        
        
		return view('common.profile',$data); 
		
	}

	public function postChangePassword(Request $request)
	{
		$response = array();
		$user = \App\User::find(\Auth::user()->id);
		$old_password = $request->old_password;
		$new_password = $request->new_password;

		if(\Hash::check($old_password, $user->getAuthPassword())){
			$user->password = \Hash::make($new_password);
			if($user->save()){
				$response['flag'] = true;
				/*-----------------------------------Send notification-------------------------------------------*/
				$receiver = array();
				$title = $user->first_name." ".$user->last_name." "."Changed Password";
				$message = $user->first_name." ".$user->last_name." "."Changed Password";
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

				DB::table('password_change_log')->insert([
										                  'user_id'=> $user->id,
										                  'ip_address'=> $_SERVER['REMOTE_ADDR'],
										                  'browser'=> $this->getBrowser(),  
										                  ]);
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went Wrong!";
			}
		}
		else{
			$response['flag'] = false;
			$response['error'] = "Invalid Old Password";
		}
		return response()->json($response);
	}





	public function updateProfilePic(Request $request)



	{



		$response = array();



		$validator = \Validator::make($request->all(),



			array(



				'profilePic' =>'image',



			)



		);



		if($validator->fails())



		{



			$response['flag'] = false;



			$response['error'] = "Please Upload valid Image";



		}



		else



		{



			$user = \Auth::user();



			if($request->file('profilePic') != ""){



				$employee_cb_profile =  \App\EmployeeCbProfile::where('user_id',$user->id)->first();



				$image = $request->file('profilePic');



				$filename = time().'.'.$image->getClientOriginalExtension();



				$destinationPath = public_path('/images/employees');



				$image->move($destinationPath, $filename);



				$employee_cb_profile->employee_pic = url('/').'/images/employees/'.$filename;



				$employee_cb_profile->save();



				$response['flag'] = true;



			} 



		}



		return response()->json($response);



	}



}



