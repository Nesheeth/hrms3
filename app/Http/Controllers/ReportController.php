<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Eod; 
use App\User;
use App\Project; 
use App\EmpSession;
use App\ProjectReview;
use App\Project_Assignation;
use Auth;

class ReportController extends Controller{
	
	public function emp_report(Request $request){ 

	    //$data = $this->prepare_report(Auth::user()->id, date('m'), date('Y'));   
		$inputs['month'] = date('m');
		$inputs['year'] = date('Y');
		$data['inputs'] = $inputs;
		$fromDate =$inputs['year'].'-'.$inputs['month'].'-'.'1';
		$toDate=$inputs['year'].'-'.$inputs['month'].'-'.date('t');
        $range = [$fromDate, $toDate]; 
		//$reviews = ProjectReview::where('user_id',Auth::user()->id)->get();
		//if(Auth::user()->role == 6){
          $data = $this->prepare_report(Auth::user()->id, date('m'), date('Y'));
            $data['month'] = $inputs['month'];
	    	$data['year'] = $inputs['year'];
		 $eod_project = Eod::where('user_id',Auth::user()->id)->whereBetween('date', $range)->distinct('project_id')->pluck('project_id');
        // dd($eod_project);
		
		 if(!is_null($eod_project))
		 {    
			$data['emp_projects'] = Project::whereIn('id',$eod_project)
			                        //->join('project_reviews','project_reviews.project_id','=','projects.id')
			                       // ->whereBetween('emp_update_month', $range)
                                    ->get();
		 }
	   // }
	  //    if(Auth::user()->role == 4){
	  //   	 $data = $this->prepare_report(Auth::user()->id, date('m'), date('Y'));
   //          $data['month'] = $inputs['month'];
	  //   	$data['year'] = $inputs['year'];
		 // $eod_project = Eod::where('user_id',Auth::user()->id)->whereBetween('date', $range)->distinct('project_id')->pluck('project_id');
   //      // dd($eod_project);
		
		 // if(!is_null($eod_project))
		 // {    
			// $data['emp_projects'] = Project::whereIn('id',$eod_project)
			//                         //->join('project_reviews','project_reviews.project_id','=','projects.id')
			//                        // ->whereBetween('emp_update_month', $range)
   //                                  ->get();
		 // }
	  //   }
		
     	//print_r($data['emp_projects']);die();
        // foreach($data['emp_projects'] as $project)
        // {
        
        // 	 $data['projects_review'] = ProjectReview::where('user_id',Auth::user()->id)->where('project_id',$project->project_id)->first();
        // 	 // print_r($data['projects_review']);die();
        	
        // }

     	//print_r($data['projects_review']);
		return view('common.reports.emp_report', $data); 
	} 

	public function add_report(Request $request)
	{
		//dd($request->all());
		
	   if(Auth::user()->role == 6){
	  //  	$this->validate($request,[
		 //   'ratings' => 'required',
		 //   'comment' => 'required' 
		 // ]);
       $report = new ProjectReview();
       $report->project_id = $request->project_id;
       $report->user_id = Auth::user()->id;
       $report->employee_rate = $request->ratings;
       $report->employee_review = $request->comment;
       $report->emp_update_month = date('Y-m-d');
       $report->save();
       return redirect()->back()->with('success','Report Added Successfully!!!');
       }else{
   //     	 	$this->validate($request,[
		 //   'tl_ratings' => 'required',
		 //   'tl_comment' => 'required' 
		 // ]);
       	 $report = ProjectReview::findOrFail($request->review_id);
		 //$report->project_id = $request->project_id;
		 $report->tl_id = Auth::user()->id;
		 $report->tl_rate = $request->tl_rating;
		 $report->tl_review = $request->tl_comment;
		 $report->tl_update_month = date('Y-m-d');
		 $check = $report->save();
         if($check){
         	$data['status'] = true;
         	//$data['emp_id'] = $report->user_id;
         	//$data['month'] =date('m');
         	//$data['year'] = date('Y');
            //$data['data_emp'] = $this->prepare_report($report->user_id, data('m'), data('Y'));
          //  $data = array_merge(['status'=>$status],$this->prepare_report($report->user_id, data('m'), data('Y')));
         }else{
         	$data['status'] = false;

         }
         return response()->json($data, 200);
       }

       

	}   
	public function add_report_by_admin(Request $request)
	{
	   //dd($request->all());
			// $this->validate($request,[
		 //   'admin_ratings' => 'required',
		 //   'admin_comment' => 'required' 
		 // ]);
       $report                     = ProjectReview::findOrFail($request->review_id);
       $report->admin_id           = Auth::user()->id;
       $report->admin_rate         = $request->admin_ratings;
       $report->admin_review       = $request->admin_comment;
       $report->admin_update_month = date('Y-m-d');
       $check = $report->save();
       if($check){
       	$data['status'] =True;
       //	$data = $this->prepare_report($report->user_id, data('m'), data('Y'));
       }else{
       	$data['status'] =false;
       }
       return response()->json($data);

	}  
	public function add_report_by_tl(Request $request)
	{
	  // dd($request->all());
			$this->validate($request,[
		   'ratings' => 'required' 
		 ]);
       $report = new ProjectReview();
       $report->project_id = $request->project_id;
       $report->user_id = Auth::user()->id;
       $report->employee_rate = $request->ratings;
       $report->employee_review = $request->comment;
       $report->emp_update_month = date('Y-m-d');
       $report->save();

       return redirect()->back()->with('success','Report Added Successfully!!!');

	} 
	
	public function emp_reportPost(Request $request){
		//$data = $this->prepare_report($request->team_member, $request->month, $request->year); 
        $inputs['month'] = $request->month;
		$inputs['year'] = $request->year; 
		$data['inputs'] = $inputs; 	
        $data['btn_status1']='';
		//$data['emp_projects'] = Project::join('project_assignation', 'projects.id', '=', 'project_assignation.project_id')
								// ->where('project_assignation.assign_status','0')
								// ->where('project_assignation.employee_id',Auth::user()->id)
								// ->whereMonth('project_assignation.date', $inputs['month'])
								// ->whereYear('project_assignation.date', $inputs['year'])
								// ->get();

		$fromDate =$inputs['year'].'-'.$inputs['month'].'-'.'1';
		$toDate=$inputs['year'].'-'.$inputs['month'].'-'.date('t');
        $range = [$fromDate, $toDate]; 
        if(date('m',strtotime($fromDate)) == date('m') && date('Y',strtotime($fromDate)) == date('Y') )
         { // echo 'if';
         	$data['btn_status1'] = $fromDate;
         }else{
         	//echo 'else';
         	$data['btn_status1'] = $fromDate;
         }	
		//$reviews = ProjectReview::where('user_id',Auth::user()->id)->get();
		//if(Auth::user()->role == 6){
        $data = $this->prepare_report($request->emp_id, $request->month, $request->year); 
           $data['month'] = $inputs['month'];
	    	$data['year'] = $inputs['year'];
		 $eod_project = Eod::where('user_id',Auth::user()->id)->whereBetween('date', $range)->distinct('project_id')->pluck('project_id');
        // dd($eod_project);
		
		 if(!is_null($eod_project))
		 {    
			$data['emp_projects'] = Project::whereIn('id',$eod_project)
			                        //->join('project_reviews','project_reviews.project_id','=','projects.id')
			                       // ->whereBetween('emp_update_month', $range)
                                    ->get();
		 }
	   // }
	   // if(Auth::user()->role == 4){
	  //   	$data = $this->prepare_report($request->team_member, $request->month, $request->year);
	  //   	$data['month'] = $inputs['month'];
	  //   	$data['year'] = $inputs['year'];  
   //       $team_members = \App\TeamMember::where('team_leader_id',Auth::user()->id)->pluck('team_member_id');
   //      // dd($team_member);
		 // $eod_project = Eod::where('user_id',$request->team_member)->whereBetween('date', $range)->distinct('project_id')->pluck('project_id');
   //      // dd($eod_project);
		
		 // if(!is_null($eod_project))
		 // {    
			// $data['emp_projects'] = Project::whereIn('id',$eod_project)
			//                         //->join('project_reviews','project_reviews.project_id','=','projects.id')
			//                        // ->whereBetween('emp_update_month', $range)
   //                                  ->get();
		 // }else{

		 // 		$data['emp_projects'] = null;
		 // }
		 // $data['team_members'] = User::whereIn('id',$team_members)->get();
	  //   }
		
     	//print_r($data['emp_projects']);die();
        // foreach($data['emp_projects'] as $project)
        // {
        
        // 	 $data['projects_review'] = ProjectReview::where('user_id',Auth::user()->id)->where('project_id',$project->project_id)->first();
        // 	 // print_r($data['projects_review']);die();
        	
        // }

     	//print_r($data['projects_review']);						

        //echo $request->emp_id;
		
		//dd($data);
		return view('common.reports.emp_report', $data); 
	}
	
	
    public function getReport(){

    	if(Auth::user()->role == 4){
			$emps = \App\TeamMember::where('team_leader_id',Auth::user()->id)->pluck('team_member_id');
			$data['employees'] =  \App\User::whereIn('id',$emps)->orderBy('first_name','ASC')->select('id','first_name','last_name')->get();
         //$data['employees'] = User::where('role','!=',1)->where('is_active',1)->orderBy('first_name','ASC')->select('id','first_name','last_name')->get();
		}else{
    	$data['employees'] = User::where('role','!=',1)->where('is_active',1)->orderBy('first_name','ASC')->select('id','first_name','last_name')->get();

         }
         //dd($data);

        return view('common.report',$data);
    }
	
	public function getReportPost(Request $request){
		
		$this->validate($request,[
		   'emp_id' => 'required',
		   'month'  => 'required',
		   'year'   => 'required', 
		 ]);
		$data = $this->prepare_report($request->emp_id, $request->month, $request->year);
		$data['inputs']    = $request->input();
		$data['month']    = $request->month;
		$data['year']    = $request->year;


		if(Auth::user()->role == 4){
			$emps = \App\TeamMember::where('team_leader_id',Auth::user()->id)->pluck('team_member_id');
			$data['employees'] =  \App\User::whereIn('id',$emps)->orderBy('first_name','ASC')->select('id','first_name','last_name')->get();
         //$data['employees'] = User::where('role','!=',1)->where('is_active',1)->orderBy('first_name','ASC')->select('id','first_name','last_name')->get();
		}else{
			$data['employees'] = User::where('role','!=',1)->where('is_active',1)->orderBy('first_name','ASC')->select('id','first_name','last_name')->get();
		}
		
		//dd($data);
		return view('common.report', $data);    
	}

    public function my_report(Request $request){

    	$month = $request->month;
    	$year = $request->year;
    	$user_id = $request->emp_id;

    	echo $startdate   = strtotime($year . '-' . $month . '-01');
    	echo '<br>';
        echo $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
        echo '<br>';
        echo     $working_day = intval((date('t',$startdate)),10);  
    	$data = $this->get_attendance($user_id, date('Y-m-d', $startdate), date('Y-m-d', $enddate)); 
    	return json_encode($data);
    }
	
	
	/* 
     * Prepare Report based on Month and year
     *	 @return report data.
	 */
	public function prepare_report($emp, $month, $year){

       // echo $emp.' '.$month.' '.$year;
		$start = date('Y-m-d', strtotime("$year-$month-01")); 
	    $end   = date('Y-m-t', strtotime($start));
		$data['attendance'] = calculate_attendance($emp,$start,$end);
		
		//array_walk($data['attendance'], function(&$key, $b) { ucwords(str_replace('_', ' ', $key)) });  
		$data['at_labels']  = json_encode(['Present','Absent','Half Day','Uninformed Leave','Sandwich Leave','Late Login']); 
		$data['at_values']  = json_encode(array_values($data['attendance'])); 
		
		$project_data =    Project::join('project_assignation','projects.id','project_assignation.project_id')
								->join('users','project_assignation.employee_id','users.id')
								->join('eods','eods.user_id','users.id')
							   
								 ->select('projects.project_name','projects.id', DB::Raw('SUM(eods.today_hours) as pr_time'))

								->where('users.id', $emp)
								->whereMonth('eods.date', $month)	
								->whereYear('eods.date', $year)	 	 							
								->whereRaw('eods.project_id = projects.id')
								->groupBy('projects.project_name','projects.id')
								 
								->get(); 


	   
		
			$sum = array_sum(array_column($project_data->toArray(),'pr_time')); 

			$data['projects'] = $project_data;
			foreach($project_data as $project){
				$labels[]   = $project->project_name;
				$cdata[]    = number_format(($project->pr_time*100) / $sum, 2); 
				//$sdata[]    = array('label'=> $project->project_name,'data'=>number_format(($project->pr_time*100) / $sum, 2),'backgroundColor'=>'green','borderColor'=>'red') ;
				$sdata[]    = array('label'=>$project->project_name,'y'=>number_format(($project->pr_time*100) / $sum, 2));
			}
			

			if(!empty($labels) && !empty($cdata)){
		     $data['labels']  = json_encode($labels);
		     $data['cdata']   = json_encode($cdata);
		     $data['sdata']   = json_encode($sdata);   
			} 
			//print_r($data['sdata']);

		     return $data; 
	}
	
	/* 
     *   Prepare Employee Attendance Data based on Month and year
     *	 @return Attendance data.
	 */
	public function get_attendance($id,$start,$end){
    	    $id = "CB0".$id;
            $attendance =  AttendanceData::whereEmployee_id($id)
                            ->whereDate('attendance_date','>=', $start) 
                            ->whereDate('attendance_date','<=', $end) 
                            ->orderBy('attendance_date','ASC')
                            ->get(['attendance_date','status']); 
			
			
			// print_r($attendance); 
			// die; 
			
			if(empty($attendance)){
				$data['present']          = 0;
				$data['leaves']           = 0;
				$data['half_day']         = 0;
				$data['ui']               = 0;
				$data['sandwich_leave']   = 0;
				return $data;
			}
			
            $attendance = $attendance->toArray(); 
             
                $startdate   = strtotime($start); 
                $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
                $currentdate = $startdate;
                $p = $ab = $ui = $hd = $sw = 0; 
                $sw_status = false;
                $holydays = ['Sun','Sat'];
                while ($currentdate <= $enddate){
                    $day = date('D', $currentdate);
                    $date = date('Y-m-d', $currentdate);
                    if(in_array($day, $holydays)){ 
                        ++$p;
                    }else{ 
                        $found_key = array_search(date('Y-m-d', $currentdate), array_column($attendance, 'attendance_date'));
                        if(!empty($found_key) || $found_key===0){ 
                            $status = $attendance[$found_key]['status'];

                            if($day=="Fri" &&  ($status=="AB" || $status=="UI"))
                            $sw_status =true; 
                            switch($status){
                                case 'P': 
                                    ++$p;
                                break;
                                case 'AB':
                                    ++$ab;
                                break;
                                case 'UI':
                                    ++$ui;
                                break;
                                case 'HD':
                                    ++$hd;
                                    $p = ($p + 0.5); 
                                break;
                            }
                            if($day=="Mon" && ($sw_status==true) &&  ($status=="AB" || $status=="UI")){
                                ++$sw; 
                                $sw_status =false;  
                                $p  = $p-2;
                                $ab = $ab+2; 
                            }
                        }else{
                            $check_holyday = Holiday::whereDate('date',$date)->first(); 
                            if(!empty($check_holyday))
                                ++$p;  
                        }
                    }
                   $currentdate = strtotime('+1 day', $currentdate);
                } 
             //echo "<br>  $id  P => $p  HD => $hd AB => $ab  UI => $ui  ";
            $data['present']          = $p;
            $data['leaves']           = $ab;
            $data['half_day']         = $hd;
            $data['ui']               = $ui;
            $data['sandwich_leave']   = $sw;
			return $data;
    }
	
}