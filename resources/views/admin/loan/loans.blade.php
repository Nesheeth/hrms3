@extends('admin.layouts.app')

@section('content')

@section('title','Projects')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<div class="page-inner">
	<div class="page-title">
		<h3>Loan List</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li class="active">Loan List</a></li> 
			</ol>
		</div>
	</div>

	<div id="main-wrapper">

		<div class="row">
			<div class="col-md-12">
				@if(session('success'))
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('success') }}
				</div>
				@endif

				@if(session('error'))
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ session('error') }}
				</div>
				@endif
				<div class="panel panel-white">
					{{--<div class="panel-heading clearfix">
						<h4 class="panel-title">Loan List</h4>
					</div>--}}
					<div class="panel-body">
					<div class="row">
                <div class="col-sm-9">
									
								</div>
								<div class="col-sm-3 ">
								<!-- <button id="apply" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_loan"> Add Loan</button>  --> 
								</div>
					</div>
					<br>
						<div class="table-responsive table-remove-padding">
							<table class="table  table-hover table-condensed" id="projects">
								<thead>
									<tr>
										<th>Employee Name</th>
										<th>Loan Amount</th>
										<th>EMI</th>
										<th>Duration</th>
										<th>Affective Date</th>
										<th>Status</th>
                                        <th>Creation Date</th>
										<th>Action</th> 
									</tr>
								</thead>
								<tbody>
                                @foreach($loans as $loan) 
										
								   <tr>
								     <td>{{$loan->user->first_name}} {{$loan->user->last_name}} </td>
								     <td>@if($loan->amount > '0')<i class="fa fa-inr" aria-hidden="true"></i> {{$loan->amount}} @else <p style="text-align: center;">-</p>  @endif</td>
								     <td>@if($loan->emi > '0') {{$loan->emi}} @else <p style="text-align: center;">-</p>  @endif</td>
								     <td>{{$loan->duration}}  @if($loan->duration > '0') Months @else <p style="text-align: center;">-</p>  @endif</td>
								     <td> {{$loan->aff_date}}</td>
								     <td>@if($loan->status==0) 
                                     <button type="button" class="btn btn-success btn-xs">Pending</button> 
                                     @endif 
                                     @if($loan->status==1)
                                    <button type="button" class="btn btn-primary btn-xs">Approved</button> 
                                     @endif 
                                     @if($loan->status==2)
                                    <button type="button" class="btn btn-danger btn-xs">Rejected</button> 
                                     @endif </td>
                                     <td>{{ $loan->created_at->format('d M Y H:i:s') }}</td>
									 <td>
									<button type="button" class="btn btn-info" id="view_emi" data-lone_id="{{$loan->id}}" data-emp_id="{{$loan->emp_id}}"><i class="fa fa-eye" aria-hidden="true"></i>View EMI</button>
									 
									 <button class="btn btn-primary pull-right" data-toggle="modal" id="edit_model" data-target="#add_loan" data-id="{{$loan->id}}" data-amount="{{$loan->amount}}" data-emi="{{$loan->emi}}" data-duration="{{$loan->duration}}" data-aff_date="{{$loan->aff_date}}" data-status="{{$loan->status}}" data-approve_date="{{$loan->approve_date}}" data-message="{{$loan->message}}" data-emp_id="{{$loan->emp_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Loan</button>  
									    
									   
									  </td>
								   </tr>
								   @endforeach
								</tbody>
							</table>
						</div>
						{{--<div class="row ">
						  <div class="col-sm-6"> Showing {{$projects->firstItem()}} to {{$projects->lastItem()}} of {{$projects->total()}} entries </div>
						  <div class="col-sm-6 pull-right"> {{ $projects->links() }}</div>
						</div>--}}
						
					</div>
				</div>
			</div>
		</div><!-- Row -->
	</div><!-- Main Wrapper -->
	





<div class="page-footer">
	<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
</div>





<!-- Modal -->
<div class="modal fade" id="add_loan" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Loan </h4>
			</div>
			<hr/>
			<div class="modal-body">
				<form action="{{url(getRoleStr().'/add-loan')}}" method="post" id="loan_data">
					
					<div class="form-group">
						<label for="leave_type" class="col-sm-2 control-label">Employee</label>
						<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" id="action" name="action" value="">
						<input type="hidden" id="id" name="id" value="">
						<select name="emp_id" id="emp_id" class="form-control select2">
							<option value="">--Select Employee--</option>	
							@foreach($users as $user)
							<option value="{{ $user->id }}" > {{$user->first_name}} {{$user->last_name}} </option>
							@endforeach 
						</select>
					</div>
					<br>
					<div class="form-group">
						<label for="amount" class="control-label">Amount</label>
						<input type="text" id="amount" class="form-control" name="amount" placeholder="Enter Amount" min="1">
					</div>
					<br>
					<div class="form-group">
						<label for="emi" class=" control-label">EMI</label>
						<input type="text" id="emi" class="form-control" name="emi" placeholder="Enter EMI">
					</div>
					<br>
					<div class="form-group">
						<label for="duration" class=" control-label">Duration</label>
						<input type="text" class="form-control" id="duration" name="duration" placeholder="Duration(In months)">
						
					</div>
					<br>
					<div class="form-group">
						<label for="aff_date" class=" control-label">Affective Date</label>
						<input type="text" id="aff_date" class="datepicker form-control" name="aff_date" placeholder="Affective Date">
					</div>
					<br>
					<div class="form-group">
						<label for="status" class="control-label">Status</label>
						<select name="status" id="status" class="form-control select2">
							<option value="">--Select Status--</option>
							<option value="0">Pending</option>
							<option value="1">Approved</option>
							<option value="2">Rejected</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" id="form-submit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
				
		</div>
	</div>
</div>

<!--EMI MODAL-->
<div id="EMI_Modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close EMI_Modal" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">View EMI</h4>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow-y: auto;">
				<table class="table">
					<thead>
					 	<tr>
					 		
					 		<th>Sr</th>
					 		<th>EMI Year</th>
					 		<th>EMI Month</th>
					 		
					 		<th>EMI Amount</th>
					 		<th>Remaining Amount</th>
					 	</tr>
					</thead>
					<tbody id="emi_list">
					 	
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default EMI_Modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--END EMI MODAL-->

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
<script src="https://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/mvc/3.0/jquery.validate.unobtrusive.min.js"></script>



<script> 
	$('#loan_data').validate({ // initialize the plugin
		rules: {
		    message: {
		        required: true

		    },
		    amount: {
		        required: true,
		        number: true
		    },
		    aff_date:{
		    	required:true
		    },
		    emi:{
		    	required:true,
		    	number: true
		    },
		    duration:{
		    	required:true,
		    	number: true
		    },
		    emp_id:{
		    	required:true
		    }

		  
		}
	});
	var nowDate = new Date();
	var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
	$('#aff_date').datepicker({
		startDate: today 
	});
	$(document).ready(function(){
		 $('#projects').dataTable({
		    "order": [[ 1, "asc" ]],
		    columnDefs: [{ orderable: false, targets: [6] }]
		 });  
	}); 

	$(document).on('click','#edit_model',function(){
        $('input[name=id]').val($(this).attr('data-id'));
        $('input[name=amount]').val($(this).attr('data-amount'));
        $('input[name=emi]').val($(this).attr('data-emi'));
        $('input[name=duration]').val($(this).attr('data-duration'));
        $('input[name=aff_date]').val($(this).attr('data-aff_date'));
        $('select[name=status]').val($(this).attr('data-status'));
        $('select[name=emp_id]').val($(this).attr('data-emp_id')).css('pointer-events','none');
        $('input[name=action]').val('update');


    });

	$(document).on('click','#view_emi',function(){
		$('#EMI_Modal').css('display','block')
		$('#EMI_Modal').addClass('in')
		$('body').append('<div class="modal-backdrop fade in" style="z-index: 1040;"></div>');
		var id = $(this).data('lone_id');
		var user_id = $(this).data('emp_id');
		var data = {};
		data.id = id;
		data.user_id = user_id;
		data._token = "{{csrf_token()}}";
		
		$.ajax({
			type:'POST',
				url:"{{url('/admin/view_emi')}}",
				dataType: 'JSON',
				method:'POST',
				data:data,
				success:function(data){
					var html=``;
					var total_emi = 0;
					var i=0;
					$.each(data.emi,function(k,v){
						
						$.each(v.get_e_m_i,function(r,d){
							i=++i;
							total_emi=total_emi+d.emi_amount;
							html+=`<tr><td>`+i+`</td><td>`+getMonth(d.month_emi)+`</td><td>`+d.emi_year+`</td><td>`+d.emi_amount+`</td><td>`+(v.amount-total_emi)+`</td></tr>`;
						});
						
					});
					$('#emi_list').html(html);
				},
				
				error:function(){
				console.log('failure');
				},
			});

	 });	

	$('.EMI_Modal').click(function(){
		$('#EMI_Modal').css('display','none')
		$('#EMI_Modal').removeClass('in')
		$('.modal-backdrop').remove();
	});
	$('#loan_data').submit(function(event){
		if (!$(this).valid()) {  //<<< I was missing this check
	        return false
	    }
		event.preventDefault()
		var data = new FormData(this);
		
		
		$.ajax({		
			url:"{{url(getRoleStr().'/add-loan')}}",
			method: 'POST',
	    	dataType: 'json',
			data:data,
			processData:false,
			contentType: false,
			success:function(result){
				swal(result.msg,'',"success");
				location.reload();
			},
			error:function(result){

			}
		});
		return false;
	});


	$("#duration").on('keyup', function(){    
	   var months = $(this).val();
	   var amount = $("#amount").val();
	   var emi = Number(amount/months);
	   var duration = Number(amount/emi);
	 
	    if(isFinite(emi)){
	    $("#emi").val(emi);
	    }
	    if(isFinite(emi)){
	    $("#duration").val(duration);
	    }
	});

	$("#emi").on('keyup', function(){    
	   var emi = $(this).val();
	   var amount = $("#amount").val();
	   var duration = Number(amount/emi);
	 
	    if(isFinite(emi)){
	    $("#duration").val(duration);
	    }
	});

	function getMonth(month){
		switch(month){
			case 1:
				return 'January';
			break;
			case 2:
				return 'February';
			break;
			case 3:
				return 'March';
			break;
			case 4:
				return 'April';
			break;
			case 5:
				return 'May';
			break;
			case 6:
				return 'June';
			break;
			case 7:
				return 'July';
			break;
			case 8:
				return 'August';
			break;
			case 9:
				return 'September';
			break;
			case 10:
				return 'October';
			break;
			case 11:
				return 'November';
			break;
			case 12:
				return 'December';
			break;
		}

	}
</script>

@endsection
@endsection 