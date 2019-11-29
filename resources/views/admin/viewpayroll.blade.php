<div class="panel panel-white">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" id="payroll_year">
                        <option value="">-- Select Year --</option>
                        @for($i=date('Y');$i >= 2014 ;$i--)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" id="payroll_month">
                        <option value="">-- Select Month --</option>
                        @for($i=01;$i<=12;$i++)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
