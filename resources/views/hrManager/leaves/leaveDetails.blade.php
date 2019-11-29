@extends('hrManager.layouts.app')
@section('style')
{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}
{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}
@endsection
@section('content')
@section('title','Leave Details')
<div class="page-inner">
	<div class="page-title">
		<h3>Leave Details</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>
				<li class="active"><a href="{{URL('/hrManager/leave-details')}}">Leave Details</a></li>
			</ol>
		</div>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">				

				<div class="panel panel-white">
					<div class="panel-heading clearfix">
						<h4 class="panel-title" id="msg"></h4>	
					</div>
					<div class="panel-body">
						<table id="example"  class="display table cell-border" cellspacing="0" width="100%" >
							<thead>
								<tr>
									<th style="border: 1px solid #ddd;">EmpId</th>
									<th style="border: 1px solid #ddd;">EmpName</th>
									<th style="border: 1px solid #ddd;">Available Leave(days)</th>
									<th style="border: 1px solid #ddd;">Rejected Application</th>
									<th style="border: 1px solid #ddd;">Pending Application</th>
									<th style="border: 1px solid #ddd;">Approved Application</th>
									<th style="border: 1px solid #ddd;">Leave Taken(days)</th>
									<th style="border: 1px solid #ddd;">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($employees as $employee)
								<tr>
									<td>{{$employee->employee_id}}</td>
									<td style="white-space:nowrap;">{{$employee->first_name}} {{$employee->last_name}}</td>
									<td> {{$employee->avail_leaves}} </td>
									<td>{{count(getLeaves($employee->user_id,-1))}}</td>
									<td>{{count(getLeaves($employee->user_id,0))}}</td>
									<td>{{count(getLeaves($employee->user_id,1))}}</td>
									<td>{{$employee->leaves_taken}}</td>
									<td><a class="btn btn-primary leaveDetails" onclick="leaveDetails(this)" href="#">View</a></td>
								</tr>                                          
								@endforeach
							</tbody>
						</table> 
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>

</div>
<div class="modal fade empList-modal-lg" id="leaveDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-body">
			<div class="panel panel-white">
				<div class="panel-heading clearfix">
					<h4 class="panel-title" id="msgleaveDetails"></h4>	

				</div>
				<div class="panel-body" id="myleaveDetails">



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section('script')
{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}
<script type="text/javascript">
	$('#example').DataTable();
	function leaveDetails(link){						
		$('#leaveDetailsModal').modal('show');
		var msg = `Leave Details Of Employee Id : `+ $(link).parent().parent().find('td:nth-child(1)').html()+` Name : `+ $(link).parent().parent().find('td:nth-child(2)').html();
		var myleaveDetails = `<table class="display table cell-border">
		<tr>
		<td>Available Leave(days)</td>
		<td>`+ $(link).parent().parent().find('td:nth-child(3)').html()+`</td>
		</tr>
		<tr>
		<td>Rejected Application</td>
		<td>`+ $(link).parent().parent().find('td:nth-child(4)').html()+`</td>
		</tr>
		<tr>
		<td>Pending Application</td>
		<td>`+ $(link).parent().parent().find('td:nth-child(5)').html()+`</td>
		</tr>
		<tr>
		<td>Approved Application</td>
		<td>`+ $(link).parent().parent().find('td:nth-child(6)').html()+`</td>
		</tr>
		<tr>
		<td>Leave Taken(days)</td>
		<td>`+ $(link).parent().parent().find('td:nth-child(7)').html()+`</td>
		</tr>
		</table>`;
		$('#msgleaveDetails').html(msg);
		$('#myleaveDetails').html(myleaveDetails);
	}
</script>
@endsection