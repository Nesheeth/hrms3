<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\Project_status;
use App\Project_type;
use App\Eod;
use App\Support_project;
use App\Fixed_project;
use App\Dedicated_developer;
use App\Project_Assignation;
use App\Project_log;
use App\Emp_role;
use App\Project_reminder;
use DB;


class ProjectManageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 

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
            if(Auth::user()->role == 7){
                return "businessAnalyst"; 
            }
        }
    }

    public function project_lists(Request $request){
         $projects = Project::orderBy('id','DESC'); 
         if($request->project_type){
              $projects->whereProject_type($request->project_type);  
            } 
        $data['p_type'] = ($request->project_type) ? $request->project_type : '';
        $data['projects'] = $projects->get();
        $data['types']    = Project_type::orderBy('name','asc')->get();  
          //print_r($data['projects']);die();
        //dd($data);
        return view('common.projects.list',$data);
    }

    public function hand_overs_projects(Request $request){
         $projects = Project::whereProject_status(3)->orderBy('id','DESC'); 
         if($request->project_type){
              $projects->whereProject_type($request->project_type);  
            } 
        $data['p_type'] = ($request->project_type) ? $request->project_type : '';
        $data['projects'] = $projects->get();
        $data['types']    = Project_type::orderBy('name','asc')->get();  
        return view('ba.projects.handover_projects',$data);
    }

    public function add_project($role, $id = null){ 
        if($id!= null){ 
            $data['project'] = Project::whereId($id)->first();
        }
        $data['types']   = Project_type::orderBy('name','ASC')->get();
        $data['status'] = Project_status::orderBy('name','ASC')->get();
        $data['time_zones'] = ['CST','EST','IST','PST']; 
        $data['client_communications'] = ['skype','email','phone'];
        return view('common.projects.add', $data);
    }

    public function save_project(Request $request){
      $this->validate($request,[
          'project_name'            =>'required|string',
          'project_type'            =>'required',
          'project_status'          =>'required',
          'client_name'             =>'string', 
          'client_time_zone'        =>'required|string',
          'client_communication'    =>'required|string',
          //'project_google_drive'    =>'required|string',
          //'project_skype_group'     =>'required|string',
          //'basecamp_link'           =>'required|string',
          'project_comments'        =>'required|string',
          'start_date'              =>'required',
          'internal_delivery_date'  =>'required|after:start_date',
          'client_delivery_date'    =>'required|after:start_date',
      ]);
       
      if(empty($request->project_id)){
         $project = new Project();
         $project->project_id = 'PR00'.$project->id;
         
      }else{
          $project = Project::whereId($request->project_id)->first();
      }
         $project->project_name         = $request->project_name;
         $project->project_type         = $request->project_type;
         $project->project_status       = $request->project_status;
         $project->client_name          = $request->client_name;
         $project->client_communication = $request->client_communication;
         $project->client_time_zone     = $request->client_time_zone;
         $project->project_google_drive_link    = $request->project_google_drive;
         $project->project_skype_group_name     = $request->project_skype_group;
         $project->project_basecamp_link        = $request->basecamp_link;
         $project->project_special_notes        = $request->project_comments;
         $project->start_date                       = $request->start_date; 
         $project->project_internal_delivery_date   = $request->internal_delivery_date;
         $project->project_client_delivery_date     = $request->client_delivery_date;
         $project->save(); 
         if(empty($request->project_id)){

             $project->project_id = 'PR00'.$project->id;
             $project->save(); 
             $log['project_id']  = $project->id;
             $log['descroption'] = "Project Create by  to ".Auth::user()->first_name." ".Auth::user()->last_name;  
             $log['last_update'] = Auth::user()->id; 
             Project_log::create($log); 

            if($request->project_type==1){  
                return redirect()->route('cm.new_support_project',['role'=>'admin','project'=> $project->id])->with('success',"Project Details save Successfully."); 
            }elseif($request->project_type==2){  
                return redirect()->route('cm.project_info',['role'=>'admin','project'=> $project->id])->with('success',"Project Details save Successfully."); 
            }elseif($request->project_type==3){  
                return redirect()->route('cm.new_dedicated_project',['role'=>'admin','project'=> $project->id])->with('success',"Project Details save Successfully."); 
            }

         } 
         return redirect()->route('cm.project_list',['role'=>'admin'])->with('success',"Project Details save Successfully.");
    }
    
    public function project_details($role,$id){ 
         $project = Project::whereId($id)->first();
         $data['project'] = $project; 
         if($project->project_type==1){ //Support Project
             $data['supports'] = Support_project::whereProject_id($id)->get();  
             $data['hours_spent'] = Eod::whereProject_id($id)->sum('today_hours');
             $data['total_hours'] = Support_project::whereProject_id($id)->sum('total_hours'); 
            // print_r($data['total_hours']);die();
             return view('common.projects.support', $data);

         }elseif($project->project_type==2){ //Fixed Project
            $data['milestones'] = Fixed_project::whereProject_id($id)->orderBy('milestone_number','ASC')->get();   
            $data['milestones_count'] = Fixed_project::whereProject_id($id)->orderBy('milestone_number','ASC')->count();   
            return view('common.projects.fix_projects',$data); 

         }elseif($project->project_type==3){ //Dedicated Developer
            $data['dedicated'] = Dedicated_developer::whereProject_id($id)->first();
           
            return view('common.projects.add_new_dedicated',$data); 
         }else{

         }
    }
    
    public function new_support_project($role, $project){ 
       $data['project'] = Project::whereId($project)->first();
       return view('common.projects.add_new_support',$data); 
    }

    public function view_new_support(){
       return view('common.projects.new_support');
    }
    
    public function add_support_project(Request $request){
          $this->validate($request,[
              'start_date'=>'required',
              'total_hours'=>'required',
              //'project_renewed'=>'required',
          ]);  
          Support_project::whereProject_id($request->project_id)->update(['project_renewed'=>1]); 
          $data['project_id']      = $request->project_id;
          $data['start_date']      = date('Y-m-d', strtotime($request->start_date));
          $data['expiry_date']     = date('Y-m-d', strtotime($request->end_date));  
          $data['total_hours']     = $request->total_hours;
          $data['remaining_hours'] = $request->total_hours;
          $data['project_renewed'] = 2; 
          Support_project::create($data); 

          $log['project_id']  = $request->project_id; 
          $log['descroption'] = "Project type Support Information updated.";  
          $log['last_update'] = Auth::user()->id; 
          Project_log::create($log); 

          if(!empty($request->is_new)){ 
            return redirect()->route('cm.project_list',['role'=>'admin'])->with('success',"Project Details save Successfully.");
          }else{
            $res['status'] = true;
            return $res;
          }
          
    }

     public function new_dedicated_project($role, $project){ 
        $data['project'] = Project::whereId($project)->first();
        return view('common.projects.add_new_dedicated',$data); 
     }

     public function save_dedicated_project(Request $request){ 
            $this->validate($request,[
                'no_of_resources'    => 'required|numeric',
                'reason_for_closing' => 'nullable|string'
            ]);

            $dedicated = Dedicated_developer::whereProject_id($request->project_id)->first();
            if(empty($dedicated)){
                $dedicated = new Dedicated_developer();
                $dedicated->project_id = $request->project_id;
            }
               $dedicated->no_of_resources = $request->no_of_resources;
               $dedicated->reason_for_closing = $request->reason_for_closing;
               $dedicated->updated_by = Auth::user()->id;  
               $dedicated->save(); 

                $log['project_id']  = $request->project_id; 
                $log['descroption'] = "Project type Support Information updated.";  
                $log['last_update'] = Auth::user()->id; 
                Project_log::create($log); 
               return redirect()->route('cm.project_list',['role'=> getRole(Auth::user()->role)])->with('success',"Project Details save Successfully.");
     }

     public function add_fixed_project($role, $project, $fix_id = null){
        $data['project'] = Project::whereId($project)->first();
        if($fix_id!=null){
            $data['fixed'] = Fixed_project::whereProject_id($project)->whereMilestone_number($fix_id)->first(); 
            if(empty($data['fixed'])){
                return redirect()->back()->with('error','Milestone not found.');
            }

        }
        return view('common.projects.add_fixed_project',$data); 
     }

     public function save_fixed_project(Request $request){

        $project = Project::where('id',$request->project_id)->first();
         
         $milestone = Fixed_project::whereProject_id($request->project_id)
                                   ->whereMilestone_number($request->milestone_number)->first();
        $validation = [];
        $validation['milestone_number']='required|numeric';
        $validation['milestone_details']='required';
        $validation['delivery_date']='required|after_or_equal:'.$project->start_date;
         if(empty($milestone)){
             $milestone = new Fixed_project();
             $milestone->project_id = $request->project_id;
             $milestone->milestone_number = $request->milestone_number;
         }else{
            if($request->delivery_date_updated==1){

                $validation['new_delivery_date']='required|after_or_equal:'.$project->start_date;
            }
            if($request->type=='add'){
                 $validation['milestone_number']='required|numeric|unique:fixed_project,milestone_number,'.$request->project_id;

            }

            
         }
         $this->validate($request,$validation);
         $milestone->milestone_details       = $request->milestone_details;
         $milestone->delivery_date           = $request->delivery_date;
         $milestone->delivery_date_updated   = $request->delivery_date_updated; 
         $milestone->reason_for_delay        = ($request->reason_for_delay!='') ? $request->reason_for_delay : NULL  ;
         $milestone->new_delivery_date       = ($request->new_delivery_date) ? $request->new_delivery_date : NULL  ;
         $milestone->save(); 
         $log['project_id']  = $request->project_id; 
         $log['descroption'] = "Project type Fixed Information updated.";  
         $log['last_update'] = Auth::user()->id; 
         Project_log::create($log);

         return redirect()->route('cm.project_info',['role'=> getRole(Auth::user()->role),'id'=> $request->project_id])->with('success',"Project Details save Successfully.");
     }

     public function edit_all_fixed($role, $project){
        $data['project'] = Project::whereId($project)->first();
        $data['fixed']   = Fixed_project::whereProject_id($project)->get(); 
        return view('common.projects.edit_fixed_project',$data);
     }

     public function edit_all_fixedPost(Request $request){
       
        for($i=0; $i< sizeof($request->milestone_number); $i++ ){
            Fixed_project::whereProject_id($request->project_id)
                        ->whereMilestone_number($request->milestone_number[$i])
                        ->update([
                            'delivery_notes' => $request->status_notes[$i],
                            'milestone_notes' => $request->milestone_notes[$i]
                        ]);
        } 

         $log['project_id']  = $request->project_id; 
         $log['descroption'] = "Project type Fixed Information updated.";  
         $log['last_update'] = Auth::user()->id; 
         Project_log::create($log);
        return redirect()->route('cm.project_info',['role'=>getRole(Auth::user()->role),'project'=>$request->project_id])->with('success',"Project Details save Successfully.");
     }

     public function assign_project(){
        $data['projects']      = Project::orderBy('project_name','asc')->get();
        $data['emps']          = User::whereRole(6)->where('department','development')->orderBy('first_name','asc')->get(['id','first_name','last_name']);
        $data['emp_roles']     = Emp_role::orderBy('name','asc')->get();
        $data['assign_status'] = ["Assigned", "Free"];
        return view('common.projects.assign_project',$data);
     }

     public function assign_projectPost(Request $request){
         $this->validate($request,[
             'project'      =>'required',
             'employee'     =>'required',
             'emp_role'     =>'required',
             'start_date'   =>'required',
             'end_date'     =>'required',
             'assign_percentage'=>'required',
             'assign_status'=>'required',
             'notes'        =>'required',
         ]);
         
         $assign_pro = Project_Assignation::whereProject_id($request->project)
                                            ->whereEmployee_id($request->employee)
                                            ->where('assign_status','!=',1)->first();
        $emp = User::findOrFail($request->employee); 
         if(empty($assign_pro)){
             $assign_pro = new Project_Assignation();
             $assign_pro->project_id        = $request->project;
             $assign_pro->employee_id       = $request->employee;
             $assign_pro->start_date        = $request->start_date;
             $assign_pro->date              = date('Y-m-d');
             $assign_pro->assign_by         = Auth::user()->id; 

             $title   = $this->getRole()." Assigned you a New Project.";
             $message = $this->getRole()." Assigned you a New Project - " .Project::where('id',$request->project)->value('project_name');
             NotificationController::notify(Auth::user()->id, [$request->employee], $title, $message); 
            
             $log['project_id']  = $request->project;
             $log['descroption'] = "Project Assign to. $emp->first_name  $emp->last_name";  
             $log['last_update'] = Auth::user()->id; 
             Project_log::create($log); 
         }else{ 
            $log['project_id']  = $request->project;
            $log['descroption'] = "Project Assign details Update for $emp->first_name  $emp->last_name";  
            $log['last_update'] = Auth::user()->id; 
            Project_log::create($log); 
         }
             $assign_pro->emp_role          = $request->emp_role;
             $assign_pro->end_date          = $request->end_date;
             $assign_pro->assign_percentage = $request->assign_percentage;
             $assign_pro->assign_status     = $request->assign_status;
             $assign_pro->performance_notes = $request->notes;
             $assign_pro->update_by         = Auth::user()->id;  
             $assign_pro->save();
            
             return redirect()->back()->with('success',"Project Assignation done Successfully.");
     }

     public function get_project_emp(Request $request){

         $emps  = Project_Assignation::whereProject_id($request->project)->pluck('employee_id');
         $users = User::whereNotIn('id',$emps)->orderBy('first_name','asc')->get();  
         $html="<option value=''> Select employee </option>";
          foreach($users as $user){ 
            $html.= "<option value='$user->id'>$user->first_name  $user->last_name </option>";
          }
   
          $res['html'] = $html;
          $res['project'] = Project::findOrFail($request->project);
          return $res; 
     }

     public function view_project_team($role,$project){ 
         $data['users'] = Project_Assignation::whereProject_id($project)->whereAssign_status(0)->get(); 
         return view('common.projects.view_team',$data); 
     }

     public function assign_update_page(){ 
          $emp_roles  = Emp_role::orderBy('name','asc')->get();
          $html = '<br><div class="form-horizontal">
                <div class="form-group">
                    <label for="end_date" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="role">
                          <option value=""> -- Select Role -- </option>';
                    foreach($emp_roles as $e_role)
                        $html.= " <option value='$e_role->id'>$e_role->name</option>";
                    
          $html.=   '</select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="end_date" class="col-sm-2 control-label">Assign Status</label>
                    <div class="col-sm-10">
                       <select class="form-control" id="assign_status">
                            <option value=""> -- Select Role -- </option>
                            <option selected value="0"> Assigned </option>
                            <option value="1"> Free </option>
                       </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="end_date" class="col-sm-2 control-label">Performance Notes</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="note" name="client_delivery_date" placeholder="Performance Notes"></textarea>
                    </div>
                </div>
            </div>';
            return $html;
     }

     public function assign_updatePost(Request $request){
        $pa = Project_Assignation::whereId($request->id)->first();
        $pa->emp_role          = ($request->role) ? $request->role :  $pa->emp_role;
        $pa->performance_notes = ($request->note) ? $request->note :  $pa->performance_notes;
        $pa->assign_status     = ($request->status) ? $request->status : $pa->assign_status;
        $pa->update_by         = Auth::user()->id; 
        $pa->save();  
        $log['project_id']  = $pa->project_id;
        $log['descroption'] = "Project Employee Status Update.";  
        $log['last_update'] = Auth::user()->id;
         Project_log::create($log);
         return ['status'=> true];
     }

     public function project_history($role, $project){ 
            $logs = Project_log::whereProject_id($project)->orderBy('id','desc')->get();
            $html='<div class="table-responsive pro"><table class="table">
                    <thead>
                    <tr>
                        <th> History </th>
                        <th> Update By </th>
                        <th> Update Time </th>
                    </tr>
                    </thead>
                    <tbody>';
            if(count($logs)>0){
                foreach($logs as $log){ 
                    $last_update = User::whereId($log->last_update)->first(); 
                    $html.= '<tr>
                                <td>'.$log->descroption.'</td>
                                <td>'.$last_update->first_name." ".$last_update->last_name.'</td>  
                                <td>'.date('h:i A - d M Y', strtotime($log->created_at)).'</td>
                            </tr>';
                }
            }else{
                $html.= '<tr>
                            <td colspan="3"> No history found.</td>
                        </tr>'; 
            }

            $html.=' </tbody>
            </table></div>';
            return $html; 
     }

     public function my_project(){ 
            
           $data['projects'] = Project_Assignation::where('employee_id',Auth::user()->id)->where('assign_status',0)->orderBy('id','DESC')->get();

        
            return view('common.projects.my_project', $data);
     }
     
     public function new_reminder(Request $request){
       $data['project'] = Project::findOrFail($request->project_id);
       return view('common.projects.add_reminder', $data); 
     }
     public function save_reminder(Request $request){
          $row = $request->except('_token'); 
          Project_reminder::create($row);
          return ['status'=> true];  
     }


}
