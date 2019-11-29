<?php







namespace App\Http\Controllers;







use Illuminate\Http\Request;

use Auth;

use DB;





class ProjectController extends Controller



{



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



	public function projects()



	{



		//$projects = \App\Project::Join('employee_projects', 'projects.id', '=', 'employee_projects.project_id')->select('projects.*', 'employee_projects.project_status','employee_projects.user_id','employee_projects.reporting_to')->get();

		$projects =  DB::table('projects')

            ->leftjoin('employee_projects', 'projects.id', '=', 'employee_projects.project_id')

            ->select('projects.*', 'employee_projects.reporting_to','employee_projects.user_id','employee_projects.project_status')

            ->get();



		$data['projects'] = $projects;



		return view($this->getRole().'.projects.index',$data);



	} 



	public function getAddProject()



	{

        $data['user_id'] = \Auth::user()->id;

		//return view('admin.projects.create');

		return view($this->getRole().'.projects.create',$data);



	} 



	public function postAddProject(Request $request){

		$user1 = $request->user_id;



		$user = \App\User::where('id',$user1)->first();



		 $admin = \App\User::select('id')->where('role',1)->first();



		$validator = \Validator::make($request->all(),



			array(



				'project_name' =>'required',



				'start_date' =>'required',



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



			$project =  new \App\Project();



			$project->name = $request->project_name;



			$project->start_date = $request->start_date;



			if($request->end_date){



				$project->end_date = $request->end_date;



			}



			if($request->client_name){



				$project->client_name = $request->client_name;



			}	



			if($request->project_comments){



				$project->project_comments = $request->project_comments;



			}



			if($project->save()){ 



				$update_project = \App\Project::find($project->id);



				$update_project->project_id = 'PROJECT00'.$project->id;



				$update_project->save();



             /*-----------------------------------Send notification----------------------*/

             if($user->role == 4){



              $title = "A New Project Added..";



				$message = "A New Project ".$request->project_name. " Added by " .$user->first_name ." ".$user->last_name;

                $receiver = array($admin->id);

               

				NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

			}

            

/*-----------------------------------Send notification----------------------*/

             







				return redirect()->back()->with('success',"Added Successfully.");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}



		}







	}







	public function getEditProject($id)



	{



		$project = \App\Project::where('id',$id)->first();



		if(is_null($project)){



			return redirect()->back()->with('error',"project Not found");



		}else{



			$data['project'] = $project;



			  return view($this->getRole().'.projects.edit',$data);



		}



	} 



	public function postEditProject(Request $request){



		$validator = \Validator::make($request->all(),



			array(



				'project_name' =>'required',



				'start_date' =>'required',



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



			$project =  \App\Project::find($request->id);



			$project->name = $request->project_name;



			$project->start_date = $request->start_date;



			
			$project->end_date = ($request->end_date) ? $request->end_date : NULL;
			



			if($request->client_name){
				$project->client_name = $request->client_name;
			}	



			if($request->project_comments){



				$project->project_comments = $request->project_comments;



			}



			if($project->save()){



				return redirect()->back()->with('success',"Updated Successfully");



			}else{



				return redirect()->back()->with('error',"Something Went Wrong.");



			}



		}



	}







	public function deleteProject($id)



	{



		$project = \App\Project::find($id);



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



