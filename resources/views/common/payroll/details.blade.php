@extends('admin.layouts.app')
@section('title','Payslip Details')
@section('style')
<style type="text/css">
    .edit,.deduction_edit{
        cursor: pointer;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="page-inner" >
            <div class="page-title" id="header">
                <h3>Payslip Details</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                        <li class="active"><a href="#">Payslip Details</a></li>
                    </ol>
                </div>
            </div>

            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="panel panel-white">
                            <div class="panel-body">
                        <div class="table-responsive table-remove-padding">
                        <table class="table table-condensed">
                                <thead>
                                    <tr> 
                                        <td><h3>Payslip for {{date('F', mktime(0, 0, 0, $payslip->salary_month, 10))}} {{$payslip->salary_year}}</h3></td>
                                        <td></td>
                                        <td><a data-id="{{$payslip->id}}" class="btn btn-info request_payslip pull-right"> Request Payslip</a>
                                        @if(Auth::user()->role==1 || Auth::user()->role==2)
                                         <a data-id="{{$payslip->id}}"  class="btn btn-warning pull-right recalculate">Recalculate</a>
                                        @endif
                                        
                                        @if(Auth::user()->role==1 || Auth::user()->role==8)
                                         <button rel="{{$payslip->id}}"  class="btn btn-info payment_status">Change Payment Status</button>
                                        @endif
                                     </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Employee Name : </strong> {{$user->first_name}} {{$user->last_name}}  </td>
                                        <td> <strong>Joining Date :</strong> {{date('d F-Y', strtotime($user->cb_profile->joining_date))}} </td>
                                        <td><strong>Current Date :</strong> {{date("d F-Y,")}}</td>
                                    </tr> 
                                    <tr>
                                        <td><strong>Working Days : </strong> {{$payslip->working_days}} </td> 
                                        <td><strong> Present  : </strong> {{ $payslip->presents_days}}</td>  
                                        <td><strong> Absent : </strong> {{$payslip->working_days-$payslip->presents_days}}</td>  
                                       
                                    </tr>
                                    <tr>                                        
                                        <td> <strong>Leaves of the month    : </strong> {{$payslip->working_days-$payslip->presents_days}}</td>  
                                        <td><strong>Half Days of the Month :</strong>  {{$payslip->half_days}} </td> 
                                        <td><strong>UI Leaves     : </strong> {{$payslip->UI}}</td>
                                    </tr>
                                    

                                </thead>
                            </table>

                                <table class="table  table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Emoluments</th>
                                            <th>Amount Rs.</th>
                                            <th>Deductions</th>
                                            <th>Amount Rs.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Basic Salary</td>
                                            
                                            <td>{{$payslip->basic_salary}}</td>
                                            <td>Employee PF Deduction</td>
                                            
                                            <td>{{$payslip->pf}}</td>
                                        </tr>
                                        <tr>
                                            <td>House Rent Allowance ( HRA )</td>
                                            
                                            <td>{{$payslip->hra}}</td>
                                            <td>Employee ESI Deduction</td>
                                            
                                            <td>{{$payslip->esi}}</td>
                                        </tr>
                                        <tr>
                                            <td>Dearness Allowance ( DA )</td>
                                            
                                            <td>{{$payslip->da}}</td>
                                            <td>Other Deductions ( Leaves )</td>
                                            
                                            <td>{{other_dedtuction($payslip->id)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Transportation Allowance ( TA )</td>
                                            
                                            <td>{{$payslip->ta}}</td>
                                            <td>Loan Installment</td>
                                            
                                            <td>{{loan_emi($payslip->id)}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <td>Other Allowance</td>
                                            
                                            <td>{{$payslip->other_allowance}}</td>
                                            <td>TDS</td>
                                            
                                            <td>{{$payslip->tds}}</td>
                                        </tr>
                                        <tr>
                                            <td>Bonus</td>
                                            
                                            <td>{{$payslip->bonus}}</td>
                                            <td></td>
                                            
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Incentives</td>
                                            
                                            <td>{{($payslip->total_earning-($payslip->bonus+$payslip->loan+$payslip->arrears))}}</td>
                                            <td></td>
                                            
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Loan</td>
                                            
                                            <td>{{$payslip->loan}}</td>
                                            <td></td>
                                            
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Employer PF</td>
                                            
                                            <td>{{$payslip->employer_pf}}</td>
                                            <td></td>
                                            
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Employer ESI</td>
                                            
                                            <td>{{$payslip->employer_esi}}</td>
                                            <td></td>
                                            
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Arrears</td>
                                            
                                            <td>{{$payslip->arrears}}</td>
                                            <td>Total Deductions</td>
                                            
                                            <td>{{($payslip->tds+loan_emi($payslip->id)+other_dedtuction($payslip->id)+$payslip->esi+$payslip->pf)}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>Gross Pay</td>
                                        
                                        {{--<td>{{$payslip->arrears+$payslip->loan+$payslip->total_earning+$payslip->bonus+$payslip->other_allowance+$payslip->ta+$payslip->hra+$payslip->da+$payslip->basic_salary}}</td>--}}
                                        <td>{{$payslip->gross_salary}}</td>
                                        <td>Net Pay</td>
                                        
                                        {{--<td>{{($payslip->arrears+$payslip->loan+$payslip->total_earning+$payslip->bonus+$payslip->other_allowance+$payslip->ta+$payslip->hra+$payslip->da+$payslip->basic_salary)-($payslip->tds+loan_emi($payslip->id)+other_dedtuction($payslip->id)+$payslip->esi+$payslip->pf)}}</td>--}}
                                        <td>{{$payslip->net_salary}}</td>
                                    </tr>
                                    <tr>
                                     <td colspan="4"> 
                                        @if(Auth::user()->role==1)  
                                        <button {{($payslip->hr_status==1) ? "" : "disabled"}} rel="{{$payslip->id}}" class="btn btn-info pull-right change_mg_status" > Change Status </button> 
                                        @elseif(Auth::user()->role==2)
                                            <button {{($payslip->hr_status==1) ? "disabled" : ""}} rel="{{$payslip->id}}" class="btn btn-info pull-right change_mg_status" > Change Status </button> 
                                        @else
                                        <button {{($payslip->hr_status==1) ? "disabled" : ""}} rel="{{$payslip->id}}" class="btn btn-info pull-right change_status" > Change Status </button> 
                                        @endif
                                     </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            </div>
                        </div>
                    @if(Auth::user()->role==1 || Auth::user()->role==2)
                        <div class="row" id="earning">
                          <div class="col-sm-6">
                            <div style="margin-bottom:25px;">
                            <h3>Earnings {{--<button data-id="{{$payslip->id}}" class="btn btn-info pull-right add_earning">New Earning</button>--}}</h3>
                            
                            </div>
                             <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Earning Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($payslip->earnings as $key=>$earning)
                                    @if($earning->type!=7)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$earning->earning_type->name}}</td>
                                            <td>{{$earning->description}}</td>
                                            <td>{{$earning->amount}}</td>

                                            <td><!-- <a class="delete" data-type="earning" data-id="{{$earning->id}}"><i class="fa fa-trash"></i></a> | --> 
                                                <a class="edit" data-type="earning" data-id="{{$earning->id}}" data-earning_type="{{$earning->type}}" data-description="{{$earning->description}}" data-amount="{{$earning->amount}}" data-salary_id="{{$earning->salary_id}}"><i class="fa fa-edit"></i></a></td>
                                        </tr>
                                    @endif

                                @endforeach
                             </table>

                          </div>
                          <div class="col-sm-6"> 
                          <div style="margin-bottom:25px;">
                            <h3>Deductions {{--<button data-id="{{$payslip->id}}" class="btn btn-info pull-right add_deduction">New Deduction</button>--}}</h3>
                            </div>
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Deduction Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($payslip->deductions as $key=>$deduction)
                                    @if($deduction->type!=11)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$deduction->deduction_type->name}}</td>
                                            <td>{{$deduction->description}}</td>
                                            <td>{{$deduction->amount}}</td>
                                            <td><!-- <a class="delete" data-type="deduction" data-id="{{$deduction->id}}"><i class="fa fa-trash"></i></a> | --> <a class="deduction_edit" data-type="deduction" data-id="{{$deduction->id}}" data-earning_type="{{$deduction->type}}" data-description="{{$deduction->description}}" data-amount="{{$deduction->amount}}" data-salary_id="{{$deduction->salary_id}}"><i class="fa fa-edit"></i></a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                          </div>
                        </div>
    @endif
                </div>
            </div>
    </div>
   </div>
  
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script>

        $(document).on('click','.edit',function(){
            var amount = $(this).data('amount');
            var description = $(this).data('description');
            var earning_type = $(this).data('earning_type');
            var salary_id = $(this).data('salary_id');
            var id = $(this).data('salary_id');
            BootstrapDialog.show({
                title:"Update Earning",
                message: $('<div>Please wait loading page...</div>').load('{{route("ern_page", ["role"=> getRoleStr()])}}?type=income&amount='+amount+'&earning_type='+earning_type+'&description='+description+'&required=required&id='+id),
                buttons:[{
                    label:"Save",
                    cssClass:"btn btn-success",
                    action: function(dialog){

                        var url = $('#income_deduction_form').attr('action');
                        var data =  $('#income_deduction_form').serialize();
                        var description = $('textarea[name=description]').val();
                        var amount = $('input[name=amount]').val();
                        
                        if(amount<0 || amount==''){
                            swal('Please add amount grater than or equal to 0','','warning');
                            return false;
                        }
                        if(description==''){
                            swal('Please add description','','warning');
                            return false;
                        }
                        if (!description.replace(/\s/g, '').length) {
                          swal('Description does not accept whitespace (ie. spaces, tabs or line breaks)','','warning');
                          return false;
                        }
                        $.ajax({
                           url : url+'?salary_id='+salary_id+'&id='+id,
                           type:'post',
                           data : data,
                           dataType:'json',
                           success:function(res){
                               if(res.success == true){
                                swal('Success',res.msg,'success'); 
                               }
                               window.location.reload();
                           },
                           error:function(error){
                            swal('Error','Somthing went wrong !','error'); 
                           }
                        });
                    }
                },{
                    label:"Close",
                    cssClass:"btn btn-danger",
                    action: function(dialog){
                        dialog.close();
                    }
                }]
            });
            

            
            
            var id = $(this).data('id');
            $('#type').attr('selected',true);
           
        });


        $(document).on('click','.request_payslip',function(){
            $.ajax({
                url:"{{ route('request_for_slip') }}",
                type:"get",
                success:function(res){
                    swal('Success!','Request send to HR Department.','success');
                }
            });
            
        });
        
        
        $(document).on('click','.change_mg_status',function(){
        
            var pay_id = $(this).attr('rel'); 
            
             BootstrapDialog.show({
                title:"Approve Payroll Status",
                message: "<br> I have review pay roll and this is correct as per my Info.",
                buttons:[{
                    label:"Approve",
                    cssClass:"btn btn-success",
                    action: function(dialog){
                        $.ajax({
                            url:"{{route('mg.payroll_status')}}",
                            type:"get",
                            data:{pay_id:pay_id},
                            success:function(res){
                                console.log(res); 
                                dialog.close();
                                swal('Success!','Payroll Status updated successfully.','success');
                                setTimeout(function() { location.reload() },3000); 
                            }
                        }); 
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
            
        $(document).on('click','.change_status',function(){
            var pay_id = $(this).attr('rel'); 
             BootstrapDialog.show({
                title:"Confirm Salary Info.",
                message: "I have review and this is correct info.",
                buttons:[{
                    label:"OK",
                    cssClass:"btn btn-success",
                    action: function(dialog){
                        $.ajax({
                            url:"{{route('payroll_status')}}",
                            type:"get",
                            data:{pay_id:pay_id,status:1},
                            success:function(res){
                                console.log(res); 
                                dialog.close();
                                swal('Success!','Payroll Status update successfully.','success');
                                setTimeout(function() { location.reload() },5000); 
                            }
                        }); 
                    }
                },{
                    label:"Issue",
                    cssClass:"btn btn-danger",
                    action: function(dialog){
                            dialog.close();
                            BootstrapDialog.show({
                                title:"Salary Calculation Issue.",
                                message: $('<div>Please wait loading the page...</div>').load("{{ route('payroll_pages',['type' => 'salary_issue_view']) }}"),
                                buttons:[{
                                          label:"Submit",
                                          cssClass:"btn btn-success",
                                          action: function(dialog){
                                               var reason = $('#reason').val();
                                                $.ajax({
                                                    url:"{{route('payroll_status')}}",
                                                    type:"get",
                                                    data:{pay_id:pay_id,status:2,reason:reason},
                                                    success:function(res){
                                                        console.log(res);
                                                        swal('Success!','Payroll Status update successfully.','success');
                                                        setTimeout(function() { location.reload() },5000); 
                                                    }
                                                }); 
                                            }
                                        },{
                                          label:"Close",
                                          cssClass:"btn btn-danger",
                                          action: function(dialog){
                                                dialog.close();
                                            }
                                        }
                                ]
                            });
                    }
                }]
            });   
    });
    
    
        $(document).on('click','.payment_status',function(){ 
            BootstrapDialog.show({
                title:"Change Payment Status",
                message: $('<div> Please wait loading page... </div>').load('{{route("payroll_pages", ["type"=>"payment_status"])}}'),
                buttons:[{
                    label:"Update",
                    cssClass:"btn btn-success",
                    action: function(dialog){
                        var pay_date = $('#payment_date').val(); 
                        var pay_mode = $('#payment_mode').val();
                        $.ajax({
                            url:"{{route('payment_status',['role'=>getRoleStr()])}}", 
                            type:"get",
                            data:{payroll_id:"{{$payslip->id}}",pay_date:pay_date,pay_mode:pay_mode},
                            success:function(res){
                                dialog.close();
                                swal('Success!','Payment status update successfully.','success');
                            }
                        });
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
        
        
        $(document).on('click','.add_earning',function(){ 
            var salary_id = $(this).data('id');    
            BootstrapDialog.show({
                title:"Add new Earning",
                message: $('<div>Please wait loading page...</div>').load('{{route("ern_page", ["role"=> getRoleStr()])}}?type=income'),
                buttons:[{
                    label:"Save",
                    cssClass:"btn btn-success",
                    action: function(dialog){
                        var url = $('#income_deduction_form').attr('action');
                        var data =  $('#income_deduction_form').serialize();
                        $.ajax({
                           url : url+'?salary_id='+salary_id,
                           type:'post',
                           data : data,
                           dataType:'json',
                           success:function(res){
                               if(res.success == true){
                                swal('Success',res.msg,'success'); 
                               }
                               window.location.reload();
                           },
                           error:function(error){
                            swal('Error','Somthing went wrong !','error'); 
                           }
                        });
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

        $(document).on('click','.add_deduction',function(){ 
            var salary_id = $(this).data('id'); 
            BootstrapDialog.show({
                title:"Add new Deduction",
                message: $('<div>Please wait loading page...</div>').load('{{route("ern_page", ["role"=> getRoleStr()])}}?type=deduction'),
                buttons:[{
                    label:"Save",
                    cssClass:"btn btn-success",
                    action: function(dialog){
                        var url = $('#income_deduction_form').attr('action');
                        var data =  $('#income_deduction_form').serialize();
                        $.ajax({
                           url : url+'?salary_id='+salary_id,
                           type:'post',
                           data : data,
                           dataType:'json',
                           success:function(res){
                               if(res.success == true){
                                swal('Success',res.msg,'success'); 
                               }
                               window.location.reload();
                           },
                           error:function(error){
                            swal('Error','Somthing went wrong !','error'); 
                           }
                        });
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

        $(document).on('click','.deduction_edit',function(){
            var amount = $(this).data('amount');
            var description = $(this).data('description');
            var deduction_type = $(this).data('earning_type');
            var salary_id = $(this).data('salary_id');
            var id = $(this).data('id');
            BootstrapDialog.show({
                title:"Update Deduction",
                message: $('<div>Please wait loading page...</div>').load('{{route("ern_page", ["role"=> getRoleStr()])}}?type=deduction&amount='+amount+'&deduction_type='+deduction_type+'&description='+description),
                buttons:[{
                    label:"Save",
                    cssClass:"btn btn-success",
                    action: function(dialog){
                        var url = $('#income_deduction_form').attr('action');
                        var data =  $('#income_deduction_form').serialize();
                        var description = $('textarea[name=description]').val();
                        var amount = $('input[name=amount]').val();
                        
                        if(amount<0 || amount==''){
                            swal('Please add amount grater than or equal to 0','','warning');
                            return false;
                        }
                        if (!description.replace(/\s/g, '').length) {
                          swal('string only contains whitespace (ie. spaces, tabs or line breaks)','','warning');
                          return false;
                        }
                        if(description==''){

                            swal('Please add description','','warning');
                            return false;
                        }
                        $.ajax({
                           url : url+'?salary_id='+salary_id+'&id='+id,
                           type:'post',
                           data : data,
                           dataType:'json',
                           success:function(res){
                               if(res.success == true){
                                swal('Success',res.msg,'success'); 
                               }
                               window.location.reload();
                           },
                           error:function(error){
                            swal('Error','Somthing went wrong !','error'); 
                           }
                        });
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

        $(document).on('click','.delete',function(){ 
            var mytype = $(this).data('type'); 
            var id = $(this).data('id');  
            var token = $('meta[name="_token"]').attr('content');
            var type = $(this).data('type');     
            
            swal({
                title: "Are you sure?",
                text: "Are you sure want to delete the "+mytype+"?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",   
                closeOnConfirm: false,
                closeOnCancel: false            
                }).then(function(isConfirm) { 
                    if (isConfirm) {
                        $.ajax({
                           url : "{{route('delete_earning_deduction',['role'=>getRoleStr()])}}",
                           type:'post',
                           data : {'id':id,'type':type,'_token':token},
                           dataType:'json',
                           success:function(res){
                            console.log(res);
                              if(res.success == true){
                                swal('Success',res.msg,'success'); 
                              }else{
                                swal('Error','Somthing went wrong !','error'); 
                              }
                           },
                           error:function(error){
                            swal('Error','Somthing went wrong !','error'); 
                           }
                        });

                    } else {
                        
                    }
                });
        });

        $(document).on('click','.recalculate',function(){ 
            var salary_id = $(this).data('id');  
            var url = '{{route("recalculate", ["role"=> getRoleStr()])}}';
            var token = $('meta[name="_token"]').attr('content');
            $.ajax({
                    url : url,
                    type:'post',
                    data : {'salary_id':salary_id,'_token':token},
                    dataType:'json',
                    success:function(res){
                        if(res.success == true){
                            swal('Success',res.msg,'success'); 
                        }
                        window.location.reload();
                    },
                    error:function(error){
                        swal('Error','Somthing went wrong !','error'); 
                    }
            });
        });

        var specialElementHandlers = {
            "#editor":function(element,renderer){
                return true;
            }
        };

       /*  $(document).on('click','.download_payslip',function(e){ 
            e.preventDefault();
            $(this).hide();
            $('#header').hide();
            $('#earning').hide();
            print();
            $(this).show();
            $('#header').show();
            $('#earning').show();
        }); */

        $(document).ready(function() {
          $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
          });
        });
 </script>
@endsection
