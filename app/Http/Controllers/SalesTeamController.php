<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesEod;
use App\User;
use App\AttendanceData;
use App\Leave_tracking;
use App\Project_Assignation;
use App\Project;
use App\Loan;
use App\LeaveType;
use Session;

use Auth;

class SalesTeamController extends Controller{
      
    public function __construct(){
        $this->middleware('auth');  
    } 

    public function dashboard(){ 

       $emp_id = Auth::user()->id;

       $data['loan'] = Loan::where('emp_id',$emp_id)->first();

        return view('sales.dashboard',$data);   
     }

    public function projects_list(){
        $data['projects'] = [['id'=>1, 'name' => 'Demo Project']];   
        return view('sales.projects', $data);  
    } 

    public function holidayCalender(Request $request){
        if($request->year){
			$data['year'] = $request->year;
		}else{
			$data['year'] = date('Y');
		}
		if($request->category){
			$data['category'] = $request->category;
		}else{
			$data['category'] = \Auth::user()->department;
		}
        return view('sales.holidays.calender', $data);  
    } 

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

        // print_r($userid);die();
        return view('sales.profile',$data);  
    }

    public function viewAttendance(){

        return view('sales.holidays.view_attendance');
}

public function calender(Request $request){

        
        
        $data['attendance'] = AttendanceData::with(['log' => function($q) {
                                $q->orderBy('id','DESC');
                            }])->where('employee_id','CB0'.Auth::user()->id)
                            ->whereMonth('attendance_date',$request->month)
                            ->whereYear('attendance_date',$request->year)
                            ->paginate(5);

            

        $data['presents'] = AttendanceData::where('employee_id','CB0'.Auth::user()->id)
                            ->whereMonth('attendance_date',$request->month)
                            ->whereYear('attendance_date',$request->year)
                            ->where('status','P')
                            ->count();

        $data['absents'] = AttendanceData::where('employee_id','CB0'.Auth::user()->id)
                            ->whereMonth('attendance_date',$request->month)
                            ->whereYear('attendance_date',$request->year)
                            ->where('status','AB')
                            ->count();

        $data['latelogin'] = AttendanceData::where('employee_id','CB0'.Auth::user()->id)
                            ->whereMonth('attendance_date',$request->month)
                            ->whereYear('attendance_date',$request->year)
                            ->where('late_login','1')
                            ->count();

        // $data['reasonlog'] = AttendanceData::with('log')
        //                  ->where('employee_id','CB0'.Auth::user()->id)
        //                  ->first();

                        

        return view('sales.holidays.calenderdata', $data);
    }

    public function getSeeTeamEOD(){

        
       //$project_id = Project_Assignation::whereEmployee_id(Auth::user()->id) ->whereEmp_role(1)->pluck('project_id'); 

        //$data['projects'] = [['id'=>1, 'name' => 'Demo Project']];   

        $data['eods_filter'] = ['id'=>1, 'name' => 'Demo Project'];

        $data['eods'] = SalesEod::where('user_id','!=',Auth::user()->id)->get(); 


        return view('sales.team_eod', $data);

    }

    public function leave_list(Request $request){ 
        
          $leaves = Leave_tracking::whereUser_id(Auth::user()->id);
         if(!empty($request->leave_type)){
           $data['l_type'] = $request->leave_type; 
           $leaves = $leaves->whereStatus($request->leave_type); 
         } 

    $data['leaves'] = User::join('leave_trackings', 'leave_trackings.user_id', '=', 'users.id')
                    ->where('user_id','!=', Auth::user()->id)
                    ->where('department','sales')
                    ->get();
      
        return View('sales.leaves.leave_list',$data);     
   }

    public function eod_details(Request $request){ 
      $eod = SalesEod::whereId($request->id)->first();      
      $html = ""; 
      $html.="<p> <b> Employee : </b>".$eod->user->first_name." ".$eod->user->last_name."</p>";   
      $html.="<p> <b> EOD Date : </b> ".date('d M-Y', strtotime($eod->eod_date))."</p>";
       $html.="<p> <b> Task 1  : </b> $eod->task_1 </p>"; 
      $html.="<p> <b> Task 2  : </b> $eod->task_2 </p>"; 
      $html.="<p> <b> Task 3  : </b> $eod->task_3 </p>"; 
      $html.="<p> <b> Task 4   : </b> $eod->task_4 </p>";  
       $html.="<p> <b> Comments   : </b> $eod->comment </p>";  
      return $html;
    }

    public function deleteSALES_EOD(Request $request){
        
        $eod = SalesEod::where('id',$request->id)->delete();
    
        return redirect()->back()->with('success',"EOD delete Successfully.");; 
    }

    public function apply_leave(){ 
        $leave_types = LeaveType::orderBy('leave_type','ASC')->get(); 
        $data['leave_types'] = $leave_types;
        return view('sales.leaves.apply_leave',$data);   
    }

     public function my_leaves(Request $request){ 
         $leaves = Leave_tracking::whereUser_id(Auth::user()->id);
         if(!empty($request->leave_type)){
           $data['l_type'] = $request->leave_type; 
           $leaves = $leaves->whereStatus($request->leave_type); 
         }  
         //$leaves = $leaves->where('status','!=', 4)->orderBy('id','desc')->get(); 
         $leaves = $leaves->orderBy('id','desc')->get();  
         $data['leaves'] = $leaves;
         $data['taken'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(1)->count('id');
         $data['rejected'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(2)->count('id'); 
         return View('sales.leaves.index',$data); 
    }

    public function leave_mng(Request $request){
         $leaves = Leave_tracking::whereUser_id(Auth::user()->id);
         if(!empty($request->leave_type)){
           $data['l_type'] = $request->leave_type; 
           $leaves = $leaves->whereStatus($request->leave_type); 
         } 
        // $leaves = $leaves->where('status','!=', 4)->orderBy('id','desc')->get();
         $leaves = $leaves->orderBy('id','desc')->get();
         $data['leaves'] = $leaves;
         $data['taken'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(1)->sum('days');
         $data['rejected'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(2)->sum('days'); 
         return View('sales.leaves.index',$data);   
  }

  public function changeleavestatus(Request $request){
        $leave = Leave_tracking::whereId($request->leave)->first();
       // print_r($request->all()); 
        if(Auth::user()->role==1 || Auth::user()->role==2){

            $emp = EmployeeCbProfile::whereUser_id($leave->user_id)->first();
            if($emp->avail_leaves > 0){
              $emp->avail_leaves = ( $emp->avail_leaves-1 );
              $emp->save();
            }  
            $leave->status = $request->action;  


        }else{
            if(empty($leave->tl1)){
                $leave->tl1 = Auth::user()->first_name;
                $leave->tl1_response =  $request->action;
                $leave->tl1_reason   = $request->comment;
            }elseif(empty($leave->tl2) && $leave->tl1!=Auth::user()->first_name){
                $leave->tl2 = Auth::user()->first_name;
                $leave->tl2_response =  $request->action;
                $leave->tl2_reason   = $request->comment;
            }elseif($leave->tl1!=Auth::user()->first_name && $leave->tl2!=Auth::user()->first_name){
                $leave->tl3 = Auth::user()->first_name;
                $leave->tl3_response =  $request->action;
                $leave->tl3_reason   = $request->comment;
            }
        }
        $leave->save();
        Session::flash('success','Leave status update Successfully.'); 

        /*-----------------------------------Send notification-------------------------------------------*/  
        $receiver = [$leave->user_id];
        $action = $request->action==1 ? "Accepted" : "Rejected"; 
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."$action your leave request.";
        $message = "<p> $title </p><br>";  
        NotificationController::notify(Auth::user()->id,$receiver,$title,$message); 
      /*-----------------------------------Send notification-------------------------------------------*/ 
   }

   public function view_notification(){

        $id= \Auth::user()->id;

        $all_notification = \App\Notification::where('receiver_id','=',$id)->orderBy('id', 'desc')->paginate(15);

        return view('sales.notification',['all_notifications'=>$all_notification]);

        

    }
    public function getProfileEdit()
    {
        $data = array();
        $data['employee'] = \App\User::where('id',\Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();
        return view('sales.edit',$data);
    }
    public function postProfileEdit(Request $request)
    {
        $user_array['first_name'] = $request->first_name;
        $user_array['last_name'] = $request->last_name;
        $user_array['address'] = $request->address;
        $user_array['phone_number'] = $request->phone_number;
        $user_array['bank_account'] = $request->account_no;
        $user_array['martial_status'] = $request->martial_status;
        $user_array['dob'] = $request->dob;
        $user_array['anniversary_date'] = $request->anniversary_date;
        $user_array['personal_email'] = $request->personal_email;
        $user_array['father_name'] = $request->father_name;
        $user_array['mother_name'] = $request->mother_name;
        $user_array['parent_contact_number'] = $request->parent_number;

        //check user profile edit or not
            $data = \App\User::where('id',\Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();
        
            $data_array['first_name'] = $data->first_name;
            $data_array['last_name'] = $data->last_name;
            $data_array['address'] = $data->personal_profile->address;
            $data_array['phone_number'] = $data->personal_profile->phone_number;
            $data_array['bank_account'] = $data->personal_profile->bank_account;
            $data_array['martial_status'] = $data->personal_profile->martial_status;
            $data_array['dob'] = $data->personal_profile->dob;
            $data_array['anniversary_date'] = $data->personal_profile->anniversary_date;
            $data_array['personal_email'] = $data->personal_profile->personal_email;
            $data_array['father_name'] = $data->personal_profile->father_name;
            $data_array['mother_name'] = $data->personal_profile->mother_name;
            $data_array['parent_contact_number'] = $data->personal_profile->parent_contact_number;
            $result= array_diff($user_array, $data_array);
            if(count($result)==0){
                return redirect()->back()->with('error','You have made no changes in your profile.');
            }
        //end profile checker
        $user = \App\User::where('id',\Auth::user()->id)->first();
        $user->request_json = json_encode($user_array);
        $user->is_request_approved = 0;
        $url = url('role/request/profile/'.$user->id);        
        if($user->save()){
            /*-----------------------------------Send notification-------------------------------------------*/
            $receiver = array();
            $title = $user->first_name." ".$user->last_name." "."Requested For profile update.";
            $message = "<p>".$user->first_name." ".$user->last_name." "."Requested For profile update."."</p>"."<br>";
            $message.= "<a href='".$url."' class='btn btn-primary'>View</a>";
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
            return redirect()->back()->with('success','Request Sent Successfully.Waiting approval from admin.'); 
        }
    }

    public function notification(Request $request){

    $response = array();
    $notification = \App\Notification::find( $request->id);
   // dd($request->id);
     if(is_null($notification)){
          $response['flag'] = false;

       }else{
      
      $notification->is_read = 1;
      $notification->save();
      $response['flag'] = true;
      $response['notification'] = $notification; 
    }
    return response()->json($response);
  }

   
} 
