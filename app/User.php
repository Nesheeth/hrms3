<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Salary;
use App\Salary_earning;
use App\Salary_deduction;
use App\Loan;
use DateTime;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function personal_profile(){
        return $this->hasOne('\App\EmployeePersonalDetail');
    }
    public function cb_profile(){
        return $this->hasOne('\App\EmployeeCbProfile');
    }
    public function previous_employment(){
        return $this->hasMany('\App\EmployeePreviousEmployment','user_id');
    }
    public function cb_appraisal_detail(){
        return $this->hasOne('\App\EmployeeCbAppraisalDetail');
    }
    public function resignation(){
        return $this->hasOne('\App\Resignation');
    }

    public function employee(){
        return $this->hasOne('\App\EmployeeCbProfile');
    }

    public function member(){
        return $this->hasMany('\App\TeamMember','team_member_id');
    }

    public function getIncentive(){
        return $this->hasManyThrough('App\Salary_earning','App\Salary','user_id','salary_id','id','user_id');
    }

     public function Loan()
    {
        return $this->belongsTo('App\Loan','emp_id');
    }

    public function getIncentives($id,$type){
        if($type=='OverTime'){
            $type=1;
        }
        if($type=='Incentive'){
            $type=2;
        }
        if($type=='Arrears'){
            $type=3;
        }
        if($type=='Bonus'){
            $type=4;
        }
        if($type=='Loan'){
            $type=5;
        }
        if($type=='Others'){
            $type=6;
        }
        if($type=='Remarks'){
            $type=7;
        }
        $salary = Salary::where('user_id',$id)->first();
        if($salary==null)
            return ;
        $salary_earning = Salary_earning::where('salary_id',$salary->id)->where('type',$type)->first();
        if($type==7)
        {
            if($salary_earning!=null)
                return $salary_earning->description;
            return ;
        }else{
            if($salary_earning!=null)
                return $salary_earning->amount;
            else
                return ;
        }
        
    }


    public function getDeductions($id,$type){
        if($type=='LateLogin'){
            $type=1;
        }
        if($type=='Uninformed'){
            $type=2;
        }
        if($type=='Sleeping'){
            $type=3;
        }
        if($type=='ESIEmployee'){
            $type=4;
        }
        if($type=='ESIEmployer'){
            $type=5;
        }
        if($type=='EPFEmployee'){
            $type=6;
        }
        if($type=='EPFEmployer'){
            $type=7;
        }
        if($type=='TDS'){
            $type=8;
        }
        if($type=='Others'){
            $type=9;
        }
        if($type=='Remarks'){
            $type=10;
        }
        $salary = Salary::where('user_id',$id)->first();
        if($salary==null)
            return ;
        $salary_deduction = Salary_deduction::where('salary_id',$salary->id)->where('type',$type)->first();
        if($type==10)
        {
            if($salary_deduction!=null)
                return $salary_deduction->description;
            else
                return ;
        }else{
            if($salary_deduction!=null)
                return $salary_deduction->amount;
            else
                return ;
        }
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

    public function getLoan($user_id){
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $loan = Loan::where('emp_id',$user_id)->whereBetween('approve_date',[$month_ini->format('Y-m-d'),$month_end->format('Y-m-d')])->first();

        $first_day_of_month = strtotime($month_ini->format('Y-m-d'));
        $last_day_of_month = strtotime($month_end->format('Y-m-d'));
        if($loan!=null){
            return $loan->amount;
        }else{
            return 0;
        }
    }

    public function getSalary(){
        return $this->hasOne('App\Salary','user_id');
    }

    public function kt_project()
    {
        return $this->hasMany('App\KnowledgeTransfer','user_id');
    }

    
}
