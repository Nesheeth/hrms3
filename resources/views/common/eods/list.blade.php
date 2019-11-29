@extends('employee.layouts.app')

@section('content')

@section('title','Sent EODs')
<div class="page-inner">
	<div class="page-title">
		<h3>Sent EODs</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/employee/dashboard')}}">Home</a></li>
				<li class="active">Sent EODs</a></li>
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
						<h4 class="panel-title">Sent EODs</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive table-remove-padding">
							<table class="table" id="datatable">
								<thead>
									<tr> 
										<th>S. NO.</th>
										<th>EOD Date</th>
										<th>Project</th>
										<th>Task Name </th>
										<th>Description</th>
										<th>ES Time </th>
										<th>Total Time </th>
										<th>Delivery Date </th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if(isset($eods))
									@foreach($eods as $eod)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{date('d M-Y', strtotime($eod->date))}}</td>
										<td>{{$eod->project->project_name}} </td>
										<td>{{$eod->task_name}}</td>
										<td>{{$eod->description}}</td>
										<td>{{$eod->es_hours}}</td>
										<td>{{$eod->total_hours}}</td>
										<td>{{date('d M-Y', strtotime($eod->delivery_date))}}</td>
										{{--<td>
											@if($eod->task_status==1)
                                                 <span class="label  label-success">Complete</span>
											@else
                                                <span class="label  label-danger">In Complete</span>
											@endif
										</td>--}} 

										<td> <span class="label  label-info">{{$eod->task_status}}</span></td>
										@if(date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d')))) == $eod->date || date('Y-m-d', strtotime($eod->date)) == date('Y-m-d'))
											   @if($eod->edit_eod_request == '1')
												<td><span class="text-success">Request Send</span></td>
											   @elseif($eod->edit_eod_request == '0')
											   <td><a class="btn btn-danger " role="button" rel="{{$eod->id}}" onclick="edit_eod({{$eod->id}})">Edit</td>
											   @elseif($eod->edit_eod_request == '2')
											    <td><a class="btn btn-info edit" role="button" rel="{{$eod->id}}">Click to Edit</td>
											   @elseif($eod->edit_eod_request == '3')
											    <td><span class="text-danger">Rejected</span></td> 	
											   @endif
										
											
										@endif
									</tr>
									@endforeach
									@endif

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- Row -->
	</div><!-- Main Wrapper -->

	<div class="modal fade view-eod-list" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-edit">
		
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mySmallModalLabel" ><i class="fa fa-pencil " aria-hidden="true">   <b>Edit EOD Details</b></i></h4>
					
				</div>
				<div class="modal-body">
					<div class="table-responsive table-remove-padding">
						<table class="table" id='edit_eod'>
							<thead>
								<tr>
									<th>EOD Date</th>
									<th>Project</th>
									<th>Task Name</th>
									<th>Description</th>
									<th>ES Time </th>
									<th>Total Time </th>
									<th>Delivery Date </th>
									<th>Status</th>
								</tr>
							</thead>
							@if(isset($eods))
							@foreach($eods as $eod)
							<tbody id="subEods">
									<td>{{$eod->date}}</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
							</tbody>
							@endforeach
							@endif
						</table>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
		
	</div>


	<div class="page-footer">
		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
	</div>
</div><!-- Page Inner -->


@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script>
	$(document).on('change','#delivery_date_edit',function(){
		$(this).datepicker();
	});
	//$('#delivery_date_edit').datepicker().on('change',function(){

	//});
	//$(document).ready(function(){
	// 	$('.edit').on('click',function(){
	// 		   var eod_id = $(this).attr('rel'); 
	// 		  // alert(eod_id);

	// 			$('.view-eod-list').modal('toggle');

	// 	});
	// });

	function edit_eod(t){
			swal({
			  title: "Are you sure?",
			  text: "Do you want to edit eod..",
			  type: "warning",
			  buttons: true,
			  dangerMode: true,
			   showCancelButton: true,
			   cancelButtonColor: '#d33',
			}).then((willDelete) => {
				if(willDelete) {	
			var id  = t;
			//alert(id);
			var data= {};
		    //var token      =   $('meta[name="_token"]').attr('content');
		    data.id = id;
		    //data._token=token;
		    url="{{ url(getRoleStr().'/edit-eod') }}";
		    $.ajax({
		        url: "{{ url(getRoleStr().'/edit-eod') }}",
		        method: 'get',
		        dataType : 'json',
		        data: data,
		        success: function(result){
		        	if(result.status){
		        		swal("Success","Request send Successfully..","success");
		        		location.reload();
		        		
		        	}
		        	else{
		        		swal("Error","Some thing went wrong..","error");
		        	}
		        }

		    });
		}
	})
}

	function getEod(id){
		var eodUrl = "{{URL('/getEod/')}}";
		$.get(eodUrl+'/'+id, function(data) {
			if(data.flag){
				$('#eodDate').text(' '+data.main_eod.created_at);
				$("#subEods").empty();
				$.each(data.main_eod.sub_eods, function(index, sub_eod) {
					var subEodUrl = "{{URL('/getSubEod/')}}";
					$.get(subEodUrl+'/'+sub_eod.id, function(sub_data) {
						if(sub_data.flag){
							var projectUrl = "{{URL('/getProject/')}}";
							var project = null;
							$.get(projectUrl+'/'+sub_data.sub_eod.project_id, function(pro) {
								if(pro.flag){
									project = pro.project.name;
								}
								$("#subEods").append('<tr><td>'+project+'</td><td>'+sub_data.sub_eod.hours_spent+'</td><td>'+sub_data.sub_eod.task+'</td></tr>');

							});
						}
					});
				});
			}else{
				swal('Oops','Something Went Wrong!','error')
			}
		});
	}

	$(document).on('click','.edit',function(){

                var eod_edit = $(this).attr('rel');
                setTimeout(function(){ $('#delivery_date_edit').datepicker({
                	  format:'yyyy-mm-dd',
                	  startDate:"0 days"
                	  
                }); }, 1000); 
                 
                BootstrapDialog.show({
				   // size:BootstrapDialog.SIZE_WIDE,

		            title:"Retract Leave",
		            message:$('<div> Please wait loading page...</div>').load("{{url(getRoleStr().'/edit-eods-details')}}/"+eod_edit),
		            buttons:[{ 
		                label:"Save",
		                cssClass:"btn btn-success edit_eod_save",

		                action: function(dialog){

		                	 var edit_reason = $('#edit_reason').val();
		                	 if(edit_reason == '' || edit_reason == null){
		                	 	swal('Error','Please enter the reason..','error');
		                	 }else{


		                     var data={}; 
		                      data.eod_id = $('#id').val();
		                      data.date_edit = $('#date').text();
		                      data.project_id_edit = $('#project_id_edit').val();
		                      data.task_name_edit = $('#task_name_edit').val();
		                      data.description_edit = $('#description_edit').val();
		                      data.es_hours_edit = $('#es_hours_edit').val();
		                      data.total_hours_edit = $('#total_hours_edit').val();
		                      data.today_hours_edit = $('#today_hours_edit').val();

		                      data.delivery_date_edit = $('#delivery_date_edit').val();
		                      data.task_status_edit = $('#task_status_edit').val();
		                      data.edit_reason = edit_reason;
		                      console.log(data);
                            //  if(reason!=''){
                                   // if(message!=''){
                                                 $.ajax({
                                                 	url:"{{url(getRoleStr().'/edit-send-eod')}}",
                                                 	type:"get",
                                                 	data:data,
                                                 	success:function(res){
                                                 		swal('Success','Eod edited Successfully..','success');
                                                         window.location.reload(); 
                                                 	}
                                                 });
                                  //  }else{
                                    	//$('#message_retract').focus();
                              //       }
                              // }else{
                              // 	$('#reason').focus(); 
                              // }
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
function calculateHour(){
var total = 0;
$('#today_hours_edit').each(function(){
    total +=  parseFloat($(this).val());
});
if(parseFloat(total) >= 8){
	console.log('if');
    $('.edit_eod_save').attr('disabled',false);
}else{
	console.log('else');
    $('.edit_eod_save').attr('disabled',true);
}
console.log(parseFloat(total));

}
</script>
@endsection

@endsection