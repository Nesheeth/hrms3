@extends('hrManager.layouts.app')

@section('style')

{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

@endsection

@section('content')

@section('title','Holidays')



<div class="page-inner">

	<div class="page-title">

		<h3>Holidays</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>

				<li class="active">Holidays</a></li>

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

						<h4 class="panel-title">Holidays</h4>

					</div>

					<div class="panel-body">

						<div class="table-responsive">

							<table class="table" id="datatable">

								<thead>

									<tr>

										<th>Month</th>

										<th>Date</th>

										<th>Description</th>
										<th>Status</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

									@foreach($holidays as $holiday)

									<tr>

										<td>{{date('F', mktime(0, 0, 0, $holiday->month, 10))}}</td>

										<td>{{$holiday->date}}</td>

										<td>{{$holiday->comments}}</td>
										<td>{{$holiday->category}}</td>

										<td> 

											<a class="btn btn-primary" href="{{URL('hrManager/holiday/'.$holiday->id)}}">Edit</a>

											<a class="btn btn-danger" href="{{URL('hrManager/holiday/delete/'.$holiday->id)}}">Delete</a>

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

{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}

<script>

	$( "#datatable" ).DataTable();

</script>

@endsection

@endsection