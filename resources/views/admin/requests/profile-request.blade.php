@extends('admin.layouts.app')



@section('content')



@section('title','Profile')







<div class="page-inner">



	<div class="page-title">



		<h3>Profile</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>



				<li><a href="{{URL('/admin/request/profile-update')}}">Request</a></a></li>



				<li class="active">{{$profile->first_name}}</a></li>



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



					<div class="panel-heading clearfix">



						<!-- <h4 class="panel-title">Sent EODs</h4> -->



					</div>



					<div class="panel-body">



						<form action="" method="post" >



							{{csrf_field()}}



							<div class="col-md-12">



								<div class="row">



									<div class="form-group col-md-6">



										<label for="first_name">First Name</label>



										<input type="text" class="form-control @if($profile->first_name != $employee->first_name )red @endif" name="first_name" id="first_name" value="{{$profile->first_name}}" placeholder="First Name">



									</div>



									<div class="form-group  col-md-6">



										<label for="last_name">Last Name</label>



										<input type="text" class="form-control col-md-6 @if($profile->last_name != $employee->last_name )red @endif" name="last_name" id="last_name"  value="{{$profile->last_name}}" placeholder="Last Name" >



									</div>







									<div class="form-group  col-md-12">



										<label for="address">Address</label>



										<textarea name="address" id="address"  class="form-control @if($profile->address != $details->address )red @endif" cols="30" rows="10">{{$profile->address}}</textarea>



									</div>



									<div class="form-group  col-md-6">



										<label for="phone_number">Phone #</label>



										<input type="text" class="form-control col-md-6 @if($profile->phone_number != $details->phone_number )red @endif" name="phone_number" id="phone_number" value="{{$profile->phone_number}}" placeholder="Phone number" >



									</div>



									<div class="form-group  col-md-6">



										<label for="account_no">Account #</label>



										<input type="text" class="form-control col-md-6 @if($profile->bank_account != $details->bank_account )red @endif" name="account_no" id="account_no" value="{{$profile->bank_account}}" placeholder="Account number" >



									</div>
									<div class="form-group  col-md-6">

													<label for="martial_status">Martial Status</label>

													<select name="martial_status" id="martial_status" class="form-control @if($profile->martial_status != $details->martial_status )red @endif">

														<option value="{{$details->martial_status}}">{{$details->martial_status}}</option>

														
													</select>

												</div>



									



									<div class="form-group  col-md-6">



										<label for="dob">Date Of Birth</label>



										<input type="text" class="pastDatepicker form-control col-md-6 @if($profile->dob != $details->dob )red @endif" name="dob" id="dob"  value="{{$profile->dob}}" placeholder="Date Of Birth" >



									</div>



									<div class="form-group  col-md-6">



										<label for="anniversary_date">Anniversary</label>



										<input type="text" class="pastDatepicker form-control col-md-6 @if($profile->anniversary_date != $details->anniversary_date )red @endif" name="anniversary_date" id="anniversary_date"  value="{{$profile->anniversary_date}}" placeholder="Anniversary" >



									</div>







									<div class="form-group col-md-12 per-bor">



										<label for="personal_info">Personal Details</label>



									</div>







									<div class="form-group col-md-12">



										<label for="personal_email">Personal Email</label>



										<input type="email" class="form-control @if($profile->personal_email != $details->personal_email )red @endif" name="personal_email" id="personal_email"  value="{{$profile->personal_email}}" placeholder="Enter email" >



									</div>







									<div class="form-group col-md-6">



										<label for="father_name">Father Name</label>



										<input type="text" class="form-control @if($profile->father_name != $details->father_name )red @endif" name="father_name" id="father_name"  value="{{$profile->father_name}}" placeholder="Father Name">



									</div>



									<div class="form-group col-md-6">



										<label for="mother_name">Mother Name</label>



										<input type="text" class="form-control @if($profile->mother_name != $details->mother_name )red @endif" name="mother_name" id="mother_name"  value="{{$profile->mother_name}}" placeholder="Mother Name">



									</div>







									<div class="form-group col-md-6">



										<label for="parent_number">Parent Contact No.</label>



										<input type="text" class="form-control @if($profile->parent_contact_number != $details->parent_contact_number )red @endif" name="parent_number" id="parent_number"  value="{{$profile->parent_contact_number}}" placeholder="Parent Contact Number">



									</div>



								</div>



								<ul class="pager wizard">



									<a href="{{URL('/admin/request/profile/approve/'.$employee->id)}}" class="btn btn-primary" >Approve</a>



									<a href="{{URL('/admin/request/profile/discard/'.$employee->id)}}" class="btn btn-danger" >Discard</a>



								</ul> 



							</form>



						</div>



					</div>



				</div>



			</div><!-- Row -->



		</div><!-- Main Wrapper -->



		<div class="page-footer">



			<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>



		</div>



	</div><!-- Page Inner -->



	@section('script')



	{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}



	{{ Html::script("assets/plugins/select2/js/select2.min.js") }}



	{{ Html::script("assets/plugins/summernote-master/summernote.min.js") }}



	{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}



	{{ Html::script("assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js") }}



	{{ Html::script("assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js") }}



	{{ Html::script("assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js") }}



	{{ Html::script("assets/js/pages/form-elements.js") }}



	<script>



		$(document).ready(function() {



			$('.pastDatepicker').datepicker({endDate: '0m'});



		});



	</script>



	@endsection



	@endsection