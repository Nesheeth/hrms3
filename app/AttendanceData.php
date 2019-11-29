<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceData extends Model
{
	protected $table = "attendance_data"; 

	public function log(){

		return $this->hasMany(AttendanceLog::class,'attendance_id');
	}
}
