<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Loan;
use Auth;
use App\Project_reminder;
use App\Emp_role;
use DB;

class BusinessAnalystController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 

    public function dashboard(){
       $data['total_project']    = Project::count('id');
       $data['handover_project'] = Project::whereProject_status(3)->count('id');
       $data['daily_reminders']  = Project_reminder::whereReminder_type(2)->get();
       $data['reminders']        = Project_reminder::where('reminder_type','!=', 2)
                                     ->whereBetween('reminder_date',[ date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks"))])
                                     ->orWhere('reminder_day', date('l'))
                                     ->get();
                                     //->whereDate('reminder_date','<=',date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks")))
       $data['timelines'] = Fixed_project::whereBetween('delivery_date',[ date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks"))])
                                       ->distinct()->get(['project_id','delivery_date']);   
                                      //whereDate('delivery_date','<=', date('Y-m-d', strtotime(date('Y-m-d')."+1 weeks")))
       $data['expired']  = Project::whereNotNull('mile_expiry')->orWhereNotNull('rem_hours')->get();

       $emp_id = Auth::user()->id;

       $data['loan'] = Loan::where('emp_id',$emp_id)->first();
        return view('ba.dashboard',$data);
    }

  public function getProfileEdit()
  {
    $data = array();
    $data['employee'] = \App\User::where('id',\Auth::user()->id)->with('personal_profile','cb_profile','previous_employment','cb_appraisal_detail')->first();
    return view('employee.profile.edit',$data);
  }

  public function postProfileEdit(Request $request)
  {
    $user_array['first_name'] = $request->first_name;
    $user_array['last_name'] = $request->last_name;
    $user_array['address'] = $request->address;
    $user_array['phone_number'] = $request->phone_number;
    $user_array['bank_account'] = $request->account_no;
    $user_array['martial_status'] = $request->martial_status;
    $user_array['dob'] = $request->dob;
    $user_array['anniversary_date'] = $request->anniversary_date;
    $user_array['personal_email'] = $request->personal_email;
    $user_array['father_name'] = $request->father_name;
    $user_array['mother_name'] = $request->mother_name;
    $user_array['parent_contact_number'] = $request->parent_number;
    $user = \App\User::where('id',\Auth::user()->id)->first();
    $user->request_json = json_encode($user_array);
    $user->is_request_approved = 0;
    $url = url('role/request/profile/'.$user->id);        
    if($user->save()){
      /*-----------------------------------Send notification-------------------------------------------*/
      $receiver = array();
      $title = $user->first_name." ".$user->last_name." "."Requested For profile update.";
      $message = "<p>".$user->first_name." ".$user->last_name." "."Requested For profile update."."</p>"."<br>";
      $message.= "<a href='".$url."' class='btn btn-primary'>View</a>";
      $admins = \App\User::where('role','1')->get();
      foreach ($admins as $admin) {
        array_push($receiver,$admin->id);
      }
      $hrs = \App\User::where('role','2')->get();
      foreach ($hrs as $hr) {
        array_push($receiver,$hr->id);
      }
      NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);
      /*-----------------------------------Send notification-------------------------------------------*/
      return redirect()->back()->with('success','Request Sent Successfully.Waiting approval from admin.'); 
    }
  }
}
