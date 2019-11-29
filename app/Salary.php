<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;
use Carbon;
use App\PayRoll;
use DateTime;
class Salary extends Model
{
    protected $table = "salaries";

    protected $fillable = ['user_id','designation','salary_month','salary_year','working_days','presents_days','leaves','half_days','UI','hra','da','ta','other_allowance','bonus','incentives','arrears','pf','esi','loan','tds','basic_salary','calculate_salary','total_earning','total_deduction','gross_salary','net_salary','salary_status','emp_status','emp_description','hr_status','acc_status','payment_status','payment_mode','management_status','payment_date','employer_pf','employer_esi'];
    
    public function user(){
     return $this->belongsTo(User::class,'user_id');
    }
        
    public function logs(){
        return $this->hasMany(Salary_log::class);
    }

    public function deductions(){
        return $this->hasMany(Salary_deduction::class);
    }
    
    public function earnings(){
        return $this->hasMany(Salary_earning::class); 
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
                                ++$ab;
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

     public function recalculate_earning($payslip_id){
       
        $is_salary_created = Salary::where('id',$payslip_id)->count();  
        
        if($is_salary_created == 1){

            $current_salary = Salary::where('id',$payslip_id)->first();
            $setting  = new Setting;
        
            $startdate   = strtotime($current_salary->salary_year . '-' . $current_salary->salary_month . '-01');
            $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
            $working_day = intval((date('t',$startdate)),10);  
            $employee = User::with('cb_profile')->whereIs_active(1)->where('role','!=',1)->orWhere('is_active',4)->get(); 

            $cb_profile = EmployeeCbProfile::whereUser_id($current_salary->user_id)->first(['joining_date','salary','stay_bonus','tds','esi','epf']); 
            $join_date = strtotime($cb_profile->joining_date); 
            $startdate = ($join_date > $startdate) ? $join_date  : $startdate;
            $emp_attendance = $this->calculate_attendance($current_salary->user_id, date('Y-m-d', $startdate), date('Y-m-d', $enddate)); 
           
            $calculated_salary = (($cb_profile->salary/$working_day) * $emp_attendance['present']);
       
            $extra_earnings_of_month = \App\Salary_earning::where('salary_id',$payslip_id)->sum('amount');
          /*  $extra_deduction_of_month = \App\Salary_deduction::where('salary_id',$payslip_id)->sum('amount');*/
            $salary_deductions = \App\Salary_deduction::where('salary_id',$payslip_id)->select('amount','type','id')->get();

            $extra_deduction_of_month = 0;
            
            foreach ($salary_deductions as $key => $deduct) {
               if($deduct->type==1){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }if($deduct->type==2){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }if($deduct->type==3){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }/*if($deduct->type==4){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }*//*if($deduct->type==6){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }*//*if($deduct->type==8){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }*/if($deduct->type==9){
                    $extra_deduction_of_month = $extra_deduction_of_month+$deduct->amount;
               }
            }
          
            $overtime = 0;
            $incentive = 0;
            $others = 0;
           /* $extra_earnings_of_month = 0;
            $extra_deduction_of_month = 0;*/
            $arrears = 0;
            $bonus = 0;
            $loan = 0;
            $salary_earnings = \App\Salary_earning::where('salary_id',$payslip_id)->get();
          
            foreach ($salary_earnings as $key => $earning) {

                if($earning->type==3){
                    $arrears = $earning->amount; 
                }else if($earning->type==4){
                    $bonus = $earning->amount; 
                }else if($earning->type==5){
                    $loan = $earning->amount; 
                }else if($earning->type==1){
                    $overtime = $earning->amount; 
                }else if($earning->type==2){
                    $overtime = $earning->amount; 
                }else if($earning->type==6){
                    $others = $earning->amount; 
                }
            }
            $basic_salary = ($calculated_salary*$setting->get_setting_by_key('basic'))/100;

            $hra = ($calculated_salary*$setting->get_setting_by_key('hra'))/100;
            $da = ($calculated_salary*$setting->get_setting_by_key('da'))/100;
            $ta = $setting->get_setting_by_key('ta');
            
            $getTa = $calculated_salary-($basic_salary+$hra+$da);

            if($getTa<1600){
                $ta = $getTa;
            }
         
            //$other_allowance = $calculated_salary-($basic_salary+$hra+$da+$ta);
            $other_allowance=0;
            if($getTa>$ta){
                $other_allowance = $calculated_salary-($basic_salary+$hra+$da+$ta);
            }else{
                $other_allowance = 0;
            }

            //$gross_salary = $calculated_salary+$extra_earnings_of_month+$loan+$bonus+$arrears;
            $esi_employer=0;
            $esi_employee = 0; 
            if($cb_profile->esi==1){
                $esi_employer = (($calculated_salary)*$setting->get_setting_by_key('esi_employer'))/100;
                $esi_employee = ($calculated_salary*$setting->get_setting_by_key('esi_employee'))/100;
                $salary['employee_esi_percentage']      = $setting->get_setting_by_key('esi_employee');
                $salary['employer_esi_percentage']      = $setting->get_setting_by_key('esi_employer');
            }else{
                $esi_employer=0;
               $esi_employee = 0; 
            }

            

            if($cb_profile->epf==1){
                $pf = (($basic_salary+$da)*$setting->get_setting_by_key('pf'))/100;
                $employer_pf = (($basic_salary+$da)*$setting->get_setting_by_key('employer_pf'))/100;
                $salary['employee_pf_percentage']      = $setting->get_setting_by_key('pf');
                $salary['employer_epf_percentage']      = $setting->get_setting_by_key('pf');

            }else{
                $pf=0;
                $employer_pf=0;
            }
            
            foreach ($salary_deductions as $key => $deduction) {
              
                if($deduction->type==4){
                    $sd = Salary_deduction::find($deduction->id);
                    $sd->amount = $esi_employee;
                    $sd->save();
                }if($deduction->type==5){
                    $sd = Salary_deduction::find($deduction->id);
                    $sd->amount = $esi_employer;
                    $sd->save();
                }if($deduction->type==6){
                    $sd = Salary_deduction::find($deduction->id);
                    $sd->amount = $pf;
                    $sd->save();
                }if($deduction->type==7){
                    $sd = Salary_deduction::find($deduction->id);
                    $sd->amount = $employer_pf;
                    $sd->save();
                }

            }
            //$gross_salary = $basic_salary+$extra_earnings_of_month+$loan+$bonus+$arrears+$employer_pf+$esi_employer+$hra+$ta+$da+$other_allowance;
            $gross_salary = $calculated_salary+$employer_pf+$esi_employer+$extra_earnings_of_month;
            //dd($gross_salary);
            $tds = $cb_profile->tds;

            $net_salary = (($calculated_salary+$extra_earnings_of_month) - ($tds+$this->calculateLoan($current_salary->user_id)+$esi_employee+$pf+$extra_deduction_of_month)); 
             //dd($emp_attendance['leaves']);                                   
            $salary['user_id']          = $current_salary->user_id;
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
            $salary['bonus']  = $bonus;
            $salary['incentives']  = $extra_earnings_of_month;
            $salary['loan']   = $loan;
            $salary['arrears']     = $arrears ;
            $salary['other_allowance'] = $other_allowance;
            $salary['basic_salary']  = $basic_salary;
            $salary['gross_salary'] = $gross_salary;  
            $salary['esi']    =$esi_employee;
            $salary['employer_esi']    = $esi_employer;
            $salary['pf']    =$pf;
            $salary['employer_pf']    = $employer_pf;
            $salary['tds']    =$tds;
            $salary['net_salary'] = $net_salary;
            $salary['calculate_salary'] = $calculated_salary ;  
            $salary['total_earning'] = $extra_earnings_of_month;  
            $salary['total_deduction'] = $extra_deduction_of_month;  
           
            Salary::where('id',$payslip_id)->update($salary);
            $log['salary_id']   = $payslip_id; 
            $log['title']       = "Recalcuated Salary on ".date('M - Y', $enddate);
            $log['description'] = "Salary is Recalcuated no ".date('M - Y', $enddate);
            Salary_log::create($log);
            // create salary payroll
                $month = date('m')-1;
                $year = ($month==1)?date('Y')-1:date('Y');
                $payroll = PayRoll::where('salary_month',$month)->where('salary_year',$year)->first();
                
                if(getRoleStr()=='admin'){
                    $payroll->admin_status = 1;
                    $payroll->final_status = 1;
                    $payroll->hr_status = 1;
                }
                if(getRoleStr()=='hrManager'){
                    $payroll->hr_status = 1;
                }

                $payroll->save();
            return true;
        }else{
            return false;
        }          
        
        
    }


    public function salary_earnings(){
        return $this->hasMany(Salary_earning::class); 
    }

    public function cb_profile(){
        return $this->hasOne('App\EmployeeCbProfile','user_id','user_id');
    }

    public function getBonus($salary_id){
        $Salary_earning_type = Salary_earning_type::where('name','Bonus')->first();
        $salary_earning      = Salary_earning::where(['salary_id'=>$salary_id,'type'=>$Salary_earning_type->id])->first();
        if($salary_earning!=null)
            return $salary_earning->amount;
        else
            return 0;
    }

    public function getArears($salary_id){
        $Salary_earning_type = Salary_earning_type::where('name','Arrears')->first();
        $salary_earning      = Salary_earning::where(['salary_id'=>$salary_id,'type'=>$Salary_earning_type->id])->first();
        if($salary_earning!=null)
            return $salary_earning->amount;
        else
            return 0;
    }

    public function calculateLoan($user_id){
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $loan = Loan::where('emp_id',$user_id)->whereBetween('approve_date',[$month_ini->format('Y-m-d'),$month_end->format('Y-m-d')])->first();
        if($loan!=null){
            return $loan->emi;
        }else{
            return 0;
        }
    }



    
}