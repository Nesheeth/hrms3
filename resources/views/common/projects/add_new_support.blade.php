@extends('admin.layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
	<div class="page-title">
		<h3>Support Projects</h3>
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
<br>
<form class="form-horizontal" method="post" action="{{route('cm.add_support_project',['role'=> getRole(Auth::user()->role)])}}">  

<div class="form-group"> 
<label for="project_name" class="col-sm-2 control-label">Start Date
</label> 
{{csrf_field()}}
<input type="hidden" name="project_id" value="{{$project->id}}">
<input type="hidden" name="is_new" value="1">   
<div class="col-sm-10"> 
<input type="text" required class="datepicker form-control" id="start_date" name="start_date" placeholder="Start Date..." required>
</div> 
</div> 

<div class="form-group"> 
<label for="project_name" class="col-sm-2 control-label">End Date
</label> 

<div class="col-sm-10"> 
<input type="text" class="datepicker form-control" id="end_date" name="end_date" placeholder="End Date..." required>
</div> 
</div> 

<div class="form-group"> 
<label for="project_name" class="col-sm-2 control-label">Total New Hours
</label> 

<div class="col-sm-10"> 
<input type="text" class="form-control" id="total_hours" name="total_hours" placeholder="Total New Hours..." required>
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

@endsection
