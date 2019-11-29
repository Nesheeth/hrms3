@extends('admin.layouts.app')
@section('title','Password Management')

@section('content')

<div class="page-inner">
	<div class="page-title">
		<h3>Leave Management</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{ URL(getRoleStr().'/dashboard') }}">Home</a></li> 
				<li><a href="">Leave List</a></li> 
			</ol>
		</div>
	</div>
    <div id="main-wrapper">
    	<div class="row">
    		   <div class="col-sm-12"> 
    		   	<a  class="btn btn-primary pull-right change_pass" {{ (Auth::user()->is_active==1)?'':'disabled' }}> Apply Leave</a> 
    		   </div>
    		   <br> 
    		   <div class="col-sm-12 table-responsive">
    		   	    <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Date From</th>
										<th>Date To</th>
										<th>Days</th>
										<th>Leave Type</th>
										<th>Details</th>
										<th>Status</th>
										{{--<th>Action</th>--}}
									</tr>
								</thead>
								<tbody>
									@foreach($leaves as $leave)
									<tr>
										<td>{{ date('d - M Y', strtotime($leave->date_from)) }}</td>
										<td>{{ date('d - M Y', strtotime($leave->date_to)) }} </td>
										<td>{{$leave->days}}</td>
										<td>{{$leave->leave->leave_type}}</td>
                                        <td>{{$leave->reason}}</td>
										<td>
											@if($leave->status == -1)
											<span class="label label-danger">Discarded</span>
											@elseif($leave->status == 0)
											<span class="label label-warning">Pending</span>
											@elseif($leave->status == 1)
											<span class="label label-success">Approved</span>
											@endif
										</td>

										{{--<td>
											@if($leave->status == 1 && $leave->date_from >= date('m/d/Y') )
											<a href="#" data-target="#myModal{{$leave->id}}" class="btn btn-primary" data-toggle="modal" >Retract</a>
										 @endif           
										</td>--}}
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
    		   </div>
    	</div>
    </div>
</div>

@endsection 

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
		$(document).on('click','.change_pass',function(){

			   var $html = '<div class="panel-body"> <form class="form-horizontal" > {{csrf_field()}} <div class="form-group"> <label for="old_password" class="col-sm-4 control-label">Old Password</label> <div class="col-sm-8"> <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password"> </div> </div> <div class="form-group"> <label for="new_password" class="col-sm-4 control-label">New Password</label> <div class="col-sm-8"> <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password"> </div> </div> <div class="form-group"> <label for="confirm_password" class="col-sm-4 control-label">Confirm Password</label> <div class="col-sm-8"> <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password"> </div> </div> </form> </div>'; 

                BootstrapDialog.show({
                	            type:"BootstrapDialog.TYPE_PRIMARY", 
					            title:"Change Password",
					            message: $html,
					            buttons:[{
					                label:"Submit",
					                cssClass:"btn btn-success",
					                action: function(dialog1){
					                	

					                    var old_password = $('#old_password').val();
										var new_password = $('#new_password').val();
										var confirm_password = $('#confirm_password').val(); 
                                      
										if(old_password == ""){ 
											swal('Oops',"Old Password Required",'warning');  
										}else if(new_password == ""){
											swal('Oops',"New Password Required",'warning');  
										}else if(confirm_password == ""){
											swal('Oops',"Confirm Password Required",'warning');  
										}else if(confirm_password !== new_password){
											swal('Oops',"Confirm Password & New Password Not Matched ",'warning');  
										}else{

											dialog1.enableButtons(false);
											$.ajaxSetup({
												headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
											});
											
											$.ajax({
												url: "{{URL('/postChangePassword')}}",
												type: 'POST',
												data: {'old_password':old_password,'new_password':new_password},
												beforeSend: function(){
													$("#loader-wrapper").show();
												},
												complete: function(){
													$("#loader-wrapper").hide();
												},
												success: function (data) {
													if(data.flag){
														dialog1.close(); 
														swal('Success','Password Changed Successfully','success'); 
													}else{ 
														dialog1.enableButtons(true);
														swal('Oops',data.error,'warning');  
													}
												}
											});
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
