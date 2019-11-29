@extends('itExecutive.layouts.app')
@section('content')
@section('title','Resignations')

<div class="page-inner">
	<div class="page-title">
		<h3>Resignation</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/itExecutive/dashboard')}}">Home</a></li>
				<li class="active">Resignations</a></li>
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
						<h4 class="panel-title">Resignations</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive table-remove-padding">
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Resignation Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($resignations as $resignation)
									<tr>
										<td>{{$resignation->id}}</td>
										<td>{{$resignation->date_of_resign}}</td>
										<td>
											@if($resignation->is_active == 1)
											<span class="label label-danger">Active</span>
											@else
											<span class="label label-danger">Retracted</span>
											@endif
										</td>
										<td>
											@if($resignation->is_active == 1)
											<a href="{{URL('/itExecutive/resignation/retract/'.$resignation->id)}}" class="btn btn-danger"><i class="fa fa-reply m-r-xs"></i>Retract</a>
											@else
											<span class="label label-danger">Retracted</span>
											@endif
											<a href="{{URL('/resignation/'.$resignation->id)}}" class="btn btn-primary"><i class="fa fa-eye m-r-xs"></i>View</a>
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
@endsection
@endsection