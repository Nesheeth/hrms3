<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemAssetMacMini extends Model
{   
	// public function asset(){
	// 	return $this->belongsTo('\App\Asset');
	// }
	public function asset1(){
		return $this->belongsTo('\App\Monitor');
	}
	public function asset2(){
		return $this->belongsTo('\App\Keyboard');
	}
	public function asset3(){
		return $this->belongsTo('\App\Mouse');
	}
	public function asset4(){
		return $this->belongsTo('\App\Cabinet');
	}
	public function asset5(){
		return $this->belongsTo('\App\Motherboard');
	}
	public function asset6(){
		return $this->belongsTo('\App\Ram');
	}
	public function asset7(){
		return $this->belongsTo('\App\Processer');
	}
	public function asset8(){
		return $this->belongsTo('\App\UpsBattery');
	}
	public function asset9(){
		return $this->belongsTo('\App\Smps');
	}

}