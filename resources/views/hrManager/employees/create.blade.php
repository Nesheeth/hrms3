@extends('hrManager.layouts.app')
@section('content')
@section('title','Employee')

<style>
.form-group {
	margin-right: 13px !important;
}

.per-bor {
	border-bottom: 2px solid;
}

.per-bor label {
	font-size: 20px;
	padding: 4px 0px 10px 0px;
}
</style>
<div class="page-inner">
	<div class="page-title">
		<h3>Employees</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/hrManager/employees')}}">Employees</a></li>
				<li class="active">Add Employee</li>
			</ol>
		</div>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-10">
				<div class="panel panel-white">
					<div class="panel-body">
						<div id="rootwizard">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Personal Info</a></li>
								<li role="presentation"><a href="javascript:void(0);" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Employee CB Profile</a></li>
								<li role="presentation"><a href="javascript:void(0);" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Previous Employment Profile</a></li>
								<li role="presentation"><a href="javascript:void(0);" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Employee CB More Details</a></li>
							</ul>


							<div class="progress progress-sm m-t-sm">
								<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								</div>
							</div>
							<!-- <form id="wizardForm"> -->
								<form class="form-horizontal" method="post" enctype="multipart/form-data" id="employeeForm">
									<div class="tab-content">
										{{csrf_field()}}
										<div class="tab-pane active fade in" id="tab1">
											<div class="row m-b-lg">
												<div class="col-md-10">
													<div class="row">

														<div class="form-group col-md-12">
															<label for="department">Department</label>
															<select name="department" id="department" class="form-control">
																<option value="">--Select Department--</option>
																<option value="development">DEVELOPMENT</option>
																<option value="sales">SALES</option>
															</select>
															@if ($errors->has('department'))
															<span class="label label-danger">{{ $errors->first('department') }}</span>
															@endif
														</div>
														
														<div class="form-group col-md-6">
															<label for="first_name">First Name</label>
															<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
															@if ($errors->has('first_name'))
															<span class="label label-danger">{{ $errors->first('first_name') }}</span>
															@endif
														</div>
														<div class="form-group  col-md-6">
															<label for="last_name">Last Name</label>
															<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" >
														</div>
														<div class="form-group col-md-12">
															<label for="email">Email address</label>
															<input type="email" class="form-control" name="email" id="email" placeholder="Enter email" >
															@if ($errors->has('email'))
															<span class="label label-danger">{{ $errors->first('email') }}</span>
															@endif
														</div>
														<div class="form-group col-md-12">
															<label for="password">Password</label>
															<input type="password" class="form-control" name="password" id="password" placeholder="Password" >
															@if ($errors->has('password'))
															<span class="label label-danger">{{ $errors->first('password') }}</span>
															@endif
														</div>

														<div class="form-group  col-md-6">
															<label for="role">Role</label>
															<select name="role" id="role" class="form-control" >
																<option value="">--Select Role--</option>
																@foreach($roles as $role )
																<option value="{{$role->id}}">{{$role->role}}</option>
																@endforeach
															</select>
															@if ($errors->has('role'))
															<span class="label label-danger">{{ $errors->first('role') }}</span>
															@endif
														</div>

														<div class="form-group  col-md-6">
															<label for="gender">Gender</label>
															<select name="gender" id="gender" class="form-control" >
																<option value="">--Select Gender--</option>
																<option value="male">Male</option>
																<option value="female">Female</option>
															</select>
															@if ($errors->has('gender'))
															<span class="label label-danger">{{ $errors->first('gender') }}</span>
															@endif
														</div>

														<div class="form-group  col-md-12">
															<label for="address">Address</label>
															<textarea name="address" id="address"  class="form-control" cols="30" rows="10"></textarea>
														</div>
														<div class="form-group  col-md-6">
															<label for="phone_number">Phone #</label>
															<input type="text" class="form-control col-md-6" name="phone_number" id="phone_number" placeholder="Phone number" >
														</div>
														<div class="form-group  col-md-6">
															<label for="aadhar_no">Aadhar #</label>
															<input type="text" class="form-control col-md-6" name="aadhar_no" id="aadhar_no" placeholder="Aadhar number" >
														</div>
														<div class="form-group  col-md-6">
															<label for="martial_status">Martial Status</label>
															<select name="martial_status" id="martial_status" class="form-control">
																<option value="">--Select Martial Status--</option>
																<option value="unmarried">Unmarried</option>
																<option value="married">Married</option>
															</select>
														</div>

														<div class="form-group  col-md-6">
															<label for="dob">Date Of Birth</label>
															<input type="text" class="pastDatepicker form-control col-md-6" name="dob" id="dob" placeholder="Date Of Birth" >
														</div>
														<div class="form-group  col-md-6" id="ann_div">
															<label for="anniversary_date">Anniversary</label>
															<input type="text" class="pastDatepicker form-control col-md-6" name="anniversary_date" id="anniversary_date" placeholder="Anniversary" >
														</div>

														<div class="form-group col-md-12 per-bor">
															<label for="personal_info">Personal Details</label>
														</div>

														<div class="form-group col-md-12">
															<label for="personal_email">Personal Email</label>
															<input type="email" class="form-control" name="personal_email" id="personal_email" placeholder="Enter email" >
														</div>

														<div class="form-group col-md-6">
															<label for="father_name">Father Name</label>
															<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name">
														</div>
														<div class="form-group col-md-6">
															<label for="mother_name">Mother Name</label>
															<input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother Name">
														</div>

														<div class="form-group col-md-6">
															<label for="parent_number">Parent Contact No.</label>
															<input type="text" class="form-control" name="parent_number" id="parent_number" placeholder="Parent Contact Number">
														</div>

														<div class="form-group col-md-12 per-bor">
															<label for="personal_info">Bank Account information</label>
														</div>

														<div class="form-group col-md-6">
															<label for="account_holder_name">Account Holder Name</label>
															<input type="text" class="form-control" name="account_holder_name" id="account_holder_name" placeholder="Account Holder Name">
														</div>

														<div class="form-group col-md-12">
															<label for="bank_name">Bank Name</label>
															<input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" >
														</div>

														<div class="form-group  col-md-6">
															<label for="account_no">Bank Account #</label>
															<input type="text" class="form-control col-md-6" name="account_no" id="account_no" placeholder=" Bank Account number" >
														</div>
														<div class="form-group col-md-6">
															<label for="ifsc_code">IFSC Code</label>
															<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code">
														</div>

													</div>
												</div>
												
											</div>
										</div>
										<div class="tab-pane fade" id="tab2">
											<div class="row">
												<div class="col-md-10">
													<div class="row">
														<div class="form-group col-md-6">
															<label for="employee_photo">Photo</label>
															<input type="file" class="form-control" name="employee_photo" id="employee_photo">
															@if ($errors->has('employee_photo'))
															<span class="label label-danger">{{ $errors->first('employee_photo') }}</span>
															@endif
														</div>

														<div class="form-group  col-md-6">
															<label for="designation">Designation</label>
															<input type="text" class="form-control col-md-6" name="designation" id="designation" placeholder="Designation" >
														</div>
														<div class="form-group col-md-12">
															<label for="joined_as">Joined as</label>
															<input type="text" class="form-control" name="joined_as" id="joined_as" placeholder="Joined as" >
														</div>
														<div class="form-group col-md-12">
															<label for="joining_date">Joining Date</label>
															<input type="text" class="datepicker form-control" name="joining_date" id="joining_date" placeholder="Joining Date" >
														</div>
														<div class="form-group col-md-12">
															<label for="employee_status">Status</label>
															<select name="employee_status" id="employee_status" class="form-control">
																<option value="active">Active</option>
																<option value="deactive">Deactive</option>
															</select>
														</div>
														<div class="form-group col-md-12">
															<label for="salary">Salary</label>
															<input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" >
														</div>

														<div class="form-group col-md-12">
															<label for="stay_bonus">Stay Bonus</label>
															<input type="text" class="form-control" name="stay_bonus" id="stay_bonus" placeholder="Stay Bonus" >
														</div>

														<div class="form-group col-md-12">
															<label for="appraisal_date">Appraisal Date</label>
															<input type="text" class="datepicker form-control" name="appraisal_date" id="appraisal_date" placeholder="Appraisal Date" >
														</div>
														<div class="form-group col-md-12">
															<label for="epf">EPF Detail</label>
															<input type="text" class="form-control" name="epf" id="epf" placeholder="EPF Detail" >
														</div>
														<div class="form-group col-md-12">
															<label for="esi">ESI Detail</label>
															<input type="text" class="form-control" name="esi" id="esi" placeholder="ESI Detail" >
														</div>
														
													</div>
												</div>
												
											</div>
										</div>
										<div class="tab-pane fade" id="tab3">
											<div class="row">
												<div class="col-md-10">
													<div class="row">
														<div class="form-group col-md-12">
															<label for="total_experience">Total Experience</label>
															<input type="text" class="form-control" name="total_experience" id="total_experience" placeholder="Total Experience">
														</div>
														<div class="form-group  col-md-12">
															<label for="last_company_details">Last Company Details</label>
															<textarea name="last_company_details" id="last_company_details"  class="form-control" cols="30" rows="10"></textarea>
														</div>
														<div class="form-group col-md-12">
															<label for="last_company_joining_date">Last Company Join Date</label>
															<input type="text" class="datepicker form-control" name="last_company_joining_date" id="last_company_joining_date" placeholder="Last Company Joining Date" >
														</div>
														<div class="form-group col-md-12">
															<label for="last_company_relieving">Last Company Relieving Date</label>
															<input type="text" class="datepicker form-control" name="last_company_relieving" id="last_company_relieving" placeholder="Last Company Relieving Date" >
														</div>
														<div class="form-group col-md-12">
															<label for="last_company_salary">Last Company Salary</label>
															<input type="text" class="form-control" name="last_company_salary" id="last_company_salary" placeholder="Last Company Salary">
														</div>
														<div class="form-group col-md-12">
															<label for="first_join_date">First Date of Joining</label>
															<input type="text" class="datepicker form-control" name="first_join_date" id="first_join_date" placeholder="First Date of Joining">
														</div>
													</div>
												</div>
												
											</div>
										</div>
										<div class="tab-pane fade" id="tab4">
											<div class="row">
												<div class="col-md-10">
													<div class="row">
														<div class="form-group col-md-6">
															<label for="appraisal_term">Appraisal Term</label>
															<select name="appraisal_term" class="form-control" id="appraisal_term">
																<option value="first">First</option>
																<option value="second">Second</option>
																<option value="third">Third</option>
															</select>
														</div>
														<div class="form-group  col-md-6">
															<label for="cb_designation">Designation</label>
															<input type="text" class="form-control col-md-6" name="cb_designation" id="cb_designation" placeholder="Designation" >
														</div>
														<div class="form-group col-md-12">
															<label for="cb_salary">Salary</label>
															<input type="text" class="form-control" name="cb_salary" id="cb_salary" placeholder="Salary" >
														</div>
														<div class="form-group col-md-12">
															<label for="cb_stay_bonus">Stay Bonus</label>
															<input type="text" class="form-control" name="cb_stay_bonus" id="cb_stay_bonus" placeholder="Stay Bonus" >
														</div>
														<div class="form-group col-md-12">
															<label for="appraisal_comments">Appraisal Comments</label>
															<textarea name="appraisal_comments" class="form-control" id="appraisal_comments" cols="30" rows="10"></textarea>
														</div>
														<div class="form-group col-md-12">
															<label for="appraisal_status">Appraisal Status</label>
															<select name="appraisal_status" id="appraisal_status" class="form-control">
																<option value="not_done">Not Done</option>
																<option value="done">Done</option>
															</select>
														</div>
													</div>
												</div>
												
											</div>
										</div>
										<ul class="pager wizard">
											<input type="submit" name="Submit" class="btn btn-primary">
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
		$(document).ready(function() {
			$('.select2').select2();
			$('.pastDatepicker').datepicker({endDate: '0m'});
			$("#martial_status").on('change',function(e){
				if(e.target.value == "unmarried"){
					$('#ann_div').hide();
				}else{
					$('#ann_div').show();
				}
			})
			
			$('#employeeForm').submit(function(event) {
				if($('#first_name').val() == ''){
					swal('Oops','First name is required','warning');
					return false;
				}
				else if($('#email').val() == ''){
					swal('Oops','Email required','warning');
					return false;
				}
				else if($('#password').val() == ''){
					swal('Oops','Password is required','warning');
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
				}
				else if(file_data != null)
				{
					if (file_data.type!=="image/png" && file_data.type!=="image/jpeg" && file_data.type!=="image/jpg")  
					{
						swal("Oops", "Please upload a valid image file", "warning");
						return false;

					}
				}else{
					return true;
				}
			});
		});
	</script>
	@endsection
	@endsection