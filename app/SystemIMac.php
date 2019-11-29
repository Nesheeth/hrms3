<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemIMac extends Model
{   
	public function assets(){
		return $this->hasMany('\App\SystemAssetIMac','system_id','id');
	}
}