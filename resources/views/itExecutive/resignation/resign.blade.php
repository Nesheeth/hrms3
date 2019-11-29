@extends('admin.layouts.app')



@section('content')



@section('title','Resignation')







<div class="page-inner">



	<div class="page-title">



		<h3>Resignation</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/itExecutive/dashboard')}}">Home</a></li>



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



					</div>



				



					<div class="message-options pull-right">



						<a href="{{URL('/retract')}}" class="btn btn-danger"><i class="fa fa-reply m-r-xs"></i>Retract</a> 



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



@endsection



@endsection