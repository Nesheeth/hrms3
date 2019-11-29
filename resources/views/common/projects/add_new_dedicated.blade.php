@extends('admin.layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
	<div class="page-title">
		<h3>Dedicated Project</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/projects')}}">Projects</a></li>
				<li class="active">Project Details</li>
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
                        <div class="row">
                             <div class="col-md-12">
                              <div class="col-sm-3"> <h4>Project Name : {{$project->project_name}}</h4></div>
                              <div class="col-sm-3"> <h4>Project Start Date : {{date('d M, Y' ,strtotime($project->start_date))}}</h4></div>
                              <div class="col-sm-3"> <h4>Project Status : {{$project->status->name}}</h4></div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                           <div class="col-sm-12">
                              <div class="col-sm-3"> <h3> Used Number of Resources : </h3> </div>
                              <div class="col-sm-3"> <h2> {{@$dedicated->no_of_resources}} </h2> </div>
                              <div class="col-sm-3"> <h3> Closing Reason : </h3> </div>
                              <div class="col-sm-3">  {{@$dedicated->reason_for_closing}}   </div>
                           </div>
                           <div class="col-sm-12">
                             <button id="edit_option" class="btn btn-info pull-right"><i class="fa fa-edit"></i> Edit</button>
                           </div>
                        </div>
                        <!-- ================================================================ -->
                         <br>
                        <div class="row" id="edit_page" style="display: none;"> 
                        <form class="form-horizontal" method="post" action="{{route('cm.save_dedicated_project',['role'=> getRole(Auth::user()->role)])}}">  
                            {{csrf_field()}}
                        <input type="hidden" name="project_id" value="{{$project->id}}"> 

                        <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label"> Number of Resources </label> 
                        <div class="col-sm-10"> 
                          <input type="text" required class="form-control" value="{{(@$dedicated->no_of_resources) ? $dedicated->no_of_resources : old('no_of_resources')}}" name="no_of_resources" placeholder="Number of Resources..." required>
                          @if ($errors->has('no_of_resources'))
                            <span class="label label-danger">{{ $errors->first('no_of_resources') }}</span>
                          @endif
                        </div> 
                        </div> 

                        <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label"> Reason for closing </label> 
                        <div class="col-sm-10"> 
                          <textarea class="form-control" name="reason_for_closing" placeholder="Reason for closing...">{{(@$dedicated->reason_for_closing) ? $dedicated->reason_for_closing : old('reason_for_closing')}}</textarea>
                          @if ($errors->has('reason_for_closing')) 
                            <span class="label label-danger">{{ $errors->first('reason_for_closing') }}</span>
                          @endif
                        </div> 
                        </div> 

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-unlock-alt"></i> &nbsp; Save</button>
                        </div>
                        </form>
                        </div>
					</div>
				</div>
			</div>
		</div><!-- Row -->
	</div><!-- Main Wrapper -->

    <div class="page-footer">
      <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>

</div> 
@endsection 
@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script>
 $(document).on('click','#edit_option',function(){
     $(this).hide();
     $('#edit_page').show(); 
 });
</script>
@endsection
