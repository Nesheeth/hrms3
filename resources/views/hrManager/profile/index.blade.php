@extends('hrManager.layouts.app')
@section('content')
@section('title','Profile')

<div class="page-inner">
	<div class="profile-cover">
		<div class="row">
			<div class="col-md-3 profile-image">
				<div class="profile-image-container">
					<img src="{{is_null($employee->cb_profile->employee_pic) ? 'assets/images/profile-picture.png':$employee->cb_profile->employee_pic}}" alt="">
					<a href="javascript:void(0)" class="btn btn-danger pull-right"  data-toggle="modal" data-target="#myModal">Edit Profile Pic</a>
				</div>

			</div>

		</div>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-3 user-profile">
				<h3 class="text-center">{{$employee->first_name}} {{$employee->last_name}}</h3>
				<p class="text-center">{{$employee->cb_profile->designation}}</p>
				<hr>
				<ul class="list-unstyled text-center">
					<li><p><i class="fa fa-envelope m-r-xs"></i><a href="#">{{$employee->email}}</a></p></li>
				</ul>
				<hr>
				
			</div>
			<div class="col-md-9 m-t-lg">
				<div class="panel panel-white">
					<div class="panel-body">
						<div id="rootwizard">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Personal Info</a></li>

							</ul>
							<div class="progress progress-sm m-t-sm">
								<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								</div>
							</div>
							<!-- <form id="wizardForm"> -->
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
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<div class="tab-content">

										<div class="tab-pane active fade in" id="tab1">
											<div class="row m-b-lg">

												<div class="form-group col-md-6">
													<label for="first_name">First Name</label>
													<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">


												</div>
												<div class="form-group  col-md-6">
													<label for="last_name">Last Name</label>
													<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" >
												</div>
												<div class="form-group col-md-12">
													<label for="email">Email address</label>
													<input type="email" class="form-control" name="email" id="email" placeholder="Enter email" >

												</div>
												<div class="form-group col-md-12">
													<label for="password">Password</label>
													<input type="password" class="form-control" name="password" id="password" placeholder="Password" >

												</div>

												<div class="form-group  col-md-6">
													<label for="role">Role</label>
													<select name="role" id="role" class="form-control"  required="required">
														<option value="">--Select Role--</option>

														<option value="1">Selelect</option>

													</select>

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
													<label for="account_no">Account #</label>
													<input type="text" class="form-control col-md-6" name="account_no" id="account_no" placeholder="Account number" >
												</div>
												<div class="form-group  col-md-6">
													<label for="martial_status">Martial Status</label>
													<select name="martial_status" id="" class="form-control">
														<option value="unmarried">Unmarried</option>
														<option value="married">Married</option>
													</select>
												</div>

												<div class="form-group  col-md-6">
													<label for="dob">Date Of Birth</label>
													<input type="text" class="datepicker form-control col-md-6" name="dob" id="dob" placeholder="Date Of Birth" >
												</div>
												<div class="form-group  col-md-6">
													<label for="anniversary_date">Anniversary</label>
													<input type="text" class="datepicker form-control col-md-6" name="anniversary_date" id="anniversary_date" placeholder="Anniversary" >
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
			</div>
		</div>
		<div class="page-footer">
			<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
		</div>
	</div><!-- Page Inner -->
	@section('script')
	@endsection
	@endsection