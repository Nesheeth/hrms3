<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;

class EmployeeProject extends Model{   
 
	public function user(){
    	return $this->belongsTo('App\User','user_id');  
    }

    public function reporting(){
    	return $this->belongsTo('App\User','reporting_to');  
    }

    public function project(){
    	return $this->belongsTo('App\Project','project_id');  
    }
}