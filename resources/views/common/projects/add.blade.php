@extends('admin.layouts.app')

@section('title','Projects')

@section('content')

<div class="page-inner">

	<div class="page-title">
		<h3>Add Projects</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/projects')}}">Projects</a></li>
				<li class="active">Add Project</li>
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
					<div class="panel-body">
						<form class="form-horizontal" action="{{route('cm.save_project',['role'=>'admin'])}}" method="post">
							<div class="box-body"> 
								{{csrf_field()}}
                                <input type="hidden" name="project_id" value="{{@$project->id}}"> 
								<div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="project_name" placeholder="Project Name" value="{{(@$project->project_name) ? $project->project_name : old('project_name') }}">
										@if ($errors->has('project_name'))
										<span class="label label-danger">{{ $errors->first('project_name') }}</span>
										@endif
									</div>
								</div>

                  <div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Type</label>
									<div class="col-sm-10">
											<select class="form-control" name="project_type">
													<option value="">-- Select Project Type --</option>
													@foreach($types as $ty)
														@if(@$project->project_type==$ty->id || old('project_type')==$ty->id )
															<option value="{{$ty->id}}" selected>{{$ty->name}}</option>
														@else
															<option value="{{$ty->id}}" >{{$ty->name}}</option>
														@endif
													@endforeach
											</select> 
										@if ($errors->has('project_type'))
										<span class="label label-danger">{{ $errors->first('project_type') }}</span>
										@endif
									</div>
								</div>

                  <div class="form-group"> 
									<label for="project_name" class="col-sm-2 control-label">Project Status</label>
									<div class="col-sm-10">
											<select class="form-control" name="project_status">
												<option value="">-- Select Project Status --</option>
												@foreach($status as $st)
													@if(@$project->project_status==$st->id || old('project_status')==$st->id )
													<option value="{{$st->id}}" selected>{{$st->name}}</option>
													@else
													<option value="{{$st->id}}">{{$st->name}}</option>
													@endif
												@endforeach
											</select> 
										@if ($errors->has('project_status'))
										 <span class="label label-danger">{{ $errors->first('project_status') }}</span>
										@endif
									</div>
								</div>

                <div class="form-group">
									<label for="client_name" class="col-sm-2 control-label">Client Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="client_name" placeholder="Client Name" value="{{(@$project->client_name) ? $project->client_name : old('client_name') }}">
										@if ($errors->has('client_name'))
										<span class="label label-danger">{{ $errors->first('client_name') }}</span>
										@endif
									</div>
								</div>
                
								<div class="form-group">
									<label for="client_name" class="col-sm-2 control-label">Client Time Zone</label>
									<div class="col-sm-10">
												<select class="form-control" name="client_time_zone">
													<option value="">-- Select Client Time Zone --</option>
													@foreach($time_zones as $tz)
														@if(@$project->client_time_zone==$tz || old('client_time_zone')==$tz )
															<option value="{{$tz}}" selected>{{$tz}}</option> 
														@else
														<option value="{{$tz}}">{{$tz}}</option>  
														@endif
													@endforeach
												</select> 
										@if ($errors->has('client_time_zone'))
										<span class="label label-danger">{{ $errors->first('client_time_zone') }}</span> 
										@endif
									</div>
								</div>

                <div class="form-group">
									<label for="client_name" class="col-sm-2 control-label">Client Communication</label>
									<div class="col-sm-10">
											<select class="form-control" name="client_communication">
													<option value=""> -- Select Client Communication -- </option>
													@foreach($client_communications as $cm)
														@if(@$project->client_communication==$cm || old('client_communication')==$cm )
															<option value="{{$cm}}" selected>{{ucwords($cm)}}</option> 
														@else   
														<option value="{{$cm}}">{{ucwords($cm)}}</option>  
														@endif
													@endforeach
											</select>
										@if ($errors->has('client_communication'))
										<span class="label label-danger">{{ $errors->first('client_communication') }}</span>
										@endif
									</div>
								</div>

                <div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Google Drive Link</label>
									<div class="col-sm-10">
										<input type="text" value="{{(@$project->project_google_drive_link) ? $project->project_google_drive_link : old('project_google_drive') }}" class="form-control" name="project_google_drive" placeholder=" Project Google Drive Link">
										@if ($errors->has('project_google_drive')) 
										<span class="label label-danger">{{ $errors->first('project_google_drive') }}</span>
										@endif
									</div>
								</div>
                
								<div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Skype Group Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" value="{{(@$project->project_google_drive_link) ? $project->project_google_drive_link : old('project_google_drive') }}" name="project_skype_group" placeholder="Project Skype Group Name">
										@if ($errors->has('project_skype_group'))
										<span class="label label-danger">{{ $errors->first('project_skype_group') }}</span>
										@endif
									</div>
								</div>

                <div class="form-group">
									<label for="project_name" class="col-sm-2 control-label">Project Basecamp Link</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" value="{{(@$project->project_google_drive_link) ? $project->project_google_drive_link : old('project_google_drive') }}" name="basecamp_link" placeholder="Project Basecamp Link">
										@if ($errors->has('basecamp_link'))
										<span class="label label-danger">{{ $errors->first('basecamp_link') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="project_comments" class="col-sm-2 control-label">Project Special Notes</label>
									<div class="col-sm-10">
										<textarea name="project_comments" id="project_comments" cols="30" rows="10" class="form-control" 
										 placeholder="Project Comments">{{(@$project->project_special_notes) ? $project->project_special_notes : old('project_comments') }}</textarea>
										@if ($errors->has('project_comments'))
										  <span class="label label-danger">{{ $errors->first('project_comments') }}</span>
										@endif
									</div>
								</div>

                <div class="form-group">
									<label for="start_date" class="col-sm-2 control-label">Project Start Date </label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" value="{{(@$project->start_date) ? date('Y-m-d',strtotime($project->start_date)) : old('start_date') }}" id="start_date" name="start_date" placeholder="Project Start Date">
										@if ($errors->has('start_date'))
										<span class="label label-danger">{{ $errors->first('start_date') }}</span>
										@endif
									</div>
								</div>

                <div class="form-group">
									<label for="start_date" class="col-sm-2 control-label">Project Internal Delivery Date</label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" id="internal_delivery_date" name="internal_delivery_date" placeholder="Project Internal Delivery Date" value="{{(@$project->project_internal_delivery_date) ? date('Y-m-d',strtotime($project->project_internal_delivery_date)) : old('internal_delivery_date') }}">
										@if ($errors->has('internal_delivery_date'))
										<span class="label label-danger">{{ $errors->first('internal_delivery_date') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label for="end_date" class="col-sm-2 control-label">Project Client Delivery Date</label>
									<div class="col-sm-10">
										<input type="text" class="datepicker form-control" id="client_delivery_date"  name="client_delivery_date" placeholder="Project Client Delivery Date" value="{{(@$project->project_client_delivery_date) ? date('Y-m-d',strtotime($project->project_client_delivery_date)) : old('client_delivery_date') }}">
										@if ($errors->has('client_delivery_date'))
										<span class="label label-danger">{{ $errors->first('client_delivery_date') }}</span>
										@endif
									</div>
								</div>

							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<a href="{{route('cm.project_list',['role'=> getRole(Auth::user()->role)])}}" class="btn btn-default"> Cancel </a> 
								<button type="submit" class="btn btn-success pull-right"><i class="fa fa-unlock-alt"></i> &nbsp; Save</button>
							</div>
							<!-- /.box-footer -->
						</form>
					</div>
				</div>
			</div>
		</div><!-- Row -->
	</div><!-- Main Wrapper -->

    <div class="page-footer">
      <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>

</div> 
@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script type="text/javascript">
	$(document).ready(function(){ 
		   $(document).on('blur','#internal_delivery_date',function(){
            var end   = new Date($(this).val()); 
            var start = new Date($('#start_date').val());
                diff = (end - start)/1000/60/60/24;
                if(diff < 1){
									$(this).val('');
									$(this).focus();  
                }
         });

				 $(document).on('blur','#client_delivery_date',function(){
            var end   = new Date($(this).val()); 
            var start  = ($('#internal_delivery_date').val()!='') ? $('#internal_delivery_date').val() : $('#start_date').val();
            console.log(start);
            start = new Date(start); 
                diff = (end - start)/1000/60/60/24;
                console.log(diff);
                if(diff < 0){
									$(this).val('');
									$(this).focus(); 
                }
         });

	});
</script>
@endsection
@endsection