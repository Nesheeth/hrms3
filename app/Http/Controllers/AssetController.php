<?php







namespace App\Http\Controllers;







use Illuminate\Http\Request;

use App\AttendanceData;

use Carbon\Carbon;

use DB;

use Auth;







class AssetController extends Controller



{



	public function getMasterAssetCode($master_id)



	{



		$master_system = \App\MasterAsset::where('id',$master_id)->first();



		$system_code = $master_system->system_code;



		return $system_code;



	} 



	public function getMasterSystem($master_id)



	{



		$master_system = \App\MasterAsset::where('id',$master_id)->first();



		return $master_system;



	} 



	public function getAssetAssoc($asset_id)



	{



		$asset_assoc = \App\AssetAssoc::where('id',$asset_id)->first();



		return $asset_assoc;



	} 

     public function all_assets()



	{



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$data['systems'] = $systems;



		$data['asset_types'] = $asset_types;



		return view('admin.asset.all_assets',$data);



	} 

       public function getEditMonitor($id)



	{



		$asset = \App\Monitor::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-monitor',$data);



		}



	} 

     public function postEditMonitor(Request $request){

     	//dd($request->all());

		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Monitor::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;
			if($request->asset_comment){
				$asset->comment = $request->asset_comment;
			}else{
				$asset->comment = null;
			}

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',1)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',1)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}   

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditKeyboard($id)



	{



		$asset = \App\Keyboard::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-keyboard',$data);



		}



	} 

     public function postEditKeyboard(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Keyboard::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			if($request->asset_comment){
				$asset->comment = $request->asset_comment;
			}else{
				$asset->comment = null;
			}
			

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',2)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',2)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}   

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	

	public function getEditCabinet($id)



	{



		$asset = \App\Cabinet::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-cabinet',$data);



		}



	} 

     public function postEditCabinet(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Cabinet::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;
			if($request->asset_comment){
				$asset->comment = $request->asset_comment;
			}else{
				$asset->comment = null;
			}

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',4)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',4)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditAc($id)



	{



		$asset = \App\Ac::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-ac',$data);



		}



	} 

     public function postEditAc(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Ac::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',27)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',27)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditAlmirah($id)



	{



		$asset = \App\Almirah::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-almirah',$data);



		}



	} 

     public function postEditAlmirah(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Almirah::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

              if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',28)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',28)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditCamera($id)



	{



		$asset = \App\Camera::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-camera',$data);



		}



	} 

     public function postEditCamera(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Camera::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',21)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',21)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditChair($id)



	{



		$asset = \App\Chair::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-chair',$data);



		}



	} 

     public function postEditChair(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Chair::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',24)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',24)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}   

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditDesk($id)



	{



		$asset = \App\Desk::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-desk',$data);



		}



	} 

     public function postEditDesk(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Desk::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',25)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',25)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditDesktop($id)



	{



		$asset = \App\Desktop::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-desktop',$data);



		}



	} 

     public function postEditDesktop(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Desktop::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',11)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',11)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditDvr($id)



	{



		$asset = \App\Dvr::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-dvr',$data);



		}



	} 

     public function postEditDvr(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Dvr::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',20)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',20)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditFan($id)



	{



		$asset = \App\Fan::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;





			return view('admin.asset.edit_all_assets.edit-fan',$data);



		}



	} 

     public function postEditFan(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Fan::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

             if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',26)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',26)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}   

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditHdd($id)



	{



		$asset = \App\Hdd::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-hdd',$data);



		}



	} 

     public function postEditHdd(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Hdd::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',10)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',10)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditHeadphone($id)



	{



		$asset = \App\Headphone::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-headphone',$data);



		}



	} 

     public function postEditHeadphone(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Headphone::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',29)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',29)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditIMac($id)



	{



		$asset = \App\IMac::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-i_mac',$data);



		}



	} 

     public function postEditIMac(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\IMac::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',14)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',14)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	

	public function getEditLaptop($id)



	{



		$asset = \App\Laptop::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-laptop',$data);



		}



	} 

     public function postEditLaptop(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Laptop::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',12)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',12)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditMac_mini($id)



	{



		$asset = \App\MacMini::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();





		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-mac_mini',$data);



		}



	} 

     public function postEditMac_mini(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\MacMini::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',13)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',13)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}    

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditMotherboard($id)



	{



		$asset = \App\Motherboard::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-motherboard',$data);



		}



	} 

     public function postEditMotherboard(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Motherboard::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',5)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',5)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditMouse($id)



	{



		$asset = \App\Mouse::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-mouse',$data);



		}



	} 

     public function postEditMouse(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Mouse::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;
			if($request->asset_comment){
				$asset->comment = $request->asset_comment;
			}else{
				$asset->comment = null;
			}

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',3)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',3)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditNetwork_switch($id)



	{



		$asset = \App\NetworkSwitch::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-network_switch',$data);



		}



	} 

     public function postEditNetwork_switch(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\NetworkSwitch::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',15)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',15)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditPen_drive($id)



	{



		$asset = \App\PenDrive::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-pen_drive',$data);



		}



	} 

     public function postEditPen_drive(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\PenDrive::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',19)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',19)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditPrinter($id)



	{



		$asset = \App\Printer::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-printer',$data);



		}



	} 

     public function postEditPrinter(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Printer::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',23)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',23)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditProcesser($id)



	{



		$asset = \App\Processer::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-processer',$data);



		}



	} 

     public function postEditProcesser(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Processer::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',7)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',7)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditRam($id)



	{



		$asset = \App\Ram::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-ram',$data);



		}



	} 

     public function postEditRam(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Ram::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',6)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',6)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditRepeater($id)



	{



		$asset = \App\Repeater::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-repeater',$data);



		}



	} 

     public function postEditRepeater(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Repeater::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

            if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',17)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',17)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditRouter($id)



	{



		$asset = \App\Router::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-router',$data);



		}



	} 

     public function postEditRouter(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Router::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',16)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',16)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditSmps($id)



	{



		$asset = \App\Smps::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-smps',$data);



		}



	} 

     public function postEditSmps(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Smps::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',9)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',9)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}   

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditUps($id)



	{



		$asset = \App\Ups::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;





			return view('admin.asset.edit_all_assets.edit-ups',$data);



		}



	} 

     public function postEditUps(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Ups::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',18)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',18)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditUps_battery($id)



	{



		$asset = \App\UpsBattery::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-ups_battery',$data);



		}



	} 

     public function postEditUps_battery(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\UpsBattery::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',8)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',8)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}

	public function getEditWeb_cam($id)



	{



		$asset = \App\WebCam::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();

		$system_type = \App\MasterAsset::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;

			$data['system_type'] = $system_type;



			return view('admin.asset.edit_all_assets.edit-web_cam',$data);



		}



	} 

     public function postEditWeb_cam(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\WebCam::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }

		       if($request->purchase_from_store){

			$asset->purchase_from_store = $request->purchase_from_store;

		       }

		       





			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}

if($request->system_type_id == 3){

            $asset->system_code = 'DT'.'00'.$request->system_id;

            $table = "system_assets";

           }

           if($request->system_type_id == 4){

            $asset->system_code = 'LP'.'00'.$request->system_id;

             $table = "system_asset_laptops";

           }

           if($request->system_type_id == 5){

            $asset->system_code = 'MM'.'00'.$request->system_id;

             $table = "system_asset_mac_minis";

           }

           if($request->system_type_id == 6){

            $asset->system_code = 'IM'.'00'.$request->system_id;

             $table = "system_asset_i_macs";

           }

			$asset->status = $request->asset_status;

			$asset->last_editing_by =\Auth::user()->id;



			if($asset->save()){



				if($request->system_id){



					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',22)->first();



					if(is_null($system_asset)){

                        // $system_asset1 = DB::table($table);

					$system_asset =	DB::table($table)->insert(

                           ['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

					}

                    else{

					$system_asset =  DB::table($table)->where('asset_id','=',$request->id)->where('asset_type_id','=',22)->update(['system_id' => $request->system_id, 'asset_id' => $request->id,'asset_type_id' => $request->asset 

                

                       ]);

                    }

					



				}  

               

				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}





	public function assets(Request $request)



	{    if($request->asset == '1'){



        	$all_assets = \App\Monitor::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.monitor',$data);

        }

        if($request->asset == '2'){



        	$all_assets = \App\Keyboard::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.keyboard',$data);

        }

        if($request->asset == '3'){



        	$all_assets = \App\Mouse::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.mouse',$data);

        }

        if($request->asset == '4'){



        	$all_assets = \App\Cabinet::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.cabinet',$data);

        }

        if($request->asset == '5'){



        	$all_assets = \App\Motherboard::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.motherboard',$data);

        }

        if($request->asset == '6'){



        	$all_assets = \App\Ram::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.ram',$data);

        }

        if($request->asset == '7'){



        	$all_assets = \App\Processer::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.processer',$data);

        }

        if($request->asset == '8'){



        	$all_assets = \App\UpsBattery::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.ups_battery',$data);

        }

        if($request->asset == '9'){



        	$all_assets = \App\Smps::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.smps',$data);

        }

        if($request->asset == '10'){



        	$all_assets = \App\Hdd::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.hdd',$data);

        }

        if($request->asset == '11'){



        	$all_assets = \App\Desktop::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.desktop',$data);

        }

        if($request->asset == '12'){



        	$all_assets = \App\Laptop::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.laptop',$data);

        }

        if($request->asset == '13'){



        	$all_assets = \App\MacMini::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.mac_mini',$data);

        }

        if($request->asset == '14'){



        	$all_assets = \App\IMac::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.i_mac',$data);

        }

        if($request->asset == '15'){



        	$all_assets = \App\NetworkSwitch::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.network_switch',$data);

        }

        if($request->asset == '16'){



        	$all_assets = \App\Router::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.router',$data);

        }

        if($request->asset == '17'){



        	$all_assets = \App\Repeater::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.repeater',$data);

        }

        if($request->asset == '18'){



        	$all_assets = \App\Ups::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.ups',$data);

        }

        if($request->asset == '19'){



        	$all_assets = \App\PenDrive::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.pen_drive',$data);

        }

        if($request->asset == '20'){



        	$all_assets = \App\Dvr::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.dvr',$data);

        }

        if($request->asset == '21'){



        	$all_assets = \App\Camera::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.camera',$data);

        }

        

        if($request->asset == '22'){



        	$all_assets = \App\WebCam::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.web_cam',$data);

        }

        if($request->asset == '23'){



        	$all_assets = \App\Printer::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.printer',$data);

        }

        if($request->asset == '24'){



        	$all_assets = \App\Chair::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.chair',$data);

        }

        if($request->asset == '25'){



        	$all_assets = \App\Desk::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.desk',$data);

        }

        if($request->asset == '26'){



        	$all_assets = \App\Fan::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.fan',$data);

        }

        if($request->asset == '27'){



        	$all_assets = \App\AC::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.ac',$data);

        }

        if($request->asset == '28'){



        	$all_assets = \App\Almirah::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.almirah',$data);

        }

        if($request->asset == '29'){



        	$all_assets = \App\Headphone::with('asset_type','master_asset','asset')->get();



		$data['assets'] = $all_assets;

		$data['assets_id'] = $request->asset;



		return view('admin.asset.all_assets.headphone',$data);

        }

        

	} 



	public function getAddAsset()



	{



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$data['systems'] = $systems;



		$data['asset_types'] = $asset_types;



		return view('admin.asset.create',$data);



	} 



	public function postAddAsset(Request $request){
		//dd($request->all());


		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect('/admin/add-asset')



			->withErrors($validator)



			->withInput();



		}



		else



		{



			if($request->asset == '1'){

            

		       $asset =  new \App\Monitor();



				$asset_assoc = $this->getAssetAssoc($request->asset);

				 // $asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;

				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}

            

			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

			$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;



			if($asset->save()){ 



				$updated_asset =   \App\Monitor::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id; 

				// $updated_asset->asset_code =   'MN145'; 

				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

                    $system_asset->asset_type_id =$request->asset;

					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

            if($request->asset == '2'){

            

		       $asset =  new \App\Keyboard();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Keyboard::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '3'){

            

		       $asset =  new \App\Mouse();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Mouse::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

           if($request->asset == '4'){

            

		       $asset =  new \App\Cabinet();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Cabinet::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '5'){

            

		       $asset =  new \App\Motherboard();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Motherboard::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '6'){

            

		       $asset =  new \App\Ram();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Ram::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '7'){

            

		       $asset =  new \App\Processer();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Processer::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '8'){

            

		       $asset =  new \App\UpsBattery();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\UpsBattery::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '9'){

            

		       $asset =  new \App\Smps();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\SMPS::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '10'){

            

		       $asset =  new \App\Hdd();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Hdd::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '11'){

            

		       $asset =  new \App\Desktop();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;

				

			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Desktop::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '12'){

            

		       $asset =  new \App\Laptop();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Laptop::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '13'){

            

		       $asset =  new \App\MacMini();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\MacMini::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '14'){

            

		       $asset =  new \App\IMac();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\IMac::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '15'){

            

		       $asset =  new \App\NetworkSwitch();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\NetworkSwitch::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '16'){

            

		       $asset =  new \App\Router();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Router::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '17'){

            

		       $asset =  new \App\Repeater();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Repeater::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '18'){

            

		       $asset =  new \App\Ups();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Ups::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '19'){

            

		       $asset =  new \App\PenDrive();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\PenDrive::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '20'){

            

		       $asset =  new \App\Dvr();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Dvr::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '21'){

            

		       $asset =  new \App\Camera();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;
				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;


			if($asset->save()){ 



				$updated_asset =   \App\Camera::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '22'){

            

		       $asset =  new \App\WebCam();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\WebCam::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '23'){

            

		       $asset =  new \App\Printer();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;



			if($asset->save()){ 



				$updated_asset =   \App\Printer::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '24'){

            

		       $asset =  new \App\Chair();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;



			if($asset->save()){ 



				$updated_asset =   \App\Chair::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '25'){

            

		       $asset =  new \App\Desk();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;

				$asset->asset_code = $asset_assoc->asset_assoc_code.$asset->id;

			if($asset->save()){ 



				$updated_asset =   \App\Desk::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '26'){

            

		       $asset =  new \App\Fan();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;



			if($asset->save()){ 



				$updated_asset =   \App\Fan::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '27'){

            

		       $asset =  new \App\AC();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;



			if($asset->save()){ 



				$updated_asset =   \App\AC::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '28'){

            

		       $asset =  new \App\Almirah();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;



			if($asset->save()){ 



				$updated_asset =   \App\Almirah::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		   if($request->asset == '29'){

            

		       $asset =  new \App\Headphone();



				$asset_assoc = $this->getAssetAssoc($request->asset);



				$asset->asset_type_id = $request->asset_type;



				$asset->asset_id = $request->asset;



				$asset->name = $asset_assoc->name;

				$asset->last_editing_by = \Auth::user()->id;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}

			if($request->purchase_from_store){



				$asset->purchase_from_store	= $request->purchase_from_store;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->warranty_end_date){



				$asset->warranty_end_date = $request->warranty_end_date;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}



			$asset->status = $request->asset_status;

				$asset->last_editing_by = \Auth::user()->id;



			if($asset->save()){ 



				$updated_asset =   \App\Headphone::find($asset->id);



				$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



				$updated_asset->save();



				if($request->system_id){



					$system_asset = new \App\SystemAsset();



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id =$asset->id;

					$system_asset->asset_type_id =$request->asset;



					$system_asset->save();



				}

                

				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}







             







		   }

		





}

	}







	public function getEditAsset($id)



	{



		$asset = \App\Asset::where('id',$id)->first();



		$asset_types = \App\AssetType::all();



		$systems = \App\System::all();



		$asset_assocs = \App\AssetAssoc::all();



		



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error',"asset Not found");



		}else{



			$data['asset'] = $asset;



			$data['systems'] = $systems;



			$data['asset_types'] = $asset_types;



			$data['asset_assocs'] = $asset_assocs;



			return view('admin.asset.edit-asset',$data);



		}



	} 



	public function postEditAsset(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'asset' =>'required',



				'asset_status' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect()->back()



			->withErrors($validator)



			->withInput();



		}



		else



		{



			$asset =  \App\Asset::find($request->id);



			$asset_assoc = $this->getAssetAssoc($request->asset);



			$asset->asset_type_id = $request->asset_type;



			$asset->asset_id = $request->asset;



			$asset->name = $asset_assoc->name;

			if($request->description){

			$asset->descriptions = $request->description;

		       }



			if($request->s_no){



				$asset->s_no = $request->s_no;



			}else{



				$asset->s_no = null;



			}



			if($request->purchase_bill_date){



				$asset->purchase_bill_date = $request->purchase_bill_date;



			}else{



				$asset->purchase_bill_date = null;



			}



			if($request->repair_replacement_date){



				$asset->repair_replacement_date = $request->repair_replacement_date;



			}else{



				$asset->repair_replacement_date = null;



			}



			$asset->is_warranty = $request->is_warranty;



			if($request->is_warranty){



				if($request->warranty_end_date){



					$asset->warranty_end_date = $request->warranty_end_date;



				}else{



					$asset->warranty_end_date = null;



				}



			}else{



				$asset->warranty_end_date = null;



			}



			if($request->system_id){



				$asset->system_id = $request->system_id;



			}else{



				$asset->system_id = null;



			}



			$asset->status = $request->asset_status;

		  $asset->last_editing_by =\Auth::user()->id;

          //  dd($asset->last_editing_by);

			if($asset->save()){



				if($request->system_id){



					$system_asset =  \App\SystemAsset::where('asset_id',$request->id)->first();



					if(is_null($system_asset)){



						$system_asset =  new \App\SystemAsset();



					}



					$system_asset->system_id = $request->system_id;



					$system_asset->asset_id = $request->id;



					$system_asset->save();



				}



				return redirect('/admin/assets')->with('success',"Updated Successfully");



			}else{



				return redirect('/admin/assets')->with('error',"Something Went Wrong.");



			}



		}



	}



   public function all_systems()



	{



		$asset_types = \App\AssetType::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		$data['employees'] = $employees;



		$data['asset_types'] = $asset_types;



		return view('admin.asset.all_system',$data);



	}



	public function releaseAsset($id)



	{



		$asset = \App\Asset::find($id);



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error','Asset Not Found');



		}else{



			$asset->user_id = NULL;



			$asset->status = "free";



			if($asset->save()){



				return redirect('/admin/assets')->with('success','asset is Released Now.');



			}else{



				return redirect('/admin/assets')->with('error','Something Went Wrong');



			}



		}



	}



	public function deleteAsset($id)



	{



		$asset = \App\Asset::find($id);



		if(is_null($asset)){



			return redirect('/admin/assets')->with('error','asset Not Found');



		}else{



			if($asset->delete()){



				return redirect('/admin/assets')->with('success','asset Removed Successfully.');



			}else{



				return redirect('/admin/assets')->with('error','Something Went Wrong');



			}



		}



	}



	public function systems(Request $request)

     {

        if($request->system_name == 3){



		$systems = \App\System::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();




		$data['systems'] = $systems;
//print_r($data['systems']);die();


		return view('admin.asset.all_systems.desktop',$data);



	}

	if($request->system_name == 4){

		$systems = \App\SystemLaptop::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		$data['systems'] = $systems;



		return view('admin.asset.all_systems.laptop',$data);



	}

	 if($request->system_name == 5){

		$systems = \App\SystemMacMini::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		$data['systems'] = $systems;



		return view('admin.asset.all_systems.mac_mini',$data);



	}

	if($request->system_name == 6){

		$systems = \App\SystemIMac::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		$data['systems'] = $systems;



		return view('admin.asset.all_systems.i_mac',$data);



	}

	else{



		$systems = \App\System::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		$data['systems'] = $systems;



		return view('admin.asset.systems',$data);



	} 

}



	public function getAddSystem()



	{



		$asset_types = \App\AssetType::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		$data['employees'] = $employees;



		$data['asset_types'] = $asset_types;



		return view('admin.asset.create-system',$data);



	} 



	public function postAddSystem(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'asset_type' =>'required',



				'system_name' =>'required',



			)



		);



		if($validator->fails())



		{



			return redirect('/admin/add-system')



			->withErrors($validator)



			->withInput();



		}



		else



		{



			 if($request->system_name == 3){



              $system =  new \App\System();



			$master_system = $this->getMasterSystem($request->system_name);



			$system->master_system_id = $request->system_name;



			$system->asset_type_id = $request->asset_type;



			$system->name = $master_system->name;

            





			$system->last_updated_by = \Auth::user()->id;



			if($request->assign_to){



				$system->assign_to = $request->assign_to;



			}

           //  print_r($system);

			if($system->save()){ 



				$updated_system =   \App\System::find($system->id);

                  // $updated_system->system_id = $request->system_code;

				 $updated_system->system_id = $master_system->asset_code.'00'.$system->id;

                  

				



				$updated_system->save();



				/*---------------------------------Send notification--------------------------*/



				if($request->assign_to){



					$receiver = array($request->assign_to);



					$title = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					$message = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



					$admin_receiver = array();



					$admins = \App\User::where('role','1')->get();



					foreach ($admins as $admin) {



						array_push($admin_receiver,$admin->id);



					}



					$title1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					$message1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					NotificationController::notify(\Auth::user()->id,$admin_receiver,$title1,$message1);







				}



				/*---------------------------------Send notification--------------------------*/







              // print_r($system);



				return redirect('/admin/system/'.$system->id.'/'.$request->system_name)->with('success',"Added Successfully.");



			}else{



				return redirect('/admin/systems')->with('error',"Something Went Wrong.");



			}







            }

            if($request->system_name == 4){



              $system =  new \App\SystemLaptop();



			$master_system = $this->getMasterSystem($request->system_name);



			$system->master_system_id = $request->system_name;



			$system->asset_type_id = $request->asset_type;



			$system->name = $master_system->name;

            





			$system->last_updated_by = \Auth::user()->id;



			if($request->assign_to){



				$system->assign_to = $request->assign_to;



			}

           //  print_r($system);

			if($system->save()){ 



				$updated_system =   \App\SystemLaptop::find($system->id);

                  // $updated_system->system_id = $request->system_code;

				 $updated_system->system_id = $master_system->asset_code.'00'.$system->id;

                  

				



				$updated_system->save();



				/*---------------------------------Send notification--------------------------*/



				if($request->assign_to){



					$receiver = array($request->assign_to);



					$title = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					$message = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



					$admin_receiver = array();



					$admins = \App\User::where('role','1')->get();



					foreach ($admins as $admin) {



						array_push($admin_receiver,$admin->id);



					}



					$title1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					$message1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					NotificationController::notify(\Auth::user()->id,$admin_receiver,$title1,$message1);







				}



				/*---------------------------------Send notification--------------------------*/











				return redirect('/admin/system/'.$system->id.'/'.$request->system_name)->with('success',"Added Successfully.");



			}else{



				return redirect('/admin/systems')->with('error',"Something Went Wrong.");



			}







            }

            if($request->system_name == 5){



              $system =  new \App\SystemMacMini();



			$master_system = $this->getMasterSystem($request->system_name);



			$system->master_system_id = $request->system_name;



			$system->asset_type_id = $request->asset_type;



			$system->name = $master_system->name;

            





			$system->last_updated_by = \Auth::user()->id;



			if($request->assign_to){



				$system->assign_to = $request->assign_to;



			}

           //  print_r($system);

			if($system->save()){ 



				$updated_system =   \App\SystemMacMini::find($system->id);

                  // $updated_system->system_id = $request->system_code;

				 $updated_system->system_id = $master_system->asset_code.'00'.$system->id;

                  

				



				$updated_system->save();



				/*---------------------------------Send notification--------------------------*/



				if($request->assign_to){



					$receiver = array($request->assign_to);



					$title = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					$message = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



					$admin_receiver = array();



					$admins = \App\User::where('role','1')->get();



					foreach ($admins as $admin) {



						array_push($admin_receiver,$admin->id);



					}



					$title1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					$message1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					NotificationController::notify(\Auth::user()->id,$admin_receiver,$title1,$message1);







				}



				/*---------------------------------Send notification--------------------------*/











				return redirect('/admin/system/'.$system->id.'/'.$request->system_name)->with('success',"Added Successfully.");



			}else{



				return redirect('/admin/systems')->with('error',"Something Went Wrong.");



			}







            }

            if($request->system_name == 6){



              $system =  new \App\SystemIMac();



			$master_system = $this->getMasterSystem($request->system_name);



			$system->master_system_id = $request->system_name;



			$system->asset_type_id = $request->asset_type;



			$system->name = $master_system->name;

            





			$system->last_updated_by = \Auth::user()->id;



			if($request->assign_to){



				$system->assign_to = $request->assign_to;



			}

           //  print_r($system);

			if($system->save()){ 



				$updated_system =   \App\SystemIMac::find($system->id);

                  // $updated_system->system_id = $request->system_code;

				 $updated_system->system_id = $master_system->asset_code.'00'.$system->id;

                  

				



				$updated_system->save();



				/*---------------------------------Send notification--------------------------*/



				if($request->assign_to){



					$receiver = array($request->assign_to);



					$title = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					$message = getRoleStr()." Assigned You System"." ".$updated_system->system_id;



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



					$admin_receiver = array();



					$admins = \App\User::where('role','1')->get();



					foreach ($admins as $admin) {



						array_push($admin_receiver,$admin->id);



					}



					$title1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					$message1 = getRoleStr()." Assigned System"." ".$updated_system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



					NotificationController::notify(\Auth::user()->id,$admin_receiver,$title1,$message1);







				}



				/*---------------------------------Send notification--------------------------*/











				return redirect('/admin/system/'.$system->id.'/'.$request->system_name)->with('success',"Added Successfully.");



			}else{



				return redirect('/admin/systems')->with('error',"Something Went Wrong.");



			}







            }



}



	}







	public function getEditSystem($id,$master_system_id)  

        

	{  

         if($master_system_id == 3){



         	$system = \App\System::where('id',$id)->first();

         

		$asset_types = \App\AssetType::all();



		$system_names = \App\MasterAsset::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		if(is_null($system)){



			return redirect('/admin/systems')->with('error',"system Not found");



		}else{



			$data['system'] = $system;



			$data['employees'] = $employees;



			$data['asset_types'] = $asset_types;



			$data['system_names'] = $system_names;

           //  print_r($data['system']);

			return view('admin.asset.edit-system',$data);



		}



	}

      if($master_system_id == 4){



         	$system = \App\SystemLaptop::where('id',$id)->first();

         

		$asset_types = \App\AssetType::all();



		$system_names = \App\MasterAsset::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		if(is_null($system)){



			return redirect('/admin/systems')->with('error',"system Not found");



		}else{



			$data['system'] = $system;



			$data['employees'] = $employees;



			$data['asset_types'] = $asset_types;



			$data['system_names'] = $system_names;

           //  print_r($data['system']);

			return view('admin.asset.edit_all_systems.edit_laptop',$data);



		}



	}

	 if($master_system_id == 5){



         	$system = \App\SystemMacMini::with('assets')->where('id',$id)->first();

         

		$asset_types = \App\AssetType::all();



		$system_names = \App\MasterAsset::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		if(is_null($system)){



			return redirect('/admin/systems')->with('error',"system Not found");



		}else{



			$data['system'] = $system;



			$data['employees'] = $employees;



			$data['asset_types'] = $asset_types;



			$data['system_names'] = $system_names;

           //  print_r($data['system']);

			return view('admin.asset.edit_all_systems.edit_mac_mini',$data);



		}



	}

	 if($master_system_id == 6){



         	$system = \App\SystemIMac::where('id',$id)->first();

         

		$asset_types = \App\AssetType::all();



		$system_names = \App\MasterAsset::all();



		$employees = \App\User::where('role','!=',1)->with('personal_profile','cb_profile')->get();



		if(is_null($system)){



			return redirect('/admin/systems')->with('error',"system Not found");



		}else{



			$data['system'] = $system;



			$data['employees'] = $employees;



			$data['asset_types'] = $asset_types;



			$data['system_names'] = $system_names;

           //  print_r($data['system']);

			return view('admin.asset.edit_all_systems.edit_i_mac',$data);



		}



	}



		}



	public function postEditSystem(Request $request){

       // dd(Auth::user()->id);

		if($request->master_asset_id == 3){$system =  \App\System::find($request->id);}

        if($request->master_asset_id == 4){$system =  \App\SystemLaptop::find($request->id);}

        if($request->master_asset_id == 5){$system =  \App\SystemMacMini::find($request->id);}

        if($request->master_asset_id == 6){$system =  \App\SystemIMac::find($request->id);}

		

		$old_owner = $system->assign_to;



		if($request->assign_to){



			$system->assign_to = $request->assign_to;



		}else{



			$system->assign_to = null;



		}

        $system->last_updated_by = \Auth::user()->id;

       

		if($system->save()){



			/*---------------------------------Send notification--------------------------*/



			if($request->assign_to && $request->assign_to != $old_owner){



				$receiver = array($request->assign_to);

				
				
					$title = getRoleStr()." Assigned You System"." ".$system->system_id;
					$message = getRoleStr()." Assigned You System"." ".$system->system_id;
				
				



				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);







				if(!is_null($old_owner)){



					$old_receiver = array($old_owner);



					$old_title = getRoleStr()." Released Your System"." ".$system->system_id;



					$old_message = getRoleStr()." Released Your System"." ".$system->system_id;



					NotificationController::notify(\Auth::user()->id,$old_receiver,$old_title,$old_message);



				}



				$admin_receiver = array();



				$admins = \App\User::where('role','1')->get();



				foreach ($admins as $admin) {



					array_push($admin_receiver,$admin->id);



				}



				$title1 = getRoleStr()." Assigned System"." ".$system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



				$message1 = getRoleStr()." Assigned System"." ".$system->system_id ." to ".getUserById($request->assign_to)->first_name.' '.getUserById($request->assign_to)->last_name;



				NotificationController::notify(\Auth::user()->id,$admin_receiver,$title1,$message1);







			}



			if(is_null($system->assign_to) && !is_null($old_owner) ){

             

				$receiver = array($old_owner);

                //print_r($receiver);

				$title = getRoleStr()." Released Your System"." ".$system->system_id;



				$message = getRoleStr()." Released Your System"." ".$system->system_id;



				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);







				$admin_receiver = array();



				$admins = \App\User::where('role','1')->get();



				foreach ($admins as $admin) {



					array_push($admin_receiver,$admin->id);



				}



				$title1 = getRoleStr()." Released System"." ".$system->system_id ." from ".getUserById($old_owner)->first_name.' '.getUserById($old_owner)->last_name;



				$message1 = getRoleStr()." Released System"." ".$system->system_id ." from ".getUserById($old_owner)->first_name.' '.getUserById($old_owner)->last_name;



				NotificationController::notify(\Auth::user()->id,$admin_receiver,$title1,$message1);







			}







			/*---------------------------------Send notification--------------------------*/



			return redirect('/admin/system/'.$system->id.'/'.$request->master_asset_id)->with('success',"Updated Successfully");



		}else{



			return redirect('/admin/system/'.$system->id.'/'.$request->master_asset_id)->with('error',"Something Went Wrong.");



		}



	}



	public function releaseSystemAsset($system_id,$id,$asset_type_id,$master_asset_id){

		if($master_asset_id == 3){$systemAsset = \App\SystemAsset::find($id);}

		if($master_asset_id == 4){$systemAsset = \App\SystemAssetLaptop::find($id);}

         if($master_asset_id == 5){$systemAsset = \App\SystemAssetMacMini::find($id);}

         if($master_asset_id == 6){$systemAsset = \App\SystemAssetIMac::find($id);}

		



		if(is_null($systemAsset)){



			return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('error','Association Not Found');



		}else{



			if($systemAsset->delete()){

                if($asset_type_id == 1){

                 $asset = \App\Monitor::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 2){

                 $asset = \App\Keyboard::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 3){

                 $asset = \App\Mouse::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 4){

                 $asset = \App\Cabinet::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 5){

                 $asset = \App\Motherboard::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 6){

                 $asset = \App\Ram::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 7){

                 $asset = \App\Processer::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 8){

                 $asset = \App\UpsBattery::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 9){

                 $asset = \App\Smps::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 10){

                 $asset = \App\Hdd::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 11){

                 $asset = \App\Desktop::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 12){

                 $asset = \App\Laptop::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 13){

                 $asset = \App\MacMini::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 14){

                 $asset = \App\IMac::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 15){

                 $asset = \App\NetworkSwitch::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 16){

                 $asset = \App\Router::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 17){

                 $asset = \App\Repeater::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 18){

                 $asset = \App\Ups::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 19){

                 $asset = \App\PenDrive::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 20){

                 $asset = \App\Dvr::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 21){

                 $asset = \App\Camera::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 22){

                 $asset = \App\WebCam::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 23){

                 $asset = \App\Printer::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 24){

                 $asset = \App\Chair::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 25){

                 $asset = \App\Desk::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 26){

                 $asset = \App\Fan::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 27){

                 $asset = \App\AC::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 28){

                 $asset = \App\Almirah::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

                if($asset_type_id == 29){

                 $asset = \App\Headphone::where('id',$systemAsset->asset_id)->first();



				$asset->system_id =  null;



				$asset->status =  "free";



				$asset->save();



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('success','Asset Release Successfully.');



                }

               

                

			}else{



				return redirect('/admin/system/'.$system_id.'/'.$master_asset_id)->with('error','Something Went Wrong');



			}



		}



	}









	public function exportAssetExcel()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Asset::select('id as Id','asset_code as Asset Code','name as Name','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}



	public function exportSystemExcel()



	{



		$systemExcel = \App\System::select('id as System Id','system_id as Unique Id','name as System Name','status as Status of system','assign_to as Assign employee' )->get();



		\Excel::create('System Lists', function($excel) use($systemExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($systemExcel) {



				$sheet->fromArray($systemExcel);



			});







		})->export('xls');



	}



	public function importAssetExcel(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{

        

			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($st)



					{  

						 //foreach($sheet as $st ){



  						$asset = \App\Asset::find($st['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Asset();



							$new = true;



						}

                      

						$asset_assoc = $this->getAssetAssoc($st['asset_id']);



						$asset->asset_type_id = $st['asset_type_id'];



						$asset->asset_id = $st['asset_id'];



						$asset->name = $asset_assoc['name'];



						if($st['s_no']){



							$asset->s_no = $st['s_no'];



						}



						if($st['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($st['purchase_bill_date'])->format('Y-m-d');



						}



						if($st['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($st['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $st['is_warranty'];



						$asset->last_editing_by = \Auth::user()->id;





						if($st['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($st['warranty_end_date'])->format('Y-m-d');



						}

						if($st['descriptions'])

						{

							$asset->descriptions   =  $st['descriptions'];

						}



						if($st['system_id']){



							$asset->system_id = $st['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Asset::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.'00'.$asset->id;



								$updated_asset->save();



								if($st['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $st['system_id'];



									$system_asset->asset_id = $asset->id;



									$system_asset->save();



								}



							}



						} 

                      //}

					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}



			return response()->json($response);



		}



	}

	 public function exportAssetExcelMonitor()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Monitor::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelAc()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Ac::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelAlmirah()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Almirah::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelCabinet()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Cabinet::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelChair()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Chair::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelDesk()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Desk::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelDesktop()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Desktop::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelDvr()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Dvr::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelFan()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Fan::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelHdd()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Hdd::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelHeadphone()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Headphone::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelImac()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\IMac::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelKeyboard()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Keyboard::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelLaptop()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Laptop::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelMac_mini()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\MacMini::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelMotherboard()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Motherboard::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelMouse()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Mouse::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelNetwork_switch()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\NetworkSwitch::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelPen_drive()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\PenDrive::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelPrinter()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Printer::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelProcesser()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Processer::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelRam()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Ram::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelRepeater()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Repeater::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelRouter()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Router::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelSmps()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Smps::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelUps()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\Ups::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelUps_battery()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\UpsBattery::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	public function exportAssetExcelWeb_cam()



	{



		$userExcel = \App\User::select('id as User Id','first_name as First Name','last_name as Last Name')->get();



		$assetExcel = \App\WebCam::select('id as Id','s_no as S.No','purchase_bill_date as Purchase/Bill date','is_warranty as Warranty','warranty_end_date as Warranty End Date','system_id as System Id','asset_type_id as Asset type id','asset_id as Asset id','repair_replacement_date as Repair replacement date','descriptions as Descriptions','purchase_from_store as Purchase from store','status as Status')->get();



		$assetTypeExcel = \App\AssetType::select('id as Asset Type Id','type as Asset Type')->get();



		$AssetAssocExcel = \App\AssetAssoc::select('id as Asset Id','name as Asset Name')->get();



		\Excel::create('Asset Lists', function($excel) use($assetExcel,$assetTypeExcel,$AssetAssocExcel,$userExcel) {



			$excel->sheet('Sheet 1', function($sheet) use($assetExcel) {



				$sheet->fromArray($assetExcel);



			});



			$excel->sheet('Asset Type', function($sheet) use($assetTypeExcel) {



				$sheet->fromArray($assetTypeExcel);



			});



			$excel->sheet('Assets Assoc', function($sheet) use($AssetAssocExcel) {



				$sheet->fromArray($AssetAssocExcel);



			});



			$excel->sheet('Users', function($sheet) use($userExcel) {



				$sheet->fromArray($userExcel);



			});



		})->export('xls');



	}

	 public function importAssetExcel_monitor(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){

                        

						$asset = \App\Monitor::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Monitor();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Monitor::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

    public function importAssetExcel_ac(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\AC::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\AC();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Ac::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

   public function importAssetExcel_almirah(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Almirah::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Almirah();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Almirah::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_cabinet(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Cabinet::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Cabinet();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Cabinet::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

    public function importAssetExcel_camera(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Camera::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Camera();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Camera::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_chair(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){

                         //print_r($sheet);

						$asset = \App\Chair::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Chair();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');

                     // $asset->purchase_bill_date = date('m/d/Y',strtotime($sheet['purchase_bill_date']));

						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Chair::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

            // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_desk(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Desk::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Desk();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Desk::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_desktop(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Desktop::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Desktop();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Desktop::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_dvr(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Dvr::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Dvr();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Dvr::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_fan(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Fan::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Fan();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Fan::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_hdd(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Hdd::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Hdd();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Hdd::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_headphone(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Headphone::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Headphone();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Headphone::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_i_mac(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\IMac::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\IMac();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\IMac::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_keyboard(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){

                        //print_r($sheet);

						$asset = \App\Keyboard::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Keyboard();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Keyboard::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_laptop(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Laptop::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Laptop();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Laptop::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_mac_mini(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\MacMini::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\MacMini();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\MacMini::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_motherboard(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Motherboard::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Motherboard();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Motherboard::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_mouse(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)

                  

					{  // foreach($sheet as $sheet ){

                          

						$asset = \App\Mouse::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Mouse();



							$new = true;



						}

                        

						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Mouse::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

              //print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_network_switch(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\NetworkSwitch::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\NetworkSwitch();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\NetworkSwitch::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_pen_drive(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\PenDrive::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\PenDrive();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\PenDrive::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_printer(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Printer::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Printer();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Printer::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_processer(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Processer::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Processer();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Processer::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_ram(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {

                   

					$reader->each(function ($sheet)

                   

					{  // foreach($sheet as $sheet ){

                        //print_r($sheet);

						$asset = \App\Ram::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Ram();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Ram::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

              // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_repeater(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Repeater::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Repeater();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Repeater::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_router(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Router::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Router();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Router::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_smps(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Smps::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Smps();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Smps::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_ups(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\Ups::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\Ups();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\Ups::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_ups_battery(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\UpsBattery::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\UpsBattery();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\UpsBattery::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function importAssetExcel_web_cam(Request $request)



	{



		$response = array();



		if($request->hasFile('assetFile'))



		{



			$extension = \File::extension($request->file('assetFile')->getClientOriginalName());



			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {



				\Excel::load($request->file('assetFile'), function($reader) {



					$reader->each(function ($sheet)



					{  // foreach($sheet as $sheet ){



						$asset = \App\WebCam::find($sheet['id']);



						$new = false;



						if(is_null($asset)){



							$asset = new \App\WebCam();



							$new = true;



						}



						$asset_assoc = $this->getAssetAssoc($sheet['asset_id']);



						$asset->asset_type_id = $sheet['asset_type_id'];



						$asset->asset_id = $sheet['asset_id'];



						$asset->name = $asset_assoc->name;



						if($sheet['s_no']){



							$asset->s_no = $sheet['s_no'];



						}



						if($sheet['purchase_bill_date']){



							$asset->purchase_bill_date = \Carbon\Carbon::parse($sheet['purchase_bill_date'])->format('Y-m-d');



						}



						if($sheet['repair_replacement_date']){



							$asset->repair_replacement_date = \Carbon\Carbon::parse($sheet['repair_replacement_date'])->format('Y-m-d');



						}



						$asset->is_warranty = $sheet['is_warranty'];

						if($sheet['descriptions'])

						{

							$asset->descriptions   =  $sheet['descriptions'];

						}

						if($sheet['purchase_from_store'])

						{

							$asset->purchase_from_store   =  $sheet['purchase_from_store'];

						}

                       $asset->last_editing_by = \Auth::user()->id; 

						if($sheet['warranty_end_date']){



							$asset->warranty_end_date = \Carbon\Carbon::parse($sheet['warranty_end_date'])->format('Y-m-d');



						}



						if($sheet['system_id']){



							$asset->system_id = $sheet['system_id'];



							$asset->status = "assigned"; 



						}else{



							$asset->system_id = null;



							$asset->status = "free"; 



						}



						if($asset->save()){



							if($new){



								$updated_asset =   \App\WebCam::find($asset->id);



								$updated_asset->asset_code =   $asset_assoc->asset_assoc_code.$asset->id;



								$updated_asset->save();



								if($sheet['system_id']){



									$system_asset = new \App\SystemAsset();



									$system_asset->system_id = $sheet['system_id'];



									$system_asset->asset_id = $asset->id;

									$system_asset->asset_type_id = $asset->asset_id;



									$system_asset->save();



								}



							}



						//} 

					}



					});



				});



				$response['flag'] = true;



				$response['message'] = "Uploaded Successfully.";



			}else {



				$response['flag'] = false;



				$response['error'] = 'Invalid file';



			}

             // print_r($response);

			return response()->json($response);



		}



	}

	public function exportSystemIMacExcel()



	{



		$systemExcel = \App\SystemIMac::select('id as System Id','system_id as Unique Id','name as System Name','assign_to as Assign To')->get();

		\Excel::create('System Lists', function($excel) use($systemExcel) {

			$excel->sheet('Sheet 1', function($sheet) use($systemExcel) {

				$sheet->fromArray($systemExcel);

			});

		})->export('xls');

	}

	public function exportSystemDesktopExcel()



	{



		$systemExcel = \App\System::select('id as System Id','system_id as Unique Id','name as System Name','assign_to as Assign To')->get();

		\Excel::create('System Lists', function($excel) use($systemExcel) {

			$excel->sheet('Sheet 1', function($sheet) use($systemExcel) {

				$sheet->fromArray($systemExcel);

			});

		})->export('xls');

	}

	public function exportSystemLaptopExcel()



	{



		$systemExcel = \App\SystemLaptop::select('id as System Id','system_id as Unique Id','name as System Name','assign_to as Assign To')->get();

		\Excel::create('System Lists', function($excel) use($systemExcel) {

			$excel->sheet('Sheet 1', function($sheet) use($systemExcel) {

				$sheet->fromArray($systemExcel);

			});

		})->export('xls');

	}

	public function exportSystemMacMiniExcel()



	{



		$systemExcel = \App\SystemMacMini::select('id as System Id','system_id as Unique Id','name as System Name','assign_to as Assign To')->get();

		\Excel::create('System Lists', function($excel) use($systemExcel) {

			$excel->sheet('Sheet 1', function($sheet) use($systemExcel) {

				$sheet->fromArray($systemExcel);

			});

		})->export('xls');

	}









}



