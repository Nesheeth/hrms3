@extends('employee.layouts.app')
@section('content')
@section('title','Employee Projects')

<div class="page-inner">
	<div class="page-title">
		<h3>Team Projects List</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/employee/dashboard')}}">Home</a></li>
				<li class="active">Team Projects List</a></li>
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
						<h4 class="panel-title">Team Projects List</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table" id="datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Project</th>
										<th>Assigned To</th>
										<th>Reporting To</th>
										<th>From Date</th>
										<th>End Date</th>
										<th>Status</th>
										<th>Assign By</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($employee_projects as $employee_project)
									<tr>
										<td>{{$employee_project->id}}</td>
										<td><a href="{{URL('/teamLead/project/'.$employee_project->project_id)}}">{{getProjectById($employee_project->project_id)->name}}</a></td>
										<td><a href="{{URL('/teamLead/profile/'.$employee_project->user_id)}}">{{getUserById($employee_project->user_id)->first_name}}</a></td>
										<td>{{getUserById($employee_project->reporting_to)->first_name}} {{getUserById($employee_project->reporting_to)->last_name}}</td>
										<td>{{$employee_project->from_date}}</td>
										<td>{{$employee_project->end_date}}</td>
										<td>
											@if($employee_project->project_status == -1)
											<b class="text-warning">Not Started</b>
											@elseif($employee_project->project_status == 0)
											<b class="text-primary">In Progress</b>
											@elseif($employee_project->project_status == 1)
											<b class="text-danger">Completed</b>
											@endif
										</td>
										<td>{{getUserById($employee_project->assign_by)['first_name']}} {{getUserById($employee_project->assign_by)['last_name']}}</td>
										<td>
											<a href="{{URL('teamLead/employee-project/'.$employee_project->id)}}" class="btn btn-primary">Edit</a>
											<a href="{{URL('/teamLead/employee-project/delete/'.$employee_project->id)}}" class="btn btn-danger">Delete</a>
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