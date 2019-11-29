@extends('admin.layouts.app')

@section('content')

@section('title','Projects')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
	<div class="page-title">
		<h3>Project List</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li class="active">Projects List</a></li> 
			</ol>
		</div>
	</div>

	<div id="main-wrapper">

		<div class="row">
			<div class="col-md-12">
				@if(session('success'))
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('success') }}
				</div>
				@endif

				@if(session('error'))
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('error') }}
				</div>
				@endif
				<div class="panel panel-white">
					{{--<div class="panel-heading clearfix">
						<h4 class="panel-title">Project List</h4>
					</div>--}}
					<div class="panel-body">
					<div class="row">
                <div class="col-sm-9">
									<div class="form-group">
										<label for="project_name" class="col-sm-2 control-label"> Filter Project : </label>
										<div class="col-sm-3">
										<select class="form-control" id="sort_by"> 
												<option value=""> -- Filter By Project Type -- </option>
											@foreach($types as $p)
												<option value="{{ $p->id }}" {{$p_type==$p->id ? 'selected' : ''}} > {{$p->name}} </option> 
											@endforeach
										</select>
										</div>
									</div>
								</div>
								<div class="col-sm-3 ">
								<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#view_history"> View Project History</button>  
								</div>
					</div>
					<br>
						<div class="table-responsive table-remove-padding">
							<table class="table  table-hover table-condensed" id="projects">
								<thead>
									<tr>
										<th>Project ID</th>
										<th>Project Name</th>
										<th>Type</th>
										<th>Status</th>
										<th>Client Name</th>
										<th>Start Date</th>
										<th>Action</th> 
									</tr>
								</thead>
								<tbody>
                                   @foreach($projects as $project)
								   <tr>
								     <td> <a href="{{route('cm.edit_project',['role'=>getRoleStr(),'id'=> $project->id])}}" > {{$project->project_id}} </a></td>
								     <td> {{$project->project_name}}</td>
								     <td> {{$project->type->name}}</td>
								     <td> {{$project->status->name}}</td>
								     <td> {{$project->client_name}}</td>
								     <td> {{date('d M Y', strtotime($project->start_date))}}</td>
									 <td>
									    <a href="{{($project->type->id == '4') ? 'javascript:void(0)' :route('cm.project_info',['role'=>getRole(Auth::user()->role),'id'=> $project->id])}}" class="btn btn-info {{($project->type->id == '4') ? 'clickoff':''}}" {{($project->type->id == '4') ? 'Disabled':''}}><i class="fa fa-eye " ></i> View</a>
									    <button rel="{{$project->id}}" class="btn btn-primary team"><i class="fa fa-users" aria-hidden="true"></i> Team </button>
									    <button rel="{{$project->id}}" class="btn btn-success reminder" {{($project->type->id == '4') ? 'Disabled':''}}><i class="fa fa-users" aria-hidden="true" ></i> Add Reminder </button>
									  </td>
								   </tr>
								   @endforeach
								</tbody>
							</table>
						</div>
						{{--<div class="row ">
						  <div class="col-sm-6"> Showing {{$projects->firstItem()}} to {{$projects->lastItem()}} of {{$projects->total()}} entries </div>
						  <div class="col-sm-6 pull-right"> {{ $projects->links() }}</div>
						</div>--}}
						
					</div>
				</div>
			</div>
		</div><!-- Row -->
	</div><!-- Main Wrapper -->

	<!-- Modal -->
  <div class="modal fade" id="view_history" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Project History </h4>
        </div>
        <div class="modal-body">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="project_name" class="col-sm-2 control-label">Project</label>
						<div class="col-sm-10">
							<select class="form-control select2" id="project"> 
									<option value=""> -- Select Project -- </option>
									@foreach($projects as $project) 
											<option value="{{$project->id}}" >{{$project->project_name}} </option>
									@endforeach
							</select>
						</div>
					</div>
			</div>
        </div>
				<br>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	<br><br>
	<div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>

</div><!-- Page Inner -->

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script src="https://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script> 
	$(document).ready(function(){
		 $('#projects').dataTable({
		    "order": [[ 1, "asc" ]],
		    columnDefs: [{ orderable: false, targets: [6] }]
		 });  
	}); 

 $(document).on('change','#sort_by',function(){
	 window.location.href = "{{route('cm.project_list',['tole'=>getRole(Auth::user()->role)])}}"+"?&project_type="+ $(this).val();
 });

 $(document).on('change','#project',function(){
			$('#view_history').modal('hide'); 
			var project_id = $(this).val();  
		  	BootstrapDialog.show({
					  size:BootstrapDialog.SIZE_WIDE,
            title:"Project History",
            message:$('<div> Please wait loading page...</div>').load('{{route("cm.project_history",["role"=>getRole(Auth::user()->role)])}}/'+project_id),
            buttons:[{ 
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){ 
                    dialog.close();
                }
            }]
        });
 });

 $(document).on('click','.team',function(){
	 var project_id = $(this).attr('rel');
	   BootstrapDialog.show({
			size:BootstrapDialog.SIZE_WIDE,
            title:"Project Team",
            message: $('<div>Please wait loading page...</div>').load('{{route("cm.view_project_team",["role"=>getRole(Auth::user()->role)])}}/'+project_id),
            buttons:[{
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){
                    dialog.close();
                }
            }]
        });
 });

 $(document).on('click','.reminder',function(){
	 var project_id = $(this).attr('rel');
	   BootstrapDialog.show({
			size:BootstrapDialog.SIZE_WIDE,
            title:"Add Reminder",
            message: $('<div>Please wait loading page...</div>').load('{{route("cm.add_reminder",["role"=> getRoleStr()])}}?project_id='+project_id),
            //data:{'project_id':project_id}, 
            buttons:[{
                label:"Save",
                cssClass:"btn btn-success save_form",
                action: function(dialog){
                    var type = $('#reminder_type').val();
						  	if(type!=''){
						       if(type==1){

						          if($('#reminder_date').val()==''){
						          	 $("#rem_error").html('Please select Reminder Date');
						          	 $('#reminder_date').focus();
						          	 return false;
						          }

						       }else if(type==2){
						       	   if($('#reminder_time').val()==''){
						          	    $("#rem_error").html('Please select Reminder Type');
						          	    $('#reminder_time').focus();
						          	 return false;
						            }

						       }else if(type==3){
						             if($('#reminder_day').val()==''){
						          	    $("#rem_error").html('Please select Reminder Type');
						          	    $('#reminder_day').focus();
						          	 return false;
						            }
						       }else{
						       	 return true; 
						       }
						  	}else{
						  		$("#rem_error").html('Please select Reminder Type');
						  		return false;
						  	}
				    var notes = $('#reminder_notes').val();
				    if(notes==''){
				    	 $("#rem_error").html('Please Enter Reminder Notes');
						  return false;
				    }else{
				    	  //var formData = new FormData($("#reminder_form").serializeArray())
				    	$('.save_form').attr('disabled','true'); 
				    	var formData = $("#reminder_form").serializeArray();
				    	$.ajax({
				    		url:"{{ route('cm.add_reminder',[ 'role' => getRoleStr()]) }}",
				    		type:"POST",
				    		data:formData,
				    		success:function (res){
   								if(res.status){ 
   									dialog.close();
   									swal('Success',"Meeting Reminder add successfully. ",'success');
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

 $(document).on('click','.edit_assign',function(){
        var id = $(this).attr('rel');
        BootstrapDialog.show({
            title:"Edit Project Assign",
            message: $('<div> Please wait loading page ...</div>').load('{{ route("cm.assign_update_page", ["role"=> getRole(Auth::user()->role)]) }}'),
            buttons:[{
                label:"Save",
                cssClass:"btn btn-success",
                action: function(dialog){
						formData = {'_token':"{{csrf_token()}}", id:id, role: $('#role').val(), note: $('#note').val(), status: $('#assign_status').val() };
						console.log(formData);
						$.ajax({ 
							url:"{{route('cm.assign_update_page',['role'=> getRole(Auth::user()->role)])}}",
							type:"POST",
							data:formData,
							success:function(res){
                                if(res.status==true){
									dialog.close();
									  window.location.reload();
								 }
							}
						}); 
               }},{
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){
                    dialog.close();
                }
            }]
        });
 });


</script>
@endsection

@endsection