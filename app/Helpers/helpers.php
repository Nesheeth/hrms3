<?php 


function getSalesRole(){
    $role = Auth::user()->role;
    switch ($role) {
         case '2':
            return 'Manager';
            break;
         case '4':
            return 'teamLead';
            break;
         case '6':
            return 'salesAnalyst';
            break;
         default:
            return 'salesAnalyst';
            break;
    }
}


function getRoleStr(){
    $role = Auth::user()->role;
   switch ($role) {
        case '1':
           return 'admin';
           break;
        case '2':
           return 'hrManager';
           break;
        case '4':
           return 'teamLead';
           break;
        case '5':
           return 'itExecutive';
           break;
        case '6':
           return 'employee';
           break;
        case '7':
           return 'businessAnalyst';
           break;
		case '8':
           return 'accountent';
           break;
        default:
           return 'employee';
           break;
   }
}


function getRole($role){
    $role = \App\Role::find($role); 
    return strtolower($role->role);
}
function getRoleId($user_id){
    if($user_id != null){
       $user = \App\User::find($user_id);
    return $user->role;

    }else{
       $user = \App\User::find(1);
    return $user->role;

    }
   
}

function getAttendanceBydate($mydate,$employee_id){
    $attendance = \App\AttendanceData::where('attendance_date',$mydate)->where('employee_id',$employee_id)->first(); 
    if(!empty($attendance)){
        return $attendance->status;   
    }else{
        return false;   
    }   
}


function get_setting_value($key_name){
    $is_key = \DB::table('hrms_global_settings')->where('key_name',$key_name)->count();
    if($is_key == 1){ 
        $data = \DB::table('hrms_global_settings')->where('key_name',$key_name)->first();
        return  $data->value;
    }else{
        return '';
    }
    
}











function getRoleById($role_id){
    $role = \App\Role::find($role_id);
    $role_name = $role->role;
    return $role_name;
}



function getEmpStatusById($id){

    $employee_status = \DB::table('employee_status')->where('id',$id)->first();


    $employee_status_name = $employee_status->status_name;


    return $employee_status_name;

	

}

function getEmpId($id){

$employee_cb_id = \DB::table('employee_cb_profiles')->where('user_id',$id)->first();

          $employee_id       = $employee_cb_id->employee_id;

          return $employee_id;

}



function getUserById($user_id){



    $user = \App\User::find($user_id);



    return $user;



}



function getSystemById($system_id){



    $system = \App\System::find($system_id);



    return $system;



}



function getAssetById($asset_id,$asset_type_id){

     if($asset_type_id == '1'){

    $asset = \App\Monitor::find($asset_id);



    return $asset;

}

    if($asset_type_id == '2'){

    $asset = \App\Keyboard::find($asset_id);



    return $asset;

}

    if($asset_type_id == '3'){

    $asset = \App\Mouse::find($asset_id);



    return $asset;

}

    if($asset_type_id == '4'){

    $asset = \App\Cabinet::find($asset_id);



    return $asset;

}

    if($asset_type_id == '5'){

    $asset = \App\Motherboard::find($asset_id);



    return $asset;

}

    if($asset_type_id == '6'){

    $asset = \App\Ram::find($asset_id);



    return $asset;

}

    if($asset_type_id == '7'){

    $asset = \App\Processer::find($asset_id);



    return $asset;

}

    if($asset_type_id == '8'){

    $asset = \App\UpsBattery::find($asset_id);



    return $asset;

}

    if($asset_type_id == '9'){

    $asset = \App\Smps::find($asset_id);



    return $asset;

}

    if($asset_type_id == '10'){

    $asset = \App\Hdd::find($asset_id);



    return $asset;

}



    if($asset_type_id == '11'){

    $asset = \App\Desktop::find($asset_id);



    return $asset;

}

 if($asset_type_id == '12'){

    $asset = \App\Laptop::find($asset_id);



    return $asset;

}

 if($asset_type_id == '13'){

    $asset = \App\MacMini::find($asset_id);



    return $asset;

}

 if($asset_type_id == '14'){

    $asset = \App\IMac::find($asset_id);



    return $asset;

}

 if($asset_type_id == '15'){

    $asset = \App\NetworkSwitch::find($asset_id);



    return $asset;

}

 if($asset_type_id == '16'){

    $asset = \App\Router::find($asset_id);



    return $asset;

}

 if($asset_type_id == '17'){

    $asset = \App\Repeater::find($asset_id);



    return $asset;

}

 if($asset_type_id == '18'){

    $asset = \App\Ups::find($asset_id);



    return $asset;

}

 if($asset_type_id == '19'){

    $asset = \App\PenDrive::find($asset_id);



    return $asset;

}

 if($asset_type_id == '20'){

    $asset = \App\Dvr::find($asset_id);



    return $asset;

}

 if($asset_type_id == '21'){

    $asset = \App\Camera::find($asset_id);



    return $asset;

}

 if($asset_type_id == '22'){

    $asset = \App\WebCam::find($asset_id);



    return $asset;

}

 if($asset_type_id == '23'){

    $asset = \App\Printer::find($asset_id);



    return $asset;

}

 if($asset_type_id == '24'){

    $asset = \App\Chair::find($asset_id);



    return $asset;

}

 if($asset_type_id == '25'){

    $asset = \App\Desk::find($asset_id);



    return $asset;

}

 if($asset_type_id == '26'){

    $asset = \App\Fan::find($asset_id);



    return $asset;

}

 if($asset_type_id == '27'){

    $asset = \App\AC::find($asset_id);



    return $asset;

}

 if($asset_type_id == '28'){

    $asset = \App\Almirah::find($asset_id);



    return $asset;

}

 if($asset_type_id == '29'){

    $asset = \App\Headphone::find($asset_id);



    return $asset;

}

 



}

function getAssetMonitorById($asset_id){



    $asset = \App\Monitor::find($asset_id);



    return $asset;



}



function getProjectById($user_id){



    $project = \App\Project::find($user_id);



    return $project;



}



function getProject($id){



    $project = \App\Project::find($id);



    // if(is_null($project)){



    //     $project = new \stdClass();



    //     $project->name = "N/A";



    // }



    return $project;



}



function getUnreadNotificationsById($receiver_id){



    $notifications = \App\Notification::where('receiver_id',$receiver_id)->where('is_read',0)->orderBy('id','DESC')->get();



    return count($notifications);



}



function getNotificationsById($receiver_id){



    $notifications = \App\Notification::where('receiver_id',$receiver_id)->where('is_read',0)->orderBy('id','DESC')->get();

    // print_r( $notifications);



    return $notifications;



}



function calculateTimeSpan($date){



    $seconds  = strtotime(date('Y-m-d H:i:s')) - strtotime($date);







    $months = floor($seconds / (3600*24*30));



    $day = floor($seconds / (3600*24));



    $hours = floor($seconds / 3600);



    $mins = floor(($seconds - ($hours*3600)) / 60);



    $secs = floor($seconds % 60);







    if($seconds < 60){



        $time = $secs." sec ago";



    }



    else if($seconds < 60*60 ){



        $time = $mins." min ago";
    }
    else if($seconds < 24*60*60){
        $time = $hours." hrs ago";
    }
    else if($seconds < 24*60*60*30){
        $time = $day." day ago";
    }
    else{
        $time = $months." month ago";
    }
    return $time;
}


function isHoliday($date,$category){

    $holiday = \App\Holiday::whereDate('date', date('Y-m-d', strtotime($date)))->orwhere('date', date('m/d/Y', strtotime($date)))->where('category', $category)->first();  

    if(empty($holiday)){
        return false;
    }else{
        return $holiday;
    }

}

function holidayComment($date,$category){

    $holiday = \App\Holiday::whereDate('date', date('Y-m-d', strtotime($date)))->orwhere('date', date('m/d/Y', strtotime($date)))->where('category', $category)->first();  
    if(empty($holiday)){
        return false;
    }else{
        return $holiday;
    }   
}

function getLeaves($user_id,$is_approved){
    $leaves = \App\Leaves::where('user_id',$user_id)->where('is_approved',$is_approved)->get();
    return $leaves;
} 



function setActive($path)



{



    return Request::is($path) ? 'open' : '1';



}

function calculateteammem($team_leader_id)

{

     $counemp = DB::table('team_members')->select('team_member_id') ->where('team_leader_id','=', $team_leader_id)->count();

     return $counemp;

}

function getAssetDescriptionsById($asset_id){



    $assetname = array();

  foreach($asset_id as $asset_ids){



    $asset = \App\Asset::where('id',$asset_ids)->value('descriptions');

  

       array_push($assetname, $asset);

    }

   

    $aa = implode(',', $assetname);

    return   $aa ;

}

function getSystemAssetById($system_id){

    $system = DB::table('system_assets')->where('system_id','=', $system_id)->get()->pluck('asset_id');

   

   $system = $system->toArray();

   

    return $system;

}

function getAssoc_name($id){

     $assoc_name = DB::table('asset_types')->where('id','=',$id)->first();

       return $assoc_name->type;

}
function getEmpName($id){
    $user = \App\User::where('id',$id)->first();
    return $user->first_name;
}



 function calculate_attendance($id,$start,$end){  
            
            $id = "CB0".$id;
            $attendance =  \App\AttendanceData::whereEmployee_id($id)
                            ->whereDate('attendance_date','>=', $start) 
                            ->whereDate('attendance_date','<=', $end) 
                            ->orderBy('attendance_date','ASC')
                            ->get(['attendance_date','status','late_login']); 
				//	print_r($attendance);		
			if($attendance->isEmpty()){
			  	$data['present']          = 0;
				$data['leaves']           = 0;
				$data['half_day']         = 0;
				$data['ui']               = 0;
				$data['sandwich_leave']   = 0;
				$data['late_login']       = 0; 
				return $data;
			} 
			
                $attendance  = $attendance->toArray(); 
                $startdate   = strtotime($start); 
                $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
                $currentdate = $startdate;
                $p = $ab = $ui = $hd = $sw = $ll = 0; 
                $sw_status = false;
                $holydays = ['Sun','Sat'];
                $Month = date('m',strtotime($start));
                $enddateCur = strtotime(date('Y-m-d'));
                if(date('m',strtotime($start)) == date('m') && date('Y',strtotime($start)) == date('Y')){
                     while ($currentdate <= $enddateCur){
                    $day = date('D', $currentdate);
                    $date = date('Y-m-d', $currentdate);
                    if(in_array($day, $holydays)){ 
                        ++$p;
                    }else{ 
                        $found_key = array_search(date('Y-m-d', $currentdate), array_column($attendance, 'attendance_date'));
                        if(!empty($found_key) || $found_key===0){ 
                            $status = $attendance[$found_key]['status'];
                            $late_login = $attendance[$found_key]['late_login'];
                            
                            if($day=="Fri" &&  ($status=="AB" || $status=="UI"))
                            $sw_status =true; 
                            switch($status){
                                case 'P': 
                                    ++$p;
                                    $ll = ($late_login==1) ? ++$ll : $ll;
                                break;
                                case 'AB':
                                    ++$ab;
                                break;
                                case 'UI':
                                    ++$ui;
                                break;
                                case 'HD':
                                    ++$hd;
                                    $p = ($p + 0.5); 
                                break;
                            }
                            if($day=="Mon" && ($sw_status==true) &&  ($status=="AB" || $status=="UI")){
                                ++$sw; 
                                $sw_status =false;  
                                $p  = $p-2;
                                $ab = $ab+2; 
                            }
                        }else{
                            $check_holyday =  \App\Holiday::whereDate('date',$date)->first(); 
                            if(!empty($check_holyday))
                                ++$p;  
                        }
                    }
                   $currentdate = strtotime('+1 day', $currentdate);
                } 
                }else{


                while ($currentdate <= $enddate){
                    $day = date('D', $currentdate);
                    $date = date('Y-m-d', $currentdate);
                    if(in_array($day, $holydays)){ 
                        ++$p;
                    }else{ 
                        $found_key = array_search(date('Y-m-d', $currentdate), array_column($attendance, 'attendance_date'));
                        if(!empty($found_key) || $found_key===0){ 
                            $status = $attendance[$found_key]['status'];
                            $late_login = $attendance[$found_key]['late_login'];
                            
                            if($day=="Fri" &&  ($status=="AB" || $status=="UI"))
                            $sw_status =true; 
                            switch($status){
                                case 'P': 
                                    ++$p;
                                    $ll = ($late_login==1) ? ++$ll : $ll;
                                break;
                                case 'AB':
                                    ++$ab;
                                break;
                                case 'UI':
                                    ++$ui;
                                break;
                                case 'HD':
                                    ++$hd;
                                    $p = ($p + 0.5); 
                                break;
                            }
                            if($day=="Mon" && ($sw_status==true) &&  ($status=="AB" || $status=="UI")){
                                ++$sw; 
                                $sw_status =false;  
                                $p  = $p-2;
                                $ab = $ab+2; 
                            }
                        }else{
                            $check_holyday =  \App\Holiday::whereDate('date',$date)->first(); 
                            if(!empty($check_holyday))
                                ++$p;  
                        }
                    }
                   $currentdate = strtotime('+1 day', $currentdate);
                } 
               } 
             //echo "<br>  $id  P => $p  HD => $hd AB => $ab  UI => $ui  ";
            $data['present']          = $p;
            $data['leaves']           = $ab;
            $data['half_day']         = $hd;
            $data['ui']               = $ui;
            $data['sandwich_leave']   = $sw;
            $data['late_login']       = $ll;
            //print_r($data);
            return $data;  
    } 

    function getEmiStatus($user_id,$emi_amount){
        $loan = \App\Loan::where('emp_id',$user_id)->where('status',1)->first();
        $emi = \App\EMI::where('emp_id',$user_id)->where('loan_id',$loan->id)->where('status',0)->sum('emi_amount');

        $deffrence = $loan->amount - $emi;
        if($emi_amount >= $deffrence){
            $loan_status = \App\Loan::find($loan->id);
            $loan_status->status = 3;//3 = loan completed; 0=requested ; 1= approved ; 2=rejected;
            $loan_status->save();
            return 1;//emi completed

        }else{
            return 0;//emi pending
        }

    }


    function getEmiAmount($user_id,$emi_amount){
        $loan = \App\Loan::where('emp_id',$user_id)->where('status',1)->first();
        $emi = \App\EMI::where('emp_id',$user_id)->where('loan_id',$loan->id)->where('status',0)->sum('emi_amount');

        $deffrence = $loan->amount - $emi;
        if($emi_amount >= $deffrence){
            return $deffrence;
        }else{
            return $emi_amount;
        }

    }

    function total_deduction($salary){
        $salary_deduction = \App\Salary_deduction::where('salary_id',$salary->id)->get();
        
        $deduction = 0;
        if($salary_deduction!=null){
            foreach ($salary_deduction as $key => $deductions) {
                if($deductions->type==10){
                    $deduction = $deduction+$deductions->amount;
                }if($deductions->type==8){
                    $deduction = $deduction+$deductions->amount;
                }if($deductions->type==4){
                    $deduction = $deduction+$deductions->amount;
                }if($deductions->type==6){
                    $deduction = $deduction+$deductions->amount;
                }
                if($deductions->type==1){
                    $deduction = $deduction+$deductions->amount;
                }if($deductions->type==2){
                    $deduction = $deduction+$deductions->amount;
                }if($deductions->type==3){
                    $deduction = $deduction+$deductions->amount;
                }if($deductions->type==9){
                    $deduction = $deduction+$deductions->amount;
                }
            }
           
        }
        return $deduction;
    }  

    function loan_emi($salary_id){
        $salary_deduction = \App\Salary_deduction::where('salary_id',$salary_id)->get();
        $loan_emi=0;
        foreach ($salary_deduction as $key => $deduction) {
            if($deduction->type==10){
                $loan_emi = $deduction->amount;
            }
        }

        return $loan_emi;
    }

    function other_dedtuction($salary_id){
        $salary_deduction = \App\Salary_deduction::where('salary_id',$salary_id)->get();
        $other_dedtuction=0;
        foreach ($salary_deduction as $key => $deduction) {
            if($deduction->type==1){
                $other_dedtuction = $other_dedtuction+$deduction->amount;
            }if($deduction->type==2){
                $other_dedtuction = $other_dedtuction+$deduction->amount;
            }if($deduction->type==3){
                $other_dedtuction = $other_dedtuction+$deduction->amount;
            }if($deduction->type==9){
                $other_dedtuction = $other_dedtuction+$deduction->amount;
            }/*if($deduction->type==5){
                $other_dedtuction = $other_dedtuction+$deduction->amount;
            }if($deduction->type==7){
                $other_dedtuction = $other_dedtuction+$deduction->amount;
            }*/
        }

        return $other_dedtuction;
    }

    function dateDiff($date1, $date2) 
    {
        // Calulating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1); 
        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return ($diff/ 86400); 
    }


    function getTotalExperience($user_id){
        $user_experience = App\EmployeePreviousExperience::where('user_id',$user_id)->first();
        if($user_experience!=null){
           
            return $user_experience->total_experience;
        }else{
            return 0;
        }

    }

    function getUANNumber($user_id){
        $user_experience = App\EmployeePreviousExperience::where('user_id',$user_id)->first();
        if($user_experience!=null){
            return $user_experience->uan_number;
        }else{
            return ;
        }

    }

     function getESINumber($user_id){
        $user_experience = App\EmployeePreviousExperience::where('user_id',$user_id)->first();
        if($user_experience!=null){
            return $user_experience->esi_number;
        }else{
            return ;
        }

    }
    function getProjectReview($project_id,$user_id,$month,$year){
         if($month != '' || $month != null ){
                //echo $month;
               $inputs['month'] = $month;
               $inputs['year'] = $year; 
            }else{
               $inputs['month'] = date('m');
               $inputs['year'] = date('Y');
            }
            //echo $project_id.'-'.$user_id.'-'.$month.'-'.$year;
        
        $fromDate =$inputs['year'].'-'.$inputs['month'].'-'.'1';
        $toDate  = date('Y-m-t',strtotime($fromDate));
        $range = [$fromDate, $toDate];
        if(Auth::user()->role == 6){
           
        $project_review = \App\ProjectReview::where('project_id',$project_id)->where('user_id',$user_id)->whereBetween('emp_update_month', $range)->first();
        return $project_review;
        }
        if(Auth::user()->role == 4 ){
        $project_review = \App\ProjectReview::where('project_id',$project_id)->where('user_id',$user_id)->whereBetween('emp_update_month', $range)->first();
        return $project_review;
        }
         if(Auth::user()->role == 1){
        $project_review = \App\ProjectReview::where('project_id',$project_id)->where('user_id',$user_id)->whereBetween('emp_update_month', $range)->first();
        //print_r($project_review);
        if(!is_null($project_review)){
            //echo 'if';
            return $project_review;
        }else{
           // echo 'else';
            return false;
        }
        
        }

    }
      function getProjectReviewtl($project_id,$user_id,$month,$year){
        //if(Auth::user()->role == 6){
            if($month != '' || $month != null ){
                //echo $month;
               $inputs['month'] = $month;
               $inputs['year'] = $year; 
            }else{
               $inputs['month'] = date('m');
               $inputs['year'] = date('Y');
            }
            //echo $project_id.'-'.$user_id.'-'.$month.'-'.$year;
        
        $fromDate = $inputs['year'].'-'.$inputs['month'].'-'.'1';
        $toDate   = date('Y-m-t',strtotime($fromDate));
        $range    = [$fromDate, $toDate];
        $project_review = \App\ProjectReview::where('project_id',$project_id)->where('user_id',$user_id)->whereBetween('emp_update_month', $range)->first();
       // print_r($project_review);
        return $project_review;
        }

?>