<div class="panel panel-white">
    <div class="panel-body ">
        <form id="newModalForm" role="form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" id="payroll_year" name="payroll_year">
                        <option value="0">-- Select Year --</option>
                        @for($i=date('Y');$i >= 2014 ;$i--)
                        <option>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" id="payroll_month" name="payroll_month">
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
<script type="text/javascript">
   
</script>
@endsection