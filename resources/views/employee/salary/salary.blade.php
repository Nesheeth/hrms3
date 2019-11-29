@extends('admin.layouts.app')

@section('title','Employee Salary')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
            <div class="page-title">
                <h3>Employees Salary</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                        <li class="active"><a href="#"> Payslip</a></li>
                    </ol>
                </div>
            </div>
<!-- 
        <div id="main-wrapper">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12"> 
                            <table class="table">
                                <thead>
                                   
                                    
                                </thead>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
           
            <div class="panel panel-white">
                <div class="panel-body">
                <div class="col-md-12"> 
                            <div class="table-responsive table-remove-padding">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Month-Year</th>
                                            <th>Basic Salary</th>
                                            <th>Gross Salary</th>
                                            <th>Net Salary</th>
                                            <th>Employee</th>
                                            <th>HR </th>
                                            <th>Accountent</th>
                                            <th>Management</th>
                                            <th> View </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($payrolls as $roll)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $roll->salary_month}} - {{$roll->salary_year}}</td>
                                                <td>&#x20B9;{{$roll->basic_salary}}</td>
                                                <td>{{$roll->calculate_salary}}</td>
                                                <td>{{$roll->calculate_salary}}</td>
                                                <td>
                                                    @if($roll->emp_status == 0) 
                                                    <span class="label label-warning">No</span>
                                                    @elseif($roll->emp_status == 1)
                                                    <span class="label label-success">ok</span>
                                                    @elseif($roll->emp_status == 2)
                                                    <span class="label label-danger">Issue</span>                                                    
                                                    @endif
                                                </td>
                                                <td><span class="label label-info">reviewing</span></td>
                                                <td><span class="label label-warning">wait</span></td>
                                                <td><span class="label label-danger">issue</span></td>
                                                <td> 
                                                <a href="{{route('c.payrolldetails',['role' => getRoleStr(),'id'=>$roll->id])}}" class="btn btn-info view_pay" >Change Status</a> 
                                                <a href="{{route('c.payrolldetails',['role' => getRoleStr(),'id'=>$roll->id])}}" class="btn btn-info view_pay" >More</a> 
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
@endsection



@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<!-- <script>
    $(document).on('click','.view_pay',function(){ 
        BootstrapDialog.show({
            title:"Select Month",
            message: function(dialog){ 
                var $message = $(`<br><div class="row"><div class="form-group"> 
                                        <label for="payroll_month" class="col-sm-2 control-label"> Delivery Date </label> 
                                        <div class="col-sm-10"> 
                                            <input class="payroll_month form-control" id="payroll_month" name="payroll_month"  placeholder="Payroll Month..."/>
                                        </div> 
                                    </div></div>`); 
                                    //$message.append($button);
                                    $('.payroll_month').datepicker();     
                                    return $message;  
            },
            buttons:[{
                label:"view",
                cssClass:"btn btn-success",
                action: function(dialog){
                    //dialog.close();
                }
            },{
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){
                    dialog.close();
                }
            }]
        });
    });
</script>-->
@endsection
