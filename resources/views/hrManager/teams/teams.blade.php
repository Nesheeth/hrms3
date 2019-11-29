@extends('hrManager.layouts.app')

@section('style')

{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}

{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}

@endsection

@section('content')

@section('title','Teams')



<div class="page-inner">

	<div class="page-title">

		<h3>Teams</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>

				<li class="active"><a href="{{URL('/hrManager/teams')}}">Teams</a></li>

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

					</div>

					<div class="panel-body">

						<div class="table-responsive table-remove-padding">

							<table class="table" id="datatable">

								<thead>

									<tr>

										<th>Employee ID</th>

										<th>Image</th>

										<th>Team Leader</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

									@foreach($team_leaders as $team_leader)

									<tr>

										<td>{{$team_leader->cb_profile->employee_id}}</td>

										<td><img src="{{$team_leader->cb_profile->employee_pic}}" alt="" height="50" width="50"></td>

										<td><a href="{{url('/hrManager/employee/profile/'.$team_leader->id)}}">{{getUserById($team_leader->id)->first_name}} {{getUserById($team_leader->id)->last_name}}</a></td>

										<td><a href="javascript::void()" class="btn btn-primary" onclick="view({{$team_leader->id}})"><i class="fa fa-users"></i> View Team Members({{calculateteammem($team_leader->cb_profile->user_id)}})</a></td>

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



	<div class="modal fade in" id="teamMembersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

					<h4 class="modal-title" id="myModalLabel">Team Members</h4>

				</div>

				<div class="modal-body">

					<table class="table" id="datatable" >

						<thead>

							<tr>

								<th>Employee ID</th>

								<th>Image</th>

								<th>Team Member</th>

								<th>Designation</th>

								<th>Action</th>

							</tr>

						</thead>

						<tbody id="teamMembers">



						</tbody>

					</table>

				</div>

				<div class="modal-footer">

					<button type="button" id="can" class="btn btn-default" data-dismiss="modal"">Cancel</button>

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

{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}

<script>

	$( "#datatable" ).DataTable({

		"order": [[ 0, "desc" ]]

	});

</script>

<script>



	function remove(id){

		var teamMemberUrl = "{{URL('/hrManager/remove/team-member/')}}";

		$.get(teamMemberUrl+'/'+id, function(data) {

			if(data.flag){

				$('#member_'+id).remove();

                
			//	swal('Success','Team Member removed Successfully','success');
				
                
			}else{

				swal('Oops','Something Went Wrong','error');

			}

		});

	}



	function view(id){

		var member_name = '';

		var teamMemberUrl = "{{URL('/hrManager/team-members/')}}";

		$.get(teamMemberUrl+'/'+id, function(data) {

			if(data.flag){

				$('#teamMembers').empty();

				$.each(data.team_members, function(index, team_member) {

					var userUrl = "{{URL('/getUser/')}}";

					$.get(userUrl+'/'+team_member.team_member_id, function(user_data) {

						

						if(user_data.flag){

							member_name = user_data.user.first_name+' '+user_data.user.last_name;

						}

						var html = `<tr id="member_`+user_data.user.id+`"><td>`+user_data.user.cb_profile.employee_id+`</td><td><img src="`+user_data.user.cb_profile.employee_pic+`" height="50" weight="50"></td><td><a href="/hrManager/employee/profile/`+user_data.user.id+`">`+member_name+`</a></td><td>`+user_data.user.cb_profile.designation+`</td><td><a href="javascript::void()" class="btn btn-primary" onclick="remove(`+user_data.user.id+`)"><i class="fa fa-times"></i>Remove</a></td></tr>`;

						$('#teamMembers').append(html);

					});

					

				});

				$('#teamMembersModal').modal('toggle');

			}else{

				swal('Oops','No Team Members Found','error')

			}

		});

		

	}

	$('#teamMembersModal,#can,.close').click(function(){
        location.reload();
	});

</script>

@endsection

@endsection