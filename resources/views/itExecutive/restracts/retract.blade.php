@extends('employee.layouts.app')
@section('content')
@section('title','Resignation')

<div class="page-inner">
	<div class="page-title">
		<h3>Resignation</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/employee/dashboard')}}">Home</a></li>
				<li class="active">Retract</a></li>
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
				<div class="mailbox-content">
					
					<div class="message-content">
						<div class="reg-decripation">
							<table class="table">
								<tbody>
									
									
									<tr>
										<td class="table-reg-mod">Reason For Leaving</td>
										<td>{{$retract['reason']}}</td>
									</tr>
									
									
									<tr>
										<td class="table-reg-mod">Message</td>
										<td >{{$retract['message']}}</td>
									</tr>

								</tbody>
							</table>
							
						</div>
						
					</div>
					
					
					<div class="pull-left">
					<p>Retract Status:@if($retract->is_active == 1)
											<b class="text-success">Accepted</b>

											@elseif($retract->is_active== 0)
											<b class="text-warning">Pending</b>
											@elseif($retract->is_active == -1)
											<b class="text-danger">Rejected</b>
											@endif</p>
										</div>
										@if($retract->is_active == 1)
										<div class="message-options pull-right">Click buton to retract
						<a href="{{URL('/itExecutive/resignation/retract/'.$retract->user_id)}}" class="btn btn-danger"><i class="fa fa-reply m-r-xs"></i>Retract</a>
						@elseif($retract->is_active == -1)
						<p class="text-danger pull-right">Your Request is rejected by Admin </p>
						@else 
					</div>
					@endif
				</div>
				
			</div>
		</div>
	</div><!-- Row -->
	<!-- Main Wrapper -->
	<div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>
</div><!-- Page Inner -->
@section('script')
@endsection
@endsection