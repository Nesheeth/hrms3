@extends('admin.layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
	<div class="page-title">
		<h3>Fixed Projects</h3>
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
                              <div class="col-sm-3">   </h4></div>
                             </div>
                             <div class="col-md-12"> 
                             <div class="col-sm-2 col-sm-offset-8"><button class="btn btn-info update_project pull-right"><i class="fa fa-edit"></i> Update Milestone</button></div>
                               @if($milestones_count<6)
                                  <div class="col-sm-2">
                                    <a href="{{route('cm.add_fixed_project',['role'=> getRole(Auth::user()->role), 'project'=> $project->id])}}"   class="btn btn-success pull-right" > <i class="fa fa-plus"></i> Add Milestone </a></div>
                               
                               @endif
                             </div>
                        </div>
                        <hr>
                       <table class="table table-bordered">
                        <thead>
                          <tr>
                           <th>Milestone Number</th>
                           <th>Milestone Details</th>
                           <th>Delivery Date </th>
                           <th>Current Status </th>
                           <th>Reason For Delay</th>
                           <th>New Delivery Date </th>
                           <th>MileStone Notes </th>
                           <th>Delivery Notes </th>
                          </tr>                        
                        </thead>
                        <tbody>
                          @foreach($milestones as $milestone)
                          <tr>
                           <th>{{$milestone->milestone_number}}</th>
                           <th>{{$milestone->milestone_details}}</th>
                           <th width="10%">{{date('d M Y', strtotime($milestone->delivery_date))}}</th>
                           <th>{{$milestone->delivery_date_updated==1 ? "Delay" : "On Time"}}</th> 
                           <th>{{$milestone->reason_for_delay}}</th>
                           <th width="10%">{{($milestone->new_delivery_date) ? date('d M Y', strtotime($milestone->new_delivery_date)) : ''}}</th>
                           <th>{{$milestone->milestone_notes}}</th>
                           <th>{{$milestone->delivery_notes}}</th>
                          </tr>  
                          @endforeach
                        </tbody>
                       </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
        $(document).on('click','.update_project',function(){
            BootstrapDialog.show({
              title:' Is delivery Date to be Updated ? ',
              //message: '<br> <div class="col-sm-12">  </div>',
              buttons:[{
                  label:"Yes ",
                  cssClass:"btn btn-success",
                  action: function(dialog){
                         dialog.close();
                        /* Inner Dialog..... */
                         BootstrapDialog.show({
                          title:' Which Milestone is effected ?',
                          message: '<br> <div class="form-group"><label for="milestone_number" class="col-sm-2 control-label"> Milestone Number </label><div class="col-sm-10"><input type="number" min="1" max="6" class="form-control" id="milestone_number" placeholder="Enter Milestone Number... "/></div></div> <br>',
                          buttons:[{ 
                                    label:"Edit",
                                    cssClass:"btn btn-success",
                                    action: function(dialog){
                                      var milestone_number = $('#milestone_number').val();
                                      if(milestone_number>=1 && milestone_number <=6){
                                         window.location.href = "{{route('cm.edit_fixed_project',['role'=>getRole(Auth::user()->role),'project'=>$project->id])}}/"+ milestone_number;
                                         //url = "{{route('cm.add_fixed_project', ['role'=> getRole(Auth::user()->role),'project'=>$project->id])}}/"+ milestone_number;
                                         //console.log(url); 
                                      }else{
                                        $('#milestone_number').focus();
                                      }
                                    }},
                                    {
                                    label:"Close",
                                    cssClass:"btn btn-danger",
                                    action: function(dialog){
                                        dialog.close();
                                    }
                                }]
                         });
                          /* Inner Dialog..... */

                  }},{
                  label:"No",
                  cssClass:"btn btn-info",
                  action: function(dialog){
                    window.location.href = "{{route('cm.edit_all_fixed',['role'=>getRole(Auth::user()->role),'project'=> $project->id])}}";
                  }},{
                  label:"Close",
                  cssClass:"btn btn-danger",
                  action: function(dialog){
                      dialog.close();
                  }}
              ]
          });
        });// End .update_project 
	}); // End ready function
</script>
@endsection
