<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
	public function leave_type(){
		return $this->belongsTo('\App\LeaveType');
	}
}
