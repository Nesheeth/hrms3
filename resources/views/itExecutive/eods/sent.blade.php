@extends('admin.layouts.app')
@section('title','Sent EOD')

@section('content')
<div class="page-inner">
	<div class="page-title">
		<h3>Send EOD</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{ URL(getRoleStr().'/dashboard') }}">Home</a></li>
				<li><a href="">SENT EOD</a></li> 
			</ol>
		</div>
	</div>
    <div id="main-wrapper">
        <div class="row">
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
                    <form class="form-horizontal" action="{{route('it.eod')}}" method="post" id="eodForm">
                        {{csrf_field()}}
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control date_of_eod" name="date" id="date_of_eod"   required placeholder="Date Of EOD">
                        </div> 
						<div class="form-group col-md-3">
                            <select class="form-control" name="shift"   required>
							 <option value=""> --Select Shift-- </option> 
							 <option value="Day"> Day </option>
							 <option value="Night"> Night </option>
							</select>
                        </div>
						<div class="table-resposive">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Task ID</th>
										<th>Issue Type</th>
										<th>CBPC NO.</th>
										<th>Issue Details</th>
										<th>Resolution Provided</th>
										<th>Resolution Status</th>
										<th>Comment</th>
									</tr>
								</thead>
								 <tbody id="eod">
									<tr>
										<td>
										   <div class="form-group col-md-1"> 
												<button type="button" class="btn btn-danger" id="addMoreBtn"><i class="fa fa-plus"></i> </button>
											 </div>
									   </td>
									   
										<td>
										   <div class="form-group col-md-12"> 
											   <input type="number" min="1" name="task_id[]" class="form-control task_id" placeholder="Task ID" required/>  
										   </div>
										</td>
										<td>
										   <div class="form-group col-md-12">
												 <input name="issue_type[]" class="form-control issue_type" required placeholder="Issue Type"/>
											</div>
										</td>
										<td>
											<div class="form-group col-md-12">
											   <input name="cbpc_no[]"  required class="form-control cbpc_no" placeholder="CBPC NO."/> 
										   </div>
										</td>
										<td>
											<div class="form-group col-md-12">
											   <textarea style="resize: none;" cols="25" rows="4" required name="issue_details[]" class="form-control issue_details" placeholder="Issue Details"></textarea> 
										   </div>
										</td>
										<td>
											<div class="form-group col-md-12">
											   <textarea style="resize: none;" cols="25" rows="4" name="resolution_provided[]" class="form-control resolution_provided" required placeholder="Resolution Provided"></textarea> 
										   </div>
										</td>
										<td>
											<div class="form-group col-md-12">
												<select class="form-control resolution_status" name="resolution_status[]"   required>
												 <option value=""> --Select Status-- </option> 
												 <option value="Fixed"> Fixed </option>
												 <option value="Handover"> Handover </option>
												 <option value="Inprocess"> Inprocess </option>
												 <option value="Not Resolve"> Not Resolve </option> 
												</select> 
										   </div>
										</td>
										<td>
											<div class="form-group col-md-12">
											   <textarea style="resize: none;" cols="25" rows="4" name="comment[]" class="form-control" placeholder="Comment.."/></textarea> 
										   </div>
										</td>
									</tr>
								</tbody>
								
							</table>
						</div>

                        <div class="col-md-12">
							<button type="submit" id="sendBtn" class="btn btn-info pull-right">Send</button>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script>
 $(document).ready(function(){  
 
      $('#date_of_eod').datepicker({format:"yyyy-mm-dd", startDate:"{{ date('Y-m-d', strtotime('-1 days')) }}", endDate:"{{date('Y-m-d')}}"});       
      $('.delivery_date').datepicker({format:"yyyy-mm-dd",startDate:"0 days"});  

      $('#eodForm').submit(function(event) {
            var projectErr,desErr,tsErr,ddErr,thErr,esErr,taskErr,hourErr;
            
            $('.task_id').each(function(){
                if($(this).val() == ""){
                    projectErr = true;
                }
            });

            $('.issue_type').each(function(){
                if($(this).val() == ""){
                    taskErr = true;
                }
            });

            $('.cbpc_no').each(function(){
                if($(this).val() == ""){
                    desErr = true;
                }
            });

            $('.resolution_provided').each(function(){
                if($(this).val() == ""){
                    esErr = true;
                }
            });

            $('.issue_details').each(function(){
                if($(this).val() == ""){
                    thErr = true;
                }
            });

            $('.resolution_status').each(function(){
                if($(this).val() == ""){
                    ddErr = true;
                }
            });

           
            if($('#date_of_eod').val() == "" ){
                swal('Oops','Date Of EOD Should Not be empty','error');
                return false;
            }else if(projectErr){
                swal('Oops','Task ID Should Not be empty','error'); 
                return false;
            }else if(desErr){
                swal('Oops','CBPC NO. Should Not be empty','error');
                return false;
            }else if(taskErr){
                swal('Oops','Issue Type Not be empty','error');
                return false;
            }else if(ddErr){
                swal('Oops','Resolution Status Should Not be empty','error');
                return false;
            }else if(thErr){ 
                swal('Oops','Issue Details Should Not be empty','error');
                return false;
            }else if(esErr){ 
                swal('Oops','Resolution Provided Should Not be empty','error');
                return false;
            }else{
                return true;
            }
        });
      
      $(document).on('click','#addMoreBtn',function(){
         // console.log('dddd'); 
           var html = `<tr><td></td>
							<td>
                                       <div class="form-group col-md-12"> 
                                           <input type="number" min="1" name="task_id[]" class="form-control task_id" placeholder="Task ID" required/>  
                                       </div>
                                    </td>
                                    <td>
                                       <div class="form-group col-md-12">
                                             <input name="issue_type[]" class="form-control issue_type" required placeholder="Issue Type"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <input name="cbpc_no[]"  required class="form-control cbpc_no" placeholder="CBPC NO."/> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <textarea style="resize: none;" cols="25" rows="4" required name="issue_details[]" class="form-control issue_details" placeholder="Issue Details"></textarea> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <textarea style="resize: none;" cols="25" rows="4" name="resolution_provided[]" class="form-control resolution_provided" required placeholder="Resolution Provided"></textarea> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <select class="form-control resolution_status" name="resolution_status[]"   required>
											 <option value=""> --Select Status-- </option> 
											 <option value="Fixed"> Fixed </option>
											 <option value="Handover"> Handover </option>
											 <option value="Inprocess"> Inprocess </option>
											 <option value="Not Resolve"> Not Resolve </option> 
											</select> 
                                       </div>
                                    </td>
									<td>
                                        <div class="form-group col-md-12">
                                           <textarea style="resize: none;" cols="25" rows="4" name="Comment[]" class="form-control" placeholder="Comment.."/></textarea> 
                                       </div>
                                    </td>
						</tr>`;

                $('#eod').prepend(html);
                $('.delivery_date').datepicker({format:"yyyy-mm-dd",startDate:"0 days"});
      });
 });

 function removeRow(row){
    $(row).closest('tr').remove();
}
</script>
@endsection 