@extends('hrManager.layouts.app')

@section('style')

{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

@endsection

@section('content')

@section('title','Profile Update Request')



<div class="page-inner">

	<div class="page-title">

		<h3>Profile Update Request</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>

				<li class="active">All Profile Update Request</a></li>

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

						<!-- <h4 class="panel-title">Sent employees</h4> -->

					</div>

					<div class="panel-body">

						<div class="table-responsive">

							<table class="table" id="datatable">

								<thead>

									<tr>

										<th>#</th>

										<th>Employee Name</th>

										<th>Date</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

									@foreach($employees as $employee)

									<tr>

										<td>{{$employee->id}}</td>

										<td><a href="{{URL('/hrManager/employee/profile/'.$employee->id)}}">{{$employee->first_name}}</a></td>

										<td>{{$employee->updated_at}}</td>

										<td>

											<a href="{{URL('hrManager/request/profile/'.$employee->id)}}" class="btn btn-primary">View</a>

											<!-- <a href="{{URL('hrManager/request/profile/approve/'.$employee->id)}}" class="btn btn-danger">Approve</a>

											<a href="{{URL('hrManager/request/profile/discard/'.$employee->id)}}" class="btn btn-danger">Discard</a> -->

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

	{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}

	<script>

		$( "#datatable" ).DataTable({

			"order": [[ 0, "desc" ]]

		});

	</script>

	@endsection

	@endsection