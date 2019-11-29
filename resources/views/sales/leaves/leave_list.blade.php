@extends('sales.layouts.app')

@section('style')

{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

@endsection

@section('content')

@section('title','Team Member Leaves Requests')
<div class="page-inner">
	<div class="page-title">
		<h3>Team Member Leaves Requests</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('sales/'.getRoleStr().'/dashboard')}}">Home</a></li>

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
					<div class="panel-body">
						
						<!-- <div class="row">
							 <div class="col-sm-12">
								<div class="form-group">
									<label for="project_name" class="col-sm-2 control-label"> Filter Leave : </label>
									<div class="col-sm-3">
									<select class="form-control" id="sort_by"> 
											<option value=""> -- Filter By Leave Status -- </option>  
											<option value="3" {{@$l_type=='3' ? 'selected' : ''}} > Pending </option> 
											<option value="1" {{@$l_type=='1' ? 'selected' : ''}} > Approved </option> 
											<option value="2" {{@$l_type=='2' ? 'selected' : ''}} > Rejected </option>
									</select>
									</div>
								</div>
							</div> 
						</div> -->

						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover" id="datatable1">
								<thead>
									<tr>
										<th>#</th>
										<th>Applied Date</th>
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
										<td>{{$loop->iteration}}</td>
										<td data-order="{{strtotime($leave->created_at)}}">{{ date('d - M Y', strtotime($leave->created_at)) }}</td>
										<td>{{getUserById($leave->user_id)->first_name}}</td>
										<td data-order="{{strtotime($leave->date_from)}}"> {{ date('d - M Y', strtotime($leave->date_from)) }}</td>
										<td data-order="{{strtotime($leave->date_to)}}"> {{ date('d - M Y', strtotime($leave->date_to)) }} </td> 
										<td>{{$leave->days}}</td>

										@if($leave->leave_type == 3)
											<td>Sick Leave</td>
										@elseif($leave->leave_type == 4)
											<td>Casual Leave</td>
										@elseif($leave->leave_type == 5)
											<td>Maternity Leave</td>
										@elseif($leave->leave_type == 6)
										<td>Paternity Leave</td>
										@elseif($leave->leave_type == 7)
										<td>Medical Leave</td>
										@elseif($leave->leave_type == 14)
										<td>Half day Leave</td>
										@elseif($leave->leave_type == 15)
										<td>test</td>
										@elseif($leave->leave_type == 16)
										<td>test 1</td>
										@elseif($leave->leave_type == 17)
										<td>test</td>
										@endif

										<td>{{$leave->reason}}</td>
										<td>
										   @if($leave->status == 2)
											<span class="label label-danger"> Rejected  </span>
											@elseif($leave->status == 3) 
											<span class="label label-warning"> Pending  </span>
											@elseif($leave->status == 1)
											<span class="label label-success"> Approved </span>
											@elseif($leave->status == 4)
											<span class="label label-danger"> Retracted </span>
											@endif
										</td>
										<td>
											@if($leave->status == 3 && (Auth::user()->role==2 || Auth::user()->role==4)) 
											 <button class="btn btn-info" onclick="openModel('{{$leave->id}}')"> View Status </button>
											@endif

											@if(Auth::user()->role==1)  
											 <button class="btn btn-info" onclick="openModel('{{$leave->id}}')"> View Status </button>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script>
	
	 $('#datatable1').dataTable(); 

	$(document).on('change','#sort_by',function(){ 
			 window.location.href = "{{route('salesleave',['role'=>getRoleStr()])}}"+"?&leave_type="+ $(this).val();
	});

	// $(document).on('change','#sort_by',function(){ 
	// 		 window.location.href = "{{route('sl.leave_mng',['role'=>getRoleStr()])}}"+"?&leave_type="+ $(this).val();
	// 	});

	

	function openModel(id){ 
		BootstrapDialog.show({
			title: 'New Leave Application ',
            message: $('<div>Loading infomation... </div>').load("{{URL('deleveper/leave-info')}}/"+id),
			buttons: [{
				    label:'Approve',
					  cssClass:'btn btn-success',
					  action:function(dialog){
						      var comments = $('#comments').val(); 
							    if(comments!=''){
										$.ajax({
											url:"{{route('s1.change_leave_status',['role'=> getRoleStr()])}}",
											type:"POST",
											data:{'_token':"{{csrf_token()}}",'action':1,'comment':comments,'leave':id}, 
											success:function(data){
												dialog.close();
												window.location.reload();
											}
										});
							  } else
								  $('#comments').focus();
					   }
			          },{
                        label:'Reject',
					    cssClass:'btn btn-danger',
					    action:function(dialog){
							  var comments = $('#comments').val();
							  if(comments!=''){ 
										$.ajax({
											url:"{{route('s1.change_leave_status',['role'=>getRoleStr()])}}",
											type:"POST",
											data:{'_token':"{{csrf_token()}}",'action':2,'comment':comments,'leave':id},
											success:function(data){
												dialog.close();
												//swal('Success','Leave status update successfully.','success');
												window.location.reload();
											}
									});
							}else
								$('#comments').focus();
					    }
					  },{
						label:'Close',
					    cssClass:'btn btn-primary',
					    action:function(dialog){
							dialog.close();
					     }
					  }]
        });
	}
</script>

@endsection

@endsection