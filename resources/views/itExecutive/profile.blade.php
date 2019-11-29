@extends('employee.layouts.app')

@section('content')

@section('title','Profile')

<style>

.form-group {

	margin-right: 13px !important;

}

.per-bor {

	border-bottom: 2px solid;

}



.per-bor label {

	font-size: 20px;

	padding: 15px 0px 10px 0px;

}



#profile-page label {

	font-size: 16px;

	font-weight: 800;

}



#profile-page p {

	font-size:  15px;

}





</style>

<div class="page-inner">

	<div class="profile-cover">

		<div class="row">

			<div class="col-md-3 profile-image">

				<div class="profile-image-container">

					<a href="javascript:void(0)" class="btn btn-danger profile-pic"  data-toggle="modal" data-target="#uploadProfilePicModal"><i class="fa fa-camera 2x"></i></a>

					<img src="{{is_null($employee->cb_profile->employee_pic) ? 'assets/images/profile-picture.png':$employee->cb_profile->employee_pic}}" alt="">

					

				</div>



			</div>



		</div>

	</div>

	<div id="main-wrapper">

		<div class="row">

			<div class="col-md-12">

				<a href="{{URL('itExecutive/profile/edit')}}" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Edit Profile</a>

				

			</div>

			<div class="col-md-12">

				@if (session('success'))

				<div class="alert alert-success">

					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					{{ session('success') }}

				</div>

				@endif

			</div>

			<div class="col-md-3 user-profile">	

				<!--added new table-->



				<div class="panel panel-white">

					<div class="panel-heading clearfix">

						<h4 class="panel-title text-center">Leave Info</h4>

					</div>

					<div class="panel-body">

						<div class="table-responsive">

							<table  class="display table" style="width: 100%; cellspacing: 0;">

								<tbody>

									<tr>
<!-- 
										<td>Available Leave(days)</td>

										<td><span class="leave-info-badges leave-info-badges-colorAv">{{$employee->cb_profile->avail_leaves}}</span></td> -->
										 <?php if(is_null(\App\Resignation::where('user_id',$employee->id)->where('is_active',1)->first())) { ?>
                                <td>Available Leave(days)</td>
										<td><span class="leave-info-badges leave-info-badges-colorAv">{{$employee->cb_profile->avail_leaves}}</span></td>
      
             
                                   <?php }else  {?>
                                      <td>Available Leave(days)</td>
										<td><span class="leave-info-badges leave-info-badges-colorAv">0</span></td>
                                     <?php } ?>

									</tr>

									<tr>
                                    <?php if(is_null(\App\Resignation::where('user_id',$employee->id)->where('is_active',1)->first())) { ?>
										<td>Rejected Application</td>

										<td><span class="leave-info-badges leave-info-badges-colorRe">{{count(getLeaves($employee->id,-1))}}</span></td>
                                 <?php }else  {?>
                                 	<td>Rejected Application</td>

										<td><span class="leave-info-badges leave-info-badges-colorRe">0</span></td>
										 <?php } ?>
									</tr>

									<tr>
                                     <?php if(is_null(\App\Resignation::where('user_id',$employee->id)->where('is_active',1)->first())) { ?>
										<td>Pending Application</td>

										<td><span class="leave-info-badges leave-info-badges-colorPe">{{count(getLeaves($employee->id,0))}}</span></td>
                                    <?php }else  {?>
                                    	<td>Pending Application</td>

										<td><span class="leave-info-badges leave-info-badges-colorPe">0</span></td>
											 <?php } ?>
									</tr>

									<tr>
                                     <?php if(is_null(\App\Resignation::where('user_id',$employee->id)->where('is_active',1)->first())) { ?>
										<td>Approved Application</td>

										<td><span class="leave-info-badges leave-info-badges-colorAp">{{count(getLeaves($employee->id,1))}}</span></td>
										<?php }else  {?>
											<td>Approved Application</td>

										<td><span class="leave-info-badges leave-info-badges-colorAp">0</span></td>
										 <?php } ?>

									</tr>
									<tr>
										      <?php if(is_null(\App\Resignation::where('user_id',$employee->id)->where('is_active',1)->first())) { ?>
										<td>Half Days</td>
										<td><span class="leave-info-badges leave-info-badges-colorLe">{{$halfdays}}</span></td>
											<?php }else  {?>
												<td>Half Days</td>
										<td><span class="leave-info-badges leave-info-badges-colorLe">0</span></td>
										 <?php } ?>
									</tr>
									<tr>
										<td>Uninform Leave</td>
										<td><span class="leave-info-badges leave-info-badges-colorPe">{{$ui}}</span></td>
									</tr>

									<tr>
                                       <?php if(is_null(\App\Resignation::where('user_id',$employee->id)->where('is_active',1)->first())) { ?>
										<td>Leave Taken(days)</td>

										<td><span class="leave-info-badges leave-info-badges-colorLe">{{$employee->cb_profile->leaves_taken}}</span></td>
										<?php }else  {?>
											<td>Leave Taken(days)</td>

										<td><span class="leave-info-badges leave-info-badges-colorLe">0</span></td>
										 <?php } ?>

									</tr>

								</tr>

							</tbody>

						</table>

					</div>

				</div>

			</div>











			<!--added new table-->

		</div>

		<div class="col-md-9 m-t-lg">

			<div class="panel panel-white">

				<div class="panel-body">

					<div id="rootwizard">

						<ul class="nav nav-tabs" role="tablist">

							<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Personal Info</a></li>

							<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Emp CB Profile</a></li>

							<li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Previous Employment Profile</a></li>

							<li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Employee CB More Details</a></li>

						</ul>





						<!-- <form id="wizardForm"> -->

							<div class="form-horizontal">

								<div class="tab-content" id="profile-page">

									<div class="tab-content">

										<div class="tab-pane active fade in" id="tab1">

											<div class="row m-b-lg">



												<div class="row">

													<div class="form-group col-md-6">

														<label for="first_name">First Name</label>

														<p>{{$employee->first_name}}</p>

													</div>

													<div class="form-group  col-md-6">

														<label for="last_name">Last Name</label>

														<p>{{$employee->last_name}}</p>

													</div>



													<div class="form-group col-md-6">

														<label for="email">Email address</label>

														<p>{{$employee->email}}</p>

													</div>



													<div class="form-group  col-md-6">

														<label for="role">Role</label>

														<p>{{getRoleById($employee->role)}}</p>

													</div>



													<div class="form-group  col-md-12">

														<label for="address">Address</label>

														<address><p>{{$employee->personal_profile->address}}</p></address>

													</div>

													<div class="form-group  col-md-6">

														<label for="phone_number">Phone #</label>

														<p>{{$employee->personal_profile->phone_number}}</p>

													</div>

													<div class="form-group  col-md-6">

														<label for="account_no">Aadhar #</label>

														<p>{{$employee->personal_profile->aadhar_no}}</p>

													</div>

													<div class="form-group  col-md-6">

														<label for="martial_status">Martial Status</label>

														<p>{{$employee->personal_profile->martial_status}}</p>

													</div>



													<div class="form-group  col-md-6">

														<label for="dob">Date Of Birth</label>

														<p>{{$employee->personal_profile->dob}}</p>

													</div>

													@if($employee->personal_profile->martial_status == 'married')

													<div class="form-group  col-md-6">

														<label for="anniversary_date">Anniversary</label>

														<p>{{$employee->personal_profile->anniversary_date}}</p>

													</div>

													@endif

													<div class="form-group col-md-12 per-bor bg-success">

														<label for="personal_info">Personal Details</label>

													</div>



													<div class="form-group col-md-12">

														<label for="personal_email">Personal Email</label>

														<p>{{$employee->personal_profile->personal_email}}</p>

													</div>



													<div class="form-group col-md-6">

														<label for="father_name">Father Name</label>

														<p>{{$employee->personal_profile->father_name}}</p>

													</div>

													<div class="form-group col-md-6">

														<label for="mother_name">Mother Name</label>

														<p>{{$employee->personal_profile->mother_name}}</p>

													</div>



													<div class="form-group col-md-6">

														<label for="parent_number">Parent Contact No.</label>

														<p>{{$employee->personal_profile->parent_contact_number}}</p>

													</div>



													<div class="form-group col-md-12 per-bor bg-success">

														<label for="personal_info">Bank Account information</label>

													</div>



													<div class="form-group col-md-12">

														<label for="">Account Holder Name</label>

														<p>{{$employee->personal_profile->account_holder_name}}</p>

													</div>



													<div class="form-group col-md-6">

														<label for="">Bank Name</label>

														<p>{{$employee->personal_profile->bank_name}}</p>

													</div>

													<div class="form-group col-md-6">

														<label for="">Account Number</label>

														<p>{{$employee->personal_profile->bank_account}}</p>

													</div>



													<div class="form-group col-md-6">

														<label for="">IFSC code</label>

														<p>{{$employee->personal_profile->ifsc_code}}</p>

													</div>



												</div>





											</div>

										</div>

										<div class="tab-pane fade" id="tab2">



											<div class="row">





												<div class="form-group  col-md-6">

													<label for="designation">Designation</label>

													<p>{{$employee->cb_profile->designation}}</p>

												</div>

												<div class="form-group col-md-6">

													<label for="joined_as">Joined as</label>

													<p>{{$employee->cb_profile->joined_as}}</p>

												</div>

												<div class="form-group col-md-6">

													<label for="joining_date">Joining Date</label>

													<p>{{$employee->cb_profile->joining_date}}</p>

												</div>

												<div class="form-group col-md-6">

													<label for="employee_status">Status</label>

													<p>{{$employee->cb_profile->status}}</p>

												</div>

												<div class="form-group col-md-6">

													<label for="salary">Salary</label>

													<p><i class="fa fa-inr" aria-hidden="true"></i> {{$employee->cb_profile->salary}}</p>

												</div>



												<div class="form-group col-md-6">

													<label for="stay_bonus">Stay Bonus</label>

													<p><i class="fa fa-inr" aria-hidden="true"></i> {{$employee->cb_profile->stay_bonus}}</p>

												</div>



												<div class="form-group col-md-6">

													<label for="appraisal_date">Appraisal Date</label>

													<p>{{$employee->cb_profile->appraisal_date}}</p>

												</div>

												<div class="form-group col-md-6">

													<label for="epf">EPF Detail</label>

													<p>{{$employee->cb_profile->epf}}</p>

												</div>

												<div class="form-group col-md-6">

													<label for="esi">ESI Detail</label>

													<p>{{$employee->cb_profile->esi}}</p>

												</div>



											</div>



										</div>

										<div class="tab-pane fade" id="tab3">



											<form method="post" class="form-horizontal" id="new_form" action="{{url('/employee/addnewdetails/'.$employee->id)}}">
											{{csrf_field()}}
											<div class="row" id="pre">
												<div class="form-group col-md-5">
													<label for="total_experience">Total Experience</label>
													<p>{{$employee->previous_employment->total_experience}}</p>
												</div>
												<div class="form-group  col-md-5">
													<label for="last_company_details">Last Company Details</label>
													<address>
														<p>{{$employee->previous_employment->last_company_details}}</p>
													</address>
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_joining_date">Last Company Join Date</label>
													<p>{{$employee->previous_employment->last_company_joining_date}}</p>
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_relieving">Last Company Relieving Date</label>
													<p>{{$employee->previous_employment->last_company_relieving}}</p>
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_salary">Last Company Salary</label>
													<p>{{$employee->previous_employment->last_company_salary}}</p>
												</div>
												<div class="form-group col-md-5">
													<label for="first_join_date">First Date of Joining</label>
													<p>{{$employee->previous_employment->first_join_date}}</p>
												</div>
												@if($employee_extra_details != null)
												@foreach($employee_extra_details as $employee_extra_detail)
												<div class="form-group  col-md-5">
													<label for="last_company_details">Company Name</label>
												
														<p>{{$employee_extra_detail->last_company_details}}</p>
													
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_joining_date">Last Company Join Date</label>
														<p>{{$employee_extra_detail->last_company_joining_date}}</p>
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_relieving">Last Company Relieving Date</label>
														<p>{{$employee_extra_detail->last_company_relieving}}</p>
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_salary">Company Salary</label>
														<p>{{$employee_extra_detail->last_company_salary}}</p>
												</div>
												@endforeach
												@endif
                                               
											</div>
											<input class="btn btn-info pull-right" id="sub" type="submit" value="Submit Information" style="display:none;">
											 <div class="form-group col-md-1">
												<a class="btn btn-danger" id="addMoreBtn"><i class="fa fa-plus"></i> </a>
											    </div>
											
                                            </form>



										</div>

										<div class="tab-pane fade" id="tab4">



											<div class="row">

												<div class="form-group col-md-6">

													<label for="appraisal_term">Appraisal Term</label>

													<p>{{$employee->cb_appraisal_detail->appraisal_term}}</p>

												</div>

												<div class="form-group  col-md-6">

													<label for="cb_designation">Designation</label>

													<p>{{$employee->cb_appraisal_detail->designation}}</p>

												</div>

												<div class="form-group col-md-12">

													<label for="cb_salary">Salary</label>

													<p>{{$employee->cb_appraisal_detail->salary}}</p>

												</div>

												<div class="form-group col-md-12">

													<label for="cb_stay_bonus">Stay Bonus</label>

													<p><i class="fa fa-inr" aria-hidden="true"></i> {{$employee->cb_appraisal_detail->stay_bonus}}</p>

												</div>

												<div class="form-group col-md-12">

													<label for="appraisal_comments">Appraisal Comments</label>

													<p>{{$employee->cb_appraisal_detail->appraisal_comment}}</p>

												</div>

												<div class="form-group col-md-12">

													<label for="appraisal_status">Appraisal Status</label>

													<p>{{$employee->cb_appraisal_detail->appraisal_status}}</p>

												</div>

											</div>



										</div>



									</div>

								</div>



							</div>

						</div>

					</div>

				</div>

			</div>                       

		</div>

	</div>

	<div class="page-footer">

		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>

	</div>



	<div id="loader-wrapper" style="display: none;">

		<div id="loader">

			<img src="{{URL('assets/images/loader.gif')}}" alt="">

		</div>

	</div>



	<div class="modal fade" id="uploadProfilePicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-sm hr-profile-md">

			<div class="modal-body">

				<div class="panel panel-danger">

					<div class="panel-heading clearfix">

						<h4 class="panel-title" id="msg">Upload Profile Picture</h4>	



					</div>

					<div class="panel-body">

						<form class="form-horizontal" >

							{{csrf_field()}}

							<div class="form-group">

								<label for="profilePic" class="col-sm-2 control-label">Photo</label>

								<div class="col-sm-10">

									<input type="file" class="form-control" id="profilePic" name="profilePic">	

								</div>

							</div>

						</form>

					</div>

					<div class="modal-footer">

						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

						<a  id="uploadProfilePic"  class="btn btn-danger">Update</a>

					</div>

				</div>

			</div>



		</div>

	</div>

</div><!-- Page Inner -->

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

	$('#uploadProfilePic').on('click',function(){

		var profilePic = document.querySelector('#profilePic');

		if(profilePic.files[0]) {

			var file_data = $('#profilePic').prop('files')[0];

			var form_data = new FormData();

			form_data.append('profilePic', file_data);

			$.ajaxSetup({

				headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}

			});

			var url  = "{{URL('/profile/update/profile-pic')}}";

			$.ajax({

				url: url,

				type: 'POST',

				data: form_data,

				beforeSend: function(){

					$("#loader-wrapper").show();

				},

				complete: function(){

					$("#loader-wrapper").hide();

				},

				success: function (data) {

					if(data.flag){

						$('#uploadProfilePicModal').modal('toggle');

						swal('Success','File Upload Successfully','success');	

						setTimeout(function(){

							location.reload();

						}, 2000)  

					}else{

						$('#uploadProfilePicModal').modal('toggle');

						swal('Oops',data.error,'warning');	

					}

				},

				contentType: false,

				cache: false,

				processData: false

			});

		}else{

			swal('Error','Upload an Image','warning');	

		}

	});
	$('#addMoreBtn').on('click',function(){
		$('#sub').show();
			var html = `<div class="row" id="new">
												<div class="form-group  col-md-5">
													<label for="last_company_details">Company Name</label><br>
												
														<input type="text" class="form-control" name="last_company_details[]" />
													
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_joining_date">Last Company Join Date</label><br>
													<input type="text" id="datepicker2" class="datepicker form-control" name="last_company_joining_date[]" />
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_relieving">Last Company Relieving Date</label><br>
													<input type="text"  id="datepicker1" class="datepicker form-control" name="last_company_relieving[]" />
												</div>
												<div class="form-group col-md-5">
													<label for="last_company_salary">Company Salary</label><br>
													<input type="text" class="form-control" name="last_company_salary[]" />
												</div>
												
											<div class="form-group col-md-1">
											<a href="#" onclick="removeRow(this)"><span class="badge"><i class="fa fa-times"></i></span></a>
											</div>
											</div>`;
			$('#pre').append(html);
		});
	function removeRow(row){
		$(row).closest('#new').remove();
		
		$('#sub').hide();
	}
	//$('.datepicker1').datepicker();
	$( "#datepicker2" ).datepicker({endDate: '0m'});
	$("#datepicker1" ).datepicker({endDate: '0m'});

</script>

@endsection

@endsection