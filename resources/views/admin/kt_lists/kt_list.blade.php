@extends('admin.layouts.app')

@section('content')

@section('title','Knowledge Transfer list')

<style>

.table td, .table>tbody>tr>td

{

	vertical-align:  middle;

}

</style>



<div class="page-inner">

	<div class="page-title">

		<h3>Knowledge Transfer list</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

				<li class="active"><a href="{{URL('/admin/kt_list')}}">Knowledge Transfer list</a></li>

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

						<h4 class="panel-title">Knowledge Transfer list</h4>

					</div>



					

					<div class="panel-body">

						<div class="table-responsive table-remove-padding">

							<table class="table" id="datatable">

								<thead>

									<tr>

										<th>#</th>

										<th>Employee ID</th>

										<th>Employee </th>

										<th>Projects</th>
										

										<th>Assign Employee</th>
									

									</tr>

								</thead>

								<tbody>

									@foreach($kt_lists as $kt_list)

									<tr>

										<td>{{$kt_list->id}}</td>

										<td>EMP00{{$kt_list->user_id}}</td>

										<td><b>{{getUserById($kt_list->user_id)->first_name}} {{getUserById($kt_list->user_id)->last_name}}</b></td>

									

										<td>{{$kt_list->project_name}}</td>

										<td>{{getUserById($kt_list->kt_given_to)['first_name']}} {{getUserById($kt_list->kt_given_to)['last_name']}}</td>
									

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



	<!-- Modal -->

	



	<div class="page-footer">

		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>

	</div>

</div><!-- Page Inner -->

@section('script')



@endsection

@endsection