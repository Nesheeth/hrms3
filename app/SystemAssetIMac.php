<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemAssetIMac extends Model
{   
	public function asset(){
		return $this->belongsTo('\App\Asset');
	}
}