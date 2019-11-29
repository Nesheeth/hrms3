<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Salary;
use App\Salary_deduction;
use App\Salary_earning;
use App\Salary_log;
use App\AttendanceData;
use App\Holiday;
use App\EmployeeCbProfile;
use App\Setting;
use DB;
use App\Notification;
use Auth;
use App\PayRoll;

class SalaryManageController extends Controller
{
   
    public function calculate_salary(Request $request){

        $c_salary;
     
        $setting  = new Setting;
        if(date('m'==01)){ 
            $year = date('Y') - 1;
            $month = 12;
         }else{
             $year = date('Y');
             $month = date('m') -1; 
         }
        $startdate   = strtotime($year . '-' . $month . '-01');
        $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
        $working_day = intval((date('t',$startdate)),10);  
        $employees = User::with('cb_profile')->whereIs_active(1)->where('role','!=',1)->orWhere('is_active',4)->get(); 
       
        foreach($employees as $employee){

          
            $cb_profile = EmployeeCbProfile::whereUser_id($employee->id)->first(['joining_date','salary','stay_bonus','tds','designation','esi','epf']); 

            $join_date = strtotime($cb_profile->joining_date); 
            $astartdate = ($join_date > $startdate) ? $join_date  : $startdate;
            $emp_attendance = $this->calculate_attendance($employee->id, date('Y-m-d', $astartdate), date('Y-m-d', $enddate));   
            
            $calculated_salary = (($cb_profile->salary/$working_day) * $emp_attendance['present']);

            
            $extra_earnings_of_month = 0;
            $extra_deduction_of_month = 0;

            if($request->action=="re_calculate"){
                $salary_data = Salary::whereUser_id($employee->id) 
                ->whereSalary_month(date('m', $startdate))
                ->whereSalary_year(date('Y', $startdate))->first();
                $salary_earning_deduction = new Salary;
                
                if(!empty($salary_data))
                    $c_salary = $salary_earning_deduction->recalculate_earning($salary_data->id);
                    $notification = new Notification;
                    $notification->title = 'Your Salary Calculate';
                    $notification->message = 'Your salary calculated. Please review it and submit status';
                    $notification->sender_id = Auth::user()->id;
                    $notification->receiver_id = $employee->id;
                    $notification->save();
                continue;
              /*  
                $extra_earnings_of_month = \App\Salary_earning::where('salary_id',$salary_data->id)->sum('amount');
                $extra_deduction_of_month = \App\Salary_deduction::where('salary_id',$salary_data->id)->sum('amount');*/
                
            }

            $basic_salary = ($calculated_salary*$setting->get_setting_by_key('basic'))/100;

            $hra = ($calculated_salary*$setting->get_setting_by_key('hra'))/100;
            $da = ($calculated_salary*$setting->get_setting_by_key('da'))/100;
            $ta = $setting->get_setting_by_key('ta');
            
            $getTa = $calculated_salary-($basic_salary+$hra+$da);

            if($getTa<1600){
                $ta = $getTa;
            }
            $other_allowance=0;
            if($getTa>=$ta){
                $other_allowance = $calculated_salary-($basic_salary+$hra+$da+$ta);
            }else{
                $other_allowance = 0;
            }
            

            //$gross_salary = $calculated_salary+$extra_earnings_of_month;
            $esi_employer =0;
            if($cb_profile->esi==1){
                $esi_employer = ($calculated_salary*$setting->get_setting_by_key('esi_employer'))/100;
                $esi_employee = ($calculated_salary*$setting->get_setting_by_key('esi_employee'))/100;
                $salary['employee_esi_percentage']      = $setting->get_setting_by_key('esi_employee');
                $salary['employer_esi_percentage']      = $setting->get_setting_by_key('esi_employer');
            }else{
                $esi_employer =0;
               $esi_employee = 0; 
            }

            
            $employer_pf = 0;
            if($cb_profile->epf==1){
                $pf = (($basic_salary+$da)*$setting->get_setting_by_key('pf'))/100;
                $employer_pf = (($basic_salary+$da)*$setting->get_setting_by_key('employer_pf'))/100;
                $salary['employee_pf_percentage']      = $setting->get_setting_by_key('pf');
                $salary['employer_epf_percentage']      = $setting->get_setting_by_key('employer_pf');

            }else{
                $employer_pf=0;
                $pf=0;
            }
            
            $gross_salary = $calculated_salary+$employer_pf+$esi_employer;
           
            
            
            $tds =  $cb_profile->tds;
            $net_salary = $calculated_salary - ($tds+$esi_employee+$pf+$extra_deduction_of_month); 

            $salary['user_id']          = $employee->id;
            $salary['designation']      = $cb_profile->designation;
            $salary['salary_month']     = date('m', $startdate);
            $salary['salary_year']      = date('Y', $startdate);
            $salary['working_days']     = $working_day;
            $salary['presents_days']    = $emp_attendance['present'];
            $salary['leaves']           = ($emp_attendance['leaves']+($emp_attendance['half_day']/2));
            $salary['half_days']        = $emp_attendance['half_day'];
            $salary['UI']               = $emp_attendance['ui']; 
            $salary['hra']    =  $hra;
            $salary['da']     =  $da ;
            $salary['ta']     = $ta ;
            $salary['esi']    = $esi_employee;
            $salary['employer_esi']    = $esi_employer;
            $salary['pf']    = $pf;
            $salary['employer_pf']    = $employer_pf;
            $salary['tds']    = $tds;
            $salary['other_allowance'] = $other_allowance;
            $salary['basic_salary']  = $basic_salary;
            $salary['gross_salary'] = $gross_salary;  
            $salary['net_salary'] = $net_salary;
            $salary['calculate_salary'] = $calculated_salary; 

              
           
            
            $is_added = Salary::whereUser_id($employee->id)
                    ->whereSalary_month(date('m', $startdate))
                    ->whereSalary_year(date('Y', $startdate))->count();  
                    
            if($is_added > 0){ 
                $salary_data = Salary::whereUser_id($employee->id)
                ->whereSalary_month(date('m', $startdate))
                ->whereSalary_year(date('Y', $startdate))->first();  
                $c_salary = Salary::where('id',$salary_data->id)->update($salary); 
                $log['salary_id']   = $salary_data->id; 
                $log['title']       = "Updated Monthly Salary of ".date('M - Y', $enddate);
                $log['description'] = "Salary calcuated and update at ".date('M - Y', $enddate);
                Salary_log::create($log);

            }else{
                $c_salary = Salary::create($salary); 
                $log['salary_id']   = $c_salary->id; 
                $log['title']       = "Monthly Salary of ".date('M - Y', $enddate);
                $log['description'] = "Salary calcuated for ".date('M - Y', $enddate);
                Salary_log::create($log);
               

            }   
            
        }
        
        
        if($c_salary){
            // create salary payroll
                $month = date('m')-1;
                $year = ($month==1)?date('Y')-1:date('Y');

                $pcount = PayRoll::where(['salary_month'=>$month,'salary_year'=>$year])->count();
                if($pcount==0){
                    $payroll = new PayRoll;
                    $payroll->salary_date = date('Y-m-d');
                    $m = date('m')-1;
                    if($m==1){
                        $payroll->salary_year = date('Y')-1;
                    }else{
                        $payroll->salary_year = date('Y');
                    }
                    $payroll->salary_month = $m;
                    
                    $payroll->save();
                }
                
            return response()->json(['status'=>true]);
        }else{
            return response()->json(['status'=>false]);

        }
    }

    public function calculate_attendance($id,$start,$end){  
            $id = "CB0".$id;
            $attendance =  AttendanceData::whereEmployee_id($id)
                            ->whereDate('attendance_date','>=', $start) 
                            ->whereDate('attendance_date','<=', $end) 
                            ->orderBy('attendance_date','ASC')
                            ->get(['attendance_date','status']); 
            $attendance = $attendance->toArray(); 
             
                $startdate   = strtotime($start); 
                $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
                $currentdate = $startdate;
                $p = $ab = $ui = $hd = $sw = 0; 
                $sw_status = false;
                $holydays = ['Sun','Sat'];
                while ($currentdate <= $enddate){
                    $day = date('D', $currentdate);
                    $date = date('Y-m-d', $currentdate);
                    if(in_array($day, $holydays)){ 
                        ++$p;
                    }else{ 
                        $found_key = array_search(date('Y-m-d', $currentdate), array_column($attendance, 'attendance_date'));
                        if(!empty($found_key) || $found_key===0){ 
                            $status = $attendance[$found_key]['status'];

                            if($day=="Fri" &&  ($status=="AB" || $status=="UI"))
                            $sw_status =true; 
                            switch($status){
                                case 'P': 
                                    ++$p;
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
                            $check_holyday = Holiday::whereDate('date',$date)->first(); 
                            if(!empty($check_holyday))
                                ++$p;  
                        }
                    }
                   $currentdate = strtotime('+1 day', $currentdate);
                } 
             //echo "<br>  $id  P => $p  HD => $hd AB => $ab  UI => $ui  ";
            $data['present']          = $p;
            $data['leaves']           = $ab;
            $data['half_day']         = $hd;
            $data['ui']               = $ui;
            $data['sandwich_leave']   = $sw;
            return $data;  
    } 

    public function gross_salary($id,$month){

    }

}
