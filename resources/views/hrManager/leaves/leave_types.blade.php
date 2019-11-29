@extends('hrManager.layouts.app')
@section('style')
{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}
{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}
@endsection
@section('content')
@section('title','Leave Types')

<div class="page-inner">
	<div class="page-title">
		<h3>Leave Type</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>
				<li class="active">Leave Types</a></li>
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
						<h4 class="panel-title">Leave Types</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table" id="datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Leave Type</th>
										<th>Description</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($leave_types as $leave_type)
									<tr>
										<td>{{$leave_type->id}}</td>
										<td>{{$leave_type->leave_type}}</td>
										<td>{{$leave_type->description}}</td>
										<td> 
											<a class="btn btn-primary" href="{{URL('hrManager/leave-type/'.$leave_type->id)}}">Edit</a>
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