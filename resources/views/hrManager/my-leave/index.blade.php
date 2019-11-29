@extends('hrManager.layouts.app')



@section('content')



@section('title','My Leaves')







<div class="page-inner">



	<div class="page-title">



		<h3>My Leaves nnnn</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>



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



					<div class="panel-heading clearfix">



						<h4 class="panel-title">My Leaves</h4>



					</div>



					<div class="panel-body">



						<div class="table-responsive table-remove-padding">



							<table class="table">



								<thead>



									<tr>



										<th>Date From</th>



										<th>Date To</th>



										<th>Days</th>



										<th>Leave Type</th>



										<th>Status</th>

										<th>Action</th>



									</tr>



								</thead>



								<tbody>



									@foreach($leaves as $leave)



									<tr>



										<td>{{$leave->date_from}}</td>



										<td>{{$leave->date_to}}</td>



										<td>{{$leave->days}}</td>



										<td>{{$leave->leave_type->leave_type}}</td>



										<td>



											@if($leave->is_approved == -1)



											<span class="label label-danger">Discarded</span>



											@elseif($leave->is_approved == 0)



											<span class="label label-warning">Pending</span>



											@elseif($leave->is_approved == 1)



											<span class="label label-success">Approved</span>



											@endif



										</td>

										<td>@if($leave->is_approved == 1 && $leave->date_from >= date('m/d/Y') )

											<a href="#" data-target="#myModal{{$leave->id}}" class="btn btn-primary" data-toggle="modal" >Retract</a>

											@elseif($leave->is_approved == 2)

											<span class="text-warring">Wait For Admin Action</span>

                                             @endif



										</td>

										<td><!---------------------------Leave modal------------------------------>



 

  <!-- Trigger the modal with a button -->

  



  <!-- Modal -->

  <div class="modal fade" id="myModal{{$leave->id}}" role="dialog">

    <div class="modal-dialog">

    

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header bg-success">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Apply Retact</h4>

        </div>

        <div class="modal-body">

         <div class="panel-body">



						<form class="form-horizontal" method="post" action="{{url('/hrManager/retract/leave/'.$leave->id)}}" enctype="multipart/form-data" id="resignForm{{$leave->id}}">



							<div class="box-body">



								{{csrf_field()}}



								<div class="form-group">



									<label for="reason" class="col-sm-2 control-label">Reason For Restract</label>



									<div class="col-sm-10">



										<select name="reason_retract" id="reason{{$leave->id}}" class="form-control select2" required>



											<option value="">--Select Reason--</option>



											<option value="Work is Completed">Work is Completed</option>



											<option value="You change your mind">You change your mind</option>



											



										</select>



										@if ($errors->has('reason'))



										<span class="label label-danger">{{ $errors->first('reason') }}</span>



										@endif



									</div>



								</div>

								



								<input type="hidden" id="resignation_reason{{$leave->id}}">



								<input type="hidden" id="type{{$leave->id}}" name="type">



								<div class="form-group">



									<label for="message" class="col-sm-2 control-label">Message</label>



									<div class="col-sm-10">



										<textarea name="message_retract" id="message{{$leave->id}}" cols="30" rows="10" class="form-control" required></textarea>



										@if ($errors->has('message'))



										<span class="label label-danger">{{ $errors->first('message') }}</span>



										@endif



									</div>



								</div>

								



							</div>



							<!-- /.box-body -->



							<div class="modal-footer">



											<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">Cancel</button>



											<button type="submit" class="btn btn-info pull-right btn-info-re">Submit</button>



										</div>



										

							<!-- preview Modal -->



						</form>



					</div>

        </div>

        <div class="modal-footer">

         

        </div>

      </div>

      

    </div>

  </div>

  



<!-----------------------leave modal--------------------------------></td>



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