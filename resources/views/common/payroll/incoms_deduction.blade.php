<form action="{{route('save_income_deduction',['role'=>getRoleStr()])}}" method="post" id="income_deduction_form">
    {{csrf_field()}}
    <input type="hidden" name="type_name"  value="{{$type}}"/>
    @if($type=='income')
        <div class="row">
            <div class="form-group"> 
                <label for="payroll_month" class="col-sm-2 control-label">  Earnings Type </label> 
                    <div class="col-sm-10">
                        <select class="form-control" name="type" id="type" readonly="true" style="pointer-events: none;">
                            @foreach($types as $type)
                            <option value="{{$type->id}}" @if(app('request')->input('earning_type')==$type->id) selected @else data-type="{{app('request')->input('earning_type')}}" @endif>{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group"> 
                <label for="payroll_month" class="col-sm-2 control-label"> Amount </label> 
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="amount" name="amount" value=" {{app('request')->input('amount')}}"  placeholder="Earning Amount..." min="0" />
                    </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group"> 
                <label for="payroll_month" class="col-sm-2 control-label"> Description </label> 
                    <div class="col-sm-10"> 
                        <textarea class="form-control" name="description" value="{{app('request')->input('description')}}" placeholder="Description..." style="resize: none;" {{app('request')->input('required')}}>{{app('request')->input('description')}}</textarea>
                    </div> 
            </div>
        </div>

    @elseif($type=='deduction')

    <div class="row">

            <div class="form-group"> 
                <label for="payroll_month" class="col-sm-2 control-label">  Deduction Type </label> 
                <div class="col-sm-10">
                        <select class="form-control" name="type" readonly="true" style="pointer-events: none;">
                            @foreach($types as $type)
                            <option value="{{$type->id}}" @if(app('request')->input('deduction_type')==$type->id) selected @else data-type="{{app('request')->input('deduction_type')}}" @endif>{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group"> 
                <label for="payroll_month" class="col-sm-2 control-label"> Amount </label> 
                    <div class="col-sm-10">
                        <input type="text" class="form-control"  id="amount" name="amount"   placeholder="Earning Amount..."/ min="0" value="{{app('request')->input('amount')}}">
                    </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group"> 
                <label for="payroll_month" class="col-sm-2 control-label"> Description </label> 
                    <div class="col-sm-10"> 
                        <textarea class="form-control" name="description"  placeholder="Description..." style="resize: none;" required>{{app('request')->input('description')}}</textarea>
                    </div> 
            </div>
        </div>
    @endif