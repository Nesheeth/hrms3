<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\EmployeeCbProfile;
use App\LeaveType;
use App\Leave_tracking;
use Auth;
use Mail; 
use Session;
use App\Project_Assignation;
use App\Resignation;
use App\Retract;

class LeaveManageController extends Controller
{   

    public function __construct(){
        $this->middleware('auth');
    } 


    public function leave_mng(Request $request){
         $leaves = Leave_tracking::whereUser_id(Auth::user()->id);
         if(!empty($request->leave_type)){
           $data['l_type'] = $request->leave_type; 
           $leaves = $leaves->whereStatus($request->leave_type); 
         } 
       
         $leaves = $leaves->orderBy('id','desc')->get();
         $data['leaves'] = $leaves;
         $data['taken'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(1)->sum('days');
         $data['rejected'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(2)->sum('days'); 
         return view('common.leaves.index',$data);   
  }
  
    public function apply_leave(){ 
        $leave_types = LeaveType::orderBy('leave_type','ASC')->get(); 
		$data['leave_types'] = $leave_types;
		return view('common.leaves.apply-leave',$data);  
    }

    public function apply_leavePost(Request $request){
         $this->validate($request,[
             'leave_type'       => 'required',
             'date_from'        => 'required',
             'date_to'          => 'required',
             'days'             => 'required',
             'contact_number'   => 'required|digits:10',
             'reason'           => 'required',
         ]); 

        //echo "<pre>"; 
        $alleaves = Leave_tracking::whereUser_id(Auth::user()->id)->select(['date_from'])->get();
        $val = [];
        foreach($alleaves as $value)
            array_push($val, strtotime($value->date_from));

        if(in_array(strtotime($request->date_from), $val)){
            return redirect()->back()->with('error','You Already Applied Leave For This Day.');
        }else{
           $row['leave_type']       =       $request->leave_type;     
           $row['user_id']          =       Auth::user()->id;   
           $row['date_from']        =       $request->date_from;  
           $row['date_to']          =       $request->date_to;
           $row['days']             =       $request->days;
           $row['contact_number']   =       $request->contact_number;    
           $row['reason']           =       $request->reason;
          // $row['status']           =       0;
           Leave_tracking::create($row); 
           	/*-----------------------------------Send notification-------------------------------------------*/
       if(Auth::user()->department == 'sales')
       {
         $url = url('/sales/teamLead/team-member-leave-listing');   
        $receiver = array();
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."Requested for Leave";
        $message = "<p> $title </p><br>";
        $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";   
       } 
       else
       {
         $url = url('role/leave-listing?type=pending');   
        $receiver = array();
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."Requested for Leave";
        $message = "<p> $title </p><br>";
        $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";   
       }
       

        if(Auth::user()->role!=2){ 
  				$admins = \App\User::where('id','!=',\Auth::user()->id)->whereIn('role',[1,2,4])->get();
  				foreach ($admins as $admin) {
  					array_push($receiver,$admin->id);  
  				}
        }else{
          $receiver[] = 1;
        }  

				NotificationController::notify(Auth::user()->id,$receiver,$title,$message); 

                $data = [
                      'sender_name'    =>  Auth::user()->first_name." ".Auth::user()->last_name,
                      'sender_email'   =>  Auth::user()->email,
                      'reason'         =>  $request->input('reason'), 
                      'designation'    =>  Auth::user()->cb_profile->designation,
                  ];

                  Mail::send('emails.leave_apply', $data, function($m) use ($data){  
                        $m->from($data['sender_email'], $data['sender_name']);
                        $m->to('leaves@codingbrains.com', "HR Manager"); 
                    }); 
                /*-----------------------------------Send notification-------------------------------------------*/ 
            return redirect()->route('em.my_leave',['role'=>getRoleStr()])->with('success',"Successfully Submitted Leave Wait For  Approval."); 
        }

    }

    public function my_leaves(Request $request){ 
         $leaves = Leave_tracking::whereUser_id(Auth::user()->id)->whereSoft_delete(0);
         if(!empty($request->leave_type)){
           $data['l_type'] = $request->leave_type; 
           $leaves = $leaves->whereStatus($request->leave_type); 
         }  
         //$leaves = $leaves->where('status','!=', 4)->orderBy('id','desc')->get(); 
         $leaves = $leaves->orderBy('id','desc')->get();  
         $data['leaves'] = $leaves;
         $data['taken'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(1)->sum('days');
         $data['rejected'] = Leave_tracking::whereUser_id(Auth::user()->id)->whereStatus(2)->sum('days'); 
         $data['resignation'] = Resignation::where('user_id',\Auth::user()->id)->where('is_active','!=',4)->first();

         $data['retracts'] = Retract::where('user_id',\Auth::user()->id)->where('is_active','!=',1)->first();
         
         return View('common.leaves.index',$data); 
    }

    public function leave_list(Request $request){ 
         //$leaves = Leave_tracking::get();
         $leaves = Leave_tracking::where('user_id','!=',Auth::user()->id)->orderBy('created_at','DESC');
         if(!empty($request->leave_type)){
           $data['l_type'] = $request->leave_type; 
       
           $leaves = $leaves->whereStatus($request->leave_type); 
         }  
         $data['leaves'] = $leaves->get();
        // $data['leaves'] = Leave_tracking::where('user_id','!=',Auth::user()->id)->orderBy('created_at','DESC')->get();

         //print_r($data['leaves']);die();
        return View('common.leaves.leave_list',$data);     
   }

   public function changeleavestatus(Request $request){
        // dd($request->all());
        $leave = Leave_tracking::whereId($request->leave)->first();
        // print_r($request->all()); 
        $user_role=User::whereId($leave->user_id)->first();
        if(Auth::user()->role==1 || Auth::user()->role==2){

            $emp = EmployeeCbProfile::whereUser_id($leave->user_id)->first();
            if($emp->avail_leaves > 0){
              $emp->avail_leaves = ( $emp->avail_leaves-1 );
              $emp->save();
            }  
            $leave->status = $request->action;  
              if(Auth::user()->role==2 && Auth::user()->id != $leave->user_id){
                 $leave->hr = Auth::user()->first_name;
                 $leave->hr_response =  $request->action;
                 $leave->hr_reason   = $request->comment;

              }

        }else{
            if(empty($leave->tl1)){
                $leave->tl1 = Auth::user()->first_name;
                $leave->tl1_response =  $request->action;
                $leave->tl1_reason   = $request->comment;
            }elseif(empty($leave->tl2) && $leave->tl1!=Auth::user()->first_name){
                $leave->tl2 = Auth::user()->first_name;
                $leave->tl2_response =  $request->action;
                $leave->tl2_reason   = $request->comment;
            }elseif($leave->tl1!=Auth::user()->first_name && $leave->tl2!=Auth::user()->first_name){
                $leave->tl3 = Auth::user()->first_name;
                $leave->tl3_response =  $request->action;
                $leave->tl3_reason   = $request->comment;
            }elseif($leave->hr!=Auth::user()->first_name ){
                $leave->hr = Auth::user()->first_name;
                $leave->hr_response =  $request->action;
                $leave->hr_reason   = $request->comment;
            }
            
        }
        $leave->save();
        Session::flash('success','Leave status update Successfully.'); 

        /*-----------------------------------Send notification-------------------------------------------*/  
        $receiver = [$leave->user_id];
        $action = $request->action==1 ? "Accepted" : "Rejected"; 
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."$action your leave request.";
        $message = "<p> $title </p><br>";  
        NotificationController::notify(Auth::user()->id,$receiver,$title,$message); 
      /*-----------------------------------Send notification-------------------------------------------*/ 
   }

   public function leave_info($role,$id){ 
         $leave  =  Leave_tracking::whereId($id)->first();

         //print_r($leave);die();
      
         $html = '<br><table class="table table-condensed table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Comments</th>
                    </tr>
                    </thead>
                    <tbody>';
              if(!empty($leave->tl1)){
                $st = $leave->tl1_response==1 ? "Approved" : "Rejected";
                $html .= '<tr>
                            <td>'.$leave->tl1.'</td>
                            <td>'.$st.'</td>
                            <td>'.$leave->tl1_reason.'</td>
                        </tr>';
                }
                if(!empty($leave->tl2)){
                    $st = $leave->tl2_response==1 ? "Approved" : "Rejected";
                    $html .= '<tr>
                                <td>'.$leave->tl2.'</td>
                                <td>'.$st.'</td>
                                <td>'.$leave->tl2_reason.'</td>
                            </tr>';
                    }
                if(!empty($leave->hr)){
                    $st = $leave->hr_response==1 ? "Approved" : "Rejected";
                    $html .= '<tr>
                                <td>'.$leave->hr.'</td>
                                <td>'.$st.'</td>
                                <td>'.$leave->hr_reason.'</td>
                            </tr>';
                    } 
                if(Auth::user()->role == 1 || Auth::user()->role == 4){
                      $html .= '</tbody></table>
              <div class="form-group"><label for="comments">Please  Mention Your Point. </label><textarea class="form-control" id="comments" rows="3"></textarea></div>';
                    return $html;
                  }else{
                     return $html;
                  }    
              

   }

   public function retract_leave_info($role,$id)
   {
      $leave  =  Leave_tracking::whereId($id)->get();
      
      print_r($leave);die();
   }

   public function retract_leave(Request $request){
       $leave = Leave_tracking::findOrFail($request->leave_id);
       $leave->status = 4;
       $leave->retract_reason = $request->reason;
       $leave->retract_message = $request->message;
       $leave->save(); 

       $emp = EmployeeCbProfile::whereUser_id($leave->user_id)->first();
       $emp->avail_leaves = ( $emp->avail_leaves+1 );
       $emp->save();

        //$url = url('role/leave-listing?type=pending');   
        $receiver = array();
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."Retract Leave."; 
        $message = "<p> $title </p><br>";
       // $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";     
        $admins = \App\User::whereIn('role',[1,2,4])->get();
        Session::flash('success','Your leave Retract Successfully.'); 
        foreach ($admins as $admin) {
          array_push($receiver,$admin->id);  
        }
        NotificationController::notify(Auth::user()->id,$receiver,$title,$message); 
   }

   public function retract_leave_list(){
        $data['leaves'] = Leave_tracking::whereStatus(4)->orderBy('id','desc')->get();
        return view('common.leaves.retract_list', $data);
   }

    public function re_apply_leavePost(Request $request){
       $preleavedeatils = Leave_tracking::whereId($request->id)->first();
           $row['leave_type']       =       $preleavedeatils->leave_type;     
           $row['user_id']          =       $preleavedeatils->user_id;   
           $row['date_from']        =       $preleavedeatils->date_from;  
           $row['date_to']          =       $preleavedeatils->date_to;
           $row['days']             =       $preleavedeatils->days;
           $row['contact_number']   =       $preleavedeatils->contact_number;    
           $row['reason']           =       $preleavedeatils->reason;
           $row['status']           =       3;
           $row['soft_delete']      =       0;
           Leave_tracking::create($row);
           $preleavedeatils->soft_delete = 1;
           $preleavedeatils->status = 5;
           $check = $preleavedeatils->save();
           if($check){
            /*-----------------------------------Send notification-------------------------------------------*/
       if(Auth::user()->department == 'sales')
       {
         $url = url('/sales/teamLead/team-member-leave-listing');   
        $receiver = array();
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."Requested for Leave";
        $message = "<p> $title </p><br>";
        $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";   
       } 
       else
       {
         $url = url('role/leave-listing?type=pending');   
        $receiver = array();
        $title = Auth::user()->first_name." ".Auth::user()->last_name." "."Requested for Leave";
        $message = "<p> $title </p><br>";
        $message.= "<a href='".$url."' class='btn btn-primary leave1'>View</a>";   
       }
       

        if(Auth::user()->role!=2){ 
          $admins = \App\User::where('id','!=',\Auth::user()->id)->whereIn('role',[1,2,4])->get();
          foreach ($admins as $admin) {
            array_push($receiver,$admin->id);  
          }
        }else{
          $receiver[] = 1;
        }  

        NotificationController::notify(Auth::user()->id,$receiver,$title,$message); 

                $data = [
                      'sender_name'    =>  Auth::user()->first_name." ".Auth::user()->last_name,
                      'sender_email'   =>  Auth::user()->email,
                      'reason'         =>  $request->input('reason'), 
                      'designation'    =>  Auth::user()->cb_profile->designation,
                  ];

                  Mail::send('emails.leave_apply', $data, function($m) use ($data){  
                        $m->from($data['sender_email'], $data['sender_name']);
                        $m->to('leaves@codingbrains.com', "HR Manager"); 
                    }); 
       //          /*-----------------------------------Send notification-------------------------------------------*/
            $data['status']  = true;
            return response()->json($data,200); 

           }
    }
}
