@extends('admin.layouts.app')

@section('style')

{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

@endsection

@section('content')

@section('title','Retract Leaves')



<div class="page-inner">

	<div class="page-title">

		<h3>Retract Leaves</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>

				<li class="active">Retract Leaves</a></li>

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
					<div class="panel-body">
						
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Applied Date</th>
										<th>Applied By</th>
										<th>Date From</th>
										<th>Date To</th>
										<th>Days</th>
										<th>Retract Reason</th>
										{{--<th>Message</th>--}}
									</tr>
								</thead>
								<tbody>
									@foreach($leaves as $leave)
									<tr>
										<td> {{$loop->iteration}} </td>
										<td> {{ date('d - M Y', strtotime($leave->created_at)) }} </td>
										<td> {{ $leave->user->first_name }} {{ $leave->user->last_name }} </td>
										<td> {{ date('d - M Y', strtotime($leave->date_from)) }} </td>
										<td> {{ date('d - M Y', strtotime($leave->date_to)) }} </td>
										<td> {{ $leave->days }} </td>
										<td><a href="#" data-toggle="tooltip" data-placement="top" 
											title="{{ $leave->retract_message }}"> {{ $leave->retract_reason }} </a>  </td>
										{{--<td>  <a href="#" data-toggle="tooltip" data-placement="left" 
											title="{{ $leave->retract_message }}"> {{ substr($leave->retract_message,0,30) }} </a> </td>--}}
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
@endsection
@endsection