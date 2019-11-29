@extends('admin.layouts.app')

@section('style')


{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

<style>
	
p {
  text-align: center;
  font-size: 15px;
  margin-top: 0px;
}

</style>

@endsection

@section('content')

@section('title','Knowledge Transfer')
<div class="page-inner"> 
	<div class="page-title">
		<h3>Knowledge Transfer</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL(getRoleStr().'/dashboard')}}">Home</a></li>

				<li class="active">Knowledge Transfer</a></li>

			</ol>

		</div>

	</div>

	<div id="main-wrapper">


		<div class="panel panel-white">
				
					    
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
			</div>
		</div>

		<table class="table table-responsive  table-striped  table-hover" >
			<thead>
				<tr><td colspan="2"><b>{{$user->first_name}} {{$user->last_name}}</b></td><td colspan="2"><b>KT Status: {{$kt_percent}}% Completed</b></td><td><b>Timer:</b></td><td><b><p id="demo"></p></b></td><td colspan="3"><b>Last Working Day: {{$resign->last_working_day}}</b></td></tr>
			</thead>
			<tbody>
		
				<tr>
					<th>S.No</th>
					<th>Projects</th>
					<th>Employee</th>
					@if(Auth::user()->role == '1' || Auth::user()->role == '2')
					<th></th>
					@else
					<th>Assign</th>
					@endif
					<th>Employee Remark</th>
					<th>{{$user->first_name}} {{$user->last_name}} Remark</th>
					<th>Status</th>
				</tr>

													
	
	
               
      			@foreach($current_projects as $current_project)
				<tr>

				<form method="POST" action="{{URL('kt-transfer/'.$user->id )}}">
					{{csrf_field()}}
					
				
					<input type="hidden" id="myAnchor" value="{{$resign->last_working_day}}" data-rel="{{$resign->last_working_day}}">

				
					
				<td>{{$loop->iteration}}.</td>


					
						<td ><input type="hidden" name="ktproject" value="{{$current_project->project_id}}"/>{{getProject($current_project->project_id)->project_name}}</td>
				
					
				


					
					

					<td id="ktemp">

						@if(Auth::user()->role == '1' || Auth::user()->role == '2')
						<input type="hidden" name="konwledge_transfer_to"  class="form-control select2 konwledge_transfer_to" required="required" value="{{$current_project->kt_given_to}}" >
						{{$current_project->kt_given_to_name}}
						@else
						<select name="konwledge_transfer_to"  class="form-control select2 konwledge_transfer_to" required="required" >

											@if(count($employees) > 0)

											<option value="">--Select Employee--</option>

											@foreach($employees as $employee)

											@if($kt)
												
												@if($current_project->user_id!=null)
													@if($current_project->user_id != $employee->id)
														<option value="{{$employee->id}}" {{($current_project->kt_given_to == $employee->id)? 'selected': '$employee->id'}}>{{$employee->first_name}} {{$employee->last_name}} </option>

													@endif
												@else
													@if($current_project->employee_id != $employee->id)
														<option value="{{$employee->id}}" {{($current_project->kt_given_to == $employee->id)? 'selected': '$employee->id'}}>{{$employee->first_name}} {{$employee->last_name}} </option>

													@endif
												@endif

											<!-- <option value="{{$employee->id}}" >{{$employee->first_name}} {{$employee->last_name}} </option> -->

											@else
											
												@if($current_project->employee_id != $employee->id)
													<option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
												@endif
											
											@endif

											@endforeach

											@else



											<option value="0" selected="selected">None</option>

											@endif

						</select> 
					@endif
					</td>
					@if(Auth::user()->role == '1' || Auth::user()->role == '2')
					<td></td>
					@else
					<td><input type="submit" class="btn btn-info btn-sm " id="assign"  value="Assign"></td>
					@endif
					@if($kt)
							
							<td><textarea rows="1" col="2" name="remark1" value="{{$current_project->emp_remark}}" disabled >{{$current_project->emp_remark}}</textarea></td>
						
							<td><textarea rows="1" col="2" name="remark2" value="{{$current_project->emp_remark}}" disabled>{{$current_project->res_emp_remark}}</textarea></td>
					@else
							
					<td><textarea rows="1" col="2" name="remark1" disabled></textarea></td>
					<td><textarea rows="1" col="2" name="remark2" disabled></textarea></td>
					@endif
					<td>
					<select name="status" disabled>
						<option value="0">-Select-</option>
						
							<option value="1" {{($current_project->status == '1')? 'selected': ''}} >Started</option>
							<option value="2" {{($current_project->status == '2')? 'selected': ''}} >Completed</option>
							<option value="3" {{($current_project->status == '3')? 'selected': ''}} >In Progress</option>
						
					</select>
				</td>
			</form>
				</tr>
			

@endforeach
		
		
       <!-- <input class="btn btn-success pull-right" type="submit"/> -->

	</tbody>

</table>
					    
			
		</div>	
		<div class="page-footer">

		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>

		</div>				
	</div>

</div>



@endsection

@section('script')

<script>

var x = document.getElementById("myAnchor").getAttribute("data-rel");
// Set the date we're counting down to
var countDownDate = new Date(x).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

@endsection