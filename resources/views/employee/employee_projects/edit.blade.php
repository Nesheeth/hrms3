@extends('employee.layouts.app')
@section('title','Employee Projects')
@section('content')
<div class="page-inner">
	<div class="page-title">
		<h3>Employee Projects</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/employee-projects')}}">Employee Projects</a></li>
				<li class="active">Update Assigned Project</li>
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
						<h4 class="panel-title">Update Assigned Project Form</h4>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="{{URL('/teamLead/employee-project/update')}}" method="post" enctype="multipart/form-data">
							<div class="box-body">
								{{csrf_field()}}
								<input type="hidden" name="id" value="{{$employee_project->id}}">
								<div class="form-group">
									<label for="project" class="col-sm-2 control-label">Project</label>
									<div class="col-sm-10">
										<select name="project" id="project" class="form-control select2">
											<option value="">--Select Project--</option>	
											@foreach($projects as $project)
											<option value="{{$project->id}}" {{$project->id == $employee_project->project_id ? "selected":''}}>{{$project->name}}</option>
											@endforeach
										</select>	
										@if ($errors->has('project'))
										<span class="label label-danger">{{ $errors->first('project') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="assign_to" class="col-sm-2 control-label">Assign To</label>
									<div class="col-sm-10">
										<select name="assign_to" id="assign_to" class="form-control select2">
											<option value="">--Select Employee--</option>	
											@foreach($employees as $employee)
											<option value="{{$employee->id}}" {{$employee->id == $employee_project->user_id ? "selected":''}}>{{$employee->first_name}} {{$employee->last_name}}</option>
											@endforeach
										</select>	
										@if ($errors->has('assign_to'))
										<span class="label label-danger">{{ $errors->first('assign_to') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="reporting_to" class="col-sm-2 control-label">Reporting To</label>
									<div class="col-sm-10">
										<select name="reporting_to" id="reporting_to" class="form-control select2">
											<option value="">--Select Reporting Person--</option>
											@foreach($upperEmployees as $upperEmployee)
											<option value="{{$upperEmployee->id}}" {{$upperEmployee->id == $employee_project->reporting_to ? "selected":''}}>{{$upperEmployee->first_name}} {{$upperEmployee->last_name}}</option>
											@endforeach
										</select>	
										@if ($errors->has('reporting_to'))
										<span class="label label-danger">{{ $errors->first('reporting_to') }}</span>
										@endif
									</div>
								</div>
								

								<div class="form-group">
									<label for="from_date" class="col-sm-2 control-label">From Date</label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" name="from_date" value="{{$employee_project->from_date}}" placeholder="From Date">
										@if ($errors->has('from_date'))
										<span class="label label-danger">{{ $errors->first('from_date') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="end_date" class="col-sm-2 control-label">End Date</label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" name="end_date" value="{{$employee_project->end_date}}" placeholder="Project End Date">
										@if ($errors->has('end_date'))
										<span class="label label-danger">{{ $errors->first('end_date') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="project_status" class="col-sm-2 control-label">Project Status</label>
									<div class="col-sm-10">
										<select name="project_status" id="project_status" class="form-control">
											<option value="-1" {{ -1 == $employee_project->project_status ? "selected":''}}>Not Started</option>
											<option value="0" {{ 0 == $employee_project->project_status ? "selected":''}}>In Progress</option>
											<option value="1" {{ 1 == $employee_project->project_status ? "selected":''}}>Completed</option>
										</select>
										@if ($errors->has('project_status'))
										<span class="label label-danger">{{ $errors->first('project_status') }}</span>
										@endif
									</div>
								</div>


								<div class="form-group">
									<label for="feedback" class="col-sm-2 control-label">Feedback</label>
									<div class="col-sm-10">
										<textarea name="feedback" id="feedback" cols="30" rows="10" class="form-control">{{$employee_project->feedback}}</textarea>
										@if ($errors->has('feedback'))
										<span class="label label-danger">{{ $errors->first('feedback') }}</span>
										@endif
									</div>
								</div>

							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<a href="{{URL('/teamLead/assign-project')}}" class="btn btn-default">Cancel</a>
								<button type="submit" class="btn btn-info pull-right">Add</button>
							</div>
							<!-- /.box-footer -->
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
{{ Html::script("assets/plugins/waves/waves.min.js") }}
{{ Html::script("assets/plugins/select2/js/select2.min.js") }}
{{ Html::script("assets/plugins/summernote-master/summernote.min.js") }}
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
{{ Html::script("assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js") }}
{{ Html::script("assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js") }}
{{ Html::script("assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js") }}
{{ Html::script("assets/js/pages/form-elements.js") }}
<script>
	$(document).ready(function() {
		$('.select2').select2();
	});
</script>
@endsection
@endsection