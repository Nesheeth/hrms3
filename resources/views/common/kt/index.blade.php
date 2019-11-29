@extends('admin.layouts.app')

@section('style')

<!-- {{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}} -->

<!-- {{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}} -->

@endsection

@section('content')

@section('title','Knowledge Transfer')
<div class="page-inner">
	<div class="page-title">
		<h3>Knowledge Transfer Of Members</h3>

		<div class="page-breadcrumb">
 
			<ol class="breadcrumb">

				<li><a href="{{URL(getRoleStr().'/dashboard')}}">Home</a></li>

				<li class="active">Knowledge Transfer</a></li>

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

							<table class="table table-striped table-bordered table-hover" id="datatable1">
								<thead>
									<tr>
										<th>#</th>
										<th>Applied Date</th>
										<th>Applied By</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								 @foreach($kt as $kt1)	

									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$kt1->date_of_resign}}</td>
										<td>{{$kt1->first_name}} {{$kt1->last_name}}</td>
										<td><a href="{{URL('kt-transfer/'.$kt1->user_id)}}" class="btn btn-primary">View</a></td>
										
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
<script>
	
	 $('#datatable1').dataTable(); 

	$(document).on('change','#sort_by',function(){ 
			 window.location.href = "{{route('cm.leave_list',['tole'=>getRoleStr()])}}"+"?&leave_type="+ $(this).val();
	});

</script>

@endsection

@endsection