<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Loan;
use Auth;
use DB;
use App\EMI;
class LoanController extends Controller
{
  public function add_loan_emp(Request $request){
     
      echo "Loan Aadded employee";
      
  }

  public function loanlist(){
      
       $data['users'] = User::where('role', '!=', 1)->where('is_active', '=', 1)->get();
     $data['loans'] = Loan::with('user')->where('emp_id', '!=', NULL)->get();
      
      return view('admin.loan.loans',$data);
  }


  public function emilist(Request $request){

    $emi = Loan::with('getEMI')->where(['id'=>$request->id,'emp_id'=>$request->user_id])->get();
     
    return response()->json(['emi'=>$emi]);
      
     // return view('admin.loan.loans',$data);
  }

  public function edit_loan(Request $request){
     $id = $request->id; 
     
     $loan_by_id = Loan::where('id',$request->id)->get();

     $loandata = array();
     foreach ($loan_by_id as $key => $loan) {
      array_push($loandata,$loan->id,$loan->emp_id,$loan->amount,$loan->emi,$loan->duration,$loan->aff_date,$loan->status,$loan->message);
    }
    echo json_encode($loandata);
  }

  public function store(Request $request){
    
    $action = $request->action; 
   
    if($action=='update'){
      $id = $request->id;
     
      $loan = Loan::find($id);

      $loan->amount = $request->amount;
      $loan->emi = $request->emi;
      $loan->duration = $request->duration;
      $loan->aff_date = date('Y-m-d',strtotime($request->aff_date));
      $loan->status = $request->status;
      
      $loan->save();
      return response()->json(['msg'=>"Data Updated successfully"]);
      
    }
    if($action=='update_user'){
      $id = $request->id; 
      $loan = Loan::find($id);
      $loan->amount = $request->amount;
      $loan->message = $request->message;
      $loan->save();
      return response()->json(['msg'=>"Data Updated successfully"]);
    }
    
    
    $status = $request->status;
    if(!isset($status)){
      $status = 0;
    }
    $msg = $request->message;
    //$data = DB::table('loans')->insert(['id' => '2','emp_id' => '5', 'amount' => '10']);
    $loan = Loan::create(['emp_id' =>  Auth::user()->id,'amount' =>  $request->amount,'emi' =>  $request->emi,'duration' =>  $request->duration,'aff_date' =>  $request->affective_date,'status' =>  $status,'message' =>  $msg]);
    
    return response()->json(['msg'=>"Loan requested successfully"]);
         
    
  }

  public function loan_management(Request $request){
      $emp_id = Auth::user()->id;
      $data['loans'] = Loan::where('emp_id', '=', $emp_id)->get();
      return view('employee.loan.loans',$data);
  
  }
}
