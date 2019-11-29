<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemAsset extends Model
{
	public function asset(){
		return $this->belongsTo('\App\Asset');
	}
}
