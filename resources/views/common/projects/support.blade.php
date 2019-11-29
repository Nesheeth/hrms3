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
                   @php
                       $rem_hours = $total_hours - $hours_spent;
                       if($total_hours != 0){
                            $rem_per = ($rem_hours*100)/$total_hours;
                          }
                        else
                        {
                          $rem_per = 0;
                        }
                       
                   @endphp
                        <div class="row">
                             <div class="col-md-12">
                              <div class="col-sm-3"> <h4>Project Name : {{$project->project_name}}</h4></div>
                              <div class="col-sm-3"> <h4>Project Start Date : {{date('d M, Y' ,strtotime($project->start_date))}}</h4></div>
                              <div class="col-sm-3"> <h4>Project Status : {{$project->status->name}}</h4></div>
                              <div class="col-sm-3"> <h4>Remaining Hours : {{$rem_hours}} / Hours </h4></div>
                             </div>
                             <div class="col-md-12">
                               <button   class="btn btn-success pull-right" onclick="openModal()"  {{$rem_per>10 ? "" : ""}}> <i class="fa fa-plus"></i> Renew  Project </button>
                             </div>
                        </div>
                        <hr>
                       <table class="table table-bordered">
                        <thead>
                          <tr>
                           <th>Start Date</th>
                           <th>Expiry Date</th>
                           <th>Total Hours</th>
                           <th>Renew Status</th>
                          </tr>                        
                        </thead>
                        <tbody>
                        @foreach($supports as $support)
                          <tr>
                            <td>{{date('d M Y', strtotime($support->start_date))}}</td>
                            <td>{{date('d M Y', strtotime($support->expiry_date))}}</td>
                            <td>{{$support->total_hours}}</td>
                            <td>{{$support->project_renewed==1?"Yes" : "No"}}</td>
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
       
       
       $(document).on('blur','#end_date',function(){
            var end   = new Date($(this).val()); 
            var start = new Date($('#start_date').val());
                diff = (end - start)/1000/60/60/24;
                if(diff < 1){
                  $(this).val('');
                  $(this).focus();  
                }
         });


        
	});

    function openModal(){
         BootstrapDialog.show({
            title:"Add New Support",
            message:$('<div>Please wait loading page...</div>').load('{{route("cm.view_new_support",["role"=>getRole(Auth::user()->role)])}}'),
            buttons:[{
                label:"Save",
                cssClass:"btn btn-success",
                action: function(dialog){
                      
                       if($('#start_date').val()=="")
                          $('#start_date').focus();
                       else if($('#end_date').val()=="")
                          $('#end_date').focus();
                       else if($('#total_hours').val()=="")
                          $('#total_hours').focus();
                       else{

                         var project_id  = "{{$project->id}}";
                         var formData = $('#new_support').serializeArray();
                         formData.push({name:"project_id",value:project_id});
                            $.ajax({
                            url:"{{route('cm.add_support_project',['role'=>getRole(Auth::user()->role)])}}", 
                            type:"POST",
                            data:formData,
                            success:function(res){
                                dialog.close();
                                swal('Success!','New Support time added Successfully.','success');
                                location.reload().delay(10000); 
                             }
                            }); 
                        
                       }//else
                      
                }},{
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){
                    dialog.close();
                }}
            ]
        });

    }// End function openModal()
</script>
@endsection
