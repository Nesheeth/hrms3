@extends('admin.layouts.app')
@section('content')
@section('title','Employee')
<style>
.form-group {margin-right: 13px !important;}
.per-bor {border-bottom: 2px solid;}
.per-bor label {font-size: 20px;padding: 14px 0px 10px 0px;}
</style>
<div class="page-inner">
	<div class="page-title">
		<h3>Employees</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/employees')}}">Employees</a></li>
				<li class="active">Update Employee</li>
			</ol>
		</div>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				@if (session('success'))
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('success') }}
				</div>
				@endif
				@if (session('error'))
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('error') }}
				</div>
				@endif
				<div class="panel panel-white">
					<div class="panel-body">
						<div id="rootwizard">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Personal Info</a></li>
								<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Employee CB Profile</a></li>
								<li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Previous Employment Profile</a></li>
								<li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Employee CB More Details</a></li>
							</ul>
                            <!-- <form id="wizardForm"> -->
								<form class="form-horizontal" method="post" action="{{URL('/admin/employee/update')}}" enctype="multipart/form-data" id="employeeForm" autocomplete="off">
									<div class="tab-content">
										{{csrf_field()}}
										<input type="hidden" name="id" value="{{$employee->id}}" class="emp_id">
										<div class="tab-pane active fade in" id="tab1">
											<div class="row m-b-lg">
												<div class="col-md-12">
														<div class="form-group col-md-4">
															<label for="department">Department</label>
															<select name="department" id="department" class="form-control">
																<option value="">--Select Department--</option>
																<option value="development" {{$employee->department == "development" ? "selected":""}}>DEVELOPMENT</option>
																<option value="sales" {{$employee->department == "sales" ? "selected":""}}>SALES</option>
															</select>
															@if ($errors->has('department'))
															<span class="label label-danger">{{ $errors->first('department') }}</span>
															@endif
														</div>
														<div class="form-group  col-md-4">
															<label for="role">Role</label>
															<select name="role" id="role" class="form-control" >
																<option value="">--Select Role--</option>
																@foreach($roles as $role )
																<option value="{{$role->id}}" {{$role->id == $employee->role ? 'selected':''}}>{{$role->role}}</option>
																@endforeach
															</select>
														</div>
														<div class="form-group  col-md-4">
															<label for="gender">Gender</label>
															<select name="gender" id="gender" class="form-control" >
																<option value="">--Select Gender--</option>
																<option value="male" {{$employee->gender == "male" ?'selected':''}}>Male</option>
																<option value="female" {{$employee->gender == "female" ?'selected':''}}>Female</option>
															</select>
															@if ($errors->has('gender'))
															<span class="label label-danger">{{ $errors->first('gender') }}</span>
															@endif
														</div>
														<div class="form-group col-md-6">
															<label for="first_name">First Name</label>
															<input type="text" class="form-control" name="first_name" id="first_name" value="{{$employee->first_name}}" placeholder="First Name">
															@if ($errors->has('first_name'))
															<span class="label label-danger">{{ $errors->first('first_name') }}</span>
															@endif
														</div>
														<div class="form-group  col-md-6">
															<label for="last_name">Last Name</label>
															<input type="text" class="form-control col-md-6" name="last_name" id="last_name"  value="{{$employee->last_name}}" placeholder="Last Name" >
														</div>
														<div class="form-group col-md-12">
															<label for="email">Email address</label>
															<input type="email" class="form-control" name="email" id="email" readonly value="{{$employee->email}}" placeholder="Enter email" >
														</div>
														<div class="form-group  col-md-12">
															<label for="address">Address</label>
															<textarea name="address" id="address"  class="form-control" cols="30" rows="10">{{$employee->personal_profile->address}}</textarea>
														</div>
														<div class="form-group  col-md-6">
															<label for="phone_number">Phone #</label>
															<input type="text" class="form-control col-md-6" name="phone_number" id="phone_number" value="{{$employee->personal_profile->phone_number}}" placeholder="Phone number" >
														</div>
														<div class="form-group  col-md-6">
															<label for="aadhar_no">Aadhar #</label>
															<input type="text" class="form-control col-md-6" name="aadhar_no" id="aadhar_no" value="{{$employee->personal_profile->aadhar_no}}" placeholder="Aadhar number" >
														</div>
														<div class="form-group  col-md-4">
															<label for="dob">Date Of Birth</label>
															<input type="text" class="pastDatepicker form-control col-md-6" name="dob" id="dob"  value="{{$employee->personal_profile->dob}}" placeholder="Date Of Birth" >
														</div>
														<div class="form-group  col-md-4">
															<label for="martial_status">Marital  Status</label>
															<select name="martial_status" id="martial_status" class="form-control">
																<option value="">--Select Marital  Status--</option>
																<option value="unmarried" {{$employee->personal_profile->martial_status == "unmarried" ? "selected":''}}>Unmarried</option>
																<option value="married" {{$employee->personal_profile->martial_status == "married" ? "selected":''}}>Married</option>
															</select>
														</div>
														<div class="form-group  col-md-4" id="ann_div">
															<label for="anniversary_date">Anniversary</label>
															<input type="text" class="pastDatepicker form-control col-md-6" name="anniversary_date" id="anniversary_date"  value="{{$employee->personal_profile->anniversary_date}}" placeholder="Anniversary" >
														</div>
														<div class="form-group col-md-12 per-bor">
															<label for="personal_info">Personal Details</label>
														</div>
														<div class="form-group col-md-6">
															<label for="personal_email">Personal Email</label>
															<input type="email" class="form-control" name="personal_email" id="personal_email"  value="{{$employee->personal_profile->personal_email}}" placeholder="Enter email" >
														</div>
														<div class="form-group col-md-6">
															<label for="father_name">Father Name</label>
															<input type="text" class="form-control" name="father_name" id="father_name"  value="{{$employee->personal_profile->father_name}}" placeholder="Father Name">
														</div>
														<div class="form-group col-md-6">
															<label for="mother_name">Mother Name</label>
															<input type="text" class="form-control" name="mother_name" id="mother_name"  value="{{$employee->personal_profile->mother_name}}" placeholder="Mother Name">
														</div>
														<div class="form-group col-md-6">
															<label for="parent_number">Parent Contact No.</label>
															<input type="text" class="form-control" name="parent_number" id="parent_number"  value="{{$employee->personal_profile->parent_contact_number}}" placeholder="Parent Contact Number">
														</div>
														<div class="form-group col-md-12 per-bor">
															<label for="personal_info">Bank Account information</label>
														</div>
														<div class="form-group col-md-6">
															<label for="account_holder_name">Account Holder Name</label>
															<input type="text" class="form-control" name="account_holder_name" id="account_holder_name" value="{{$employee->personal_profile->account_holder_name}}" placeholder="Account Holder Name" >
														</div>
														<div class="form-group col-md-6">
															<label for="bank_name">Bank Name</label>
															<input type="text" class="form-control" name="bank_name" id="bank_name" value="{{$employee->personal_profile->bank_name}}" placeholder="Bank Name" >
														</div>
														<div class="form-group  col-md-6">
															<label for="account_no">Bank Account #</label>
															<input type="text" class="form-control col-md-6" name="account_no" id="account_no" value="{{$employee->personal_profile->bank_account}}" placeholder="Account number" >
														</div>
														<div class="form-group col-md-6">
															<label for="ifsc_code">IFSC Code</label>
															<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="{{$employee->personal_profile->ifsc_code}}" placeholder="IFSC Code">
														</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="tab2">
												<div class="col-md-12">
														<div class="form-group col-md-6 employeeimgchng">
															<label for="employee_photo">Photo</label>
															<div class="profilepicupload">
																<img src="{{$employee->cb_profile->employee_pic}}" alt="" height="100" width="100">
																<input type="file" class="form-control" name="employee_photo" id="employee_photo">
															</div>
															@if ($errors->has('employee_photo'))
															<span class="label label-danger">{{ $errors->first('employee_photo') }}</span>
															@endif
															
														</div>
														<div class="form-group  col-md-6">
															<label for="designation">Designation</label>
															<input type="text" value="{{$employee->cb_profile->designation}}" class="form-control col-md-6" name="designation" id="designation" placeholder="Designation" >
														</div>
														<div class="form-group  col-md-6">
															<label for="biometric">Employee Biometric Code</label>
															<input type="text" value="{{$employee->cb_profile->attendance_id}}" class="form-control col-md-6" name="biometric" id="biometric" placeholder="Employee Biometric Code" >
														</div>
														<div class="form-group col-md-12">
															<label for="joined_as">Joined as</label>
															<input type="text" class="form-control" name="joined_as" id="joined_as" value="{{$employee->cb_profile->joined_as}}"  placeholder="Joined as" >
														</div>
														<div class="form-group col-md-6">
															<label for="joining_date">Joining Date</label>
															<input type="text" class="datepicker form-control" name="joining_date" id="joining_date" value="{{$employee->cb_profile->joining_date}}"  placeholder="Joining Date" >
														</div>
														<div class="form-group col-md-6">
															<label for="notice_period">Notice Period</label>
															<input type="number" class=" form-control" name="notice_period" id="notice_period" value="{{$employee->cb_profile->notice_period}}"  placeholder="Notice Period" min="0">
														</div>
														<div class="form-group col-md-12">
															<label for="employee_status">Status</label>
															<select name="employee_status" id="employee_status" class="form-control">
																<option value="active" {{$employee->cb_profile->status=="active"?"selected":''}}>Active</option>
																<option value="deactive" {{$employee->cb_profile->status=="deactive"?"selected":''}}>Deactive</option>
															</select>
														</div>
														<div class="form-group col-md-12">
															<label for="salary">Salary</label>
															<input type="text" class="form-control" name="salary" id="salary"  value="{{$employee->cb_profile->salary}}" placeholder="Salary" >
														</div>
														<div class="form-group col-md-12">
															<input type="text" class="form-control" name="stay_bonus" id="stay_bonus"  value="{{$employee->cb_profile->stay_bonus}}" placeholder="Stay Bonus" >
														</div>
														<div class="form-group col-md-12">
															<input type="text" class="form-control" name="tds" id="tds"  value="{{$employee->cb_profile->tds}}" placeholder="TDS" >
														</div>
														<div class="form-group col-md-12">
															<label for="appraisal_date">Appraisal Date</label>
															<input type="text" class="datepicker form-control" name="appraisal_date" id="appraisal_date"  value="{{$employee->cb_profile->appraisal_date}}" placeholder="Appraisal Date" >
														</div>
														<!-- <div class="form-group col-md-12">
															<label for="epf">EPF Detail</label>
															<input type="text" class="form-control" name="epf" id="epf"  value="{{$employee->cb_profile->epf}}" placeholder="EPF Detail" >
														</div>
														<div class="form-group col-md-12">
															<label for="esi">ESI Detail</label>
															<input type="text" class="form-control" name="esi" id="esi"  value="{{$employee->cb_profile->esi}}" placeholder="ESI Detail" >
														</div> -->
														<div class="form-group col-md-12">



															<label for="epf">EPF Detail</label>
															<select name="epf" class="form-control">
																
																<option value="1" @if($employee->cb_profile->epf==1) selected @endif>Yes</option>
																<option value="0" @if($employee->cb_profile->epf==0) selected @endif>No</option>
															</select>


															



														</div>



														<div class="form-group col-md-12">



															<label for="esi">ESI Detail</label>


															<select name="esi" class="form-control">
																
																<option value="1" @if($employee->cb_profile->esi==1) selected @endif>Yes</option>
																<option value="0" @if($employee->cb_profile->esi==0) selected @endif>No</option>
															</select>
															



														</div>
												</div>
										</div>
										<div class="tab-pane fade" id="tab3">
											<div class="row">
												<div class="col-sm-12 table-responsive">
													<table class="table table-bordered">
														<thead>
															<th>Sr No</th>
															<th>Total Experience</th>
															<th>Company Name</th>
															<th>Company Join Date</th>
															<th>Company Relieving Date</th>
															<th>Company Salary</th>
															<th>Designation</th>
															<th>Gap</th>
															<th>Gap Start Date</th>
															<th>Gap End Date</th>
															<th>BGV Status</th>
															<th>UAN</th>
															<th>ESI</th>
															<th>Action</th>
														</thead>
														<tbody id="emp_previous_employment">
															
															@if(count($employee->previous_employment)>0)
																@foreach($employee->previous_employment as $key=> $previous_employment)
																	<tr id="{{++$loop->index}}">
																		<td>{{$loop->index}}
                                                                           <input type="hidden" value="{{$previous_employment->gap_end_date}}" class="gap_ed_date">
																			<input type="hidden" name="user[gap_start_date][]" value="{{$previous_employment->gap_start_date}}"><input type="hidden" name="user[gap_end_date][]" value="{{$previous_employment->gap_end_date}}"></td>
																		@if($key==0)
																		<td>
																		<input type="hidden" class="form-control pointer_events" name="user[total_experience][]" value="{{$previous_employment->total_experience}}" placeholder="Total Experience" autocomplete="off" ><span class="total_experience">
																			@php
																				$getYear = $previous_employment->total_experience/365;
																		       echo (int) $getYear .' Years ';
																		        $getMonth = ($previous_employment->total_experience%365)/30;
																		        echo (int) $getMonth . ' Months ';
																		        $getDays = ($previous_employment->total_experience%365)%30;
																		        echo (int) $getDays . ' Days ';
																			@endphp
																			</span></td>
																		@else
																			<td>
																				<input type="hidden" class="form-control" value="{{$previous_employment->total_experience}}" placeholder="Total Experience" name="user[total_experience][]" autocomplete="off">
																				<span class="total_experience">
																			@php
																				$getYear = $previous_employment->total_experience/365;
																		       echo (int) $getYear .' Years ';
																		        $getMonth = ($previous_employment->total_experience%365)/30;
																		        echo (int) $getMonth . ' Months ';
																		        $getDays = ($previous_employment->total_experience%365)%30;
																		        echo (int) $getDays . ' Days ';
																			@endphp
																		</span>
																			</td>
																		@endif
																		<td>
																			<input type="hidden" name="user[id][]" value="{{$previous_employment->id}}">
																			<input type="hidden" name="user[last_company_details][]"   class="form-control pointer_events" autocomplete="off" value="{{$previous_employment->last_company_details}}"><span>{{$previous_employment->last_company_details}}</span></td>
																		<td><input type="hidden" class="datepicker form-control last_company_joining_date pointer_events" name="user[last_company_joining_date][]"  value="{{$previous_employment->last_company_joining_date}}" placeholder="Last Company Joining Date" autocomplete="off"><span>{{$previous_employment->last_company_joining_date}}</span></td>
																		<td><input type="hidden" class="datepicker form-control last_company_relieving pointer_events" name="user[last_company_relieving][]"  value="{{$previous_employment->last_company_relieving}}" placeholder="Last Company Relieving Date" ><span>{{$previous_employment->last_company_relieving}}</span></td>
																		<td><input type="hidden" class="form-control pointer_events" name="user[last_company_salary][]"  value="{{$previous_employment->last_company_salary}}" placeholder="Last Company Salary" min="0"><span>{{$previous_employment->last_company_salary}}</span></td>
																		<td><input type="hidden" class="form-control pointer_events" name="user[last_company_designation][]" value="{{$previous_employment->designation}}" placeholder="Company Designation"><span>{{$previous_employment->designation}}</span></td>
																		<td>@if($previous_employment->gap)<span>{{$previous_employment->gap}} Days</span>@else - @endif</td>
																		<td>@if($previous_employment->gap_start_date)<span>{{$previous_employment->gap_start_date}}</span>@else - @endif</td>
																		<td>@if($previous_employment->gap_end_date)<span>{{$previous_employment->gap_end_date}}</span>@else - @endif</td>
																		
																		<td><select style="display: none;"  name="user[bgv_required_status][]"  class="form-control pointer_events">
																			<option value="Not required" {{($previous_employment->bgv_required_status=='Not required')?'selected':''}}>Not required</option>
																			<option value="Awaiting Confirmation" {{($previous_employment->bgv_required_status=='Awaiting Confirmation')?'selected':''}}>Awaiting Confirmation</option>
																			<option value="Done" {{($previous_employment->bgv_required_status=='Done')?'selected':''}}>Done</option>
																			<option value="Failed" {{($previous_employment->bgv_required_status=='Failed')?'selected':''}}>Failed</option>
																		</select><span>{{$previous_employment->bgv_required_status}}</span></td>

																		
																			<td><input type="hidden" class=" form-control pointer_events" placeholder="UAN Number" name="uan_number" value="{{getUANNumber($previous_employment->user_id)}}"><span>{{$previous_employment->uan_number}}</span></td>
																			<td><input type="hidden" class=" form-control pointer_events" placeholder="ESI Number" name="esi_number" value="{{getESINumber($previous_employment->user_id)}}"><span>{{$previous_employment->esi_number}}</span></td>
																		
																			
																		
																		<td>
																			<!-- <button type="button" class="btn btn-primary btn-small edit_previous_company_detail" data-toggle="modal" data-target="#myModal" data-company_name="{{$previous_employment->last_company_details}}" data-joining_date="{{$previous_employment->last_company_joining_date}}" data-relieving="{{$previous_employment->last_company_relieving}}" data-salary="{{$previous_employment->last_company_salary}}" data-designation="{{$previous_employment->designation}}" data-gap_start_date="{{$previous_employment->gap_start_date}}" data-gap_end_date="{{$previous_employment->gap_end_date}}" data-uan="{{getUANNumber($previous_employment->user_id)}}" data-esi="{{getESINumber($previous_employment->user_id)}}" data-bgv_required_status="{{$previous_employment->bgv_required_status}}" data-id="{{$previous_employment->id}}" data-user_id="{{$previous_employment->user_id}}"><span class="fa fa-edit"></span></button> -->
																			<button type="button" class="btn btn-danger btn-big delete_previous_compony_details" data-id="{{$previous_employment->id}}" data-user_id="{{$previous_employment->user_id}}" data-row_id="{{$loop->index}}"><span class="fa fa-trash"></span></button></td>
																	</tr>
																@endforeach
															@endif
														</tbody>
														
													</table>
												</div>
											
													
												
													<div class="col-md-12">
															<div class="row">
																@if(count($employee->previous_employment)==0)
																<!-- <div class="form-group col-md-12">
																	<label for="total_experience">Total Experience</label>
																	<input type="hidden" name="user[id][]">
																	<input type="text" class="form-control" name="total_experience" id="total_experience" value="" placeholder="Total Experience" autocomplete="off">
																</div> -->
																@endif

																<div class="previous_employee">
																	<div class="form-group  col-md-12">
																		<label for="last_company_details">Company Name</label>
																		<input type="text"  id="last_company_details"  class="form-control" cols="30" rows="10" autocomplete="off" name="last_company_details">
																	</div>



																	<div class="form-group col-md-12">
																		<label for="last_company_joining_date">Join Date</label>
																		
																		<input type="text" class="datepicker form-control" id="last_company_joining_date"  value="" placeholder="Last Company Joining Date"  name="last_company_joining_date" autocomplete="new-password" >
																	</div>



																	<div class="form-group col-md-12">
																		<label for="last_company_relieving">Relieving Date</label>
																		<input type="text" class="datepicker form-control" id="last_company_relieving"  value="" placeholder="Last Company Relieving Date" name="last_company_relieving" >
																	</div>



																	<div class="form-group col-md-12">
																		<label for="last_company_salary">Company Salary</label>
																		<input type="number" class="form-control" id="last_company_salary" value="" placeholder="Last Company Salary" min="0" name="last_company_salary">
																	</div>


																	<div class="form-group col-md-12">
																		<label for="designation">Designation</label>
																		<input type="text" class="form-control" id="compony_designation" value="" placeholder="Last Company Designation" min="0" name="last_company_designation">
																	</div>



																	<div class="form-group col-md-12">
																		<label for="Any Gap">Any Gap</label>
																		<input type="checkbox" class="form-control" id="any_gap">
																	</div>
																	<div class="any_gap">
																		<div class="col-md-12 form-group">
																			<label for="gap_start">Gap Start Date</label>
																			<input type="text" class="datepicker form-control" id="gap_start" name="gap_start">
																		</div>
																		<div class="col-md-12 form-group">
																			<label for="gap_end">Gap End Date</label>
																			<input type="text" class="datepicker form-control" id="gap_end" name="gap_end">
																		</div>
																	</div>

																	<div class="form-group col-md-12">
																		<label for="Any Gap">UAN And ESI Login</label>
																		<input type="checkbox" class="form-control" id="uan_and_esi" >
																	</div>

																	<div class="uan_and_esi">
																		<div class="col-md-12 form-group">
																			<label for="uan">UAN</label>
																			<input type="number" class=" form-control" id="uan" name="uan_and_esi">
																		</div>
																		<div class="col-md-12 form-group">
																			<label for="esi">ESI</label>
																			<input type="number" class=" form-control" id="esi" name="esi">
																		</div>
																	</div>
																	
																	
																	<div class="form-group col-md-12 bgv_required_status">
																		<label for="bgv_required_status">BGV Status</label>
																		<select id="bgv_required_status" class="form-control" name="bgv_required_status">
																			<option value="Not required">Not required</option>
																			<option value="Awaiting Confirmation">Awaiting Confirmation</option>
																			<option value="Done">Done</option>
																			<option value="Failed">Failed</option>
																		</select>
																	</div>
																	
																</div>
																<div class="form-group col-md-1"> 
						                                            <button type="button" class="btn btn-danger" id="addMoreBtn"><i class="fa fa-plus"></i> </button>
						                                        </div>
															</div>
														</div>
													</div>
										</div>
										<div class="tab-pane fade" id="tab4">
											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="form-group col-md-6">
															<label for="appraisal_term">Appraisal Term</label>
															<select name="appraisal_term" class="form-control" id="appraisal_term">
																<option value="first" {{$employee->cb_appraisal_detail->appraisal_term =="first"?"selected":''}}>First</option>
																<option value="second"  {{$employee->cb_appraisal_detail->appraisal_term =="second"?"selected":''}}>Second</option>
																<option value="third"  {{$employee->cb_appraisal_detail->appraisal_term =="third"?"selected":''}}>Third</option>
															</select>
														</div>
														<div class="form-group  col-md-6">
															<label for="cb_designation">Designation</label>
															<input type="text" class="form-control col-md-6" name="cb_designation" id="cb_designation"  value="{{$employee->cb_appraisal_detail->designation}}" placeholder="Designation" >
														</div>
														<div class="form-group col-md-12">
															<label for="cb_salary">Salary</label>
															<input type="text" class="form-control" name="cb_salary" id="cb_salary" value="{{$employee->cb_appraisal_detail->salary}}" placeholder="Salary" >
														</div>
														<div class="form-group col-md-12">
															<label for="cb_stay_bonus">Stay Bonus</label>
															<input type="text" class="form-control" name="cb_stay_bonus" id="cb_stay_bonus" value="{{$employee->cb_appraisal_detail->stay_bonus}}" placeholder="Stay Bonus" >
														</div>
														<div class="form-group col-md-12">
															<label for="appraisal_comments">Appraisal Comments</label>
															<textarea name="appraisal_comments" class="form-control" id="appraisal_comments" cols="30" rows="10">{{$employee->cb_appraisal_detail->appraisal_comment}}</textarea>
														</div>
														<div class="form-group col-md-12">
															<label for="appraisal_status">Appraisal Status</label>
															<select name="appraisal_status" id="appraisal_status" class="form-control">
																<option value="not_done" {{$employee->cb_appraisal_detail->appraisal_status == "not_done"?'selected':'' }}>Not Done</option>
																<option value="done" {{$employee->cb_appraisal_detail->appraisal_status == "done"?'selected':'' }}>Done</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<ul class="pager wizard">
											<input type="submit" name="Submit" class="btn btn-primary sub_form">
										</ul> 
									</div>
								</form>
									</div>
								</div>
							</div>
						</div>
					</div><!-- Row -->
				</div><!-- Main Wrapper -->
				<div class="page-footer">
					<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
				</div>
			</div>


			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Edit previous company detail</h4>
						</div>
						<div class="modal-body">
							
							<div class="form-grou">
								<input type="hidden" id="edit_user_id">
								<input type="hidden" id="edit_id">
								<label for="edit_last_company_details">Company Name</label>
								<input type="text"  id="edit_last_company_details"  class="form-control" cols="30" rows="10" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="edit_last_company_joining_date">Join Date</label>
								<input type="text" class="datepicker form-control" id="edit_last_company_joining_date"  value="" placeholder="Last Company Joining Date" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="edit_last_company_relieving">Relieving Date</label>
								<input type="text" class="datepicker form-control" id="edit_last_company_relieving"  value="" placeholder="Last Company Relieving Date" >
							</div>
							<div class="form-group">
								<label for="edit_last_company_salary">Company Salary</label>
								<input type="number" class="form-control" id="edit_last_company_salary" value="" placeholder="Last Company Salary" min="0">
							</div>
							<div class="form-group">
								<label for="edit_company_designation">Designation</label>
								<input type="text" class="form-control" id="edit_company_designation" value="" placeholder="Last Company Designation" min="0">
							</div>
							<div class="form-group">
								<label for="edit_any_gap">Any Gap</label>
								<input type="checkbox" class="form-control" id="edit_any_gap">
							</div>
							<div class="edit_any_gap">
								<div class="form-group">
									<label for="edit_gap_start">Gap Start Date</label>
									<input type="text" class="datepicker form-control" id="edit_gap_start">
								</div>
								<div class="form-group">
									<label for="edit_gap_end">Gap End Date</label>
									<input type="text" class="datepicker form-control" id="edit_gap_end">
								</div>
							</div>
							<div class="form-group">
								<label for="edit_uan_and_esi">UAN And ESI Login</label>
								<input type="checkbox" class="form-control" id="edit_uan_and_esi">
							</div>
							<div class="edit_uan_and_esi">
								<div class="form-group">
									<label for="edit_uan">UAN</label>
									<input type="number" class=" form-control" id="edit_uan">
								</div>
								<div class="form-group">
									<label for="edit_esi">ESI</label>
									<input type="number" class=" form-control" id="edit_esi">
								</div>
							</div>
							<div class="form-group bgv_required_status">
								<label for="edit_bgv_required_status">BGV Status</label>
								<select id="edit_bgv_required_status" class="form-control">
									<option value="Not required">Not required</option>
									<option value="Awaiting Confirmation">Awaiting Confirmation</option>
									<option value="Done">Done</option>
									<option value="Failed">Failed</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" id="update_previous_company_details" class="btn btn-primary">Update</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			@section('script')
			{{ Html::script("assets/plugins/waves/waves.min.js") }}
			{{ Html::script("assets/plugins/select2/js/select2.min.js") }}
			{{ Html::script("assets/plugins/summernote-master/summernote.min.js") }}
			{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
			{{ Html::script("assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js") }}
			{{ Html::script("assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js") }}
			{{ Html::script("assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js") }}
			{{ Html::script("assets/js/pages/form-elements.js") }}
			<script>
				
                $('.datepicker').datepicker({
			        format: "yyyy-mm-dd",
			        autoclose: true,
			        orientation: "top",
			        endDate: "today"

                 });

				
				$(document).ready(function() {
					@if(count($employee->previous_employment) >0)
					
                      $('#last_company_joining_date').change(function(){
                        var last_cmpy_rd      = Date.parse($('#emp_previous_employment #{{count($employee->previous_employment)}} .last_company_relieving').val()) /1000;
                        var new_last_cmpy_rd    = Date.parse($('#last_company_joining_date').val()) /1000;
                        var gap_end_date_last = Date.parse($('#emp_previous_employment #{{count($employee->previous_employment)}} .gap_ed_date').val()) /1000;
                       // var new_gap_end_date_last = Date.parse($('#gap'))
                         console.log("lascomp ="+last_cmpy_rd +' gap '+gap_end_date_last);

                         console.log(last_cmpy_rd +' bb '+new_last_cmpy_rd);
                         if(!isNaN(gap_end_date_last) ){
                         	 if(new_last_cmpy_rd <= gap_end_date_last){
                             $('#last_company_joining_date').val('');
                             $('#last_company_joining_date').focus();
                              swal('Error','Please insert valid date..','error');
                           // return false;
                            }
                             }else{
                             	if(new_last_cmpy_rd <= last_cmpy_rd){
                                 $('#last_company_joining_date').val('');
                                 $('#last_company_joining_date').focus();
                                 swal('Error','Please insert valid date..','error');
                           // return false;
                            }

                           // }
                         }
                        
                      });
					@else

					
					 $('#last_company_joining_date').on('change', function(){
						 endDate   = this.value; 
						 start_date = "{{date('Y-m-d')}}";
						 var diff = new Date(start_date) - new Date(endDate);
                              diff = (diff/1000/60/60/24);
                              console.log(diff); 
						 if(diff  < 1){      
						 	$('#last_company_joining_date').val(''); 
						 	$('#last_company_joining_date').focus(); 
						 	//$('#end_date_error').text('Date should be greater then start data.'); 
						 }
					
					
                    
					});
					 @endif
					$('#appraisal_date').datepicker().on('change', function(){
						 endDate    = this.value; 
						 start_date = $('#joining_date').val();
						 var diff   = new Date(endDate) - new Date(start_date);
                            diff    = (diff/1000/60/60/24);
						 if(diff < 1 ){      
						 	$('#appraisal_date').val(''); 
						 	$('#appraisal_date').focus(); 
						 	//$('#end_date_error').text('Date should be greater then start data.'); 
						 }
					});
					$('#last_company_relieving').datepicker().on('change', function(){
						 endDate    = this.value; 
						 start_date = $('#last_company_joining_date').val();
						 crr_date   = "{{date('Y-m-d')}}";
						 var diff   = new Date(endDate) - new Date(start_date);
						     diff2  = new Date(crr_date) - new Date(endDate);
                             diff   = (diff/1000/60/60/24);
                             diff2  = (diff2/1000/60/60/24);
						 if(diff < 1){
						 	$('#last_company_relieving').val(''); 
						 	$('#last_company_relieving').focus(); 
						 	//$('#end_date_error').text('Date should be greater then start data.'); 
						 }
                            //console.log(" diff2 "+diff2);   
						 if(diff2 < 1){    
						    console.log(" diff2d "+diff2);    
						 	$('#last_company_relieving').val(''); 
						 	$('#last_company_relieving').focus();   
						 	//$('#end_date_error').text('Date should be greater then start data.'); 
						 }
					});
					$('.select2').select2();
					$('.pastDatepicker').datepicker({endDate: '0m'});
					$("#martial_status").on('change',function(e){
						if(e.target.value == "unmarried"){
							$('#ann_div').hide();
						}else{
							$('#ann_div').show();
						}
					})
					if($("#martial_status option:selected").val() == 'unmarried'){
						$('#ann_div').hide();
					}
					if($("#martial_status option:selected").val() == 'married'){
						$('#ann_div').show();
					}
					$('#employeeForm').submit(function(event) {
						var file_data = $('#employee_photo').prop('files')[0]; 
						if($('#first_name').val() == ''){
							swal('Oops','First name is required','warning');
							return false;
						}
						else if($('#role option:selected').val() == ''){
							swal('Oops','Role is required','warning');
							return false;
						}
						else if($('#department option:selected').val() == ''){
							swal('Oops','Department is required','warning');
							return false;
						}
						else if($('#gender option:selected').val() == ''){
							swal('Oops','Gender is required','warning');
							return false;
						}else if(file_data != null)
						{
							if (file_data.type!=="image/png" && file_data.type!=="image/jpeg" && file_data.type!=="image/jpg")  
							{
								swal("Oops", "Please upload a valid image file", "warning");
								return false;
							}
						} 
						else{
							return true;
						}
					});
				});


			$(document).on('click','#addMoreBtn',function(){
				var last_company_details = $('#last_company_details').val();
				if(last_company_details==''){
					$('#last_company_details').focus();
					$('#last_company_details').css('border-color','red');
					return false;
				}

				var last_company_joining_date = $('#last_company_joining_date').val();
				if(last_company_joining_date==''){
					$('#last_company_joining_date').focus();
					$('#last_company_joining_date').css('border-color','red');

					return false;
				}
				var last_company_relieving = $('#last_company_relieving').val();
				if(last_company_relieving==''){
					$('#last_company_relieving').focus();
					$('#last_company_relieving').css('border-color','red');
					return false;
				}
				//check join and relieving date
				const date1 = new Date(last_company_joining_date);
				const date2 = new Date(last_company_relieving);
				const diffTime = new Date(date2 - date1);

				const diff_in_days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
				if(diff_in_days<0){
					swal('Relieving Date must be greater than Joininng date','','warning')
					$('#last_company_relieving').focus();
					return false;
				}

				var last_company_salary = $('#last_company_salary').val();
				if(last_company_salary==''){
					$('#last_company_salary').focus();
					$('#last_company_salary').css('border-color','red');
					return false;
				}
				var gap = 0;
				/*if(gap==''){
					$('#gap').focus();
					$('#gap').css('border-color','red');
					return false;
					
				}*/

				var cmp_designation = $('#compony_designation').val();
				
				if(cmp_designation==''){
					$('#compony_designation').focus();
					$('#compony_designation').css('border-color','red');
					return false;
				}

				var rowCount = $('#emp_previous_employment tr').length+1;
				

				if($('#any_gap').is(':checked')){
					if($('#gap_start').val()==''){
						$('#gap_start').focus();
						$('#gap_start').css('border-color','red');
						return false;
					}if($('#gap_end').val()==''){
						$('#gap_end').focus();
						$('#gap_end').css('border-color','red');
						return false;
					}
                    var dategsd = $('#gap_start').val();
                    var dateged = $('#gap_end').val();
                  
                    
					const date1 = new Date($('#gap_start').val());
					const date2 = new Date($('#gap_end').val());
					const diffTime = new Date(date2 - date1);
					const diff = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
					if(diff<0){
						swal('Gap End Date must be greater than Gap Start Date','','warning')
						$('#gap_end').focus();
						return false;
					}else{
						gap = parseInt(diff)+parseInt(1);
					}
				}

				if($('#uan_and_esi').is(':checked')){
					if($('#uan').val()==''){
						$('#uan').focus();
						$('#uan').css('border-color','red');
						return false;
					}if($('#esi').val()==''){
						$('#esi').focus();
						$('#esi').css('border-color','red');
						return false;
					}
				}
				var bgv_required_status = $('#bgv_required_status').val();
				var uan1 = $('#uan').val();
				var esi1 = $('#esi').val();

				//add functionality

				// append input type gap ,experience etc....
				var html =`<tr id="`+rowCount+`">
								<td>`+rowCount+`<input type="hidden" name="user[gap_start_date][]" value="`+$('#gap_start').val()+`"><input type="hidden" name="user[gap_end_date][]" value="`+$('#gap_end').val()+`"></td>`;
				if(rowCount-1==0){
					var total_experience = parseInt(diff_in_days)+parseInt(1);
					var getYear = parseInt(total_experience/365);
					var getMonth = parseInt(parseInt(parseInt(total_experience)%365)/30);
					var getDays = parseInt(parseInt(parseInt(total_experience)%365)%30);
					//$('.total_experience').text(parseInt(getYear) + ' Years ' +parseInt(getMonth) + ' Months ' + parseInt(getDays) + ' Days' );
					html+=`<td><input type="hidden" class="form-control" name="user[total_experience][]" id="total_experience" value="`+parseInt(diff_in_days)+`" placeholder="Total Experience" autocomplete="off" style="pointer-events: none;"><span class="total_experience">`+parseInt(getYear) + ' Years ' +parseInt(getMonth) + ' Months ' + parseInt(getDays) + ` Days `+`</span></td>`;
				}else{
					//var total_experience = parseInt($('input[name=total_experience]:first').val())+parseInt(diff_in_days)-parseInt(gap);
					var total_experience = parseInt(diff_in_days);
					
					
					//$('input[name=total_experience]').val(parseInt(total_experience))
					var getYear = parseInt(total_experience/365);
					var getMonth = parseInt(parseInt(parseInt(total_experience)%365)/30);
					var getDays = parseInt(parseInt(parseInt(total_experience)%365)%30);
					html+=`<td><input type="hidden" name="user[total_experience][]" class="form-control" value="`+total_experience+`" placeholder="Total Experience" autocomplete="off" style="pointer-events: none;"><span class="total_experience">`+parseInt(getYear) + ' Years ' +parseInt(getMonth) + ' Months ' + parseInt(getDays) + ` Days `+`</span></td>`;
					//$('.total_experience').text(parseInt(getYear) + ' Years ' +parseInt(getMonth) + ' Months ' + parseInt(getDays) + ' Days' );
				}
				
							html+=`<td><input type="hidden" name="user[id][]" value=""><input type="hidden" name="user[last_company_details][]"  class="form-control" value="`+last_company_details+`"><span>`+last_company_details+`</span></td>
								<td><input type="hidden" class="datepicker form-control" name="user[last_company_joining_date][]"  value="`+last_company_joining_date+`" placeholder="Last Company Joining Date" ><span>`+last_company_joining_date+`</span></td>
								<td><input type="hidden" class="datepicker form-control" name="user[last_company_relieving][]"  value="`+last_company_relieving+`" placeholder="Last Company Relieving Date" ><span>`+last_company_relieving+`</span></td>
								<td><input type="hidden" class="form-control" name="user[last_company_salary][]" value="`+last_company_salary+`" placeholder="Last Company Salary"><span>`+last_company_salary+`</span></td>
								<td><input type="hidden" class="form-control" name="user[last_company_designation][]" value="`+cmp_designation+`" placeholder="Company Designation" min="0"><span>`+cmp_designation+`</span></td>
								<td><input type="hidden" class="form-control" name="user[gap][]"  value="`+gap+`" placeholder="Gap"><span>`+gap+`</span></td>
								`;
					
						html+=`<td>
								<select style="display:none"  name="user[bgv_required_status][]" class="form-control">`;
							if(bgv_required_status=='Not required'){
								html+=`<option value="Not required" selected>Not required</option>`;
							}else{
								html+=`<option value="Not required" >Not required</option>`;
							}

							if(bgv_required_status=='Awaiting Confirmation'){
								html+=`<option value="Awaiting Confirmation" selected>Awaiting Confirmation</option>`
							}else{
								html+=`<option value="Awaiting Confirmation">Awaiting Confirmation</option>`;
							}
							
							if(bgv_required_status=='Done'){
								html+=`<option value="Done" selected>Done</option>`;
							}else{
								html+=`<option value="Done">Done</option>`;
							}

							if(bgv_required_status=='Failed'){
								html+=`<option value="Failed" selected>Failed</option>`;
							}else{
								html+=`<option value="Failed">Failed</option>`;
							}
								
							html+=`</select><span>`+bgv_required_status+`</span></td>`;
							if(rowCount-1==0){
								html+=`<td><input type="hidden" class=" form-control" placeholder="UAN Number" name="uan_number" value="`+$('#uan').val()+`"><span>`+$('#uan').val()+`</span>
									</td>
									<td><input type="hidden" class=" form-control" placeholder="ESI Number" name="esi_number" value="`+$('#esi').val()+`"><span>`+$('#esi').val()+`</span></td>`;
				
								
							}else{
								if($('#uan').val()!=''){
									$('input[name=uan_number]').val($('#esi').val());
								}
								if($('#esi').val()){
									$('input[name=esi_number]').val($('#esi').val());
								}
								html+=`<td><input type="hidden" class=" form-control" placeholder="UAN Number" name="uan_number" value="`+$('#uan').val()+`"><span>`+$('#uan').val()+`</span>
									</td>
									<td><input type="hidden" class=" form-control" placeholder="ESI Number" name="esi_number" value="`+$('#esi').val()+`"><span>`+$('#esi').val()+`</span></td>`;
									$('input[name=uan_number]').val($('#uan').val());
							}
							html+=`<td><button type="button" class="btn btn-danger bitn-big delete_previous_compony_details" data-joining_data="`+last_company_joining_date+`" data-relieving="`+last_company_relieving+`" data-id="0" data-user_id="0" data-row_id="`+rowCount+`"><span class="fa fa-trash"></span></button></td>
									</tr>`;
							$(".rowspan").attr("rowspan",rowCount);
						$('#emp_previous_employment').append(html);
						$('#last_company_details').val('');
						$('#last_company_joining_date').val('');
						$('#last_company_relieving').val('');
						$('#last_company_salary').val('');
						$('#compony_designation').val('');
						$('#gap_start').val('');
						$('#gap_end').val('');
						$('#uan').val('');
						$('#esi').val('');
						$('#bgv_required_status > option:first').attr('selected','selected');
						
						if($('#uan_and_esi').is(':checked')){
							$('#uan_and_esi').click();
						}
						if($('#any_gap').is(':checked')){
							$('#any_gap').click();

						}
						
						var data = {};
				data.last_company_details = last_company_details;
				data.last_company_joining_date = last_company_joining_date;
				data.last_company_relieving = last_company_relieving;
				data.last_company_salary = last_company_salary;
				data.gap = gap;
				data._token ="{{csrf_token()}}";
				data.last_company_designation = cmp_designation;
				data.id = $('.emp_id').val();
				data.total_experience = total_experience;
				data.gap_start = dategsd;
				data.gap_end = dateged;
				data.uan = uan1;
				data.esi = esi1;
				data.bgv_required_status = bgv_required_status;


				$.ajax({
					url:"{{url(getRoleStr().'/employee/update-pre-company-details')}}",
					method:"post",
					data:data,
					dataType:'json',
					success:function(result){
						console.log(result);
						swal('Success','Submitted Successfully','success');
                        window.location.reload();
                         $('.nav-tabs li:nth-child(3)').click(); 
					}
				});

					});

				function removeRow(row){
		    $(row).closest('div.pr_compony_detail').remove();
		}

		$(document).on('click','.delete_previous_compony_details',function(){
			
			var id = $(this).data('id');
			var user_id = $(this).data('user_id');
			var row_id = $(this).data('row_id');
			var token = "{{csrf_token()}}";
			var data = {};
			data.id = id;
			data.user_id=user_id;
			data._token=token;
			swal({
			  title: "Are you sure?",
			  text: "Once deleted, you will not be able to recover this data!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			  	$.ajax({
			  		url:"{{url(getRoleStr().'/delete-previous-compony-details')}}",
			  		method:"POST",
			  		data:data,
			  		success:function(result){
			  			var rowCount = $('#emp_previous_employment tr').length;
						if(rowCount-1==0){
							/*$('input[name=total_experience]:first').attr('type','text');
							$('input[name=uan_number]:first').attr('type','text');
							$('input[name=esi_number]:first').attr('type','text');*/
							/*$('button.delete_previous_compony_details:first').css('cursor-pointer','none');
							$('button.delete_previous_compony_details:first').addClass('batham');
							$('button.delete_previous_compony_details:first').removeAttr('disabled');*/
						}
						console.log(row_id+'row_id')
						$('tr#'+row_id).remove();
						//$('.total_experience:first').css('display','block');
			  		},error:function(result){
			  			console.log();
			  		}
			  	});
			  }
			});
		});

		$(document).ready(function () {

			//$('.total_experience:not(.total_experience:first)').css('display','none');
	        //  var today = new Date();
	        // $('.datepicker').datepicker({
	        //     format: 'mm-dd-yyyy',
	        //     autoclose:true,
	        //     endDate: "today",
	        //     maxDate: today
	        // }).on('changeDate', function (ev) {
	        //         $(this).datepicker('hide');
	        //     });


	        $('.datepicker').keyup(function () {
	            if (this.value.match(/[^0-9]/g)) {
	                this.value = this.value.replace(/[^0-9^-]/g, '');
	            }
	        });
	        //any gap
	        if($('#any_gap').is(":checked")){
        		$('.any_gap').show();
        	}else{
        		$('.any_gap').hide();
        	}


	        $('#any_gap').click(function(){
	        	if($(this).is(":checked")){
	        		$('.any_gap').show();
	        	}else{
	        		$('.any_gap').hide();
	        	}
	        });

        	//uan and esi
        	if($('#uan_and_esi').is(':checked')){
        		$('.uan_and_esi').show();
        	}else{
        		$('.uan_and_esi').hide();
        	}


	        $('#uan_and_esi').click(function(){
	        	if($(this).is(":checked")){
	        		$('.uan_and_esi').show();
	        	}else{
	        		$('.uan_and_esi').hide();
	        	}
	        });


	         $(document).on('click','.edit_previous_company_detail',function(){
	        	$('.edit_any_gap').hide();
	        	$('.edit_uan_and_esi').hide();
	        	var company_name 				= $(this).data('company_name');
	        	var joining_date 				= $(this).data('joining_date');
	        	var relieving_date				= $(this).data('relieving');
	        	var salary 						= $(this).data('salary');
	        	var designation 				= $(this).data('designation');
	        	var gap_start_date 				= $(this).data('gap_start_date');
	        	var gap_end_date 				= $(this).data('gap_end_date');
	        	var uan 						= $(this).data('uan');
	        	var esi 						= $(this).data('esi');
	        	var bgv_required_status 		= $(this).data('bgv_required_status');
	        	var user_id                     = $(this).data('user_id');
	        	var id                    		= $(this).data('id');
	        	$('#edit_last_company_details').val(company_name);
	        	$('#edit_last_company_joining_date').val(joining_date);
	        	$('#edit_last_company_relieving').val(relieving_date);
	        	$('#edit_last_company_salary').val(salary);
	        	$('#edit_company_designation').val(designation);
	        	$('#edit_user_id').val(user_id);
	        	$('#edit_id').val(id);
	        	
	        	if(gap_start_date!='' && gap_end_date!=''){
	        		$('.edit_any_gap').show();
	        		$('#edit_any_gap').click();
	        		$('#edit_gap_start').val(gap_start_date);
	        		$('#edit_gap_end').val(gap_end_date);
	        	}
	        	if(uan!='' && esi!=''){
	        		$('.edit_uan_and_esi').show();
	        		$('#edit_uan_and_esi').click();
	        		$('#edit_uan').val(uan);
	        		$('#edit_esi').val(esi);
	        	}
	        	$('#edit_bgv_required_status').val(bgv_required_status);
	        });

	        $('#edit_any_gap').click(function(){
	        	if($(this).is(":checked")){
	        		$('.edit_any_gap').show();
	        	}else{
	        		$('.edit_any_gap').hide();
	        	}
	        });

	        $('#edit_uan_and_esi').click(function(){
	        	if($(this).is(":checked")){
	        		$('.edit_uan_and_esi').show();
	        	}else{
	        		$('.edit_uan_and_esi').hide();
	        	}
	        });


	        $(document).on('click','#update_previous_company_details',function(){
			
				var last_company_details = $('#edit_last_company_details').val();
				if(last_company_details==''){
					$('#edit_last_company_details').focus();
					return false;
				}

				var last_company_joining_date = $('#edit_last_company_joining_date').val();
				if(last_company_joining_date==''){
					$('#edit_last_company_joining_date').focus();
					return false;
				}
				var last_company_relieving = $('#edit_last_company_relieving').val();
				if(last_company_relieving==''){
					$('#edit_last_company_relieving').focus();
					return false;
				}
				//check join and relieving date
				const date1 = new Date(last_company_joining_date);
				const date2 = new Date(last_company_relieving);
				const diffTime = new Date(date2 - date1);

				const diff_in_days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
				if(diff_in_days<0){
					swal('Relieving Date must be greater than Joininng date','','warning')
					$('#edit_last_company_relieving').focus();
					return false;
				}

				var last_company_salary = $('#edit_last_company_salary').val();
				if(last_company_salary==''){
					$('#edit_last_company_salary').focus();
					return false;
				}
				var gap = 0;
				var cmp_designation = $('#edit_company_designation').val();
				
				if(cmp_designation==''){
					$('#edit_company_designation').focus();
					return false;
				}
				

				var rowCount = $('#emp_previous_employment tr').length+1;
				

				if($('#edit_any_gap').is(':checked')){
					if($('#edit_gap_start').val()==''){
						$('#edit_gap_start').focus();
						return false;
					}if($('#edit_gap_end').val()==''){
						$('#edit_gap_end').focus();
						return false;
					}


					const date1 = new Date($('#edit_gap_start').val());
					const date2 = new Date($('#edit_gap_end').val());
					const diffTime = new Date(date2 - date1);
					const diff = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
					if(diff<0){
						swal('Gap End Date must be greater than Gap Start Date','','warning')
						$('#edit_gap_end').focus();
						return false;
					}else{
						gap = diff;
					}
				}

				if($('#edit_uan_and_esi').is(':checked')){
					if($('#edit_uan').val()==''){
						$('#edit_uan').focus();
						return false;
					}if($('#edit_esi').val()==''){
						$('#edit_esi').focus();
						return false;
					}
				}
				var bgv_required_status 		= $('#edit_bgv_required_status').val();
				var data 						= {};
				var token 						= "{{csrf_token()}}";
				var gap_start                   = $('#edit_gap_start').val();
				var gap_end                     = $('#edit_gap_end').val();
				var uan                         = $('#edit_uan').val();
				var esi                         = $('#edit_esi').val();
				var user_id                     = $('#edit_user_id').val();
	        	var id                    		= $('#edit_id').val();
				data._token						= token;
				data.last_company_details 		= last_company_details;
				data.last_company_joining_date  = last_company_joining_date;
				data.last_company_relieving     = last_company_relieving;
				data.last_company_salary        = last_company_salary;
				data.cmp_designation 			= cmp_designation;
				data.gap_start                  = gap_start;
				data.gap_end                    = gap_end;
				data.uan                        = uan;
				data.esi                        = esi;
				data.user_id 					= user_id;
				data.id       					= id;
				data.bgv_required_status        = bgv_required_status;
				
				$.ajax({
			  		url:"{{url(getRoleStr().'/update-previous-compony-details')}}",
			  		type:"post",
			  		dataType: "json",
			  		data:data,
					success:function(result){
						swal('Record updated successfully','','success');
						window.location.reload();
					},error:function(result){

					}
				});
				
			});
	    });
    

        //Hide button on tab 3 click
        $('.nav-tabs li').click(function(){
        	if($(this).index() == 2){
           $('.sub_form').hide();
           }else{
           	$('.sub_form').show();
           }

        });
        // gap start validation
          $('#gap_start').change(function(){
          	var last_cmpy_rd      = Date.parse($('#last_company_relieving').val()) /1000;
          	var dategsd = $('#gap_start').val();
            	if( last_cmpy_rd  >= Date.parse(dategsd)/1000 ){
                    		$(this).val('');
                    		$(this).focus();
                            swal('Error','Please enter date after company relieving date','error');
                      }
                    });
          // gap end validation
          $('#gap_end').change(function(){
          	var last_cmpy_rd      = Date.parse($('#last_company_relieving').val()) /1000;
          	var dategsd = Date.parse($('#gap_start').val())/1000;
            var dateged = $('#gap_end').val();
          	
                    if( dategsd  >= Date.parse(dateged)/1000 ){
                    		$(this).val('');
                    		$(this).focus();
                            swal('Error','Please enter date after company relieving date','error');
                      }
                    });
        
 			</script>
			@endsection
			@endsection