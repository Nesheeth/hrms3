<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemMacMini extends Model
{   
	public function assets(){
		return $this->hasMany('\App\SystemAssetMacMini','system_id','id');
	}
}