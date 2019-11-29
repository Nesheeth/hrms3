@extends('hrManager.layouts.app')
@section('content')
@section('title','Profile')

<div class="page-inner">
	<div class="profile-cover">
		<div class="row">
			<div class="col-md-3 profile-image">
				<div class="profile-image-container">
					<img src="{{is_null($employee->cb_profile->employee_pic) ? 'assets/images/profile-picture.png':$employee->cb_profile->employee_pic}}" alt="">
					
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
							
							<!-- <form id="wizardForm"> -->
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<div class="tab-content">
										{{csrf_field()}}
										<div class="tab-pane active fade in" id="tab1">
											<div class="row m-b-lg">
												
												<div class="form-group col-md-6">
													<label for="first_name">First Name</label>
													<input type="text" class="form-control" name="first_name" id="first_name" value="{{$employee->first_name}}" placeholder="First Name">
												</div>
												<div class="form-group  col-md-6">
													<label for="last_name">Last Name</label>
													<input type="text" class="form-control col-md-6" name="last_name" id="last_name"  value="{{$employee->last_name}}" placeholder="Last Name" >
												</div>
												<div class="form-group col-md-12">
													<label for="email">Email address</label>
													<input type="email" class="form-control" name="email" id="email" readonly value="{{$employee->email}}" placeholder="Enter email" disabled="disabled" >
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
													<label for="account_no">Account #</label>
													<input type="text" class="form-control col-md-6" name="account_no" id="account_no" value="{{$employee->personal_profile->bank_account}}" placeholder="Account number" >
												</div>
												<div class="form-group  col-md-6">
													<label for="martial_status">Martial Status</label>
													<select name="martial_status" id="martial_status" class="form-control">
														<option value="unmarried" {{$employee->personal_profile->martial_status == "unmarried" ? "selected":''}}>Unmarried</option>
														<option value="married" {{$employee->personal_profile->martial_status == "married" ? "selected":''}}>Married</option>
													</select>
												</div>

												<div class="form-group  col-md-6">
													<label for="dob">Date Of Birth</label>
													<input type="text" class="pastDatepicker form-control col-md-6" name="dob" id="dob"  value="{{$employee->personal_profile->dob}}" placeholder="Date Of Birth" >
												</div>
												<div class="form-group  col-md-6" id="ann_div">
													<label for="anniversary_date">Anniversary</label>
													<input type="text" class="pastDatepicker form-control col-md-6" name="anniversary_date" id="anniversary_date"  value="{{$employee->personal_profile->anniversary_date}}" placeholder="Anniversary" >
												</div>

												<div class="form-group col-md-12 per-bor">
													<label for="personal_info">Personal Details</label>
												</div>

												<div class="form-group col-md-12">
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
											</div>
										</div>



									</div>


									<ul class="pager wizard">
										<button type="submit" name="Submit" class="btn btn-primary">Request for Change</button>
									</ul> 
								</div>
							</form>
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
	{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
	<script>
		$( function() {
			$('.pastDatepicker').datepicker({endDate: '0m'});
			$("#martial_status").on('change',function(e){
				if(e.target.value == "unmarried"){
					$('#ann_div').hide();
				}else{
					$('#ann_div').show();
				}
			})
			if($("#martial_status option:selected").val() == "unmarried"){
				$('#ann_div').hide();
			}
		} );
	</script>
	@endsection
	@endsection