@extends('admin.layouts.app')



@section('content')



@section('title','Leaves')







<div class="page-inner">



	<div class="page-title">



		<h3>Leave</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>



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



					<div class="panel-heading clearfix">



						<h4 class="panel-title">Leave</h4>



					</div>



					<div class="panel-body">



						<div class="table-responsive table-remove-padding">



							<table class="table" id="datatable">



								<thead>



									<tr>



										<th>#</th>



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



										<td>{{$leave->id}}</td>

										



										<td><a href="{{URL('/admin/employee/profile/'.$leave->user_id)}}">{{getUserById($leave->user_id)->first_name}}</a></td>



										<td>{{$leave->date_from}}</td>



										<td>{{$leave->date_to}}</td>



										<td>{{$leave->days}}</td>



										<td>{{$leave->leave_type->leave_type}}</td>

										 <td>{{$leave->reason}}</td>



										<td>



											@if($leave->is_approved == -1)



											<b class="text-danger">Not Approved</b>



											@elseif($leave->is_approved == 0)



											<b class="text-warning">Pending</b>



											@elseif($leave->is_approved == 1)



											<b class="text-primary">Approved</b>



											@endif



										</td>



										<td>



											@if($leave->is_approved == 1 || $leave->is_approved == -1)



											<!-- <a href="{{URL('/admin/leave/delete/'.$leave->id)}}" class="btn btn-danger">Delete</a> -->



											@else



											<a class="btn btn-info " data-toggle="modal" data-target="#reason{{$leave->id}}" href="javsacript:void(0);" onclick="openreason({{$leave->id}})" >Not Approve</a>



											<a href="{{URL('/admin/leave/approve/'.$leave->id)}}"  class="btn btn-primary">Approve</a>



											<!-- <a href="{{URL('/admin/leave/delete/'.$leave->id)}}" class="btn btn-danger">Delete</a> -->



											@endif



											



										</td>

										<td>

										 <!-- Modal -->

	 <div class="modal fade" id="reason{{$leave->id}}" role="dialog">

    <div class="modal-dialog">

    

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Reason of Not Approve</h4>

        </div>

        <div class="modal-body">

        	

        	

          <form action="{{URL('/admin/leave/discard/'.$leave->id)}}" method="post">

          	{{ csrf_field() }}

		 <textarea rows="4" name="not_approve_reason" cols="50" placeholder="Enter the reason..." required></textarea>

		 <div class="modal-footer">

		 	

		<button class="btn btn-primary"> Submit</button>

		<!--  <input type="button" class="cancelnotapprove btn btn-default" value="Cancel"> -->

		</div>

		</form>

		 

      

        </div>

        

      </div>

      

    </div>

  </div></td>



									</tr>

                                    

	</div><!-- Main Wrapper -->

	

  

   

									@endforeach



								</tbody>



							</table>



						</div>



					</div>



				</div>



			</div>



		</div><!-- Row -->



	 {{$leaves->links()}}



	<div class="page-footer">



		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>



	</div>



</div><!-- Page Inner -->



@section('script')

<script>

	// function openreason(id)

	// {

	//    $.ajaxSetup({

 //        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}

 //      });

	// 	 var url  = "{{URL('/admin/leave/discard')}}";

 //      $.ajax({

 //        url: url+'/'+id,

 //        type: 'post',

 //        success: function (data) {

 //          console.log(data);

 //        //  location.reload();

 //         }

 //      });

	

	// }

	// $('.cancelnotapprove').click(function(){

 //       $('#reasonofnotapprove').css('display','none');

	// });

	function openreason1(id)

	{

	   $.ajaxSetup({

        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}

      });

		 var url  = "{{URL('/admin/leave/discard')}}";

      $.ajax({

        url: url+'/'+id,

        type: 'post',

        success: function (data) {

          console.log(data);

        //  location.reload();

         }

      });

	

	}



</script>



@endsection



@endsection