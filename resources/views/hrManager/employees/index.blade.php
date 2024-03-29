@extends('hrManager.layouts.app')



@section('style')



{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}



{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}



@endsection



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



				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>



				<li class="active"><a href="{{URL('/hrManager/employees')}}">Employees</a></li>



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



						<h4 class="panel-title">Employees</h4>



					</div>







					<a href="{{URL('/hrManager/export/employee-sheet')}}" class="btn btn-danger pull-right" style="margin-top: -16px;margin-right: 10px;">Export Employees</a>



					<button type="submit" data-toggle="modal" data-target="#importEmployeeModal" class="btn btn-primary pull-right" style="margin-top: -16px;margin-right: 10px;">Import Employees</button>



					<a href="{{URL('/templates/Employees.xls')}}" class="btn btn-warning pull-right" style="margin-top: -16px;margin-right: 10px;">Employee Template</a>





                     <div class="panel">

			<form action="{{url('/hrManager/employees')}}" method="get">
							{{ csrf_field() }}
							    <span class="">Filter By Department:-</span>
		                    	<select name="filter_dep" id="filter_dep">
		                    	<option value="0">--select--</option>
								<option value="development">Development</option>
								 <option value="sales">Sales</option>
								</select>
								<span class="pad">Filter By Role:-</span>
		                    	<select name="filter_dep1" id="filter_role">
			                    	<option value="0">--select--</option>
									<option value="2">HrManager</option>
									 <option value="4">Team Lead</option>
								     <option value="5">It Executive</option>
									 <option value="6">Employee</option>
								</select>
								<span>Filter By Status:-</span>
								<select name="filter_status" id="filter_status">

			                    	<option value="0">--select--</option>
									<option value="1" {{(app('request')->input('type')== 'active')? 'selected' : ' '  }}>Active</option>
									 <option value="2" >Resigned</option>
								     <option value="3">Absconding</option>
									
								</select>
								<!-- <input type="submit" id="fil" value="Search" class="btn btn-sm btn-default"> -->
								<button id="fil" class="btn btn-sm btn-primary" type="submit"><span class="icon-magnifier"></span></button>
		                    </form>

					</div>

					<div class="panel-body">



						<div class="table-responsive table-remove-padding">



							<table class="table" id="datatable">



								<thead>



									<tr>



										<th>#</th>



										<th>Photo</th>



										<th>Employee ID</th>



										<th>Name</th>



										<th>Email</th>



										<th>Role</th>

										<th>Department</th>

										<th>Status</th>

										<th>Action</th>



									</tr>



								</thead>



								<tbody>



									@foreach($employees as $employee)



									<tr>



										<td>{{$employee->id}}</td>



										<td><img src="{{is_null($employee->cb_profile->employee_pic) ? 'assets/images/profile-picture.png':$employee->cb_profile->employee_pic}}" alt="" height="50" width="50" class="img-circle"></td>



										<td><b>{{$employee->cb_profile->employee_id}}</b></td>



										<td>{{$employee->first_name}} {{$employee->last_name}}</td>



										<td>{{$employee->email}}</td>



										<td>{{getRoleById($employee->role)}}</td>

										<td>{{$employee->department}}</td>
										@if($employee->is_active != null)
											<td>{{getEmpStatusById($employee->is_active)}}</td>
										@else
											<td>{{$employee->is_active}}</td>
										@endif
										<td>

											<a class="btn btn-primary" href="{{URL('hrManager/employee/profile/'.$employee->id)}}">View</a>



											<a class="btn btn-primary" href="{{URL('hrManager/employee/'.$employee->id)}}">Edit</a></td>



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







	<!-- Modal -->



	<div class="modal fade" id="importEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">



		<div class="modal-dialog">



			<div class="modal-body">



				<div class="panel panel-white">



					<div class="panel-heading clearfix">



						<h4 class="panel-title" id="msg">Upload Employees Excel Sheet</h4>	







					</div>



					<div class="panel-body">



						<form class="form-horizontal" >



							{{csrf_field()}}



							<div class="form-group">



								<label for="employeeFile" class="col-sm-2 control-label">File</label>



								<div class="col-sm-10">



									<input type="file" class="form-control" id="employeeFile" name="employeeFile">	



								</div>



							</div>



						</form>



					</div>



					<div class="modal-footer">



						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>



						<a  id="uploadEmployee"  class="btn btn-success">Update</a>



					</div>



				</div>



			</div>







		</div>



	</div>











	<div class="page-footer">



		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>



	</div>



</div><!-- Page Inner -->



@section('script')



{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}



<script>



	$( "#datatable" ).DataTable({



		"order": [[ 0, "desc" ]]



	});



</script>
<script>
		$(document).ready(function(){

			

		});
</script>
<script>



	$(document).ready(function() {



		$('#uploadEmployee').on('click',function(){



			var employeeFile = document.querySelector('#employeeFile');



			if(employeeFile.files[0]) {



				var file_data = $('#employeeFile').prop('files')[0];



				var form_data = new FormData();



				form_data.append('employeeFile', file_data);



				$.ajaxSetup({



					headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}



				});



				var url  = "{{URL('/hrManager/import/employee-sheet')}}";



				$.ajax({



					url: url,



					type: 'POST',



					data: form_data,



					success: function (data) {

                      console.log(data);

						if(data.flag){



							$('#importEmployeeModal').modal('toggle');



							swal('Success','File Upload Successfully','success');	



							setTimeout(function(){



								window.location.reload();



							}, 2000);



						}else{



							$('#importEmployeeModal').modal('toggle');



							swal('Oops',data.error,'warning');	



						}



					},



					contentType: false,



					cache: false,



					processData: false



				});



			}



		});



	});



</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#fil').click(function(){
			var dept = $('#filter_dep').val();
			var role = $('#filter_role').val();
			var status = $('#filter_status').val();

			console.log(dept);
			console.log(role);
			console.log(status);

			if((dept == 0 && role == 0 && status == 0) || (dept != 0 && role == 0 && status == 0) || (dept == 0 && role != 0 && status == 0) || (dept == 0 && role == 0 && status != 0) || (dept != 0 && role != 0 && status == 0) || (dept != 0 && role == 0 && status != 0) || (dept == 0 && role != 0 && status != 0) )
			{
				swal('warning','Please Select Department & Role & Status First','warning');
				return false;
			}

		});
		
	});
</script>


@endsection



@endsection