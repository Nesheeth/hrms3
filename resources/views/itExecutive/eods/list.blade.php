@extends('admin.layouts.app')
@section('title','My Eods')

@section('content')
<div class="page-inner">
	<div class="page-title">
		<h3>My Eods</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/employee/dashboard')}}">Home</a></li>
				<li class="active">My Eods</a></li>
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
						<div class="table-responsive   mn-text-align">
							 <table class="table table-striped table-bordered table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
									<th>Date</th>
                                    <th>Task ID</th>
                                    <th>Issue Type</th>
                                    <th>CBPC NO.</th>
                                    <th>Issue Details</th>
                                    <th>Resolution Provided</th>
                                    <th>Resolution Status</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
							 <tbody>
                                @foreach($iode as $iod)
								   <tr>
								     <td>{{$loop->iteration}}</td>
								     <td>{{date('d-m-Y', strtotime($iod->eod_date))}}</td>
								     <td>{{$iod->task_id}}</td>
								     <td>{{$iod->issue_type}}</td>
								     <td>{{$iod->cbpc_no}}</td>
								     <td>{{$iod->issue_details}}</td>
								     <td>{{$iod->resolution_provided}}</td>
								     <td>{{$iod->resolution_status}}</td>
								     <td>{{$iod->comment}}</td>
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
@endsection
@section('script')

@endsection