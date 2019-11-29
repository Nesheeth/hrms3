@extends('admin.layouts.app')

@section('content')

@section('title','Resignations')



<div class="page-inner">

	<div class="page-title">

		<h3>Resignations Retract</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

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

				@if (session('error'))

				<div class="alert alert-danger">

					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					{{ session('error') }}

				</div>

				@endif

				<div class="panel panel-white">

					<div class="panel-heading clearfix">

						<h4 class="panel-title">Retract List</h4>

					</div>

					<div class="panel-body">

						<div class="table-responsive table-remove-padding">

							<table class="table">

								<thead>

									<tr>

										<th>#</th>

										<th>Employee</th>

										<th>Status</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

									@foreach($retracts as $retract)

									<tr>

										<td>{{$retract->id}}</td>

										<td>{{getUserById($retract->user_id)->first_name}} {{getUserById($retract->user_id)->last_name}}</td>


										<td>

											@if($retract->is_active == 1)
											<span class="text-success">Accepted</span>

											@elseif($retract->is_active == 0)
											<b class="text-warning">Pending</b>
											@elseif($retract->is_active == -1)
											<b class="text-danger">Rejected</b>
											@endif

										</td>

										<td><a href="javascript::void()" onclick="view({{$retract->id}})" class="btn btn-primary"><i class="fa fa-eye"></i>View</a></td>

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

					<h4 class="modal-title" id="myModalLabel">Retract Details</h4>

				</div>

				<div class="modal-body">

					

					<div class="reg-decripation">

						<table class="table">

							<tbody>
                               
								

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



	<div class="page-footer">

		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>

	</div>

</div><!-- Page Inner -->

@section('script')

<script>

	function view(id){

		
		var resignUrlaccept = "{{URL('/admin/retract/accepted/')}}";
		var resignUrlaccept1 = (resignUrlaccept +'/' + id) ;
		var resignUrlrejected = "{{URL('/admin/retract/rejected/')}}";
		var resignUrlrejected1 = (resignUrlrejected +'/' + id) ;
		$('#acceptedid').attr("href",resignUrlaccept1 );
		$('#rejectedid').attr("href",resignUrlrejected1);
         var resignUrl = "{{URL('/retract/')}}";
		$.get(resignUrl+'/'+id, function(data) {
		

			if(data.flag){

				
                $('#reason').empty().text(data.retracts.reason);                
				$('#message').empty().text(data.retracts.message);

			}else{

				swal('Oops','Something Went Wrong!','error')

			}

		});

		$('#previewModal').modal('toggle');

	}

</script>

@endsection

@endsection