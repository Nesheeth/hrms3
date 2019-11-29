<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use DB;



class AjaxController extends Controller

{

	public function getMasterAssetByType($type_id){

		$master_assets = \App\MasterAsset::where('asset_type_id',$type_id)->get();

		return response()->json($master_assets);

	}

	public function getAssetByAssetType_unique(Request $request,$master_asset_id,$type_id){

	//	$master_assets = \App\AssetAssoc::where('asset_type_id',$type_id)->get();
      $system_id = $request->system_id;
	  $asset_type_id = $request->asset_type_id;
	 //  echo $master_asset_id;


   // $master_assets = DB::select('SELECT id,name,asset_type_id FROM asset_assocs WHERE id NOT IN (

   //                    SELECT asset_id FROM assets WHERE id IN ( SELECT asset_id FROM system_assets WHERE system_id ="'.$system_id.'" )) and asset_type_id ="'.$asset_type_id .'"');
     if($master_asset_id == 3){
     $master_assets = DB::select('SELECT id, name, asset_type_id FROM asset_assocs WHERE id NOT IN (SELECT asset_type_id FROM system_assets WHERE system_id ="'.$system_id.'" )AND asset_type_id ="'.$asset_type_id.'"');
 }
    if($master_asset_id == 4){
      $master_assets = DB::select('SELECT id, name, asset_type_id FROM asset_assocs WHERE id NOT IN (SELECT asset_type_id FROM system_asset_laptops WHERE system_id ="'.$system_id.'" )AND asset_type_id ="'.$asset_type_id.'"');
 }
    if($master_asset_id == 5){
     $master_assets = DB::select('SELECT id, name, asset_type_id FROM asset_assocs WHERE id NOT IN (SELECT asset_type_id FROM system_asset_mac_minis WHERE system_id ="'.$system_id.'" )AND asset_type_id ="'.$asset_type_id.'"');
 }
    if($master_asset_id == 6){
     $master_assets = DB::select('SELECT id, name, asset_type_id FROM asset_assocs WHERE id NOT IN (SELECT asset_type_id FROM system_asset_i_macs WHERE system_id ="'.$system_id.'" )AND asset_type_id ="'.$asset_type_id.'"');
 }


      // print_r($master_assets);
		return response()->json($master_assets);

	}

	public function getAssetByAssetType(Request $request,$type_id){

		$master_assets = \App\AssetAssoc::where('asset_type_id',$type_id)->get();
   //        $system_id = $request->system_id;
		 //   $asset_type_id = $request->asset_type_id;
	     


   // $master_assets   	=	 DB::select('SELECT id,name,asset_type_id FROM asset_assocs WHERE id NOT IN (

   //                    SELECT asset_id FROM assets WHERE id IN ( SELECT asset_id FROM system_assets WHERE system_id ="'.$system_id.'" )) and asset_type_id ="'.$asset_type_id .'"');
		return response()->json($master_assets);

	}

	public function freeAssets($type_id,$asset_id){

		if($asset_id == '1'){$free_assets = \App\Monitor::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '2'){$free_assets = \App\Keyboard::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '3'){$free_assets = \App\Mouse::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '4'){$free_assets = \App\Cabinet::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '5'){$free_assets = \App\Motherboard::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '6'){$free_assets = \App\Ram::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '7'){$free_assets = \App\Processer::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '8'){$free_assets = \App\UpsBattery::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '9'){$free_assets = \App\Smps::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '10'){$free_assets = \App\Hdd::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '11'){$free_assets = \App\Desktop::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '12'){$free_assets = \App\Laptop::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '13'){$free_assets = \App\MacMini::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '14'){$free_assets = \App\IMac::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '15'){$free_assets = \App\NetworkSwitch::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '16'){$free_assets = \App\Router::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '17'){$free_assets = \App\Repeater::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '18'){$free_assets = \App\Ups::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '19'){$free_assets = \App\PenDrive::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '20'){$free_assets = \App\Dvr::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '21'){$free_assets = \App\Camera::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '22'){$free_assets = \App\WebCam::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '23'){$free_assets = \App\Printer::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '24'){$free_assets = \App\Chair::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '25'){$free_assets = \App\Desk::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '26'){$free_assets = \App\Fan::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '27'){$free_assets = \App\AC::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		if($asset_id == '28'){$free_assets = \App\Almirah::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
				if($asset_id == '29'){$free_assets = \App\Headphone::where('asset_type_id',$type_id)->where('system_id',null)->where('status','free')->get();
		return response()->json($free_assets);}
		

	}

	public function getAssetsByTypeMaster($type_id,$master_type){

		$master_assets = \App\AssetAssoc::where('asset_type_id',$type_id)->where('master_asset_id',$master_type)->get();

		return response()->json($master_assets);

	}

	public function assignAsset(Request $requset,$system_id,$asset_id,$asset_assoc_id){
	
		$response['asset_assoc_id'] = $asset_assoc_id;
		if($asset_assoc_id == 1){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Monitor::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Monitor::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Monitor::where('id',$asset_id)->first();
				$asset->system_id = $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 2){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Keyboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Keyboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Keyboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 3){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Mouse::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Mouse::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Mouse::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 4){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Cabinet::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Cabinet::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Cabinet::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 5){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Motherboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Motherboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Motherboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 6){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ram::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ram::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ram::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 7){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Processer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Processer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Processer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 8){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\UpsBattery::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\UpsBattery::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\UpsBattery::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 9){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Smps::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Smps::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Smps::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 10){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Hdd::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Hdd::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Hdd::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 11){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desktop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desktop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desktop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 12){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Laptop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Laptop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Laptop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 13){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\MacMini::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\MacMini::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\MacMini::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 14){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\IMac::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\IMac::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\IMac::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 15){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\NetworkSwitch::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 16){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Router::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Router::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Router::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 17){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Repeater::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Repeater::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Repeater::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 18){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ups::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ups::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ups::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 19){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\PenDrive::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\PenDrive::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\PenDrive::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 20){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Dvr::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Dvr::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Dvr::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 21){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Camera::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Camera::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Camera::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 22){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\WebCam::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\WebCam::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\WebCam::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 23){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Printer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Printer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Printer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 24){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Chair::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Chair::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Chair::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 25){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desk::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desk::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desk::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 26){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Fan::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Fan::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Fan::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 27){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\AC::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\AC::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\AC::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 28){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Almirah::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Almirah::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Almirah::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 29){
			$response = array();
		$result = \App\SystemAsset::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Headphone::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Headphone::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAsset();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Headphone::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->system_code  =  $_GET["system_code"];
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}

       
	}
	public function assignAsset_laptop($system_id,$asset_id,$asset_assoc_id){
		
		$response['asset_assoc_id'] = $asset_assoc_id;
		if($asset_assoc_id == 1){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Monitor::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Monitor::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Monitor::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 2){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Keyboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Keyboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Keyboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 3){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Mouse::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Mouse::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Mouse::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 4){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Cabinet::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Cabinet::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Cabinet::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 5){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Motherboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Motherboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Motherboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 6){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ram::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ram::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ram::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 7){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Processer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Processer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Processer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 8){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\UpsBattery::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\UpsBattery::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\UpsBattery::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 9){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Smps::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Smps::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Smps::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 10){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Hdd::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Hdd::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Hdd::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 11){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desktop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desktop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desktop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 12){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Laptop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Laptop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Laptop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 13){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\MacMini::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\MacMini::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\MacMini::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 14){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\IMac::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\IMac::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\IMac::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 15){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\NetworkSwitch::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 16){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Router::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Router::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Router::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 17){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Repeater::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Repeater::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Repeater::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 18){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ups::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ups::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ups::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 19){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\PenDrive::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\PenDrive::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\PenDrive::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 20){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Dvr::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Dvr::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Dvr::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 21){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Camera::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Camera::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Camera::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 22){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\WebCam::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\WebCam::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\WebCam::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 23){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Printer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Printer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Printer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 24){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Chair::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Chair::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Chair::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 25){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desk::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desk::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desk::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 26){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Fan::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Fan::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Fan::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 27){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\AC::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\AC::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\AC::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 28){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Almirah::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Almirah::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Almirah::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 29){
			$response = array();
		$result = \App\SystemAssetLaptop::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Headphone::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Headphone::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetLaptop();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Headphone::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}

       
	}
	public function assignAsset_mac_mini($system_id,$asset_id,$asset_assoc_id){
		
		$response['asset_assoc_id'] = $asset_assoc_id;
		if($asset_assoc_id == 1){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Monitor::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Monitor::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Monitor::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 2){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Keyboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Keyboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Keyboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 3){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Mouse::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Mouse::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Mouse::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 4){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Cabinet::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Cabinet::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Cabinet::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 5){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Motherboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Motherboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Motherboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 6){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ram::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ram::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ram::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 7){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Processer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Processer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Processer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 8){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\UpsBattery::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\UpsBattery::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\UpsBattery::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 9){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Smps::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Smps::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Smps::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 10){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Hdd::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Hdd::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Hdd::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 11){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desktop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desktop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desktop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 12){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Laptop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Laptop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Laptop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 13){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\MacMini::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\MacMini::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\MacMini::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 14){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\IMac::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\IMac::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\IMac::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 15){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\NetworkSwitch::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 16){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Router::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Router::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Router::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 17){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Repeater::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Repeater::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Repeater::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 18){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ups::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ups::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ups::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 19){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\PenDrive::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\PenDrive::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\PenDrive::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 20){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Dvr::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Dvr::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Dvr::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 21){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Camera::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Camera::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Camera::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 22){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\WebCam::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\WebCam::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\WebCam::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 23){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Printer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Printer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Printer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 24){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Chair::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Chair::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Chair::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 25){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desk::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desk::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desk::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 26){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Fan::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Fan::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Fan::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 27){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\AC::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\AC::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\AC::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 28){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Almirah::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Almirah::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Almirah::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 29){
			$response = array();
		$result = \App\SystemAssetMacMini::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Headphone::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Headphone::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetMacMini();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Headphone::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}

       
	}
	public function assignAsset_i_mac($system_id,$asset_id,$asset_assoc_id){
		
		$response['asset_assoc_id'] = $asset_assoc_id;
		if($asset_assoc_id == 1){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Monitor::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Monitor::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Monitor::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 2){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Keyboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Keyboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Keyboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 3){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Mouse::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Mouse::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Mouse::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 4){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Cabinet::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Cabinet::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Cabinet::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 5){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Motherboard::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Motherboard::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Motherboard::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 6){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ram::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ram::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ram::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 7){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Processer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Processer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Processer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 8){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\UpsBattery::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\UpsBattery::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\UpsBattery::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 9){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Smps::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Smps::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Smps::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 10){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Hdd::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Hdd::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Hdd::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 11){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desktop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desktop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desktop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 12){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Laptop::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Laptop::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Laptop::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 13){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\MacMini::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\MacMini::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\MacMini::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 14){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\IMac::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\IMac::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\IMac::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 15){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\NetworkSwitch::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\NetworkSwitch::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 16){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Router::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Router::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Router::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 17){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Repeater::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Repeater::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Repeater::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 18){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Ups::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Ups::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Ups::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 19){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\PenDrive::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\PenDrive::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\PenDrive::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 20){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Dvr::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Dvr::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Dvr::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 21){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Camera::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Camera::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Camera::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 22){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\WebCam::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\WebCam::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\WebCam::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
          if($asset_assoc_id == 23){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Printer::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Printer::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Printer::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
        if($asset_assoc_id == 24){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Chair::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Chair::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Chair::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
         if($asset_assoc_id == 25){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Desk::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Desk::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Desk::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 26){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Fan::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Fan::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Fan::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 27){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\AC::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\AC::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\AC::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 28){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Almirah::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Almirah::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Almirah::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}
		 if($asset_assoc_id == 29){
			$response = array();
		$result = \App\SystemAssetIMac::where('system_id',$system_id)->where('asset_id',$asset_id)->where('asset_type_id',$asset_assoc_id)->first();
		  $response['aa']  = \App\Headphone::where('id',$asset_id)->value('asset_code');

		   $response['aa'] =  substr($response['aa'],0,2);
		   $response['asset_type_id']  = \App\Headphone::where('id',$asset_id)->value('asset_id');
		if(!is_null($result)){
			$response['flag'] = false;
			$response['error'] = "Already Assigned";
		}else{
			$system_asset = new \App\SystemAssetIMac();
			$system_asset->system_id = $system_id;
			$system_asset->asset_id = $asset_id;
			$system_asset->asset_type_id = $asset_assoc_id;
			if($system_asset->save()){
				$asset = \App\Headphone::where('id',$asset_id)->first();
				$asset->system_id =  $system_id;
				$asset->status =  "assigned";
				$asset->save();
				$response['flag'] = true;
			}else{
				$response['flag'] = false;
				$response['error'] = "Something Went wrong.";
			}
		}
		
		return response()->json($response);
		}

       
	}


	public function releaseAsset($id)

	{

		$response = array();

		$asset = \App\Asset::find($id);

		$asset->user_id = NULL;

		$asset->status = "free";

		if($asset->save()){

			$response['flag'] = true;

		}else{

			$response['flag'] = false;

		}

		return response()->json($response);

	}

	public function getSystem($id,$master_system_id)

	{

		$response = array();
		if( $master_system_id == 3){
        $system = \App\System::where('id',$id)->with('assets')->first();

		if(is_null($system)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['system'] = $system;

		}

		return response()->json($response);


		}
		if( $master_system_id == 4){
        $system = \App\SystemLaptop::where('id',$id)->with('assets')->first();

		if(is_null($system)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['system'] = $system;

		}

		return response()->json($response);


		}
		if( $master_system_id == 5){
        $system = \App\SystemMacMini::where('id',$id)->with('assets')->first();

		if(is_null($system)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['system'] = $system;

		}

		return response()->json($response);


		}
		if( $master_system_id == 6){
        $system = \App\SystemIMac::where('id',$id)->with('assets')->first();

		if(is_null($system)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['system'] = $system;

		}

		return response()->json($response);


		}
       
	}

	public function getAsset($id,$asset_type_id)

	{

		$response = array();
        if($asset_type_id == 1){
        	$asset = \App\Monitor::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 2){
        	$asset = \App\Keyboard::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 3){
        	$asset = \App\Mouse::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 4){
        	$asset = \App\Cabinet::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 5){
        	$asset = \App\Motherboard::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 6){
        	$asset = \App\Ram::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 7){
        	$asset = \App\Processer::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 8){
        	$asset = \App\UpsBattery::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 9){
        	$asset = \App\Smps::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 10){
        	$asset = \App\Hdd::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 11){
        	$asset = \App\Desktop::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 12){
        	$asset = \App\Laptop::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 13){
        	$asset = \App\MacMini::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 14){
        	$asset = \App\IMac::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 15){
        	$asset = \App\NetworkSwitch::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 16){
        	$asset = \App\Router::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 17){
        	$asset = \App\Repeater::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 18){
        	$asset = \App\Ups::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 19){
        	$asset = \App\PenDrive::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 20){
        	$asset = \App\Dvr::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 21){
        	$asset = \App\Camera::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 22){
        	$asset = \App\WebCam::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 23){
        	$asset = \App\Printer::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 24){
        	$asset = \App\Chair::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 25){
        	$asset = \App\Desk::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 26){
        	$asset = \App\Fan::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 27){
        	$asset = \App\AC::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 28){
        	$asset = \App\Almirah::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 29){
        	$asset = \App\Headphone::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }
        if($asset_type_id == 1){
        	$asset = \App\Monitor::where('id',$id)->first();

		if(is_null($asset)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['asset'] = $asset;

		}

		return response()->json($response);
        }

	}

	public function getUser($id)

	{

		$response = array();

		$user = \App\User::where('id',$id)->with('cb_profile')->first();

		if(is_null($user)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['user'] = $user;

		}

		return response()->json($response);

	}

	function getNewSystemId($system_name_id){

		$response = array();
         if($system_name_id == 3){
		$system = \App\System::select('*')->orderBy('id','DESC')->first();
         }
         if($system_name_id == 4){
		$system = \App\SystemLaptop::select('*')->orderBy('id','DESC')->first();
         }
         if($system_name_id == 5){
		$system = \App\SystemMacMini::select('*')->orderBy('id','DESC')->first();
         }
         if($system_name_id == 6){
		$system = \App\SystemIMac::select('*')->orderBy('id','DESC')->first();
         }
		if(is_null($system)){

			$response['flag'] = false;

			$response['error'] = "No Asset found";

		}else{

			$response['flag'] = true;

			$response['system'] = $system;

		}

		return response()->json($response);

	}

	public function getMasterSystemById($id){

		$response = array();

		$master_system = \App\MasterAsset::where('id',$id)->first();

		if(is_null($master_system)){

			$response['flag'] = false;

			$response['error'] = "No Asset found";

		}else{

			$response['flag'] = true;

			$response['master_system'] = $master_system;

		}

		return response()->json($response);

	}

	public function creditLeave(){

		$currentDay = date('d');

		if($currentDay != 1){

			$users = \App\EmployeeCbProfile::all();

			foreach ($users as $user) {

				if($user->leaves_taken == 0){

					$user->avail_leaves = $user->avail_leaves + 1;

				}else{

					$user->leaves_taken =  ($user->leaves_taken - 1);

				}

				$user->save();

			}

		}

	} 

	public function getEod($id)

	{

		$response = array();

		$main_eod = \App\MainEod::where('id',$id)->with('sub_eods')->first();

		if(is_null($main_eod)){

			$response['flag'] = false;

			$response['error'] = "No found";

		}else{

			$response['flag'] = true;

			$response['main_eod'] = $main_eod;

		}

		return response()->json($response);

	}

	public function getSubEod($id)

	{

		$response = array();

		$sub_eod = \App\SubEod::where('id',$id)->first();

		if(is_null($sub_eod)){

			$response['flag'] = false;

			$response['error'] = "No EOD found";

		}else{

			$response['flag'] = true;

			$response['sub_eod'] = $sub_eod;

		}

		return response()->json($response);

	}



	public function getProject($id)

	{

		$response = array();

		$project = \App\Project::where('id',$id)->first();

		if(is_null($project)){

			$response['flag'] = false;

			$response['error'] = "No Project found";

		}else{

			$response['flag'] = true;

			$response['project'] = $project;

		}

		return response()->json($response);

	}
	Public function getSystemNameBySystemType($system_type_id,$asset_type_id)
		  { 
				  	$response = array();
                     session(['asset_type_id_sess' => $asset_type_id]);
				  	if($system_type_id == 3){//dd($asset_type_id);
						    $systems  = \App\System::whereNotIn('id', function($query) {//dd(session($asset_type_id));
						    $query->select('system_id')
						    ->from('system_assets')
						    ->where('asset_type_id','=',session('asset_type_id_sess'));
						      })->get();

								 
									
						if($systems->count() == 0 ){

				$response['flag'] = false;

				$response['error'] = "No System found";

			}else{

				$response['flag'] = true;

				$response['systems'] = $systems;

			}	

						//print_r($response);		
				    return response()->json($response);
		     
		          }

            	if($system_type_id == 4){
				    $systems  = \App\SystemLaptop::whereNotIn('id', function($query) {
				    $query->select('system_id')
				    ->from('system_asset_laptops')
				    ->where('asset_type_id', '=', session('asset_type_id_sess'));
				      })->get();
                
						if($systems->count() == 0 ){

						$response['flag'] = false;

						$response['error'] = "No System found";

					    }else{

						$response['flag'] = true;

						$response['systems'] = $systems;

					  }	
					   return response()->json($response);
				     
				           }
			  	if($system_type_id == 5){
						    $systems  = \App\SystemMacMini::whereNotIn('id', function($query) {
						    $query->select('system_id')
						    ->from('system_asset_mac_minis')
						    ->where('asset_type_id', '=', session('asset_type_id_sess'));
						      })->get();
		                
						if($systems->count() == 0 ){

				$response['flag'] = false;

				$response['error'] = "No System found";

			}else{

				$response['flag'] = true;

				$response['systems'] = $systems;

			}		   
				    return response()->json($response);
		     
		            }
		              	if($system_type_id == 6){
						    $systems  = \App\SystemIMac::whereNotIn('id', function($query) {
						    $query->select('system_id')
						    ->from('system_asset_i_macs')
						    ->where('asset_type_id', '=', session('asset_type_id_sess'));
						      })->get();

						
						if($systems->count() == 0 ){

				$response['flag'] = false;

				$response['error'] = "No System found";

			}else{

				$response['flag'] = true;

				$response['systems'] = $systems;

			}			    
				    return response()->json($response);
		     
		  }
		}

}