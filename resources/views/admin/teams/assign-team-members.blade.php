@extends('admin.layouts.app')

@section('content')

@section('title','Assign Team members')



<div class="page-inner">

	<div class="page-title">

		<h3>Assign Team members</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

				<li class="active">Assign Team members</a></li>

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

									<label for="team_leader" class="col-sm-2 control-label">Team Leader</label>

									<div class="col-sm-10">

										<select name="team_leader" id="team_leader" class="form-control select">

											<option value="">--Select Team Leader--</option>  

											@foreach($team_leaders as $team_leader)

											<option value="{{$team_leader->id}}">{{$team_leader->first_name}} {{$team_leader->last_name}}</option>

											@endforeach

										</select>

										@if ($errors->has('team_leader'))

										<span class="label label-danger">{{ $errors->first('team_leader') }}</span>

										@endif

									</div>

								</div>



								<div class="form-group">

									<label for="team_members" class="col-sm-2 control-label">Team Members</label>

									<div class="col-sm-10">

										<select name="team_members[]" id="team_members" class="form-control select" multiple="multiple">

											<option  disabled>--Select Team members--</option>

											@foreach($team_members as $team_member)

											<option value="{{$team_member->id}}">{{$team_member->first_name}} {{$team_member->last_name}}</option>

											@endforeach

										</select>

										@if ($errors->has('team_members'))

										<span class="label label-danger">{{ $errors->first('team_members') }}</span>

										@endif

									</div>

								</div>

							</div>

							<!-- /.box-body -->

							<div class="box-footer">

								<a href="{{URL('/admin/dashboard')}}" class="btn btn-default">Cancel</a>

								<button type="submit" class="btn btn-info pull-right">Assign</button>

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

{{ Html::script("assets/plugins/select2/js/select2.min.js") }}

<script>

	$(document).ready(function() {

		$('select').select2();

	});

</script>	

@endsection

@endsection