@extends('sales.layouts.app')

@section('content')

@section('title','Sent EODs')
<div class="page-inner">
	<div class="page-title">
		<h3>Sent EODs</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('sales/'.getRoleStr().'/dashboard')}}">Home</a></li>
				<li class="active">Sent EODs</a></li>
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
						<h4 class="panel-title">Sent EODs</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive table-remove-padding">
							<table class="table" id="datatable">
								<thead>
									<tr> 
										<th>S. NO.</th>
										<th>EOD Date</th>
										<th>Project</th>
										<th>Task Name </th>
										<th>Description</th>
										<th>ES Time </th>
										<th>Total Time </th>
										<th>Delivery Date </th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($eods as $eod)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{date('d M-Y', strtotime($eod->date))}}</td>
										<td>{{$eod->project->project_name}}</td>
										<td>{{$eod->task_name}}</td>
										<td>{{$eod->description}}</td>
										<td>{{$eod->es_hours}}</td>
										<td>{{$eod->total_hours}}</td>
										<td>{{date('d M-Y', strtotime($eod->delivery_date))}}</td>
										{{--<td>
											@if($eod->task_status==1)
                                                 <span class="label  label-success">Complete</span>
											@else
                                                <span class="label  label-danger">In Complete</span>
											@endif
										</td>--}} 

										<td> <span class="label  label-info">{{$eod->task_status}}</span></td>
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

	<div class="modal fade view-eod-list" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mySmallModalLabel" ><i class="fa fa-pencil fa-2x" aria-hidden="true"> EOD Details</i></h4>
					<p>System Code:1110</p>
				</div>
				<div class="modal-body">
					<h5>Date:<span id="eodDate"></span></h5>
					<div class="table-responsive table-remove-padding">
						<table class="table">
							<thead>
								<tr>
									<th>Project</th>
									<th>Hours Spent</th>
									<th>Task</th>
								</tr>
							</thead>
							<tbody id="subEods">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


	<div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>
</div><!-- Page Inner -->


@section('script')

<script>
	function getEod(id){
		var eodUrl = "{{URL('/getEod/')}}";
		$.get(eodUrl+'/'+id, function(data) {
			if(data.flag){
				$('#eodDate').text(' '+data.main_eod.created_at);
				$("#subEods").empty();
				$.each(data.main_eod.sub_eods, function(index, sub_eod) {
					var subEodUrl = "{{URL('/getSubEod/')}}";
					$.get(subEodUrl+'/'+sub_eod.id, function(sub_data) {
						if(sub_data.flag){
							var projectUrl = "{{URL('/getProject/')}}";
							var project = null;
							$.get(projectUrl+'/'+sub_data.sub_eod.project_id, function(pro) {
								if(pro.flag){
									project = pro.project.name;
								}
								$("#subEods").append('<tr><td>'+project+'</td><td>'+sub_data.sub_eod.hours_spent+'</td><td>'+sub_data.sub_eod.task+'</td></tr>');

							});
						}
					});
				});
			}else{
				swal('Oops','Something Went Wrong!','error')
			}
		});
	}
</script>
@endsection

@endsection