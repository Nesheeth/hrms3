<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HrEod extends Model
{   
	 protected $fillable = ['user_id','date_of_eod','recruitment','generalist','comment']; 

	public function user(){ 
      return $this->belongsTo('App\User','user_id'); 
	}

	
}