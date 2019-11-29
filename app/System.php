<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class System extends Model

{

	public function assets(){

		return $this->hasMany('\App\SystemAsset');

	}
	public function Users(){

		return $this->hasOne('\App\User', 'id','assign_to');

	}

}

