@extends('employee.layouts.app')
@section('title','Projects')
@section('content')
<div class="page-inner">
	<div class="page-title">
		<h3>Projects</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/employee/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/employee/projects')}}">Projects</a></li>
				<li class="active">Update Project</li>
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
						<h4 class="panel-title">Update Project Form</h4>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="{{URL('/teamLead/project/update')}}" method="post" enctype="multipart/form-data">
							<div class="box-body">
								{{csrf_field()}}
								<input type="hidden" name="id" value="{{$project->id}}">
								<div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="project_name" value="{{$project->name}}" placeholder="Project Name">
										@if ($errors->has('project_name'))
										<span class="label label-danger">{{ $errors->first('project_name') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="start_date" class="col-sm-2 control-label">Start Date</label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" name="start_date" value="{{$project->start_date}}" placeholder="Project Start Date">
										@if ($errors->has('start_date'))
										<span class="label label-danger">{{ $errors->first('start_date') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="end_date" class="col-sm-2 control-label">End Date</label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" name="end_date" value="{{$project->end_date}}" placeholder="Project End Date">
										@if ($errors->has('end_date'))
										<span class="label label-danger">{{ $errors->first('end_date') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="client_name" class="col-sm-2 control-label">Client Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="client_name" value="{{$project->client_name}}" placeholder="Client Name">
										@if ($errors->has('client_name'))
										<span class="label label-danger">{{ $errors->first('client_name') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="project_comments" class="col-sm-2 control-label">Comments</label>
									<div class="col-sm-10">
										<textarea name="project_comments" id="project_comments" cols="30" rows="10" class="form-control" placeholder="Project Comments">{{$project->project_comments}}</textarea>
										@if ($errors->has('project_comments'))
										<span class="label label-danger">{{ $errors->first('project_comments') }}</span>
										@endif
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<a href="{{URL('/teanLead/projects')}}" class="btn btn-default">Cancel</a>
								<button type="submit" class="btn btn-info pull-right">Update</button>
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

@endsection
@endsection