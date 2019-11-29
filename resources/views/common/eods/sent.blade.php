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
                    <form class="form-horizontal" action="" method="post" id="eodForm">
                        {{csrf_field()}}
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control date_of_eod" name="date" id="date_of_eod"   required placeholder="Date Of EOD">
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Project</th>
                                    <th>Task Name</th>
                                    <th>Description</th>
                                    <th width="10%">Estimated Hours</th>
                                    <th width="10%">Hours Spent Today</th>
                                    <th width="10%">Total Hours</th>
                                    <th>Delivery Date</th>
                                    <th>Task Status</th>
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
                                            <select name="project[]" class="form-control project" required>
                                                <option value="">--Select Project--</option>
                                                @foreach($projects as $project)
                                                <option value="{{$project->project_id}}">{{$project->project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td> 
                                    <td>
                                       <div class="form-group col-md-12">
                                           <input name="task_name[]" class="form-control" placeholder="Task Name" required/> 
                                       </div>
                                    </td>
                                    <td>
                                       <div class="form-group col-md-12">
                                             <textarea name="description[]" style="resize: none;" cols="25" rows="4" class="form-control task" required placeholder="Description"></textarea>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group col-md-12">
                                           <input name="es_hours[]" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.key === "Backspace"' required class="form-control" placeholder="Estimated hours"/> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <input name="today_hours[]" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.key === "Backspace"' onkeyup="calculateHour()" required class="form-control today_hours" placeholder="Today hours "/> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <input onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.key === "Backspace"'  required name="total_hours[]" class="form-control total_hours" placeholder="Total hours"/> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <input name="delivery_date[]" class="form-control delivery_date" required placeholder="Delivery Date"/> 
                                       </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-12">
                                           <select name="task_status[]" class="form-control task_status" required>
                                               <option> In Progress </option> 
                                               <option> Hold </option>
                                               <option> Internal Testing </option>
                                               <option> Delivered </option>
                                               <option> Client Bugs </option>
                                               <option> Change Request </option>
                                               <option> Closed </option>
                                           </select>
                                       </div>
                                    <td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-md-12">
							<button type="submit" id="sendBtn" class="btn btn-info pull-right" disabled="disabled">Send</button>
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
            
             $('#sendBtn').attr('disabled',false);   

            $('.project').each(function(){
                if($(this).val() == ""){
                    projectErr = true;
                }
            });

            $('.task_name').each(function(){
                if($(this).val() == ""){
                    taskErr = true;
                }
            });

            $('.description').each(function(){
                if($(this).val() == ""){
                    desErr = true;
                }
            });

            $('.es_hours').each(function(){
                if($(this).val() == ""){
                    esErr = true;
                }
            });

            $('.total_hours').each(function(){
                if($(this).val() == ""){
                    thErr = true;
                }
            });

            $('.delivery_date').each(function(){
                if($(this).val() == ""){
                    ddErr = true;
                }
            });

            $('.task_status').each(function(){
                if($(this).val() == ""){
                    tsErr = true;
                }
            });
            if($('#date_of_eod').val() == "" ){
                swal('Oops','Date Of EOD Should Not be empty','error');
                return false;
            }
            else if(desErr){
                swal('Oops',' Description Should Not be empty','error');
                return false;
            }else if(taskErr){
                swal('Oops','Task Should Not be empty','error');
                return false;
            }else if(hourErr){
                swal('Oops','Hour Should Not be empty','error');
                return false;
            }else if(tsErr){
                swal('Oops','Task Status Should Not be empty','error');
                return false;
            }else if(ddErr){
                swal('Oops','Delivery Date Should Not be empty','error');
                return false;
            }else if(thErr){ 
                swal('Oops','Total Hour Should Not be empty','error');
                return false;
            }else if(esErr){ 
                swal('Oops','Estimated Hour Should Not be empty','error');
                return false;
            }else{
                  
                 $('#sendBtn').attr('disabled',true); 
                return true;
            }

           
        });
      
      $(document).on('click','#addMoreBtn',function(){
         // console.log('dddd'); 
           var html = `<tr>
                        <td></td>
                        <td>
                            <div class="form-group col-md-12">
                                <select name="project[]" class="form-control project" required>
                                    <option value="">--Select Project--</option>
                                    @foreach($projects as $project)
                                    <option value="{{$project->project_id}}">{{$project->project->project_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td> 
                        <td>
                            <div class="form-group col-md-12">
                                <input name="task_name[]" required class="form-control task_name" placeholder="Task Name"/> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-12">
                                    <textarea name="description[]" cols="35" rows="4" class="form-control description" required placeholder="Description"></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-12">
                                <input required name="es_hours[]" onkeypress='return event.charCode >= 46 && event.charCode <= 57 || event.key === "Backspace"' class="form-control es_hours" placeholder="Estimated hours"/> 
                            </div>
                        </td>
                        <td> 
                            <div class="form-group col-md-12">
                               <input name="today_hours[]" onkeypress='return event.charCode >= 46 && event.charCode <= 57 || event.key === "Backspace"' required class="form-control today_hours" onkeyup="calculateHour()" placeholder="Today hours "/> 
                           </div>
                        </td>
                        <td>
                            <div class="form-group col-md-12">
                                <input required onkeypress='return event.charCode >= 46 && event.charCode <= 57 || event.key === "Backspace"'  name="total_hours[]" class="form-control total_hours" placeholder="Total hours"/> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-12">
                                <input required name="delivery_date[]" class="form-control delivery_date" placeholder="Delivery Date"/> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-12">
                                <select name="task_status[]" class="form-control task_status" required>
                                   <option> In Progress </option>
                                   <option> Hold </option>
                                   <option> Internal Testing </option>
                                   <option> Delivered </option>
                                   <option> Client Bugs </option>
                                   <option> Change Request </option>
                                   <option> Closed </option>
                               </select> 
                            </div>
                        <td>
                        <td><a href="#" onclick="removeRow(this)"><span class="badge"><i class="fa fa-times"></i></span></a></td>
                        </tr>`;

                $('#eod').prepend(html);
                $('.delivery_date').datepicker({format:"yyyy-mm-dd",startDate:"0 days"});
      });
 });

 function removeRow(row){
    $(row).closest('tr').remove();
    var total = 0;
    $('.today_hours').each(function(){
        total +=  parseFloat($(this).val());
    });


    if(parseFloat(total) >= 8){
        $('#sendBtn').removeAttr('disabled');
    }else{
        $('#sendBtn').attr('disabled','disabled');
    } 
}

function calculateHour(){
var total = 0;
$('.today_hours').each(function(){
    total +=  parseFloat($(this).val());
});
if(parseFloat(total) >= 8){
    $('#sendBtn').removeAttr('disabled');
}else{
    $('#sendBtn').attr('disabled','disabled');
}

}
</script>
@endsection 