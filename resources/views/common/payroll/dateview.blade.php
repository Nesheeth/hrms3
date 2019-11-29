<div class="row"><br>
        <div class="form-group"> 
            <label for="payroll_month" class="col-sm-2 control-label"> Delivery Date </label> 
                <div class="col-sm-10">
                    <input type="text" class="payroll_month form-control" id="payroll_month" name="payroll_month"  placeholder="Payroll Month..."/>
                </div> 
        </div>
</div>

<script>
    $("#payroll_month").datepicker( {
        format: "mm-yyyy",
        endDate: '-1m',
        viewMode: "months", 
        minViewMode: "months"
    });   
</script>