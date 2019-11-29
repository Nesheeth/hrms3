<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dvr extends Model
{
	public function asset_type(){
		return $this->belongsTo('\App\AssetType');
	}

	public function master_asset(){
		return $this->belongsTo('\App\MasterAsset');
	}
	public function asset(){
		return $this->belongsTo('\App\AssetAssoc');
	}
	
}
