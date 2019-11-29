
 @if($type=='salary_issue_view')
	<div class="row">
		<br>
        <div class="form-group">
			<label for="reason" class="col-sm-2 control-label">Reason</label>
			<div class="col-sm-10">
				<textarea name="reason" id="reason" cols="20" rows="10" class="form-control"></textarea>
			</div>
		</div>
    </div>
@elseif($type=='payment_status')
            <br/>
		    <div class="form-group row"> 
				<label for="payment_mode" class="col-sm-2 control-label"> Payment Mode </label> 
					<div class="col-sm-10">
						<select class="form-control" id="payment_mode">
						 <option> Cash </option>
						 <option> Cheque </option>
						 <option> NEFT  </option> 
						</select>
					</div> 
			</div>
			
			<div class="form-group row"> 
				<label for="payment_date" class="col-sm-2 control-label"> Payment Date </label> 
					<div class="col-sm-10">
						<input type="text" class="payment_date form-control" id="payment_date"  placeholder="Payment date..."/>
					</div> 
			</div>
	
		{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
		<script>
			$("#payment_date").datepicker( {
				format: "yyyy-mm-dd",
				endDate: '-1m'
			});   
		</script>
 @endif