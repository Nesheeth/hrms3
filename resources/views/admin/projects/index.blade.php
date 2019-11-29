@extends('admin.layouts.app')

@section('content')

@section('title','Projects')



<div class="page-inner">

	<div class="page-title">

		<h3>Projects</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

				<li class="active">Projects</a></li>

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

						<h4 class="panel-title">Projects</h4>

					</div>

					<div class="panel-body">

						<div class="table-responsive table-remove-padding">

							<table class="table" id="datatable">

								<thead>

									<tr>

										<th>Project ID</th>
										<th>Project Name</th>
										<th>Assigned To</th>
										<th>Reporting To</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Client Name</th>
										<th>Status</th>
										<th>Action</th>
									</tr>

								</thead>

								<tbody>

									@foreach($projects as $project)

									<tr>

										<td><b>{{$project->project_id}}</b></td>
										<td><a href="{{URL('/admin/project/'.$project->id)}}">{{getProjectById($project->id)->name}}</a></td>
											<td><a href="{{URL('/admin/employee/profile/'.$project->user_id)}}">{{getUserById($project->user_id)['first_name']}}</a></td>
												<td><a href="{{URL('/admin/employee/profile/'.$project->reporting_to)}}">{{getUserById($project->reporting_to)['first_name']}} {{getUserById($project->reporting_to)['last_name']}}</a></td>
										<td>{{$project->start_date}}</td>
										<td>{{$project->end_date}}</td>
										<td>{{$project->client_name}}</td>
										<td>@if($project->project_status == -1)
											<b class="text-warning">Not Started</b>
											@elseif($project->project_status == 0)
											<b class="text-primary">In Progress</b>
											@elseif($project->project_status == 1)
											<b class="text-danger">Completed</b>
											@endif</td>
										<td>
											<a href="{{URL('/admin/project/'.$project->id)}}" class="btn btn-primary">View</a>
											<!-- <a href="{{URL('/admin/project/'.$project->id)}}" class="btn btn-primary">Update</a> -->
											<!-- <a href="{{URL('/admin/project/delete/'.$project->id)}}" class="btn btn-danger">Delete</a> -->
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