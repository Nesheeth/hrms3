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

				

											</div>


										</div>

									</div>








									<ul class="pager wizard">


										<button type="submit" name="Submit" class="btn btn-primary">Submit</button>


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