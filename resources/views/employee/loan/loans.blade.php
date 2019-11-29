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
								<button id="apply_loan" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_loan" data-action="add_loan_emp"> Apply For Loan</button>  
								</div>
					</div>
					<br>
						<div class="table-responsive table-remove-padding">
							<table class="table  table-hover table-condensed" id="projects">
								<thead>
									<tr>
										<th>Loan Amount</th>
										<th>EMI</th>
										<th>Duration</th>
										<th>Affective Date</th>
										<th>Status</th>
                                        <th>Creation Date</th>
                                        <th>Message</th>
										<th>Action</th> 
									</tr>
								</thead>
								<tbody>
                              
                                @foreach($loans as $loan) 	
								   <tr>
								     <td>{{$loan->amount}} </td>
								     <td>{{$loan->emi}}</td>
								     <td> {{$loan->duration}}</td>
								     <td>{{$loan->aff_date}}</td>
                                     @if($loan->status =='0')
								     <td><button type="button" class="btn btn-success">Pending</button> </td>
                                     @endif 
                                     @if($loan->status =='1')
								     <td><button type="button" class="btn btn-primary">Approved</button> </td>
                                     @endif 
                                     @if($loan->status =='2')
								     <td><button type="button" class="btn btn-danger">Rejected</button> </td>
                                     @endif 
								     <td>{{$loan->created_at}} </td>
                                     <td>{{$loan->message}} </td>
									 <td>
									 @if($loan->status !='1')
									 	<button class="btn btn-primary pull-right edit_model" data-toggle="modal" id="edit_model" data-target="#add_loan" data-action="update_user" data-id="{{$loan->id}}" data-amount="{{$loan->amount}}" data-message="{{$loan->message}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Loan</button>
									 @endif  
									    
									   
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
			<!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Apply Loan</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>

			<div class="modal-body">
			
				<form id="loan_data" action="{{url(getRoleStr().'/add-loan')}}" method="post">
					{{csrf_field()}}
					<div class="form-group">
						<label for="leave_type" class="col-sm-2 control-label">Amount</label>
						
							<input type="hidden" id="action" name="action" value="add_loan_emp">
							<input type="text" id="amount" class="form-control" name="amount" placeholder="Enter Amount" min="1">
						
					</div>
					<br/>
					<div class="form-group">
            			<label for="leave_type" class="col-sm-2 control-label">Message</label>
            			
            				<Textarea  id="msg" rows="10" cols="60" class="form-control" name="message" placeholder="Enter Message" style="resize:none;"></Textarea>
            				
            		</div>
            	</div>
	      
	            <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			        <button type="Submit" class="btn btn-success">Submit</button>
			      </div>
				</form>
				
		</div>
      
    </div>
  </div>

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
        }
      
    }
});
$('#apply_loan').click(function(){
	$('input[name=amount]').val('');
	$('#msg').text('');
	var action = $(this).data('action');
	$('h4.modal-title').text('Apply Loan');
	$('#action').val(action);
});
$('.edit_model').click(function(){
	$('h4.modal-title').text('Edit Loan');
	var id = $(this).data('id');
	$('input[name=amount]').val($(this).data('amount'));
	$('#msg').text($(this).data('message'));
	$('input[name=id]').remove();
	$('#loan_data').append('<input type="hidden" name="id" value="'+id+'">')
	var action = $(this).data('action');
	$('#action').val(action);
})
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
</script> 

@endsection
@endsection 