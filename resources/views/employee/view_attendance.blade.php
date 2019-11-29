<div class="panel panel-white">
    <div class="panel-body ">
        <form id="form" role="form" >
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" id="payroll_year" name="payroll_year" required>
                        <option value="0">-- Select Year --</option>
                        @for($i=date('Y');$i >= 2014 ;$i--)
                        <option>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" id="payroll_month" name="payroll_month" required>
                        <option value="0">-- Select Month --</option>
                        @for($i=01;$i<=12;$i++)
                        <option>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
<script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#form" ).validate({
  rules: {
    payroll_year: {
      required: true
    }
    payroll_month: {
      required: true
    }
  }
});
</script>
@endsection