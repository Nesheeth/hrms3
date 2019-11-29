<?php







namespace App\Http\Controllers;







use Illuminate\Http\Request;

use Auth;

use DB;
use App\User;



class EmployeeProjectController extends Controller{

	public function getRole(){

		if(Auth::check()){

			if(Auth::user()->role == 1){

				return "admin";

			}

			if(Auth::user()->role == 2){

				return "hrManager";

			}

			if(Auth::user()->role == 3){

				return "hrExecutive";

			}

			if(Auth::user()->role == 4){

				return "employee";

			}

			if(Auth::user()->role == 5){

				return "itExecutive";

			}

			if(Auth::user()->role == 6){

				return "employee";

			}

		}

	}



	public function employee_projects(){

		  $role = \Auth::user()->role;

          if($role == 1 )

          {

		$employee_projects = \App\EmployeeProject::orderBy('id','DESC')->get();

		$data['employee_projects'] = $employee_projects;

	      }

	      else

	      {

	      		$employee_projects = \App\EmployeeProject::where('assign_by',\Auth::user()->id)->orwhere('reporting_to',\Auth::user()->id)->orderBy('id','DESC')->get();

	      		$data['employee_projects'] = $employee_projects;

	      }




		return view($this->getRole().'.employee_projects.index',$data);



	}







	public function getAssignProject(){
		$data['projects']       = \App\Project::all();
        $data['employees']      = User::whereRole(6)->orwhere('role','=',4)->whereIs_active(1)->get(); 
		$data['upperEmployees'] = User::where('role','!=',6)->where('role','!=',1)->where('role','!=',5)->get();
		$data['user_id']        = \Auth::user()->id; 
		return view($this->getRole().'.employee_projects.create',$data);
	} 



	public function postAssignProject(Request $request){

		$user1 = $request->user_id;



		$user = \App\User::where('id',$user1)->first();



		 $admin = \App\User::select('id')->where('role',1)->first();



		$validator = \Validator::make($request->all(),



			array(



				'project' =>'required',



				'assign_to' =>'required',



				'reporting_to' =>'required',



				'from_date' =>'required',



				'end_date' =>'required',



				'project_status' =>'required',

				'standard_time_zone' => 'required',



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



			$old_employee_project =  \App\EmployeeProject::where('project_id',$request->project)->where('user_id',$request->assign_to)->first();



			if(is_null($old_employee_project)){



				$employee_project =  new \App\EmployeeProject();



				for($n=0; $n < count($request->assign_to); $n++){

				$th =['project_id' => $request->project,

                 

				'user_id' => $request->assign_to[$n],

				 

				'reporting_to' => $request->reporting_to,

				'from_date' => $request->from_date,

				'end_date' => $request->end_date,

				'project_status' => $request->project_status,

			    'client_standard_time_zone' => $request->standard_time_zone,

			    'assign_by' => \Auth::user()->id,

				

				'feedback' => $request->feedback];

				

				$th = DB::table('employee_projects')->insert($th);

				 $receiver[$n] = $request->assign_to[$n];

				}



				if(isset($th)){ 

                   if(Auth::user()->role == 4)

                   {

                    /*--------------------------------Send Notification----------------------------------*/



					$title = "Team-lead (". \App\User::where('id',\Auth::user()->id)->value('first_name') . ") Assigned you a New Project.";



					$message = "Team-lead (". \App\User::where('id',\Auth::user()->id)->value('first_name') .") Assigned you a New Project - " .\App\Project::where('id',$request->project)->value('name');



					// $receiver = array($request->assign_to);



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



					/*--------------------------------Send Notification----------------------------------*/

                   }

                   else{

					/*--------------------------------Send Notification----------------------------------*/



					$title = $this->getRole()." Assigned you a New Project.";



					$message = $this->getRole()." Assigned you a New Project - " .\App\Project::where('id',$request->project)->value('name');



					// $receiver = array($request->assign_to);



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



					/*--------------------------------Send Notification----------------------------------*/



					 $title = "You are assigned to lead a new project.";



					$message = " Assigned you a New Project - " .\App\Project::where('id',$request->project)->value('name');



					 $receiver = array($request->reporting_to);



					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);





					/*-----------------------------------Send admin notification----------------------*/

				}

             if($user->role == 4){

             	 foreach ($receiver as $key => $value) {

                                   $emp[] = \App\User::where('id',$value)->value('first_name');

                                                   } 

                                                   $string = join(',', $emp);

                                           

              $title = \App\User::where('id',$request->user_id)->value('first_name') ." Assigned  A  Project.";



				$message = \App\User::where('id',$request->user_id)->value('first_name') . " Assigned  A Project ".\App\Project::where('id',$request->project)->value('name') . " To ".  $string;

                $receiver = array($admin->id);

               

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

			}

            

/*-----------------------------------Send  notification to Assign managet or teamlead ----------------------*/

                       

















					return redirect()->back()->with('success',"Added Successfully.");



				}else{



					return redirect()->back()->with('error',"Something Went Wrong.");



				}



			}else{



				return redirect()->back()->with('error',"Employee Is already assigned to this project ");



			}



			



		}







	}







	public function getEditEmployeeProject($id){
		$employee_project = \App\EmployeeProject::where('id',$id)->first();
		if(is_null($employee_project)){
			return redirect()->back()->with('error',"employee project Not found");
		}else{
			$projects = \App\Project::all();
			$employees = \App\User::where('role','!=',1)->where('role','!=',2)->get();
			$upperEmployees = \App\User::where('role','!=',6)->where('role','!=',1)->get();
			$data['projects'] = $projects;
			$data['employees'] = $employees;
			$data['upperEmployees'] = $upperEmployees;
			$data['employee_project'] = $employee_project;
			return view($this->getRole().'.employee_projects.edit',$data);
		}
	} 



	public function postEditEmployeeProject(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'project' =>'required',



				'assign_to' =>'required',



				'reporting_to' =>'required',



				'from_date' =>'required',



				'end_date' =>'required',



				'project_status' =>'required',



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



			$employee_project =  \App\EmployeeProject::find($request->id);



			$employee_project->project_id = $request->project;



			$employee_project->user_id = $request->assign_to;



			$employee_project->reporting_to = $request->reporting_to;



			$employee_project->from_date = $request->from_date;



			$employee_project->end_date = $request->end_date;



			$employee_project->project_status = $request->project_status;



			if($request->feedback){



				$employee_project->feedback = $request->feedback;



			}



			if($employee_project->save()){ 



				$title = "Admin Assigned you a New Project.";



				$message = "Admin Assigned you a New Project.";



				$receiver = array($request->assign_to);



				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);



				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}



		}



	}







	public function deleteEmployeeProject($id)



	{



		$project = \App\EmployeeProject::find($id);



		if(is_null($project)){



			return redirect()->back()->with('error','project Not Found');



		}else{



			if($project->delete()){



				return redirect()->back()->with('success','Removed Successfully.');



			}else{



				return redirect()->back()->with('error','Something Went Wrong');



			}



		}



	}



}



