<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\LeaveType;
use App\Leave_tracking;
use Auth;
use Mail;
use App\Salary;
use App\Salary_log;
use DB;
use App\Salary_earning_type;
use App\Salary_deduction_type;
use App\Salary_earning;
use App\Salary_deduction;
use App\PayRoll;

class PayrollController extends Controller
{   

    public function __construct(){
        $this->middleware('auth');
    } 
	
	
	public function request_for_slip(Request $request){
		
		$receivers = User::where('role', 1)->orWhere('role', 2)->pluck('id');  
		//NotificationController::notify( Auth::user()->id, $receivers, Auth::user()->,$message)
	}
	
    public function adminPayrollsEmp(){

        //add incentive and deduction

        $arr=date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $arr=explode('-',$arr);
        $month;$year;
        $month = ltrim($arr[1],'0');
        $year = $arr[0];
        if($month==1){
            $year=$year-1;
        }
        
        $last_month_salary = Salary::where(['salary_month'=>$month,'salary_year'=>$year])->count(); 
        $last_month = Salary::where(['salary_month'=>$month,'salary_year'=>$year])->get(); 
        $Salary_earning = 0;
        foreach ($last_month as $key => $last) {
            $Salary_earning = Salary_earning::where('salary_id',$last->id)->count();
            if($Salary_earning>0){
                break;
            }else{
                continue;
            }
        }
        $Salary_deduction=0;
        foreach ($last_month as $key => $last) {
            
            $Salary_deduction = Salary_deduction::where('salary_id',$last->id)->count();
            if($Salary_deduction>0){
                break;
            }else{
                continue;
            }
        }
        
        
        $data['Salary_earning'] = $Salary_earning;
        $data['Salary_deduction'] = $Salary_deduction; 
        //check for salary calculate or not and hide add_deduction,add_incentive and Final_calculate button
        $data['last_month_salary']=$last_month_salary;
        $data['users']=User::with('cb_profile','getIncentive','getSalary')->where('role','!=',1)->whereIn('is_active',[1,4])->orderBy('first_name')->get();
       
        //end incentive and deduction
        
        //$data['users'] = User::where('role','!=',1)->where('is_active',1)->orderBy('id','desc')->get();
        //check Hr salary status
        $m = date('m')-1;
        $y =($m==1)?date('Y')-1:date('Y');
       
        $salary_status_of_month = PayRoll::where(['salary_month'=>$m,'salary_year'=>$y])->first();
        $data['salary_status_of_month']= $salary_status_of_month; 
        return view('admin.payroll_list',$data);
    }

    public function view_payroll(){
        return view('admin.viewpayroll');
    }

    public function payslipLists(Request $request){
        $data['user'] = User::findOrFail($request->id); 
        $data['payrolls'] = Salary::with('cb_profile')->whereUser_id($request->id)->orderBy('created_at','desc')->get();  
        
        return view('common.payroll.payslip',$data);
    }

    public function payrollDetails(Request $request){ 
       
        if(!empty($request->id)){
            $payslip = Salary::findOrFail($request->id);
        }else{
            $month = $request->month;
            $year = $request->year;
            $user = $request->emp;
            //print_r($request->all()); die; 
           // $data = strtotime($data);  
            $payslip = Salary::where(['user_id'=> $user,'salary_month' => $month,'salary_year'=> $year])->first();  
             //$payslip = Salary::whereUser_id(210)->whereSalary_month($date[0])->whereSalary_year($date[1])->first();    
            //print_r(DB::getQueryLog());die;
            if(empty($payslip))
            return back()->with('error','PaySlip not fount or not generated for this month');
        }

        $data['user'] = User::findOrFail($payslip->user_id);
        $data['payslip'] = $payslip;
        /* $a= 18;
        $b=$a/2;
        var_dump($a); //14
        echo $b; //7 */
        return view('common.payroll.details',$data);  
    }


    public function view_ern(Request $request){
         		 
        if(!empty($request->type)){
            $data['type'] = $request->type;           
            if($request->type=="income"){
                $data['types'] = Salary_earning_type::orderBy('name','asc')->get();
               return view('common.payroll.incoms_deduction', $data); 
            }
            if($request->type=="deduction"){
                $data['types'] = Salary_deduction_type::orderBy('name','asc')->get();
               return view('common.payroll.incoms_deduction', $data);
           }
		   
		   if($request->type=="payment_status"){
               return view('common.payroll.incoms_deduction', $data);
           }
        }
    }

    public function save_income_deduction(Request $request){

        if($request->type_name == "income"){
             $salary_earning;
            $count = Salary_earning::where('salary_id',$request->salary_id)->count();
            
            if($count>0){
                $salary_earning = Salary_earning::find($request->id);
                
                $msg='Earning has updated successfully';
                

            }else{
                $salary_earning = new Salary_earning;
                
                $msg='Earning has added successfully';
            }
            
            $salary_earning->salary_id = $request->salary_id;  
            $salary_earning->type = $request->type;  
            $salary_earning->amount = $request->amount;  
            $salary_earning->description = $request->description;  
            $salary_earning->save();
            return json_encode(['success'=>true,'msg'=>$msg]);
        }
        if($request->type_name == "deduction"){
            $count=Salary_deduction::where('salary_id',$request->salary_id)->count();
            $salary_deduction;
            if($count>0){
                $salary_deduction = Salary_deduction::find($request->id);
                
                $msg='Deduction has updated successfully';
            }else{
                $salary_deduction = new Salary_deduction;
                
                $msg='Deduction has added successfully';

            }
            
            $salary_deduction->salary_id = $request->salary_id;  
            $salary_deduction->type = $request->type;  
            $salary_deduction->amount = $request->amount;  
            $salary_deduction->description = $request->description;  
            $salary_deduction->save();
            return json_encode(['success'=>true,'msg'=>$msg]);
        }      
    }

    public function delete_earning_deduction(Request $request){
    
        if($request->type="earning"){
            $salary_earning = Salary_earning::where('id',$request->id)->delete();

            if($salary_earning){
                return json_encode(['success'=>true,'msg'=>"Earning has Deleted successfully"]);
            }else{
                return json_encode(['success'=>false]);
            }
            
        }
        if($request->type="deduction"){

            $salary_deduction =  Salary_deduction::where('id',$request->id)->delete();

            if($salary_deduction){
                return json_encode(['success'=>true,'msg'=>"Deduction has Deleted successfully"]);
            }else{
                return json_encode(['success'=>false]);
            }
          
        }
        
    }

    /*
    |
       Salary Recalculated Here
    |
    */

    public function recalculate(Request $request){

        $salary = new Salary;
        
        if($salary->recalculate_earning($request->salary_id)){
            return json_encode(["success"=>true]);
        }else{
            return json_encode(["success"=>false]);
        }      
        
    }

    /*
    |
        Get pay slip details by pay slip Id
    |
    */

    public function get_payslip_details_by_id(Request $request){
        $is_salary_created = Salary::where('id',$request->salary_id)->count();  
        if($is_salary_created == 1){
            $payslip_details = Salary::where('id',$request->salary_id)->first();
            return json_encode(['success'=>true,'payslip_details'=>$payslip_details]);
        }else{
            return json_encode(['success'=>false]);
        }
    }
	
	
	public function payroll_pages(Request $request){
		$data['type'] = $request->type;
		return view('common.payroll.payroll_pages', $data);
		
	}
	
	public function changePaymentStatus(Request $request){
		$salary =  Salary::findOrFail($request->payroll_id);
		$salary->payment_status = 1;
		$salary->payment_mode = $request->pay_mode;
		$salary->payment_date = $request->pay_date;
		$salary->save(); 
		print_r($salary);
		
	}
	
	public function changePayRollStatusEmp(Request $request){
		$payroll = Salary::findOrFail($request->pay_id);
			if($request->status==1){
				$payroll->emp_status = 1;
			}elseif($request->status==2){
				$payroll->emp_status = 2;
				$payroll->emp_description = $request->reason;
			}
			/*-----------------------------------Send notification-------------------------------------------*/
			$url = url('role/payrolls-list/')."/".$payroll->user_id;   
			$receiver = array();
			$user = User::findOrFail($payroll->user_id);
			$title = $user->first_name." ".$user->last_name." has update pay roll status";
			$message = "<p> $title </p><br>";
			$message.= "<a href='".$url."' class='btn btn-primary leave1'> View </a>";     
			$admins = User::whereIn('role',[1,2,8])->get();
			foreach ($admins as $admin) {
				array_push($receiver,$admin->id);  
			}
			NotificationController::notify(Auth::user()->id,$receiver,$title,$message); 
			/*-----------------------------------Send notification-------------------------------------------*/
			    $description = "";
				if($request->status==1)
					$description = $user->first_name." ".$user->last_name." update his payroll status as correct.";
				elseif($request->status==2)
					$description = $user->first_name." ".$user->last_name." update his payroll status as some issues ($payroll->emp_description).";
			    $log['salary_id']   = $request->pay_id; 
                $log['title']       = $title;
                $log['description'] = $description;
                Salary_log::create($log);
			/*-----------------------------------Send notification-------------------------------------------*/
		$payroll->save();
	}
	
	public function changePayRollStatus(Request $request){
		$payroll = Salary::findOrFail($request->pay_id);
		$user    = User::findOrFail($payroll->user_id);
		$title   = $title2 = "";
		$receiver = array();
			if(Auth::user()->role==2){
				$title  = "HR has update your pay roll status";
				$title2 = "HR has update ".$user->first_name." ".$user->last_name." pay roll status .";
				$payroll->hr_status = 1; 
				$admins = User::whereIn('role',[1,8])->get();
				foreach ($admins as $admin) {
					array_push($receiver,$admin->id);  
				}
			}elseif(Auth::user()->role==1){
				$payroll->management_status = 1;
				$title  = "Management has update your pay roll status";
				$title2 = "Management has update ".$user->first_name." ".$user->last_name."  pay roll status.";
				
			}elseif(Auth::user()->role==8){
				$payroll->acc_status = 1;
				$title  = "Account Department has update your pay roll status";
				$title2 = "Account Department has update pay roll status";
				$admins = User::whereIn('role',[1])->get();
				foreach ($admins as $admin) {
					array_push($receiver,$admin->id);  
				}
			}
			$user = User::findOrFail($payroll->user_id);
			NotificationController::notify(Auth::user()->id,[$user->id], $title, "<p> $title </p><br>"); 
			
			NotificationController::notify(Auth::user()->id, $receiver, $title2, "<p> $title2 </p><br>"); 
			
			$log['salary_id']   = $request->pay_id; 
			$log['title']       = $title2;
			$log['description'] = $title2;
			Salary_log::create($log);
			$payroll->save(); 
	}
}
