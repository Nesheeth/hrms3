@extends('admin.layouts.app')

@section('title','Employee Payroll List')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
            <div class="page-title">
                <h3>Employees Payroll List</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                        <li class="active"><a href="#"> Payslips List</a></li>
                    </ol>
                </div>
            </div>

        <div id="main-wrapper">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12"> 
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td><strong>Employee Id : </strong>{{$user->cb_profile->employee_id}}</td>
                                        <td><strong>Employee Name : </strong> {{$user->first_name}} {{$user->last_name}}  </td>
                                        <td><strong>Position :</strong> {{$user->cb_profile->designation}}  </td>
                                        
                                    </tr>
                                    <tr>
                                        <td><strong> Joining Date :</strong> {{date('d M-Y', strtotime($user->cb_profile->joining_date))}} </td>
                                        <td> <strong>Appraisal Date :</strong> {{date('d M-Y', strtotime($user->cb_profile->appraisal_date))}}</td>
                                        <td><strong>Current Date :</strong> {{date("F j, Y, g:i a")}}</td>
                                    </tr>
                                    
                                </thead>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
           
            <div class="panel panel-white">
                <div class="panel-body">
                <div class="col-md-12"> 
                            <div class="table-responsive table-remove-padding">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Month-Year</th>
                                            <th>Monthly Salary</th>
                                            <th>Gross Salary</th>
                                            <th> Net Salary </th>
                                            <th> Employee </th>
                                            <th> HR </th>
                                            {{--<th> Accountent </th>--}}
                                            <th> Management </th>
                                            <!-- <th> View </th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($payrolls as $roll)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <!-- <td>{{ $roll->salary_month}} - {{$roll->salary_year}}</td> -->
                                                <td>
                                                    <a href="{{route('c.payrolldetails',['role' => getRoleStr(),'id'=>$roll->id])}}"> 
                                                      {{ date('F', mktime(0, 0, 0, $roll->salary_month, 10)) }} - {{$roll->salary_year}} 
                                                    </a>
                                                </td>
                                                <td>&#x20B9;{{$roll->cb_profile->salary}}</td>
                                                <td>{{$roll->gross_salary}}</td>
                                                <td>{{$roll->net_salary}}</td>
                                                <td>
                                                    @if($roll->emp_status == 0) 
                                                    <span class="label label-warning">Pending</span>
                                                    @elseif($roll->emp_status == 1)
                                                    <span class="label label-success">Approved</span>
                                                    @elseif($roll->emp_status == 2)
                                                    <span style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="{{$roll->emp_description}}" class="label label-danger">Issue</span>                                                    
                                                    @endif
                                                </td>
                                                <td>
												    @if($roll->hr_status == 0) 
                                                    <span class="label label-warning">Pending</span>
                                                    @elseif($roll->hr_status == 1)
                                                    <span class="label label-success">Approved</span>
													@endif
												</td>
                                                {{--<td>
												    @if($roll->acc_status == 0) 
                                                    <span class="label label-warning">Pending</span>
                                                    @elseif($roll->acc_status == 1)
                                                    <span class="label label-success">Approved</span>
													@endif
												</td>--}}
                                                <td>
												    @if($roll->management_status == 0) 
                                                    <span class="label label-warning">Pending</span>
                                                    @elseif($roll->management_status == 1)
                                                    <span class="label label-success">Approved</span>
													@endif
												</td>
                                               {{--  <td> 
												
												@php $st = "" @endphp
												@if(Auth::user()->role==2)
												   @php	$st = ($roll->emp_status != 1 || $roll->acc_status !=1 || $roll->management_status !=1) ? "disabled" : "" @endphp
												@elseif(Auth::user()->role==8)
												   @php	$st = ($roll->hr_status != 1 || $roll->management_status !=1)  ? "disabled" : "" @endphp
												@endif
                                                <button {{$st}}  rel="{{$roll->id}}" class="btn btn-info change_status" >Change Status</button> 
                                                <a href="{{ route('c.payrolldetails',['role' => getRoleStr(),'id'=> $roll->id]) }}" class="btn btn-info view_pay" >More</a> 
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script>
    $(document).on('click','.change_status',function(){
		
		    var pay_id = $(this).attr('rel'); 
			
             BootstrapDialog.show({
				title:"Approve Payroll Status",
				message: "<br> I have review pay roll and this is correct as per my Info.",
				buttons:[{
					label:"Approve",
					cssClass:"btn btn-success",
					action: function(dialog){
						$.ajax({
							url:"{{route('mg.payroll_status')}}",
							type:"get",
							data:{pay_id:pay_id},
							success:function(res){
								console.log(res); 
								dialog.close();
								swal('Success!','Payroll Status updated successfully.','success');
								setTimeout(function() { location.reload() },3000); 
							}
						}); 
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

</script>
@endsection
