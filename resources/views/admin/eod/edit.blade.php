@extends('admin.layouts.app')
@section('content')
@section('title','EOD')

<div class="page-inner">
	<div class="page-title">
		<h3>EOD</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/eods')}}">All EODs</a></li>
				<li class="active">EOD</li>
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
					</div>
					<div class="panel-body">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<div class="box-body">
								{{csrf_field()}}
								<div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Name</label>
									<div class="col-sm-10">
										<input type="text" readonly class="form-control" name="project_name" id="Project Name" value="{{$eod->project_name}}">
									</div>
								</div>
								<div class="form-group">
									<label for="hours_spent" class="col-sm-2 control-label">Hours Spent</label>
									<div class="col-sm-10">
										<input type="text" readonly class="form-control" name="hours_spent" id="Contact Number" value="{{$eod->hours_spent}}">
									</div>
								</div>

								<div class="form-group">
									<label for="comments" class="col-sm-2 control-label">Comments</label>
									<div class="col-sm-10">
										<textarea name="comments" readonly id="comments" cols="30" rows="10" class="form-control">
											{{$eod->comments}}
										</textarea>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<a href="{{URL('/admin/eods')}}" class="btn btn-default">Back</a>
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