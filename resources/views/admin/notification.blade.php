@extends('admin.layouts.app')

@section('content')

@section('title','Employees')

<style>

.table td, .table>tbody>tr>td

{

	

	vertical-align:  middle;

}
span.pad {
    padding-left: 5px;
}
</style>



<div class="page-inner">

	<div class="page-title">

		<h3>Employees</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

				<li class="active"><a href="#">Employees</a></li>

			</ol>

		</div>

	</div>

	<div id="main-wrapper">

		<div class="row">

			<div class="col-md-12">
			
				<div class="panel panel-white">

					<div class="panel-heading clearfix">

						<h4 class="panel-title">View Notification</h4>

					</div>
					<div class="panel-body">

						<div class="col-sm-12 col-xl-6">
							<div class="card">
								
								<div class="card-body">
									<div class="list-group" id="notify_me_all">
									@foreach($all_notifications as $notification)
										<a onclick="viewNotification({{$notification->id}})" class="list-group-item list-group-item-action flex-column align-items-start {{ $notification->is_read=='1' ? '' : 'active' }}" href="#">
										<div class="d-flex w-100 justify-content-between">
										<small class="pull-right">{{calculateTimeSpan($notification->created_at)}}</small>
										<h5 class="mb-1">{{$notification->title}}</h5>
										
										</div>
										@php 
                                          $text = strip_tags($notification->message); 
									   @endphp
										<p class="mb-1">{{ substr($text, 0, strlen($text)-4)   }}</p>
										</a>
									@endforeach
								    {{ $all_notifications->links() }}
								</div>
								</div>	
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

@section('script')

@endsection

@endsection