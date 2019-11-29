@extends('employee.layouts.app')

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

			
			@if(Session::has('error'))
				<span class="alert alert-danger">{{Session::get('error')}}</span>
			@endif

			@if(Session::has('success'))
				<span class="alert alert-success">{{Session::get('success')}}</span>
			@endif

			<div class="col-md-9 m-t-lg">



				<div class="panel panel-white">



					<div class="panel-body">



						<div id="rootwizard">



							<ul class="nav nav-tabs" role="tablist">



								<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Personal Info</a></li>

							</ul>

							<!-- <form id="wizardForm"> -->



								<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form">



									<div class="tab-content">



										{{csrf_field()}}



										<div class="tab-pane active fade in" id="tab1">



											<div class="row m-b-lg">



												



												<div class="form-group col-md-6">



													<label for="first_name">First Name</label>



													<input type="text" class="form-control " name="first_name" id="first_name" required value="{{$employee->first_name}}" placeholder="First Name">



												</div>



												<div class="form-group  col-md-6">



													<label for="last_name">Last Name</label>



													<input type="text" class="form-control col-md-6" name="last_name" id="last_name" required="required"  value="{{$employee->last_name}}" placeholder="Last Name" >



												</div>



												<div class="form-group col-md-12">



													<label for="email">Email address</label>



													<input type="email" class="form-control" name="email" id="email" readonly value="{{$employee->email}}" placeholder="Enter email" disabled="disabled" required="required">



												</div>







												<div class="form-group  col-md-12">



													<label for="address">Address</label>



													<textarea name="address" id="address"  class="form-control" cols="30" rows="10" required="required">{{$employee->personal_profile->address}}</textarea>



												</div>



												<div class="form-group  col-md-6">



													<label for="phone_number">Phone #</label>



													<input type="text" class="form-control col-md-6" name="phone_number" id="phone_number" value="{{$employee->personal_profile->phone_number}}" placeholder="Phone number" required="required">



												</div>



												<div class="form-group  col-md-6">



													<label for="account_no">Account #</label>



													<input type="text" class="form-control col-md-6" name="account_no" id="account_no" value="{{$employee->personal_profile->bank_account}}" placeholder="Account number" required="required">



												</div>



												<div class="form-group  col-md-6">



													<label for="martial_status">Marital Status</label>



													<select name="martial_status" id="martial_status" class="form-control" required="required">



														<option value="unmarried" {{$employee->personal_profile->martial_status == "unmarried" ? "selected":''}}>Unmarried</option>



														<option value="married" {{$employee->personal_profile->martial_status == "married" ? "selected":''}}>Married</option>



													</select>



												</div>







												<div class="form-group  col-md-6">



													<label for="dob">Date Of Birth</label>



													<input type="text" class="datepicker form-control col-md-6" name="dob" id="dob"  value="{{$employee->personal_profile->dob}}" placeholder="Date Of Birth" required="required">



												</div>


                                               
												<div class="form-group  col-md-6" id="anniversary">
													<label for="anniversary_date">Anniversary</label>
													<input type="text" class="datepicker form-control col-md-6" name="anniversary_date" 
													id="anniversary_date"  value="{{$employee->personal_profile->anniversary_date}}" placeholder="Anniversary" >
												</div>
                                               

												<div class="form-group col-md-12 per-bor bg-success">
													<label for="personal_info">Personal Details</label>
												</div>







												<div class="form-group col-md-12">



													<label for="personal_email">Personal Email</label>



													<input type="email" class="form-control" name="personal_email" id="personal_email"  value="{{$employee->personal_profile->personal_email}}" placeholder="Enter email" required="required">



												</div>







												<div class="form-group col-md-6">



													<label for="father_name">Father Name</label>



													<input type="text" class="form-control" name="father_name" id="father_name"  value="{{$employee->personal_profile->father_name}}" placeholder="Father Name" required="required">



												</div>



												<div class="form-group col-md-6">



													<label for="mother_name">Mother Name</label>



													<input type="text" class="form-control" name="mother_name" id="mother_name"  value="{{$employee->personal_profile->mother_name}}" placeholder="Mother Name" required="required">


												</div>



												<div class="form-group col-md-6">



													<label for="parent_number">Parent Contact No.</label>

													<input type="text" class="form-control" name="parent_number" id="parent_number"  value="{{$employee->personal_profile->parent_contact_number}}" placeholder="Parent Contact Number" required="required">



												</div>



											</div>



										</div>
									</div>


									<ul class="pager wizard"> 
										<button type="submit"  name="Submit" class="btn btn-primary" {{Auth::user()->request_json!='' ? 'disabled' : ''}} > Request for Change </button>
									    @if(Auth::user()->request_json!='')
                                          <br> <span style="color: red"> * You can make request after approved your last request.</span> 
									    @endif
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
<script type="text/javascript">
	
$(document).ready(function(){ 

	  @if($employee->personal_profile->martial_status == "unmarried")
	      $('#anniversary').hide(); 
	  @endif 

	  $(document).on('change',"#martial_status" ,function(){  
	  	 if(this.value=='married')
	  	 	$('#anniversary').show();
	  	 else
	  	 	$('#anniversary').hide(); 
	  });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
<!-- <script>
    $(document).ready(function () {
    $('#form').validate({ // initialize the plugin
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            address: {
                required: true,   
            },
            father_name: {
                required: true    
            },
            mother_name: {
                required: true     
            },
            parent_number: {
            	required: true
            }
            
        }
    });
});
</script> -->


@endsection



@endsection