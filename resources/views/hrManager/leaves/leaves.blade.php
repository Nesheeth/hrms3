@extends('hrManager.layouts.app')

@section('style')

{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

@endsection

@section('content')

@section('title','Leaves')



<div class="page-inner">

	<div class="page-title">

		<h3>Leaves</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>

				<li class="active">Leaves</a></li>

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

						<h4 class="panel-title">Leave</h4>

					</div>

					<div class="panel-body">

						<div class="table-responsive">

							<table class="table" id="datatable">

								<thead>

									<tr>

										<th>#</th>

										<th>Applied By</th>

										<th>Date From</th>

										<th>Date To</th>

										<th>Days</th>

										<th>Leave Type</th>
                                        <th>Details</th>
										<th>Status</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

									@foreach($leaves as $leave)

									<tr>

										<td>{{$leave->id}}</td>

										<td><a href="{{URL('/hrManager/employee/profile/'.$leave->user_id)}}">{{getUserById($leave->user_id)->first_name}}</a></td>

										<td>{{$leave->date_from}}</td>

										<td>{{$leave->date_to}}</td>

										<td>{{$leave->days}}</td>

										<td>{{$leave->leave_type->leave_type}}</td>
										 <td>{{$leave->reason}}</td>

										<td>

											@if($leave->is_approved == -1)

											<b class="text-danger">Not Approve</b>

											@elseif($leave->is_approved == 0)

											<b class="text-warning">Pending</b>

											@elseif($leave->is_approved == 1)

											<b class="text-primary">Approved</b>

											@endif

										</td>

										<td>

											@if($leave->is_approved == 1 || $leave->is_approved == -1)

											<!-- <a href="{{URL('/hrManager/leave/delete/'.$leave->id)}}" class="btn btn-danger">Delete</a> -->

											@else

											<a href="{{URL('/hrManager/leave/approve/'.$leave->id)}}"  class="btn btn-primary">Approve</a>

											<a href="{{URL('/hrManager/leave/discard/'.$leave->id)}}"  class="btn btn-info">Not Approve</a>

										<!-- 	<a href="{{URL('/hrManager/leave/delete/'.$leave->id)}}" class="btn btn-danger">Delete</a> -->

											@endif



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

	$( "#datatable" ).DataTable({

		"order": [[ 0, "desc" ]]

	});

</script>

@endsection

@endsection