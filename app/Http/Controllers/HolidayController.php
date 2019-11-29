<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HolidayController extends Controller
{
	public function holidayCalender(Request $request)
	{
		$holidays = \App\Holiday::all();
		if($request->year){
			$data['year'] = $request->year;
		}else{
			$data['year'] = date('Y');
		}
		if($request->category){
			$data['category'] = $request->category;
		}else{
			$data['category'] = 'development';
		}
		return view('admin.holidays.calender',$data);
	} 
	public function holidays()
	{
		$holidays = \App\Holiday::all();
		$data['holidays'] = $holidays;
		return view('admin.holidays.index',$data);
	} 
	public function getAddHoliday()
	{
		return view('admin.holidays.create');
	} 
	public function postAddHoliday(Request $request){
		
		$validator = \Validator::make($request->all(),
			array(
				'month' =>'required',
				'date' =>'required',
				'category' =>'required',
				'comments' =>'required',
			)
		);
		if($validator->fails())
		{
			return redirect('/admin/add-holiday')
			->withErrors($validator)
			->withInput();
		}
		else
		{
			$holiday =  new \App\Holiday();
			$holiday->month = $request->month;
			$holiday->date = $request->date;
			$holiday->category = $request->category;
			$holiday->comments = $request->comments;
			if($holiday->save()){ 
				return redirect('/admin/holidays')->with('success',"Added Successfully.");
			}else{
				return redirect('/admin/holidays')->with('error',"Something Went Wrong.");
			}
		}

	}

	public function getEditHoliday($id)
	{
		$holiday = \App\Holiday::where('id',$id)->first();
		if(is_null($holiday)){
			return redirect('/admin/holidays')->with('error',"holiday Not found");
		}else{
			$data['holiday'] = $holiday;
			return view('admin.holidays.edit',$data);
		}
	} 
	public function postEditHoliday(Request $request){
		$validator = \Validator::make($request->all(),
			array(
				'month' =>'required',
				'date' =>'required',
				'category' =>'required',
				'comments' =>'required',
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
			$holiday =  \App\Holiday::find($request->id);
			$holiday->month = $request->month;
			$holiday->date = $request->date;
			$holiday->category = $request->category;
			$holiday->comments = $request->comments;
			if($holiday->save()){
				return redirect('/admin/holidays')->with('success',"Updated Successfully");
			}else{
				return redirect('/admin/holidays')->with('error',"Something Went Wrong.");
			}
		}
	}


	public function exportHolidayExcel()
	{
		$holidayExcel = \App\Holiday::all();
		\Excel::create('HolidayExcel', function($excel) use($holidayExcel) {
			$excel->sheet('Sheet 1', function($sheet) use($holidayExcel) {
				$sheet->fromArray($holidayExcel);
			});
		})->export('xls');
	}
	public function importHolidayExcel(Request $request)
	{
		$response = array();
		if($request->hasFile('holidayFile'))
		{
			$extension = \File::extension($request->file('holidayFile')->getClientOriginalName());
			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
				\Excel::load($request->file('holidayFile'), function($reader) {
					$reader->each(function ($sheet)
					{
						$holiday = \App\Holiday::find($sheet->id);
						if(is_null($holiday)){
							$holiday = new \App\Holiday();
						}
						$holiday->month = $sheet->month;
						$holiday->date = date('m/d/Y',strtotime($sheet->date));
						$holiday->category = $sheet->category;
						$holiday->comments = $sheet->comments;
						$holiday->save();
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
	
	public function deleteHoliday($id)
	{
		$holiday = \App\Holiday::find($id);
		if(is_null($holiday)){
			return redirect('/admin/holidays')->with('error','Holiday Not Found');
		}else{
			if($holiday->delete()){
				return redirect('/admin/holidays')->with('success','Removed Successfully.');
			}else{
				return redirect('/admin/holidays')->with('error','Something Went Wrong');
			}
		}
	}
	
}
