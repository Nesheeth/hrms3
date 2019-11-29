
<div class="panel panel-white">
	<div class="panel-body">
		<table class="table">
			<tr>
				<th>Project Name : </th>
				<td>{{$project->project_name}}</td>
				<th>Project Type : </th>
				<td>{{$project->type->name}}</td>
				<th> Client Name : </th>
				<td>{{$project->client_name}}</td>
			</tr>
		</table>
		<form class="form-horizontal" action="" method="post" id="reminder_form">
			<div class="box-body"> 
				 {{csrf_field()}}
                <input type="hidden" name="project_id" value="{{@$project->id}}"> 
				<div class="form-group">
					<label for="project_name" class="col-sm-2 control-label">Reminder Type</label>
					<div class="col-sm-10">
					 <select class="form-control" name="reminder_type" id="reminder_type" required>
					 	 <option value=""> --  Select Reminder Type --</option>
					 	 <option value="1"> One Time </option>
					 	 <option value="2"> Every Day </option>
					 	 <option value="3"> Weekly </option>
					 </select>
					</div>
				</div>

				<div class="form-group" id="date">
					<label for="project_name" class="col-sm-2 control-label">Reminder Date</label>
					<div class="col-sm-10">
					  <input class="form-control datepicker" name="reminder_date" id="reminder_date" placeholder="Enter date of reminder.">
					</div>
				</div>

				<div class="form-group" id="day">
					<label for="project_name" class="col-sm-2 control-label">Reminder Week Day</label>
					<div class="col-sm-10">
					 <select class="form-control" name="reminder_day" id="reminder_day"> 
					 	 <option value=""> --  Select Week Day --</option>
					 	 <option> Sunday </option>
					 	 <option> Monday </option>
					 	 <option> Tuesday </option>
					 	 <option> Wednesday </option>
					 	 <option> Thursday </option>
					 	 <option> Friday </option>
					 	 <option> Saturday </option> 
					 </select>
					</div>
				</div>

				<div class="form-group" id="time">
					<label for="project_name" class="col-sm-2 control-label">Reminder  Time </label>
					<div class="col-sm-10">
					   <input class="form-control" name="reminder_time" id="reminder_time" placeholder="Enter time of reminder.">
					</div>
				</div>

				<div class="form-group">
					<label for="project_name" class="col-sm-2 control-label">Reminder Notes.</label>
					<div class="col-sm-10">
					 <textarea class="form-control" name="reminder_notes" id="reminder_notes" rows="5"></textarea> 
					</div>
				</div>

				<span id="rem_error" style="color: red"></span>

			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
  $('.datepicker').datepicker({format:"yyyy-mm-dd",startDate:"0 days"});
  $('#reminder_time').timepicker({minuteStep:1, defaultTime:false});           
  $('#date').hide();
  $('#day').hide();
  $('#time').hide();

  $(document).on('change','#reminder_type', function(){
        var type = $(this).val(); 
         if(type==1){
         	  $('#date').show();
			  $('#day').hide();
			  $('#time').hide();
			  
         }else if(type==2){
			  $('#time').show();
         	  $('#date').hide();
			  $('#day').hide();
         }else if(type==3){
			  $('#day').show();
			  $('#time').hide();
         	  $('#date').hide();
         }else{
         	  $('#date').hide();
			  $('#day').hide();
			  $('#time').hide();
         }
          $('#reminder_date').val('');
		  $('#reminder_time').val('');
		  $('#reminder_day').val('');
  });


</script>