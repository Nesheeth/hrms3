<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\AttendanceData;



use DB;





class LeavecountController extends Controller

{

public function leavecount1()

{   

	  $current_year = date('Y');

	  $current_month = date('m'); 

   $all_employees = DB::table('employee_cb_profiles')->get();

    foreach($all_employees as $all_employee)

    {

      $emp_join_date = explode("/",$all_employee->joining_date);

     $int = settype($emp_join_date[2],"integer");

     $int1 = settype($emp_join_date[1],"integer");

     $int2 = settype($emp_join_date[0],"integer");

  

     if($emp_join_date[2] == $current_year )

     {// echo "hello";

        if($emp_join_date[1] == $current_month )

        {



   	     $all_emp_id = $all_employee->employee_id;

     // echo "if--";

       if($emp_join_date[0] > date('d')){

       //	echo "innerif";

        	DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> 0]);

							}

	   else

	   {

		DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> 1]);

	   }

     }

   }

   else{

       echo "else";

       $firstdate_of_month = date('Y-m-01'); 

      $lastdate_of_month = date('Y-m-t');

      $all_emp_id =$all_employee->employee_id;

      $query ='SELECT count(distinct IF(status = "P", attendance_date, NULL)) as TOTAL_PRESENT,count(distinct IF(status = "AB", attendance_date, NULL)) as TOTAL_Absent,count(distinct IF(status = "HD", attendance_date, NULL)) as TOTAL_HD,count(distinct IF(status = "UI", attendance_date, NULL)) as TOTAL_UI FROM attendance_data WHERE employee_id = "'.$all_emp_id.'" and attendance_date > "'.$firstdate_of_month.'" and attendance_date < "'. $lastdate_of_month.'"';

     $emptoatlworkingdays = DB::select($query);

   

    if($emptoatlworkingdays[0]->TOTAL_HD >= 2 || $emptoatlworkingdays[0]->TOTAL_Absent >= 1 || $emptoatlworkingdays[0]->TOTAL_UI >= 1)

    {

      

      $currentavailleaves = $all_employee->avail_leaves;

      if($currentavailleaves > 0){

      $userid = $all_employee->user_id;

      $takenleave = DB::table('leaves')->where('user_id','=',$userid)->where('created_at','>',$firstdate_of_month)->where('created_at','<',$lastdate_of_month)->select('days')->get();

           $totalleavetaken=0; 

       

      foreach($takenleave as $takens)

         {

         	$taken = $takens->days;

         

         	$totalleavetaken += $taken;

     

         }

       

         if($totalleavetaken < $currentavailleaves )

           {

            // echo 'if';

          DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->decrement('avail_leaves', $totalleavetaken);

           }

          else

          {

          	//echo 'else';

          	DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> 0]);

          }

        

    }

  }

    else

     { 

         //echo 'else';

      	 $avail_leave = $all_employee->avail_leaves;

      	 $avail_leave = $avail_leave + 1;

         DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> $avail_leave]); 



     }

   }

  }

  return redirect()->back()->with('updated');

 }

 public function leavecount($id)

{   

    $current_year = date('Y');

    $current_month = date('m'); 

   $all_employees = DB::table('employee_cb_profiles')->where('user_id',$id)->get();



    foreach($all_employees as $all_employee)

    {

      

      $emp_join_date = explode("/",$all_employee->joining_date);

     $int = settype($emp_join_date[2],"integer");

     $int1 = settype($emp_join_date[1],"integer");

     $int2 = settype($emp_join_date[0],"integer");

  

     if($emp_join_date[2] == $current_year )

     {// echo "hello";

        if($emp_join_date[1] == $current_month )

        {



         $all_emp_id = $all_employee->employee_id;

     // echo "if--";

       if($emp_join_date[0] > date('d')){

       // echo "innerif";

          DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> 0]);

              }

     else

     {

    DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> 1]);

     }

     }

   }

   else{

       echo "else";

       $firstdate_of_month = date('Y-m-01'); 

      $lastdate_of_month = date('Y-m-t');

      $all_emp_id =$all_employee->employee_id;

      $query ='SELECT count(distinct IF(status = "P", attendance_date, NULL)) as TOTAL_PRESENT,count(distinct IF(status = "AB", attendance_date, NULL)) as TOTAL_Absent,count(distinct IF(status = "HD", attendance_date, NULL)) as TOTAL_HD,count(distinct IF(status = "UI", attendance_date, NULL)) as TOTAL_UI FROM attendance_data WHERE employee_id = "'.$all_emp_id.'" and attendance_date > "'.$firstdate_of_month.'" and attendance_date < "'. $lastdate_of_month.'"';

     $emptoatlworkingdays = DB::select($query);

   

    if($emptoatlworkingdays[0]->TOTAL_HD >= 2 || $emptoatlworkingdays[0]->TOTAL_Absent >= 1 )

    {

      

      $currentavailleaves = $all_employee->avail_leaves;

      if($currentavailleaves > 0){

      $userid = $all_employee->user_id;

      $takenleave = DB::table('leaves')->where('user_id','=',$userid)->where('created_at','>=',$firstdate_of_month)->where('created_at','<=',$lastdate_of_month)->select('days')->get();

           $totalleavetaken=0; 

       

      foreach($takenleave as $takens)

         {

          $taken = $takens->days;

         

          $totalleavetaken += $taken;

     

         }

       

         if($totalleavetaken < $currentavailleaves )

           {

            // echo 'if';

          DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->decrement('avail_leaves', $totalleavetaken);

           }

          else

          {

            //echo 'else';

            DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> 0]);

          }

        

    }

  }

    else

     { 

         //echo 'else';

         // $avail_leave = $all_employee->avail_leaves;

         // $avail_leave = $avail_leave + 1;

         // DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['avail_leaves'=> $avail_leave,'updated_at'=> date('Y-m-d h:m:s')]); 

         DB::table('employee_cb_profiles')->where('employee_id',$all_emp_id)->update(['leaves_taken'=> 0,'updated_at'=>date('Y-m-d h:m:s')]);



     }

   }

  }

  return redirect()->back()->with('success','leaves info updated');

 }

}

