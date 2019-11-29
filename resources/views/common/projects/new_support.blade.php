
<div class="row">
<br>
<form class="form-horizontal" id="new_support">  

<div class="form-group"> 
<label for="project_name" class="col-sm-2 control-label">Start Date
</label> 
    {{csrf_field()}}
<div class="col-sm-10"> 
<input type="text" required class="datepicker form-control" id="start_date" name="start_date" placeholder="Start Date..." required autocomplete="off">
</div> 
</div> 

<div class="form-group"> 
<label for="project_name" class="col-sm-2 control-label">End Date
</label> 

<div class="col-sm-10"> 
<input type="text" class="datepicker form-control" id="end_date" name="end_date" placeholder="End Date..." required autocomplete="off">
</div> 
</div> 

<div class="form-group"> 
<label for="project_name" class="col-sm-2 control-label">Total New Hours
</label> 

<div class="col-sm-10"> 
<input type="text" class="form-control" id="total_hours" name="total_hours" placeholder="Total New Hours..." required>
</div> 
</div> 
</form>
</div>
<script>
  $('.datepicker').datepicker();
</script>