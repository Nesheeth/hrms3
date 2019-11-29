@extends('admin.layouts.app')
@section('title','My  Projects')

@section('content')

<div class="page-inner">
	<div class="page-title">
		<h3>My  Projects</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{ URL(getRoleStr().'/dashboard') }}">Home</a></li>
				<li class="active">My Projects</li>
			</ol>
		</div>
	</div>
    <div id="main-wrapper">
      <div class="row table-responsive">
      	  <table class="table table-bordered" id="projects">
      	  	<thead>
      	  		<tr>
      	  			<th>#</th>
      	  			<th>Project Name</th>
      	  			<th>Start Date</th>
      	  			<th>Role</th>
      	  			<th>Assign Percentage %</th> 
      	  			
      	  		</tr>
      	  	</thead>
      	  	<tbody>
      	  		@forelse ($projects as $project)
				    <tr>
      	  			   <td>{{ $loop->iteration }}</td>
      	  			   <td>{{ $project->project->project_name }}</td>
      	  			   <td>{{ date('d M Y', strtotime($project->start_date)) }}</td>
      	  			   <td>{{ $project->role->name }}</td>
      	  			   <td>{{ $project->assign_percentage }}</td>
      	  			   
      	  		    </tr>
				@empty
				   <tr>
      	  			   <td colspan="5">No project assign. please contact to team lead.</td>
      	  		    </tr>
				@endforelse
      	  		
      	  	</tbody>
      	  </table>
      </div>

    </div>

    <div class="page-footer">
      <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>

</div>

@endsection 
@section('script')
<script>
 // $(document).ready(function(){
	// 	 $('#projects').dataTable({
	// 	    "order": [[ 1, "asc" ]],
	// 	    //columnDefs: [{ orderable: false, targets: [6] }]
	// 	 });  
	// });
</script>
@endsection