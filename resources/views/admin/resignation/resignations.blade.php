@extends('admin.layouts.app')
@section('content')
@section('title','Resignations')
<div class="page-inner">
	<div class="page-title">
		<h3>Resignations</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
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
						<h4 class="panel-title">Resignation List</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive table-remove-padding">
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee</th>
										<th>Resign Date</th>
										<th>Last Working Day</th>
										<th>FNF Date</th>
										<!-- <th>Knowledge Transfer Status</th> -->
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($resignations as $resignation)
									<tr>
										<td>{{$resignation->id}}</td>
										<td>{{getUserById($resignation->user_id)['first_name']}} {{getUserById($resignation->user_id)['last_name']}}</td>
										<td>{{$resignation->date_of_resign}}</td>
										<td>{{$resignation->last_working_day}}</td>
										<td>{{$resignation->fnf_date}}</td>
										<!-- <td>
											@if($resignation->is_actived == 1)
											<a href="#" id="kt_assigned" onclick="view1({{$resignation->id}})">
												<span class="text-info">Kt confirmation Request</span>
											</a>
											@elseif($resignation->is_actived == 2)
											<b class="text-success">Confirmed</b>
											@elseif($resignation->is_actived == -1)
											<b class="text-danger">Rejected</b>
											@elseif($resignation->is_actived == 0)
											<b class="text-primary"> Not given</b>
											@endif
										</td> -->
										<td>
											@if($resignation->is_retracted == 1)
											<span class="label label-danger">Retracted</span>
											@endif
											@if($resignation->is_active == 1)
											<span class="label label-success">Accepted</span>
											@elseif($resignation->is_active== 0)
											<b class="label label-warning">Pending</b>
											@elseif($resignation->is_active == -1)
											<b class="label label-danger">Rejected</b>
											@endif
										</td>
										<td>
											<button rel="{{$resignation->id}}" class="btn btn-primary view_resignation">
												<i class="fa fa-eye"></i> View
											</button>
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
	<!-- preview Modal -->
	<div class="modal fade in" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel">Resignation Details</h4>
				</div>
				<div class="modal-body">
					<div class="list">
						<ul class="list-item">
							<li><span>Resignation Date: </span><span id="date_of_resign"></span></li>
							<li><span>Last Working Day: </span><span id="last_working_day"></span></li>
							<li><span>FNF Date: </span><span id="fnf_date"></span></li>
						</ul>
					</div>
					<div class="reg-decripation">
						<table class="table">
							<tbody>
								<tr>
									<td class="table-reg-mod">Current Project</td>
									<td id="Current_Project"></td>
								</tr>
								<tr>
									<td class="table-reg-mod">Reporting Manager</td>
									<td id="reporting_manager"></td>
								</tr>
								<tr>
									<td class="table-reg-mod">Reason For Leaving</td>
									<td id="reason"></td>
								</tr>
								<tr>
									<td class="table-reg-mod">Message</td>
									<td id="message"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-primary " href="#" id="acceptedid">Accept</a>
					<a class="btn btn-danger " href="#" id="rejectedid">Reject</a>
					<button type="button" class="btn btn-default" data-dismiss="modal"">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<!-- preview Modal -->
	<!--- kt assign cnfirm-->
	<div class="modal fade in" id="kt_assign_to" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel">Knowledge Transfer Details</h4>
				</div>
				<div class="modal-body">
					<div class="reg-decripation">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="table-reg-mod bg-dark">Current Project</td>
									<td class=" bg-dark">Assign Knowledge Transfer</td>
								</tr>
								<tr>
									<td class="table-reg-mod" id="Current_Project1"></td>
									<td class="" id="kt_assign"></td> 
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-primary " href="#" id="confirmid">Confirm</a>
					<a class="btn btn-danger " href="#" id="rejected1id">Reject</a>
					<button type="button" class="btn btn-default" data-dismiss="modal"">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<!--- kt assign cnfirm-->
	<div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>
</div><!-- Page Inner -->
@section('script')
<script>



	$(document).on('click','.view_resignation',function(){
		var id = $(this).attr('rel');
		$.ajax({
			url:"{{URL('/resignation')}}/"+id, 
			type:"get",
			success:function(data){
                  console.log(data);
				 $('#date_of_resign').html(data.date);
				 $('#last_working_day').html(data.last_date);
				 $('#fnf_date').html(data.fnf_date);  
				 $('#Current_Project').html(data.c_project);
				 $('#reporting_manager').html(data.manager);
				 $('#reason').html(data.reason);  
				 $('#message').html(data.message);  
				 	$('#acceptedid').attr("href", "{{URL('/admin/resignations/accepted/')}}/" + id );
		            $('#rejectedid').attr("href", "{{URL('/admin/resignations/rejected/')}}/" + id); 
				 $('#previewModal').modal('toggle'); 
			}
		});
	});



	function view(id){
		var resignUrl = "{{URL('/resignation/')}}";
		var resignUrl = "{{URL('/resignation/')}}";
		var resignUrlaccept = "{";
		var resignUrlaccept1 = (resignUrlaccept +'/' + id) ;
		var resignUrlrejected = "";
		var resignUrlrejected1 = (resignUrlrejected +'/' + id) ;
		$('#acceptedid').attr("href",resignUrlaccept1 );
		$('#rejectedid').attr("href",resignUrlrejected1);

		$.get(resignUrl+'/'+id, function(data) {
			if(data.flag){
				if(data.project == null)
				{
					$('#Current_Project').empty().text("none");
				}
				else{
					$('#Current_Project').empty().text(data.project.name);
				}
				$('#date_of_resign').empty().text(data.resign.date_of_resign);
				$('#last_working_day').empty().text(data.resign.last_working_day);
				$('#fnf_date').empty().text(data.resign.fnf_date);
				$('#reason').empty().text(data.resign.reason);
				$('#message').empty().text(data.resign.message);
				var userUrl = "{{URL('/getUser/')}}";
				if(data.resign.manager_id == null){
					var manager = "N/A";
					$('#reporting_manager').text(' '+manager);
				}else{
					$.get(userUrl+'/'+data.resign.manager_id, function(data) {
						if(data.flag){
							var manager = data.user.first_name+' '+data.user.last_name;
							$('#reporting_manager').text(' '+manager);
						}
					});
				}
			}else{
				swal('Oops','Something Went Wrong!','error')
			}
		});
		$('#previewModal').modal('toggle');
	}


	function view1(id){
		$('#Current_Project1').text('');
		$('#kt_assign').text('');
		var resignUrlaccept = "{{URL('/admin/ktassign/confirm/')}}";
		var resignUrlaccept1 = (resignUrlaccept +'/' + id) ;
		var resignUrlrejected = "{{URL('/admin/ktassign/rejected/')}}";
		var resignUrlrejected1 = (resignUrlrejected +'/' + id) ;
		$('#confirmid').attr("href",resignUrlaccept1 );
		$('#rejected1id').attr("href",resignUrlrejected1);   
		var resignUrl = "{{URL('/resignation_kt/')}}";
		$.get(resignUrl+'/'+id, function(data) {
			if(data.flag){
				var kt = (data.$kt_given).length;
				console.log(kt);

				if(kt == 1){
					//console.log("if");
					$('#Current_Project1').html(data.$kt_given[0].project_name+' <br>');
					$('#kt_assign').html(data.$kt_given[0].kt_given_to_name +' <br>');
				}
				else{
					for(var k=0; k<kt; k++)
					{
						$('#Current_Project1').append(data.$kt_given[k].project_name+' <br>');
						$('#kt_assign').append(data.$kt_given[k].kt_given_to_name +' <br>');
					}
				}
				var userUrl = "{{URL('/getUser/')}}";
			}else{
				swal('Oops','Something Went Wrong!','error')
			}
		});
		$('#kt_assign_to').modal('toggle');
	}


	//$('.modal').click(function(){
	//	location.reload();
	//})  
</script>
@endsection
@endsection