@extends('admin.layouts.app')



@section('title','Projects')



@section('content')



<div class="page-inner">



	<div class="page-title">



		<h3>Projects</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>



				<li><a href="{{URL('/admin/projects')}}">Projects</a></li>



				<li class="active">Add Project</li>



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



						<h4 class="panel-title">Add Project Form</h4>



					</div>



					<div class="panel-body">



						<form class="form-horizontal" method="post" enctype="multipart/form-data">



							<div class="box-body">



								{{csrf_field()}}

                              <input type="hidden" name="user_id" value="{{$user_id}}">

								<div class="form-group">



									<label for="project_name" class="col-sm-2 control-label">Project Name</label>



									<div class="col-sm-10">



										<input type="text" class="form-control" name="project_name" placeholder="Project Name">



										@if ($errors->has('project_name'))



										<span class="label label-danger">{{ $errors->first('project_name') }}</span>



										@endif



									</div>



								</div>







								<div class="form-group">



									<label for="start_date" class="col-sm-2 control-label">Start Date</label>



									<div class="col-sm-10">



										<input type="text" class="datepicker form-control" id="start_date" name="start_date" placeholder="Project Start Date">



										@if ($errors->has('start_date'))



										<span class="label label-danger">{{ $errors->first('start_date') }}</span>



										@endif



									</div>



								</div>







								<div class="form-group">



									<label for="end_date" class="col-sm-2 control-label">End Date</label>



									<div class="col-sm-10">



										<input type="text" class="form-control" name="end_date" placeholder="Project End Date" id="end_date">

                                        <span id="end_date_error" class="label label-danger"></span>

										@if ($errors->has('end_date'))



										<span class="label label-danger">{{ $errors->first('end_date') }}</span>



										@endif



									</div>



								</div>







								<div class="form-group">



									<label for="client_name" class="col-sm-2 control-label">Client Name</label>



									<div class="col-sm-10">



										<input type="text" class="form-control" name="client_name" placeholder="Client Name">



										@if ($errors->has('client_name'))



										<span class="label label-danger">{{ $errors->first('client_name') }}</span>



										@endif



									</div>



								</div>







								<div class="form-group">



									<label for="project_comments" class="col-sm-2 control-label">Comments</label>



									<div class="col-sm-10">



										<textarea name="project_comments" id="project_comments" cols="30" rows="10" class="form-control" placeholder="Project Comments"></textarea>



										@if ($errors->has('project_comments'))



										<span class="label label-danger">{{ $errors->first('project_comments') }}</span>



										@endif



									</div>



								</div>



							</div>



							<!-- /.box-body -->



							<div class="box-footer">



								<a href="{{URL('/admin/projects')}}" class="btn btn-default">Cancel</a>



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



<script type="text/javascript">

	

	$(document).ready(function(){

		$('#end_date').datepicker().on('change', function(){
			 endDate = this.value;
			 startDate = $('#start_date').val();
			 var diff = new Date(endDate) - new Date(startDate);

			 if( (diff/1000/60/60/24) < 1){ 
			 	console.log('Invalid date');
			 	$('#end_date').val(''); 
			 	$('#end_date').focus(); 
			 	//$('#end_date_error').text('Date should be greater then start data.'); 
			 }
		});

	});
</script>



@endsection



@endsection