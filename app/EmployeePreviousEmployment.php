<?php

namespace App;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class EmployeePreviousEmployment extends Model
{
    public function getDays($date1,$date2){
    	
		$date_first = strtotime(date($date1));
		$date_second = strtotime(date($date2));
		$diff_in_sec = ($date_first-$date_second);
		if($diff_in_sec<0){
			$date1 = new DateTime($date1);
			$date2 = new DateTime($date2);
			$diff  = $date2->diff($date1)->format("%a");
			$diff  = '-'.$diff;
		}else{
			$date1 = new DateTime($date1);
			$date2 = new DateTime($date2);
			$diff  = $date2->diff($date1)->format("%a");
		}
		
		return $diff;
	}
}
