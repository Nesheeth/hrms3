<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLaptop extends Model
{   
	public function assets(){
		return $this->hasMany('\App\SystemAssetLaptop','system_id','id');
	}
}