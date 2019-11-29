@extends('admin.layouts.app')
@section('title','Settings')
@section('content')

<div class="page-inner">
	<div class="page-title">
		<h3>Settings</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li class="active"><a href="#">Settings</a></li>
			</ol>
			<!-- <a data-toggle="modal" data-target="#myModal" class="pull-right btn btn-success">Add Setting</a> -->
		</div>
	</div>
    <div id="main-wrapper">
            <div class="row">
            	@if (session('success'))


				<div class="alert alert-success">


					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>


					{{ session('success') }}


				</div>


				@endif


				@if (session('error'))


				<div class="alert alert-danger">


					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>


					{{ session('error') }}


				</div>


				@endif


                <div class="col-md-12"> 
					<form class="form-horizontal" action="{{ url('admin/setting') }}" method="post">

						<div class="box-body">

							{{csrf_field()}}
							<div class="form-group">
								<table class="table  table-bordered" id="settings_row" role="grid" >							
							
									<tbody>
									<tbody>
										
										<tr>
											<td><label for="leave_type" class="control-label">Employee contributes for ESI in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('esi_employee')}}" name="data[esi_employee]" placeholder=""></td>
										
										</tr>	
										<tr>
											<td><label for="leave_type" class="control-label">Employer contributes for ESI in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('esi_employer')}}" name="data[esi_employer]" placeholder=""></td>
										
										</tr>
										<tr>
											<td><label for="leave_type" class="control-label">Basic Salary in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('basic')}}" name="data[basic]" placeholder=""></td>
										
										</tr>
										<tr>	
											<td><label for="leave_type" class="control-label">House Rent Allowance (HRA)  in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('hra')}}" name="data[hra]" placeholder=""></td>
										
										</tr>	
											
										<tr>
											<td><label for="leave_type" class="control-label"> Dearness Allowance (DA) in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('da')}}" name="data[da]" placeholder=""></td>
										
										</tr>
										
										<tr>
											<td><label for="leave_type" class="control-label">Transportation Allowance ( TA ) Fixed Amoount</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('ta')}}" name="data[ta]" placeholder=""></td>
										
										</tr>	
										<tr>
											<td><label for="leave_type" class="control-label">Employee Provident Fund ( EPF ) in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('pf')}}" name="data[pf]" placeholder=""></td>
										
										</tr>
										<tr>
											<td><label for="leave_type" class="control-label">Employer Provident Fund ( EPF ) in %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('employer_pf')}}" name="data[employer_pf]" placeholder=""></td>
										
										</tr>
										<tr>
											<td><label for="leave_type" class="control-label">Tax Deducted at Source (TDS) %</label></td>
											<td width="200"><input class="form-control" value="{{get_setting_value('tds')}}" name="data[tds]" placeholder=""></td>
										
										</tr>
										
									</tbody>	
									</tbody>
								</table>
							</div>
						</div>

						<!-- /.box-body -->

						<div class="box-footer">

							<a href="#" class="btn btn-default">Cancel</a>

							<button type="submit" class="btn btn-info pull-right">Submit</button>

						</div>

						<!-- /.box-footer -->

					</form>					
                </div>
            </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
		<form class="form-horizontal" action="{{ url('admin/add_setting') }}" method="post" id="add_setting">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Add New Setting Key</h4>
      		</div>
      		<div class="modal-body">
	  		
				<div class="box-body">

					{{csrf_field()}}
					<div class="form-group">
						<label>Enter Level</label>
						<input type="text" name="level" class="form-control" placeholder="Enter Level"/>
					</div>
					<div class="form-group">
						<label>Key Name</label>
						<input type="text" name="key_name" class="form-control" placeholder="Key Name"/>
					</div>
					<div class="form-group">
						<label>Value</label>
						<input type="text" name="value" class="form-control" placeholder="Enter Value"/>
					</div>
				</div>
			
      		</div>
      		<div class="modal-footer">
	  
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="save" class="btn btn-success">Save</button>
      		</div>
		</form>
    </div>

  </div>
</div>

@endsection

@section('script')

<script>
	$(document).ready(function(){
		$('#add_setting').submit(function(){
			var mydata = $('#add_setting').serialize();
			var url = $('#add_setting').attr('action');
			$.ajax({
				url: url,
				type:'post',
				data: mydata,
				dataType:'json',
				success:function(data){
					console.log(data);
					if(data.success == true){
						var html ="<tr><td><label class='control-label'>"+data.mydata.level+"</label></td><td width='200'><input type='text' class='form-control'name='data["+data.mydata.key_name+"]' value='"+data.mydata.value+"'/></td></tr>";
						$('#settings_row > tbody').append(html);
					}else{
						alert(data.msg);
					}
				},
				error : function(error){
					console.log(error);
				}
			});
			return false;
		});
	});
</script>

@endsection