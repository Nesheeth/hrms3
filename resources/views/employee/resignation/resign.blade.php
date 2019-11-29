@extends('admin.layouts.app')

@section('content')

@section('title','Resignation')


<style type="text/css">
	#add_employee:hover{color:white;}
</style>

<div class="page-inner">



	<div class="page-title">



		<h3>Resignation</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">


				@if(Auth::User()->role == 4  && Auth::User()->department == 'sales')
				<li><a href="{{URL('sales/'.getRoleStr().'/dashboard')}}">Home</a></li>
				@else
				<li><a href="{{URL(getRoleStr().'/dashboard')}}">Home</a></li>
				@endif
			



				<li class="active">Resignation</a></li>



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



				<div class="mailbox-content">



					<div class="message-header">



						<h3>Resignation letter </h3>



                        <div class="list">



												<ul class="list-item">



													<li><span>Resignation Date: </span>{{$resign->date_of_resign}}</li>



													<li><span>Last Working Day: </span>{{$resign->last_working_day}}</li>



													<li><span>FNF Date: </span>{{$resign->fnf_date}}</li>



												</ul>



                                                



											</div>



						



					</div>
					@if(Auth::User()->department = 'development')
					 <div class="form-group">

						
									

									<!-- 
									@if($kt_status)
										<a href="#" id="update_employee" class="btn bg-success">Update Knowledge Transfer</a>
									@else
										<a href="#" id="add_employee" class="btn bg-primary">Assign Knowledge Transfer</a>
									@endif -->



										 @if($kt_status)

										 <span>Kt Confirmation Status:@if($kt_status->is_actived == 2)

											<b class="text-success">Confirmed</b>



											@elseif($kt_status->is_actived == 1)

											<b class="text-warning">In process..</b>

											@elseif($kt_status->is_actived == -1)

											<b class="text-danger">Rejected</b>

											@elseif($kt_status->is_actived == 0)

											<b class="text-primary">Not given</b>

											@endif</span>

											@endif

										

                                       



								



							</div>

						

						


					



										


								</div>

					@endif

					<div class="message-content">



						<div class="reg-decripation">



							<table class="table">



								<tbody>



									<tr>



										<td class="table-reg-mod">Current Project</td>



										<td>@if(is_null($resign->current_project_id))



											<b>N/A</b>



											@else



											<b>{{getProjectById($resign->current_project_id)->name}} </b>



											@endif



										</td>



									</tr>



									<tr>



										<td class="table-reg-mod">Reporting  Manager</td>



										<td>@if(is_null($resign->manager_id))



											<b>N/A</b>



											@else



											<b>{{getUserById($resign->manager_id)->first_name}} {{getUserById($resign->manager_id)->last_name}}</b>



											@endif



										</td>



									</tr>



									<tr>



										<td class="table-reg-mod">Reason For Leaving</td>



										<td>{{$resign->reason}}</td>



									</tr>



									<tr>



										<td class="table-reg-mod">Message</td>



										<td >{{$resign->message}}</td>



									</tr>







								</tbody>



							</table>



							



						</div>

						@if($kt_status)

						@if($kt_status->is_actived == 2)

                        <div class="form-group">

							

															<label for="message" class="col-sm-2 control-label">Your Knowledge Transfer Document here </label>

															<div class="col-sm-10"><a type="file" name="upload_file" href="https://drive.google.com/open?id=0B0nPn4pq9cYyS0prQ2VuU0FSMEU" target="_blank" id="upload_knowledge_tranfer_file">Knowledge Transfer Document</a>

																@if ($errors->has('knowledge_tranfer_file_url'))

										<span class="label label-danger">{{ $errors->first('knowledge_tranfer_file_url') }}</span>

										@endif

															</div>

															

														

                             </div>

                             @endif

                              @endif

					</div>

						



					</div>



					



					<div class="message-options pull-right">

                       @if($resign->is_active == 0 || $resign->is_active== 1)
 
						<a href="{{URL('/retract/')}}?resignation={{$resign->id}}" class="btn btn-danger"><i class="fa fa-reply m-r-xs"></i>Retract</a> 

                     @elseif($resign->is_active == -1)

					  Click here to retract	<a href="{{URL('/employee/resignation/retract/'.$resign->user_id)}}" class="btn btn-danger"><i class="fa fa-reply m-r-xs"></i>Retract</a>

                       @endif

					</div>

					<div class="pull-left">

					<p>Resign Status:@if($resign->is_active == 1)

											<b class="label label-success">Accepted</b>



											@elseif($resign->is_active== 0)

											<b class="label label-warning">Pending</b>

											@elseif($resign->is_active == -1)

											<b class="label label-danger">Rejected</b>

											@endif</p>

										</div>



					



				</div>



				



			</div>



		</div>



	</div><!-- Row -->



	<!-- Main Wrapper -->



	<div class="page-footer">



		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>



	</div>



</div><!-- Page Inner -->



@section('script')

<script>

	$(document).ready(function() {

		$('#add_employee').on('click',function() {

		$('#add_employee1').modal('toggle');

		//$('#kt_submit').modal('toggle');

	});

		$('#kt_submit').on('click',function() {

		
			
		$('#add_employee1').modal('toggle');

	});



		// 

      

	});

   $(document).ready(function() {

		$('#update_employee').on('click',function() {

		$('#update_employee1').modal('toggle');

		//$('#kt_submit').modal('toggle');

	});

		$('#kt_submit').on('click',function() {

		
			
		$('#update_employee1').modal('toggle');

	});



		// 

      

	});

   



	</script>



@endsection



@endsection