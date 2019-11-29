@extends('sales.layouts.app')

@section('content')

@section('title','My Leaves')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
<div class="page-inner">
	<div class="page-title">
		<h3>Leave Management</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{ URL('sales/'.getRoleStr().'/dashboard') }}">Home</a></li>
				<li class="active">My Leaves</a></li>
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
					    <div class="row">  
					       <div class="col-sm-12">
					       	  <div class="col-sm-4"> <h3> <span class="label label-success"> Available Leave(days) : {{Auth::user()->cb_profile['avail_leaves'] }}</span></h3> </div>
					       	  <div class="col-sm-4"> <h3><span class="label label-info"> Taken Leave (days) :  {{$taken}} </span></h3> </div>
					       	  <div class="col-sm-4">  <h3><span class="label label-danger"> Rejected Leave (days) : {{$rejected}} </span></h3>  </div>
					       </div>
					       <div class="col-sm-9">
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
							<div class="col-sm-3">
		    		   	         <a href="{{route('sl.apply_leave',['role'=> getRoleStr()])}}" class="btn btn-primary pull-right" {{ (Auth::user()->is_active==1)?'':'disabled' }}> Apply Leave</a> 
							</div>
		    		    </div> 
		    		    <br>
						<div class="row">

						   <div class="table-responsive">  
							<table class="table  table-bordered " id="leaves">
								<thead>
									<tr>
										<th>Apply Date</th>
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
										<td>{{ date('d - M Y', strtotime($leave->created_at)) }}</td>
										<td>{{ date('d - M Y', strtotime($leave->date_from)) }}</td>
										<td>{{ date('d - M Y', strtotime($leave->date_to)) }} </td>
										<td>{{$leave->days}}</td>
										<td>{{$leave->leave->leave_type}}</td>
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
											@if($leave->status == 1 && date('Y-m-d', strtotime($leave->date_from)) >= date('Y-m-d')) 
											   <button class="btn btn-primary cancelLeave" rel="{{$leave->id}}" > Retract </button>  
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
			</div>
		</div><!-- Row -->

	</div><!-- Main Wrapper -->
	<div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>

</div><!-- Page Inner -->

@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#leaves').dataTable();

		$(document).on('change','#sort_by',function(){ 
			 window.location.href = "{{route('sl.leave_mng',['role'=>getRoleStr()])}}"+"?&leave_type="+ $(this).val();
		});

		$(document).on('click','.cancelLeave',function(){
                var leave_id = $(this).attr('rel'); 
                BootstrapDialog.show({
				   // size:BootstrapDialog.SIZE_WIDE,
		            title:"Retract Leave",
		            message:'<div class="row"><br>{{csrf_field()}}<div class="col-sm-12"> <label for="reason" class="col-sm-2 control-label">Reason For Cancel</label> <div class="col-sm-10"> <select name="reason_retract" id="reason" class="form-control select2" required> <option value="">--Select Reason--</option> <option value="Work is Completed">Work is Completed</option> <option value="You change your mind">I change my mind</option> </select> </div></div><br><div class="col-sm-12"> <label for="message_retract" class="col-sm-2 control-label">Message</label> <div class="col-sm-10"> <textarea name="message_retract" id="message_retract" rows="5" class="form-control" required></textarea> </br></div></div></div>',
		            buttons:[{ 
		                label:"Save",
		                cssClass:"btn btn-success",
		                action: function(dialog){ 
		                     var reason = $('#reason').val();
		                     var message = $('#message_retract').val();
                              if(reason!=''){
                                    if(message!=''){
                                                 $.ajax({
                                                 	url:"{{route('em.retract_leave',[ 'role'=>getRoleStr() ])}}",
                                                 	type:"get",
                                                 	data:{leave_id:leave_id,reason:reason,message:message},
                                                 	success:function(res){
                                                         window.location.reload(); 
                                                 	}
                                                 });
                                    }else{
                                    	$('#message_retract').focus();
                                    }
                              }else{
                              	$('#reason').focus(); 
                              }
		                }
		            },{ 
		                label:"Close",
		                cssClass:"btn btn-danger",
		                action: function(dialog){ 
		                    dialog.close();
		                }
		            }]
		        });
		});
	});
</script>

@endsection