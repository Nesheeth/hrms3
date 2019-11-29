<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmployeeCbProfile extends Model
{
    public function checkStayBonus($user_id){
      
    	$user_data = $this->where('user_id',$user_id)->first();
    	$date = date("Y-m-d", strtotime("-2 months"));

    	$appdate = date_parse_from_format("Y-m-d", $user_data->appraisal_date);
    	$checkdate = date_parse_from_format("Y-m-d", $date);
       
       
		$appraisal_month =  $appdate["month"];
		$check_month =  $checkdate["month"];
      
		$user = User::where('id',$user_id)->first();
    	if(($check_month-$appraisal_month)==0 && $user->is_active==1){
    		return true;
    	}else{
    		return false;
    	}
    }
}
