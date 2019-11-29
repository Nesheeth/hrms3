@extends('employee.layouts.app')



@section('content')



@section('title','Assigned Projects')







<div class="page-inner">



	<div class="page-title">



		<h3>My Assigned Projects</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/employee/dashboard')}}">Home</a></li>



				<li class="active">My Assigned Projects</a></li>



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



						<h4 class="panel-title">My Assigned Projects</h4>



					</div>



					<div class="panel-body">



						<div class="table-responsive table-remove-padding">



							<table class="table">



								<thead>



									<tr>



										<th>Project</th>



										<th>Reporting To</th>



										<th>From Date</th>



										<th>End Date</th>



										<th>Status</th>

											

									</tr>



								</thead>



								<tbody>



									@foreach($projects as $project)



									<tr>



										<td>{{getProjectById($project->project_id)->name}}</td>



										<td>{{getUserById($project->reporting_to)->first_name}}</td>



										<td>{{$project->from_date}}</td>



										<td>{{$project->end_date}}</td>



										<td>



											@if($project->project_status == -1)



											<b class="text-warning">Not Started</b>



											@elseif($project->project_status == 0)



											<b class="text-primary">In Progress</b>



											@elseif($project->project_status == 1)



											<b class="text-danger">Completed</b>



											@endif



										</td>



									</tr>



									@endforeach



								</tbody>



							</table>



						</div>



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



@endsection



@endsection