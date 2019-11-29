@extends('admin.layouts.app')
@section('title','Employee Payroll List')
@section('style')
<style type="text/css">
    /*.border{
        border: 1px solid red;
    }

   
.fixed_headers {
    max-width:980px;
    table-layout:fixed;
    margin:auto;
}
.fixed_headers > th, .fixed_headers > td {
    padding:5px 10px;
    border:1px solid #000;
}
.fixed_headers > thead {
    background:#f9f9f9;
    display:table;
    width:100%;
    width:calc(100% - 18px);
}
.fixed_headers > tbody {
    height:300px;
    overflow:auto;
    overflow-x:hidden;
    display:block;
    width:100%;
}
.fixed_headers > tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}

*/


.border{
        border: 1px solid red;
    }
.fixed_headers tbody{
  display:block;
  overflow:auto;
  height:500px !important;
  width:100%;
}
.fixed_headers thead tr{
  display:block;
}


</style>
@stop
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
    <div class="page-title">
        <h3>Employees Payroll List</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                <li class="active"><a href="#">Employees Payroll List</a></li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
         <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($last_month_salary!=0)
                                @if($Salary_earning==0)
                                    <div class="col-sm-3">
                                        <button id="all_users_add_increments" class="btn btn-success pull-left"  data-toggle="modal" data-target="#modal_all_users_Increments">Add Incentive</button>
                                    </div>
                                    
                                @else
                                    <div class="col-sm-3">
                                        <button id="all_users_view_increments" class="btn btn-success"  data-toggle="modal" data-target="#modal_all_users_Incentive">View Incentive</button>
                                    
                                        <button id="add_increments" class="btn btn-primary"  data-toggle="modal" data-target="#modalIncrements">Edit Incentive</button>
                                    </div>
                                @endif
                                
                                @if($Salary_deduction==0)
                                    <div class="col-sm-3">
                                        <button id="add_deductions" class="btn btn-danger" data-toggle="modal" data-target="#modal_all_users_deductions">Add Deductions</button>


                                    </div>
                                @else
                                    <div class="col-sm-3">
                                        <button id="view_deduction" class="btn btn-warning" data-toggle="modal" data-target="#modal_view_users_deductions">View Deductions</button>
                                        <button id="edit_deductions" class="btn btn-info" data-toggle="modal" data-target="#edit_modal_all_users_deductions">Edit Deductions</button>                                        
                                    </div>
                                @endif
                                <div class="col-sm-4">
                                    @if($salary_status_of_month!=null)
                                        <button class="btn btn-success calculate" data-id="calculate">View Attendance</button>

                                        <button class="btn btn-success salary-calculate" data-id="re_calculate">
                                    
                                        @if(getRoleStr()=='admin')
                                            Verify and Final Calculate
                                        @else
                                            Final Calculate
                                        @endif


                                    
                                        </button>

                                        
                                    @endif

                                </div>
                            @endif


                            <!--display one in a month-->
                            @if($last_month_salary==0)
                                <div class="col-sm-3">
                                    <button class="btn btn-success calculate" data-id="calculate">Start Salary Calculation</button>
                                </div>
                            @endif
                            <!---->
                            
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"> 
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('error') }}
                        </div>
                    @endif 
                    <div class="table-responsive table-remove-padding">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Code </th>
                                    <th>Employee Name </th>
                                    <th>Designation</th>
                                    <th>Joining Date</th> 
                                    <th>Monthly Salary</th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($users as $user)
                                     <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$user->cb_profile->employee_id}}</td>
                                        <td>{{$user->first_name}} {{$user->last_name}} </td>
                                        <td>{{getRoleById($user->role)}}</td>
                                        <td>{{ date('d M-Y', strtotime($user->cb_profile->joining_date))}}</td>
                                        <td>&#x20B9;{{$user->cb_profile->salary}}</td>
                                        <td>
                                           <button class="btn btn-info view_pay" rel="{{$user->id}}"> View Payroll </button>  
                                           <a href="{{route('c.payroll',['role' => getRoleStr(),'id'=> $user->id])}}" class="btn btn-primary" > All Slip </a> 
                                        </td>
                                     </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

    <!--add incentive and dection modals--->
          <!-- preview Modal -->
    <div class="modal fade" id="modalIncrements" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">    
                    <form id="add_employee">           
                        <div class="add_increments">
                            
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <small>Select all</small><br/>
                                                <input type="checkbox" id="users">
                                            </td>
                                            <td>
                                                <b>Employee</b>
                                            </td>
                                        </tr>
                                        
                                             @foreach($users as $key=>$employee)

                                            <tr>
                                                <td><input type="checkbox" name="users" class="users" value="{{$employee->id}}" data-name="{{$employee->first_name.' '.' '.$employee->last_name}}"></td>
                                                <td>
                                                    {{$employee->first_name.' '.' '.$employee->last_name}}
                                                </td>
                                                
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            
                        </div>
                    </div>
                    <div class="modal-footer" style="position:static !important;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-info pull-right btn-info-re" value="next">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- preview Modal -->


<div class="modal fade" id="FsalaryCalculate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Final Salary Calculate</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">    
                              
                       
                    
                       
                    <input type="button"  class="btn btn-info pull-right btn-info-re salary-calculate" value="Final Salary Calculation" data-id="re_calculate">
                   
               
            </div>
        </div>
    </div>
</div>

<!--view incentive-->

    <div class="modal fade" id="modal_all_users_Incentive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">View Incentive</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">  
                    <div class="add_increments">
                        <form class="add-incentive" action="{{url(getRoleStr().'/add-incentive')}}" method="post" data-model_id="modal_all_users_Increments">
                            {{csrf_field()}}
                            <table class="table table-bordered fixed_headers">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Overtime</th>
                                        <th>Incentive</th>
                                        <th>Arrears</th>
                                        <th>Bonus</th>
                                        <th>Loan</th>
                                        <th>Others</th>
                                        <th>Remarks</th>
                                        <!-- <th><span class="fa fa-trash" style="color: red;"></span></th> -->
                                    </tr>
                                </thead>
                                <tbody> 

                                  @foreach($users as $key=>$user)
                                        

                                    <tr id="{{$user->id}}">
                                        <td>{{$user->first_name.' '.$user->last_name}}</td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][overtime]" style="width: 80px !important" value="{{$user->getIncentives($user->id,'OverTime')}}"></td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][incentive]" style="width: 65px !important" value="{{$user->getIncentives($user->id,'Arrears')}}"></td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][area]" style="width: 65px !important" value="{{$user->getIncentives($user->id,'Incentive')}}"></td>
                                        <td>
                                            @if($user->cb_profile->checkStayBonus($user->id)==true)
                                                <input type="number" min="0" name="mincentive[{{$user->id}}][bonus]" style="width: 65px !important" value="{{($user->cb_profile->stay_bonus=='')?0:$user->cb_profile->stay_bonus}}" readonly="true">
                                            @else
                                                <input type="number" min="0" name="mincentive[{{$user->id}}][bonus]" style="width: 65px !important" value="0" readonly="true">

                                            @endif
                                        </td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][loan]" style="width: 65px !important" value="{{$user->getIncentives($user->id,'Loan')}}" readonly></td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][others]" style="width: 65px !important" value="{{$user->getIncentives($user->id,'Others')}}"></td>
                                        <td><input type="text" min="0" name="mincentive[{{$user->id}}][remark]" style="width:65px !important" value="{{$user->getIncentives($user->id,'Remarks')}}"></td>
                                        <!-- <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id="{{$user->id}}">&times</span></td> -->
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer" style="position:static !important;">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

<!--end view incentive-->
    <!-- preview Modal -->

    <!--all users incentive preview Modal -->
    <div class="modal fade" id="modal_all_users_Increments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Add Incentive</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">  
                    <div class="add_increments">
                        <form class="add-incentive" action="{{url(getRoleStr().'/add-incentive')}}" method="post" data-model_id="modal_all_users_Increments">
                            {{csrf_field()}}
                            <table class="table table-bordered fixed_headers">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Overtime</th>
                                        <th>Incentive</th>
                                        <th>Arrears</th>
                                        <th>Bonus</th>
                                        <th>Loan</th>
                                        <th>Others</th>
                                        <th>Remarks</th>
                                        <!-- <th><span class="fa fa-trash" style="color: red;"></span></th> -->
                                    </tr>
                                </thead>
                                <tbody> 
                                  @foreach($users as $key=>$user)

                                    <tr id="{{$user->id}}">
                                        <td>{{$user->first_name.' '.$user->last_name}}</td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][overtime]" style="width: 80px !important"></td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][incentive]" style="width: 65px !important"></td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][area]" style="width: 65px !important"></td>
                                        <td>
                                            @if($user->cb_profile->checkStayBonus($user->id)==true)
                                                <input type="number" min="0" name="mincentive[{{$user->id}}][bonus]" style="width: 65px !important" value="{{($user->cb_profile->stay_bonus=='')?'0':$user->cb_profile->stay_bonus}}" readonly="true">
                                            @else
                                                <input type="number" min="0" name="mincentive[{{$user->id}}][bonus]" style="width: 65px !important" value="0" readonly="true">

                                            @endif
                                        </td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][loan]" style="width: 65px !important" value="{{$user->getLoan($user->id)}}" readonly></td>
                                        <td><input type="number" min="0" name="mincentive[{{$user->id}}][others]" style="width: 65px !important"></td>
                                        <td><input type="text" min="0" name="mincentive[{{$user->id}}][remark]" style="width:65px !important"></td>
                                        <!-- <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id="{{$user->id}}">&times</span></td> -->
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer" style="position:static !important;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-info pull-right btn-info-re" value="Next">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end preview Modal -->

    <!---add employee modal--->

    <!---end employee modal--->


    <!-- preview Modal -->
    <div class="modal fade" id="modalIncentives" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal_size">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Update Incentive</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">
                    <div class="col-sm-12" style="margin-top: 20px">
                        <div class="col-sm-8 form-group">
                            <select id="emp_list" class="form-control">
                                @foreach($users as $key=>$employee)
                                    <option value="{{$employee->id}}" data-name="{{$employee->first_name.' '.' '.$employee->last_name}}">{{$employee->first_name.' '.' '.$employee->last_name}}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="col-sm-4">
                            <button class="add_employee" class="btn btn-success pull-right">Add Employee</button>   
                        </div>
                    </div>
                  
                            
                    <div class="add_increments">
                        <form class="add-incentive" action="{{url(getRoleStr().'/update-incentive')}}" method="post" data-model_id="modalIncentives">
                            {{csrf_field()}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Overtime</th>
                                        <th>Incentive</th>
                                        <th>Arrears</th>
                                        <th>Bonus</th>
                                        <th>Loan</th>
                                        <th>Others</th>
                                        <th>Remarks</th>
                                        <th><span class="fa fa-trash" style="color: red;"></span></th>
                                    </tr>
                                </thead>
                                <tbody id="table_contenet"> 
                                  
                                </tbody>
                            </table>
                        
                    </div>
                </div>
                <div class="modal-footer" style="position:static !important;">
                    <button type="button" class="close_modal btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-info pull-right btn-info-re">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- preview Modal -->



    <!--all users deduction preview Modal -->
    <div class="modal fade" id="modal_all_users_deductions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Add deductions</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">  
                    <div class="add_increments">
                        <form class="add-incentive" action="{{url(getRoleStr().'/add-deductions')}}" method="post" data-model_id="modal_all_users_deductions">
                            {{csrf_field()}}
                            <table class="table table-bordered fixed_headers">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Late Login</th>
                                        <th>Uninformed</th>
                                        <th>Sleeping</th>
                                        <th>ESI Employee ({{get_setting_value('esi_employee')}})%</th>
                                        <th>ESI Employer ({{get_setting_value('esi_employer')}})%</th>
                                        <th>EPF Employee ({{get_setting_value('pf')}})%</th>
                                        <th>EPF Employer ({{get_setting_value('employer_pf')}})%</th>
                                        <th>TDS </th>
                                        <th>Others</th>
                                        <th>Loan EMI</th>
                                        <th>Remarks</th>
                                        <!-- <th><span class="fa fa-trash" style="color: red;"></span></th> -->
                                    </tr>
                                </thead>
                                <tbody> 
                                  @foreach($users as $key=>$user)
                                    <tr id="{{$user->id}}">
                                        <td>{{$user->first_name.' '.$user->last_name}}</td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][late_login]" style="width: 80px !important"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][uninformed]" style="width: 65px !important"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][sleeping]" style="width: 65px !important"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][esi_employee]" style="width: 65px !important" readonly="true" value="{{($user->getSalary!=null)?($user->getSalary->esi):0}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][esi_employer]" style="width: 65px !important" readonly="true" value="{{($user->getSalary!=null)?($user->getSalary->employer_esi):0}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][epf_employee]" style="width: 65px !important" readonly="true" value="{{($user->getSalary!=null)?($user->getSalary->pf):0}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][epf_employer]" style="width:65px !important" readonly="true" value="{{($user->getSalary!=null)?($user->getSalary->employer_pf):0}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][tds]" style="width:65px !important" readonly="true" value="{{($user->getSalary!=null)?($user->getSalary->tds):0}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][other]" style="width:65px !important"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][loan_emi]" style="width:65px !important" value="{{$user->calculateLoan($user->id)}}" readonly></td>

                                        <td><input type="text" min="0" name="mdeductions[{{$user->id}}][remark]" style="width:65px !important"></td>
                                        <!-- <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id="{{$user->id}}">&times</span></td> -->
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer" style="position:static !important;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-info pull-right btn-info-re" value="Next">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end deduction preview Modal -->


    <!--view deduction-->
        
    <div class="modal fade" id="modal_view_users_deductions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">View deductions</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">  
                    <div class="add_increments">
                        <form class="add-incentive" action="{{url(getRoleStr().'/add-deductions')}}" method="post" data-model_id="modal_all_users_deductions">
                            {{csrf_field()}}
                            <table class="table table-bordered fixed_headers">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Late Login</th>
                                        <th>Uninformed</th>
                                        <th>Sleeping</th>
                                        <th>ESI Employee ({{get_setting_value('esi_employee')}})%</th>
                                        <th>ESI Employer ({{get_setting_value('esi_employer')}})%</th>
                                        <th>EPF Employee ({{get_setting_value('pf')}})%</th>
                                        <th>EPF Employer ({{get_setting_value('employer_pf')}})%</th>
                                        <th>TDS</th>
                                        <th>Others</th>
                                        <th>Loan EMI</th>
                                        <th>Remarks</th>
                                        
                                    </tr>
                                </thead>
                                <tbody> 
                                  @foreach($users as $key=>$user)
                                    <tr id="{{$user->id}}">
                                        <td>{{$user->first_name.' '.$user->last_name}}</td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][late_login]" style="width: 80px !important" value="{{$user->getDeductions($user->id,'LateLogin')}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][uninformed]" style="width: 65px !important" value="{{$user->getDeductions($user->id,'Uninformed')}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][sleeping]" style="width: 65px !important" value="{{$user->getDeductions($user->id,'Sleeping')}}"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][esi_employee]" style="width: 65px !important" value="{{$user->getDeductions($user->id,'ESIEmployee')}}" readonly="true"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][esi_employer]" style="width: 65px !important" value="{{$user->getDeductions($user->id,'ESIEmployer')}}" readonly="true"></td>
                                        <td><input type="number" min="0" name="mdeductions[{{$user->id}}][epf_employee]" style="width: 65px !important" value="{{$user->getDeductions($user->id,'EPFEmployee')}}" readonly="true"></td>
                                        <td><input type="text" min="0" name="mdeductions[{{$user->id}}][epf_employer]" style="width:65px !important" value="{{$user->getDeductions($user->id,'EPFEmployer')}}" readonly="true"></td>
                                        <td><input type="text" min="0" name="mdeductions[{{$user->id}}][tds]" style="width:65px !important" value="{{$user->getDeductions($user->id,'TDS')}}" readonly="true"></td>
                                        <td><input type="text" min="0" name="mdeductions[{{$user->id}}][other]" style="width:65px !important" value="{{$user->getDeductions($user->id,'Others')}}"></td>
                                        <td><input type="text" min="0" name="mdeductions[{{$user->id}}][loan_emi]" style="width:65px !important" value="{{$user->calculateLoan($user->id)}}" readonly></td>
                                        <td><input type="text" min="0" name="mdeductions[{{$user->id}}][remark]" style="width:65px !important" value="{{$user->getDeductions($user->id,'Remarks')}}"></td>
                                        
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer" style="position:static !important;">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--end view deduction-->




    <!-- edit deduction preview Modal -->
    <div class="modal fade" id="edit_modal_all_users_deductions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal_size">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">
                    
                            
                    <div class="add_increments">
                        <form id="add_employee_for_deduction">
                            {{csrf_field()}}
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <small>Select all</small><br/>
                                            <input type="checkbox" id="users_deduction">
                                        </td>
                                        <td>
                                            <b>Employee</b>
                                        </td>
                                    </tr>
                                    
                                     @foreach($users as $key=>$employee)

                                    <tr>
                                        <td><input type="checkbox" name="users" class="users" value="{{$employee->id}}" data-name="{{$employee->first_name.' '.' '.$employee->last_name}}"></td>
                                        <td>
                                            {{$employee->first_name.' '.' '.$employee->last_name}}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                    </div>
                </div>
                <div class="modal-footer" style="position:static !important;">
                    <button type="button" class="close_modal btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-info pull-right btn-info-re">Next</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- preview Modal -->




    <!---->
    <!-- edit deductions preview Modal -->
    <div class="modal fade" id="modalDeductions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal_size">
            <div class="modal-content">
                <div class="modal-header modal-bg-color">
                    <button type="button" class="close close_deduction_modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                     <h4 class="modal-title" id="myModalLabel">Update Deductions</h4>
                </div>
                <div class="modal-body" style="overflow-x: scroll;max-height: 400px;">
                    <div class="col-sm-12" style="margin-top: 20px">
                        <div class="col-sm-8 form-group">
                            <select id="emp_list_for_deductions" class="form-control">
                                @foreach($users as $key=>$employee)
                                    <option value="{{$employee->id}}" data-name="{{$employee->first_name.' '.' '.$employee->last_name}}">{{$employee->first_name.' '.' '.$employee->last_name}}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="col-sm-4">
                            <button class="emp_list_for_deductions" class="btn btn-success pull-right">Add Employee</button>   
                        </div>
                    </div>
                  
                            
                    <div class="add_increments">
                        <form class="add-incentive" action="{{url(getRoleStr().'/update-deductions')}}" method="post" data-model_id="modalDeductions">
                            {{csrf_field()}}
                            <table class="table table-bordered fixed_headers">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>LateLogin</th>
                                        <th>Uninformed</th>
                                        <th>Sleeping</th>
                                        <th>ESI Employee ({{get_setting_value('esi_employee')}})%</th>
                                        <th>ESI Employer ({{get_setting_value('esi_employer')}})%</th>
                                        <th>EPF Employee ({{get_setting_value('pf')}})%</th>
                                        <th>EPF Employer ({{get_setting_value('employer_pf')}})%</th>
                                        <th>TDS</th>
                                        <th>Others</th>
                                        <th>Loan EMI</th>
                                        <th>Remarks</th>
                                        <th><span class="fa fa-trash" style="color: red;"></span></th>
                                    </tr>
                                </thead>
                                <tbody id="table_contenet_deductions"> 
                                  
                                </tbody>
                            </table>
                        
                    </div>
                </div>
                <div class="modal-footer" style="position:static !important;">
                    <button type="button" class="close_modal btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-info pull-right btn-info-re">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- preview Modal -->

    <!----->
@endsection

@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
 <script>
    $(document).on('click','.view_pay',function(){ 
        var user = $(this).attr('rel');  
        var role = "{{getRoleStr()}}";
        BootstrapDialog.show({
            title:"Select month and year of the slip.",
            message: $('<div> Please wait loading page...</div>').load("{{route('viewpayroll')}}"),   
            buttons:[{   
                label:"view",
                cssClass:"btn btn-success",
                action: function(dialog){  
                   var month = $('#payroll_month').val();
                   var year = $('#payroll_year').val();
                   if(month!='' && year!='')
                        window.location.href = window.location.origin+"/"+role+"/payrolls-details/?month="+month+"&year="+year+"&emp="+user;
                    else
                        swal('Please select month and year','','warning')
                } 
            },{
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){
                    dialog.close();
                }
            }]
        });
    });



    //add incentive and deduction js open
    // checked and unchecked all check box
    $('#add_increments,#edit_deductions').click(function(){
        $('.checker > span').removeClass('checked');  
    });
    $('#users,#users_deduction').click(function(){ 
        if ($(this).is(':checked')) {       
            $('.checker > span').addClass('checked');
        }else{
            $('.checker > span').removeClass('checked');
        }
    });

    $('#user_next').click(function(){
        if($('.checker > span.checked').length>0){
            
            $('#modalIncrements').removeClass('in');
            $('#modalIncrements').css('display','none');
            $('#modalIncentives').css('display','block');
            $('#modalIncentives').addClass('in');
            
        }else{
            swal({text:"Please select a  employee then click to next",icon: "warning",buttons: true});
        }
    });

    $('.close_modal').click(function(){
        $('#modalIncentives').css('display','none');
        $('.modal-backdrop').remove();
    });
    var users = [];
    var html = '';
    $('#add_employee').submit(function(){
        users = [];
        if($('.checker > span.checked').length>0){
            
            $('#modalIncrements').removeClass('in');
            $('#modalIncrements').css('display','none');
            $('#modalIncentives').css('display','block');
            $('#modalIncentives').addClass('in');
            
            
            $("span.checked > input:not(#users)").each(function(k,v){                
                var data  = {};
                data.id = $(this).val();
                data.name = $(this).data('name');               
                users.push(data);
            });
            
          
            
           
            $.each(users,function(key,value){
                var data = {};
                data.id=value.id;
                data._token="{{csrf_token()}}";
                
                $.ajax({
                    url:"{{url(getRoleStr().'/get-salary-earning')}}",
                    method:"post",
                    data:data,
                    dataType : 'json',
                    
                    success:function(result){
                        console.log(result);
                        if(result.length!=0){
                            html+=`<tr id="`+value.id+`"><td>`+value.name+`</td>`;
                            $.each(result,function(k,v){

                              
                                    
                                    if(v.name=='OverTime'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+value.id+`][overtime]" style="width: 80px !important" value="`+v.amount+`"></td>`;
                                        
                                    }
                                    
                                    if(v.name=='Incentive'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+value.id+`][incentive]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                        
                                    }
                                    if(v.name=='Arrears'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+value.id+`][area]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                        
                                    }

                                    if(v.name=='Bonus'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+value.id+`][bonus]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }

                                    if(v.name=='Loan'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+value.id+`][loan]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }
                                    
                                    if(v.name=='Others'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+value.id+`][others]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }
                                    
                                    
                                    if(v.name=='Remarks'){
                                        if(v.description!=null){
                                            html+=`<td><input class="remark" type="text" min="0" name="mincentive[`+value.id+`][remark]" style="width:65px !important" value="`+v.description+`" required></td>`;
                                        }else{
                                            html+=`<td><input class="remark" type="text" min="0" name="mincentive[`+value.id+`][remark]" style="width:65px !important" value="" required></td>`;
                                        }
                                        
                                        
                                    }
                                    
                                   
                            });
                             html+=`<td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+value.id+`>&times</span></td>
                                </tr>`;
                        }else{
                            html+=`<tr id="`+value.id+`">
                                <td>`+value.name+`</td>
                                <td><input type="number" min="0" name="mincentive[`+value.id+`][overtime]" style="width: 80px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+value.id+`][incentive]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+value.id+`][area]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+value.id+`][bonus]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+value.id+`][loan]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+value.id+`][others]" style="width: 65px !important"></td>
                                <td><input class="remark" type="text" min="0" name="mincentive[`+value.id+`][remark]" style="width:65px !important" required></td>
                                <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+value.id+`>&times</span></td>
                            </tr>`;
                        }
                        $('#table_contenet').html(html); 
                        
                    }
                       

                });
                    
                
            });
           
            $('#table_contenet').html(html);
        }else{
            swal({text:"Please select a  employee then click to next",icon: "warning",buttons: true});
        }
       
        return false;
    });

    /* Find and remove selected table rows */
    $(document).on('click',".delete-row",function(){
        
        var id=$(this).data('id');        
        $('tr#'+id).remove(); 
       
        $.each(users, function(i, el){
            if (this.id == id){
                users.splice(i, 1);
            }
        });
        
        
    });
    //second modal

    $('.add_employee').click(function(){

        var html='';
        var id = $('#emp_list').val();
        var name = $('#emp_list option:selected').data('name');
        var test= Object.keys(users).every(function(key) {
            if (users[key].id==id){
                return false;
            }else{ 
                return true;
            }

        });
        if(test==true){
            var data  = {};
            data.id = id;
            data.name = name;               
            users.push(data);

            data._token="{{csrf_token()}}";
             $.ajax({
                    url:"{{route('geternings',['role'=> getRoleStr()])}}",  
                    method:"post",
                    data:data,
                    dataType : 'json',
                    
                    success:function(result){
                        console.log(result);
                        if(result.length!=0){
                            html+=`<tr id="`+id+`"><td>`+name+`</td>`;
                            $.each(result,function(k,v){

                              
                                    
                                    if(v.name=='OverTime'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+id+`][overtime]" style="width: 80px !important" value="`+v.amount+`"></td>`;
                                        
                                    }
                                    
                                    if(v.name=='Incentive'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+id+`][incentive]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                        
                                    }
                                    if(v.name=='Arrears'){
                                        html +=`<td><input type="number" min="0" name="mincentive[`+id+`][area]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                        
                                    }

                                    if(v.name=='Bonus'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+id+`][bonus]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }

                                    if(v.name=='Loan'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+id+`][loan]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }
                                    
                                    if(v.name=='Others'){
                                        html+=`<td><input type="number" min="0" name="mincentive[`+id+`][others]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }
                                    
                                    
                                    if(v.name=='Remarks'){
                                        if(v.description!=null){
                                            html+=`<td><input class="remark" type="text" min="0" name="mincentive[`+id+`][remark]" style="width:65px !important" value="`+v.description+`" required></td>`;
                                        }else{
                                            html+=`<td><input class="remark" type="text" min="0" name="mincentive[`+id+`][remark]" style="width:65px !important" value="" required></td>`;
                                        }
                                        
                                        
                                    }
                                    
                                   
                            });
                             html+=`<td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+id+`>&times</span></td>
                                </tr>`;
                            $('#table_contenet').append(html); 
                        }else{
                            html+=`<tr id="`+id+`">
                                <td>`+name+`</td>
                                <td><input type="number" min="0" name="mincentive[`+id+`][overtime]" style="width: 80px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+id+`][incentive]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+id+`][area]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+id+`][bonus]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+id+`][loan]" style="width: 65px !important"></td>
                                <td><input type="number" min="0" name="mincentive[`+id+`][others]" style="width: 65px !important"></td>
                                <td><input class="remark" type="text" min="0" name="mincentive[`+id+`][remark]" style="width:65px !important" required></td>
                                <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+id+`>&times</span></td>
                            </tr>`;
                            $('#table_contenet').append(html); 
                        }
                        
                        
                    }
                       

                });
           
        }else{
              swal('You have already added this employee so please add new employee','',"warning");
        }  
    });

    $('.add-incentive').submit(function(){
        var count = 0;
        var modal_id = $(this).data('model_id');
        $('.remark').each(function(){
            if($(this).val()==''){
                count++;
                $(this).addClass('border');
                $(this).focus();
               // return false;
            }else{
                $(this).removeClass('border');
            }
            
        });
       
        if(count>0){
            return false;
        }
        var data   = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            dataType : 'json',
            data: data,
            beforeSend: function() {
                
                $('button[type=submit]').attr('Disabled',true);
                $('input[type=submit]').attr('Disabled',true);
                $('input[type=button]').attr('Disabled',true);
               
            },
            contentType: false,
            processData: false,
           
            success: function(result){
                if(result.status==true){
                    swal(result.msg,'',"success");
                    console.log(modal_id);
                    if(modal_id=='modal_all_users_Increments'){
                        $('#modal_all_users_Increments').removeClass('in');
                        $('#modal_all_users_Increments').css('display','none');
                        $('.modal-backdrop').remove();

                        $('#modal_all_users_deductions').addClass('in');
                        $('#modal_all_users_deductions').css('display','block');
                        $('#modal_all_users_deductions').css('z-index','9999');

                        $('body').append('<div class="modal-backdrop fade in" style="z-index: 1040;"></div>');
                    }

                    if(modal_id=="modal_all_users_deductions"){
                        $('#modal_all_users_deductions').removeClass('in');
                        $('#modal_all_users_deductions').css('display','none');
                        $('.modal-backdrop').remove();

                        $('#FsalaryCalculate').addClass('in');
                        $('#FsalaryCalculate').css('display','block');
                        $('#FsalaryCalculate').css('z-index','9999');

                        $('body').append('<div class="modal-backdrop fade in" style="z-index: 1040;"></div>');
                    }
                    //setTimeout(function(){ window.location.reload(); }, 2000);
                }
                else{
                    swal(result.msg,'',"warning");
                }


            },
            complete: function() {
                $('button[type=submit]').attr('Disabled',false);
                $('input[type=submit]').attr('Disabled',false);
                $('input[type=button]').attr('Disabled',false);
            },
        });
        return false;
    });
    









    //add employee for deduction
    $('#add_employee_for_deduction').submit(function(){
        users = [];
        html="";
        if($('.checker > span.checked').length>0){
            $('#edit_modal_all_users_deductions').removeClass('in');
            $('#edit_modal_all_users_deductions').css('display','none');
            $('#modalDeductions').css('display','block');
            $('#modalDeductions').addClass('in');
            $("span.checked > input:not(#users)").each(function(k,v){
                var data  = {};
                data.id = $(this).val();
                data.name = $(this).data('name');
                users.push(data);
            });

            $.each(users,function(key,value){
                var data = {};
                data.id=value.id;
                data._token="{{csrf_token()}}";
                $.ajax({
                    url:"{{url(getRoleStr().'/get-deduction')}}",
                    method:"post",
                    data:data,
                    dataType : 'json',
                    success:function(result){
                        console.log(result);
                        if(result.length!=0){
                            html+=`<tr id="`+value.id+`"><td>`+value.name+`</td>`;
                            $.each(result,function(k,v){
                                if(v.name=='LateLogin'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][late_login]" style="width: 80px !important" value="`+v.amount+`"></td>`;
                                }
                                if(v.name=='Uninformed'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][uninformed]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                }
                                if(v.name=='Sleeping'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][sleeping]" style="width: 65px !important" value="`+v.amount+`" ></td>`;
                                }
                                if(v.name=='ESIEmployee'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][esi_employee]" style="width: 65px !important" value="`+v.amount+`" readonly></td>`;
                                }
                                if(v.name=='ESIEmployer'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][esi_employer]" style="width: 65px !important" value="`+v.amount+`" readonly></td>`;
                                }
                                if(v.name=='EPFEmployee'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][epf_employee]" style="width: 65px !important" value="`+v.amount+`" readonly></td>`;
                                }
                                if(v.name=='EPFEmployer'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][epf_employer]" style="width: 65px !important" value="`+v.amount+`" readonly></td>`;
                                }
                                if(v.name=='TDS'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][tds]" style="width: 65px !important" value="`+v.amount+`" readonly></td>`;
                                }
                                if(v.name=='Others'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][other]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                }
                                if(v.name=='LoanEMI'){
                                    html+=`<td><input type="number" min="0" name="mdeductions[`+value.id+`][loan_emi]" style="width: 65px !important" value="`+v.amount+`" readonly></td>`;
                                }
                                if(v.name=='Remarks'){
                                    if(v.description!=null){
                                        html+=`<td><input class="remark" type="text" min="0" name="mdeductions[`+value.id+`][remark]" style="width:65px !important" value="`+v.description+`" required></td>`;
                                    }else{
                                        html+=`<td><input class="remark" type="text" min="0" name="mdeductions[`+value.id+`][remark]" style="width:65px !important" value="" required></td>`;
                                    }
                                }
                                
                            });

                            html+=`<td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+value.id+`>&times</span></td>
                                    </tr>`;
                        }else{
                            html+=`<tr id="`+value.id+`">
                                        <td>`+value.name+`</td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][late_login]" style="width: 80px !important">
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][uninformed]" style="width: 65px !important">
                                            </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][sleeping]" style="width: 65px !important">
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][esi_employee]" style="width: 65px !important">
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][esi_employer]" style="width: 65px !important">
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][epf_employee]" style="width: 65px !important">
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][epf_employer]" style="width: 65px !important">
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="mdeductions[`+value.id+`][tds]" style="width: 65px !important">
                                        </td>
                                        <td><input type="number" min="0" name="mdeductions[`+value.id+`][other]" style="width: 65px !important">
                                        </td>
                                        
                                        <td><input type="number" min="0" name="mdeductions[`+value.id+`][loan_emi]" style="width: 65px !important" readonly>
                                        </td>
                                        <td>
                                            <input class="remark" type="text" min="0" name="mdeductions[`+value.id+`][remark]" style="width:65px !important" required>
                                        </td>
                                        <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+value.id+`>&times</span>
                                        </td>
                                    </tr>`;
                        }
                       
                        $('#table_contenet_deductions').html(html); 
                            
                    }
                });
            });
            
            $('#table_contenet_deductions').html(html);
        }else{
            swal({text:"Please select a  employee then click to next",icon: "warning",buttons: true});
        }
           
        return false;
    });


    $('.close_deduction_modal').click(function(){
        $('#modalDeductions').css('display','none');
        $('.modal-backdrop').remove();
    });

    $('.emp_list_for_deductions').click(function(){
        console.log(users);
        var html='';
        var id = $('#emp_list_for_deductions').val();
        var name = $('#emp_list_for_deductions option:selected').data('name');
        var test= Object.keys(users).every(function(key) {
            if (users[key].id==id){
                return false;
            }else{ 
                return true;
            }

        });
        if(test==true){
            var data  = {};
            data.id = id;
            data.name = name;               
            users.push(data);

            data._token="{{csrf_token()}}";
             $.ajax({
                    url:"{{url(getRoleStr().'/get-deduction')}}",
                    method:"post",
                    data:data,
                    dataType : 'json',
                    
                     success:function(result){
                        console.log(result);
                        if(result.length!=0){
                            html+=`<tr id="`+id+`"><td>`+name+`</td>`;
                            $.each(result,function(k,v){

                              
                                     if(v.name=='LateLogin'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][late_login]" style="width: 80px !important" value="`+v.amount+`"></td>`;
                                        
                                    }
                                    
                                    if(v.name=='Uninformed'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][uninformed]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                        
                                    }
                                    if(v.name=='Sleeping'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][sleeping]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                        
                                    }

                                    if(v.name=='ESIEmployee'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][esi_employee]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }

                                    if(v.name=='ESIEmployer'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][esi_employer]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }
                                    
                                    if(v.name=='EPFEmployee'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][epf_employee]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }


                                    if(v.name=='EPFEmployer'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][epf_employer]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                       
                                    }

                                    if(v.name=='TDS'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][tds]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                    }

                                    if(v.name=='Others'){
                                        html+=`<td><input type="number" min="0" name="mdeductions[`+v.id+`][other]" style="width: 65px !important" value="`+v.amount+`"></td>`;
                                    }
                                    
                                    
                                    if(v.name=='Remarks'){
                                        if(v.description!=null){
                                            html+=`<td><input class="remark" type="text" min="0" name="mdeductions[`+v.id+`][remark]" style="width:65px !important" value="`+v.description+`" required></td>`;
                                        }else{
                                            html+=`<td><input class="remark" type="text" min="0" name="mdeductions[`+v.id+`][remark]" style="width:65px !important" value="" required></td>`;
                                        }
                                        
                                        
                                    }
                                   
                                    
                                   
                            });
                             html+=`<td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+id+`>&times</span></td>
                                </tr>`;
                            $('#table_contenet_deductions').append(html); 
                        }else{
                          html+=`<tr id="`+id+`">
                                <td>`+name+`</td>
                                <td><input type="number" min="0" name="mdeductions[`+id+`][late_login]" style="width: 80px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][uninformed]" style="width: 65px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][sleeping]" style="width: 65px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][esi_employee]" style="width: 65px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][esi_employer]" style="width: 65px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][epf_employee]" style="width: 65px !important"></td>
                                <td>
                                <input type="number" min="0" name="mdeductions[`+id+`][epf_employer]" style="width: 65px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][tds]" style="width: 65px !important"></td>

                                <td><input type="number" min="0" name="mdeductions[`+id+`][other]" style="width: 65px !important"></td>

                                <td><input class="remark" type="text" min="0" name="mdeductions[`+id+`][remark]" style="width:65px !important" required></td>

                                <td><span class="delete-row btn btn-large" style="color:red;font-size:18px" data-id=`+id+`>&times</span></td>
                            </tr>`;
                            
                        }
                        console.log(html);
                        $('#table_contenet_deductions').append(html); 
                    }
                       

                });
           
        }else{
              swal('You have already added this employee so please add new employee','',"warning");
        } 
    });


    // calculate salary
    $('.salary-calculate').click(function(){
        var data={};
           data.action= $(this).data('id');
        $.ajax({
            url:"{{url('calculate-monthly-salary')}}",
            method:"get",
            dataType:'json',
            data:data,
            success: function(result){
                if(result.status==true){
                    $(this).hide();
                    swal('Salary Calculated successfully');
                    setTimeout(function(){ window.location.reload(); }, 3000);
                    //window.location.reload();
                }
            },
        });
    })
   // incentive and deduction js close

   $(document).on('click','.calculate',function(){
        var data={};
        data.action= $(this).data('id');
        @if($salary_status_of_month!=null)
            BootstrapDialog.show({
                title:"view attendance",
                size:BootstrapDialog.SIZE_WIDE,
                message: $('<div>Please wait loading page...</div>').load('{{url(getRoleStr()."/at-veiw-data")}}')
                
            });
        @else
            BootstrapDialog.show({
                title:"view attendance",
                size:BootstrapDialog.SIZE_WIDE,
                message: $('<div>Please wait loading page...</div>').load('{{url(getRoleStr()."/at-veiw-data")}}'),
                buttons:[{
                        label:"Close",
                        cssClass:"btn btn-danger",
                        action: function(dialog){
                            dialog.close();
                        }
                    },{
                        label:"Next",
                        cssClass:"btn btn-success",
                        action: function(dialog){
                        
                        $.ajax({
                            url:"{{url('calculate-monthly-salary')}}",
                            method:"get",
                            dataType:'json',
                            data:data,
                            success: function(result){
                                if(result.status==true){                                
                                     dialog.close();
                                     window.location.reload();
                                     /*$('#modal_all_users_Increments').addClass('in');
                                     $('#modal_all_users_Increments').css('display','block');
                                     $('#modal_all_users_Increments').css('z-index','9999');
                                     $('body').append('<div class="modal-backdrop fade in" style="z-index: 1040;"></div>');*/
                                     

                                }
                            },
                        });
                    }
                }]
            });
        @endif

        
   });
   /*@if($salary_status_of_month!=null)
        @if($Salary_earning==0)
            $('#modal_all_users_Increments').addClass('in');
            $('#modal_all_users_Increments').css('display','block');
            $('#modal_all_users_Increments').css('z-index','9999');
            $('body').append('<div class="modal-backdrop fade in" style="z-index: 1040;"></div>');
        @else
            @if($Salary_deduction==0)
                $('#modal_all_users_deductions').addClass('in');
                $('#modal_all_users_deductions').css('display','block');
                $('#modal_all_users_deductions').css('z-index','9999');
                $('body').append('<div class="modal-backdrop fade in" style="z-index: 1040;"></div>');
            @endif
        @endif


    @endif*/
 </script>
@endsection
