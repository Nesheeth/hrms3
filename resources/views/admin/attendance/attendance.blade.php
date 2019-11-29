@extends('admin.layouts.app')
@section('style')
{{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}
{{Html::style("assets/plugins/datatables/css/jquery.datatables_themeroller.css")}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
table.dataTable.cell-border tbody td {padding: 5px 15px !important;}
table#example1 tr td {padding: 5px 15px !important;}
.empList-modal-sm .panel-body {overflow-y: scroll;height: 420px;}
.table>tbody>tr>td {padding: 5px 14px !important;border: 1px solid #e1e1e1;}
.table>tbody>tr>th {background: #22baa0;color: #fff;font-weight: 600;}
table::-webkit-scrollbar {height: 8px;}
table::-webkit-scrollbar-track {-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);}
table::-webkit-scrollbar-thumb {background-color: #22baa0;outline: 1px solid #168e79;border-radius: 50px;}
.attenreg tr:last-child td { text-align: center; padding: 5px 0px!important;}
.attenreg td {text-align: center;}
.panel-body .attenreg tr th {padding: 8px 15px 20px !important;position:  relative;text-align: center;font-size: 14px;}
.attenreg tr th span {font-size: 10px;position: absolute;bottom: 4px;left: 0;right: 0;}
</style>
@endsection
@section('content')
@section('title','Calender')
<div class="page-inner">
	<div class="page-title">
		<h3>Attendance</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>
				<li class="active"><a href="{{URL('/hrManager/attendance')}}">Attendance</a></li>
			</ol>
		</div>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">				
				<div class="panel panel-white">
					<div class="panel-heading clearfix">
						<h4 class="panel-title">Show Calender By Month</h4>
					</div>
					<div class="panel-body">
						<div class="col-md-4">
							<form class="form-inline" >
								<div class="form-group">
									<label class="sr-only" for="exampleInputEmail2">Month</label>
									<select name="month" class="form-control m-b-sm">
										<option value="1" {{$current_month == 1 ? 'selected' : ''}}>January</option>
										<option value="2" {{$current_month == 2 ? 'selected' : ''}}>February</option>
										<option value="3" {{$current_month == 3 ? 'selected' : ''}}>March</option>
										<option value="4" {{$current_month == 4 ? 'selected' : ''}}>April</option>
										<option value="5" {{$current_month == 5 ? 'selected' : ''}}>May</option>
										<option value="6" {{$current_month == 6 ? 'selected' : ''}}>June</option>
										<option value="7" {{$current_month == 7 ? 'selected' : ''}}>July</option>
										<option value="8" {{$current_month == 8 ? 'selected' : ''}}>August</option>
										<option value="9" {{$current_month == 9 ? 'selected' : ''}}>September</option>
										<option value="10" {{$current_month == 10 ? 'selected' : ''}}>October</option>
										<option value="11" {{$current_month == 11 ? 'selected' : ''}}>November</option>
										<option value="12" {{$current_month == 12 ? 'selected' : ''}}>December</option>
									</select>
								</div>

								<div class="form-group">
									<label class="sr-only" for="exampleInputPassword2">Year</label>
									<select class="form-control m-b-sm" name="year">
										@for ($y = $current_year; $y >= 2010; $y--)
										<option value="{{$y}}" {{$search_year == $y ? 'selected' : ''}}>{{$y}}</option>
										@endfor
									</select>
								</div>
								<div class="form-group">
									<label class="sr-only" for="exampleInputPassword2">Year</label>
									<select class="form-control m-b-sm " name="type">
										<option value="development" {{$emp_type == "development" ? "selected" : ''}}>DEVELOPMENT</option>
										<option value="sales" {{$emp_type == "sales" ? "selected" : ''}}>SALES</option>
									</select>
								</div>
								<button type="submit" class="btn btn-info" style="margin-top: -16px;">Show</button>
							</form>
						</div>
						<div class="col-md-8">
							<tr>											
											
												<?php 		
												$i = date("d");									
												$date=$search_year.'-'.$current_month.'-'.$i;							
												$hdate=str_pad($current_month, 2, "0", STR_PAD_LEFT).'/'.str_pad($i, 2, "0", STR_PAD_LEFT).'/'.$search_year;  		
												$get_name = date('l', strtotime($date)); 										
												$day_name = substr($get_name, 0, 3); 								
												$curdate=strtotime(date('Y-m-d'));						
												$mydate=strtotime($date);								
												?>											
												@if(isHoliday($hdate,$emp_type)|| $day_name == "Sat" || $day_name =="Sun" || $curdate < $mydate)			
													<td ></td>									
												@else										
													<td><button class="btn btn-reponsive btn-primary pull-right UpdateAttendance" data-mydate="{{$date}}" data-emptype="{{$type}}" style="margin-top: -16px;">Review Today's Attendance</button></td>	
												@endif									
													 							
										</tr>
							

							<button  data-toggle="modal" data-target="#importAttendanceModal" class="btn btn-primary pull-right" style="margin-top: -16px;margin-right: 10px;">Upload Attendance Excel</button>
							<!-- <button type="submit" data-toggle="modal" data-target=".empList-modal-lg" class="btn btn-primary pull-right" style="margin-top: -16px;margin-right: 10px;">Upload Attendance Excel</button>

								<a href="{{URL('/hrManager/export/attendance-sheet')}}" class="btn btn-warning pull-right" style="margin-top: -16px;margin-right: 10px;">Export Attendance</a> -->
						</div>
						<div class="col-md-12">
							<h2 class="pull-left">Attendance Report of Month {{date("F", strtotime('2018-'.$current_month.'-01'))}} of {{$search_year}}</h2>
						</div>
					</div>
						<div class="panel-body" style="padding:0px 20px">
							<div class="col-md-12 colorpanel table-responsive">
								<table  class="display colorpaneltable" cellspacing="0" width="auto" style="float: left;border-right: 1px solid #e4e4e4">
									<tr>
										<td class="colorswach P"></td>
										<td>Present</td>
										<td class="colorswach HD"></td>
										<td>Half Day</td>
										<td class="colorswach UI"></td>
										<td>Un-Informed Leave</td>
										<td class="colorswach OT"></td>
										<td>Over Time</td>
										<td class="colorswach AB"></td>
										<td>Absent</td>
										<td class="colorswach myHoliday"></td>
										<td>Company Holiday</td>
										<td class="colorswach sun"></td>
										<td>Weekend</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="panel-body">				
							<div class="" style="overflow:hidden; position: relative;">
								<table  class="display table cell-border" cellspacing="0" width="100%" style="width: 25%;float: left;border-right: 1px solid #e4e4e4">
									<tr>
										<th style="border: 1px solid #ddd;">EmpId</th>
										<th style="border: 1px solid #ddd;">EmpName</th>
									</tr>
									
									@foreach ($employees as $employee)
									<tr>
										@if($employee)
											<td>{{$employee->employee_id}}</td>
											<td style="white-space:nowrap;">{{$employee->first_name}} {{$employee->last_name}}</td>
										@endif
									</tr>                                          
									@endforeach
								</table> 
								<table class="display table cell-border hr_sale attenreg" cellspacing="0" width="100%" style="width: 75%;display: inline-block;overflow-x: scroll;">
									<tr>
										@for ($i = 1; $i <= $day_in_month; $i++)
										<th style="border: 1px solid #ddd;">
										   {{str_pad($i, 2, "0", STR_PAD_LEFT)}}
											<?php $date=$search_year.'-'.$current_month.'-'.$i; 
											  $get_name = date('l', strtotime($date)); 
											  $day_name = substr($get_name, 0, 3); 
											?>
											<span>{{$day_name}}</span></th>
											@endfor
									</tr>
										@foreach ($employees as $employee)
										<tr>									
											@for ($i = 1; $i <= $day_in_month; $i++)
											<?php 
												$date=$search_year.'-'.$current_month.'-'.$i; 
												$hdate=str_pad($current_month, 2, "0", STR_PAD_LEFT).'/'.str_pad($i, 2, "0", STR_PAD_LEFT).'/'.$search_year; 
												$get_name = date('l', strtotime($date)); 
												$day_name = substr($get_name, 0, 3); 
											?>
											@if($day_name == "Sat" || $day_name =="Sun")
											<td class="sun"><span>{{$day_name}}</span> </td>
											@elseif(isHoliday($hdate,$emp_type))
											<td class="myHoliday">
												<span></span> 
											</td>
											@else
											<td class="{{getAttendanceBydate($search_year.'-'.$current_month.'-'.$i,$employee->employee_id)}}">
												<span>
													{{getAttendanceBydate($search_year.'-'.$current_month.'-'.$i,$employee->employee_id)}}</span> 
												</td>

												@endif

												@endfor
										</tr>    

											@endforeach
										<tr>											
											@for ($i = 1; $i <= $day_in_month; $i++)
												<?php 											
												$date=$search_year.'-'.$current_month.'-'.$i;							
												$hdate=str_pad($current_month, 2, "0", STR_PAD_LEFT).'/'.str_pad($i, 2, "0", STR_PAD_LEFT).'/'.$search_year;  		
												$get_name = date('l', strtotime($date)); 										
												$day_name = substr($get_name, 0, 3); 								
												$curdate=strtotime(date('Y-m-d'));						
												$mydate=strtotime($date);								
												?>											
												@if(isHoliday($hdate,$emp_type)|| $day_name == "Sat" || $day_name =="Sun" || $curdate < $mydate)			
													<td ></td>									
												@else										
													<td><a class="btn btn-reponsive btn-primary UpdateAttendance" data-mydate="{{$date}}" data-emptype="{{$type}}">Edit</a></td>	
												@endif									
											@endfor			 							
										</tr>
								</table> 
							</div>
						</div>
				</div>
			</div>
		</div><!-- Row -->
				</div><!-- Main Wrapper -->
				<div class="page-footer">
					<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
				</div>

				<!-- Modal -->
				{{--<div class="modal fade empList-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<form class="modal-content" action="{{URL('hrManager/submitAttendance')}}" id="assignAssetForm" method="post">
							{{csrf_field()}}
							<input type="hidden" name="attendanceDate" id="attendanceDate" value="{{date('Y-m-d')}}">
							<div class="modal-body ">
								<div class="panel panel-white">
									<div class="panel-heading clearfix">
										<h4 class="panel-title" id="msg">Add Attendance for {{date('Y-m-d')}}</h4>	
									</div>
									
									<div class="panel-body">
										<div class="table-responsive" style="overflow: hidden;">
											<table id="example1" class="display table" style="width: 100%; cellspacing: 0;">
												<thead>
													<tr>
														<th>Employee Id</th>
														<th>Employee Name</th>
														<th>In Time</th>
														<th>Out Time</th>
														<th>Action</th>
														<th>Late Login</th>
													</tr>
												</thead>
												<tbody id="myAttendanceData">
													@foreach($employees as $key => $employee)
													<tr>
														<td><b>
															{{$employee->employee_id}}</b> 
															<input type="hidden" name="attendance[{{$key}}][employee_id]" value="{{$employee->employee_id}}">
														</td>
														<td>{{$employee->first_name}} {{$employee->last_name}}</td>
														<td>{{ ($employee->in_time) ? $employee->in_time : "N/A"  }}</td>
														<td>{{ ($employee->out_time) ? $employee->out_time : "N/A"  }}</td> 
														<td>
															<select id="at_status ST{{$employee->employee_id}}" 
															       class="{{getAttendanceBydate(date('Y-m-d'),$employee->employee_id)}}" 
																   name="attendance[{{$key}}][status]" onchange="changeColor(this,'ST{{$employee->employee_id}}')">
																@foreach($dayTypes as $dayType)
																<option class="{{$dayType->short_name}}" style="color:#262626;" value="{{$dayType->short_name}}"
																	@if(getAttendanceBydate(date('Y-m-d'),$employee->employee_id) == $dayType->short_name)
																	selected
																	@endif
																	>{{$dayType->short_name}}</option>
																	@endforeach
															</select> 
														</td>
														<td>
															<select id="latelogin" name="latelogin">
																<option value="0">No</option>
																<option value="1">Yes</option>
															</select>	
														</td>
													</tr>
														@endforeach
													</tbody>

											</table> 
											</div>



										</div>

									</div>

								</div>

								<div class="modal-footer">

									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

									<button type="submit"  class="btn btn-success">Update</button>

								</div>
						</form> 
						</div>
				</div>--}}
				
				
				
	</div>
</div><!-- Page Inner -->

 <!-- Upload Attendance Model -->
    <div class="modal fade" id="importAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-body">
				<div class="panel panel-white">
					<div class="panel-heading clearfix">
						<h4 class="panel-title" id="msg">Upload Attendance Excel Sheet</h4>	
					</div>
					<div class="panel-body">
						<form class="form-horizontal" >
							{{csrf_field()}}
							<div class="form-group">
								<label for="assetFile" class="col-sm-2 control-label">File</label>
								<div class="col-sm-10">
									<input type="file" class="form-control" id="assetFile" name="assetFile">	
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a  id="uploadAsset"  class="btn btn-success">Update</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Review Today's Attendance -->
	 <div class="modal fade" id="empListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-body">
				<div class="panel panel-white">
					<div class="panel-heading clearfix">
						<h4 class="panel-title" id="msg">Review Today's Attendance</h4>	
					</div>
					<div class="panel-body">
						<form class="form-horizontal" >
							{{csrf_field()}}
							<div class="form-group">
								<label for="assetFile" class="col-sm-2 control-label">File</label>
								<div class="col-sm-10">
									<input type="file" class="form-control" id="assetFile" name="assetFile">	
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a  id="uploadAsset"  class="btn btn-success">Update</a>
					</div>
				</div>
			</div>
		</div>
	</div>


	@endsection

	@section('script')
	{{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
		var oldValue = "";
		$(document).on('click','.UpdateAttendance',function(){
			
			    var mydate  = $(this).data('mydate');
		        var emptype = $(this).data('emptype');
				
				var url = "?at_date="+mydate+"&type="+emptype;
				 BootstrapDialog.show({
						title:"Update Attendance.",
						message: $('<div> Please wait loading page... </div>').load('{{route("daily_attendance")}}'+url),
						buttons:[{
							label:"Submit",
							cssClass:"btn btn-success",
							action: function(dialog){
								formData = $('#updateAttendence').serializeArray();
								//console.log(formData);  
								
								$.ajax({
									url:"{{ route('update_daily_attendance') }}",
									type:"POST",
									data:formData,
									success:function(data){
										swal('Success','Attendance update successfully.','success');	
										setTimeout(function(){ 
											window.location.reload();
										}, 2000);
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
		
		
		$(document).on('focus','.at_status',function(e){
			oldValue = $(this).val();
			console.log(oldValue); 
		});
		
	    $(document).on('change','.at_status',function(e){
			    var key = $(this).attr('rel'); 
			    var $html = '<div class="panel-body"> <form class="form-horizontal" > <div class="form-group"> <label for="old_password" class="col-sm-2 control-label">Remark : </label> <div class="col-sm-10"> <textarea  rows="5" class="form-control" name="remark" id="remark"></textarea> </div> </div> </form> </div>'; 
                BootstrapDialog.show({
					            title:"Add Remark.",
					            message: $html,
					            buttons:[{
					                label:"Submit",
					                cssClass:"btn btn-success",
					                action: function(dialog){ 
									    
					                	 if($('#remark').val()==""){
											$('#remark').focus();
										 }else{
											 $("input[name*='attendance["+ key +"][remark]']").val($('#remark').val());
											 dialog.close();  
										 } 
					                }
					            },{
					                label:"Close",
					                cssClass:"btn btn-danger",
					                action: function(dialog){
					                    dialog.close();  
									    $(this).val(oldValue).trigger('change');		
					                }
					            }]
				});
		});
			/////////////////////////////////////////////////////////////////////////////////////////////////////

				$('#example').DataTable({
					"scrollX":true,
					"scrollY":false,
					"ordering":false,
					"paging":false,
				});
    	
	});
             $(document).on('click','#uploadAsset',function(){ 
						var assetFile = document.querySelector('#assetFile');
						if(assetFile.files[0]) {
							var file_data = $('#assetFile').prop('files')[0];
							var form_data = new FormData();
							form_data.append('assetFile', file_data);
							$.ajaxSetup({
								headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
							});
							var url  = "{{URL('/hrManager/import/attendance-sheet')}}";
							$.ajax({
								url: url,
								type: 'POST',
								data: form_data,
								success: function (data) {
									if(data.flag){
										$('#importAssetModal').modal('toggle');
										swal('Success','File Upload Successfully','success');	
										setTimeout(function(){
											window.location.reload();
										}, 2000);
									}else{
										$('#importAssetModal').modal('toggle');
										swal('Oops',data.error,'warning');	
									}
								},
								error: function(data){
										$('#importAssetModal').modal('toggle');
										swal('Oops'," Invalid Excel formate !",'warning');          
								},
								contentType: false,
								cache: false,
								processData: false
							});
						} 
					});

				function makeAttendance(employees_id,mydate,t){
					alert(t.value);
				}

				

				$(document).ready(function(){
					$('#assignAssetForm').submit(function(){
						var url = $('#assignAssetForm').attr('action');
						var mydata = $('#assignAssetForm').serialize();
						//console.log(mydata);
						$.ajax({
							url:url,
							data:mydata,
							dataType:'json',
							type:'post',
							success:function(responce){
								if(responce.success == true){
									$('#myModal').modal('hide');
									location.reload();
								}
							},
							error:function(responce){
								console.log(responce.responseText);
							}
						});
						return false;
					});

					

					$('#uploadAttendance').on('click',function(){
						var attendanceFile = document.querySelector('#attendanceFile');
						if(attendanceFile.files[0]) {
							var file_data = $('#attendanceFile').prop('files')[0];
							var form_data = new FormData();
							form_data.append('attendanceFile', file_data);
							$.ajaxSetup({
								headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
							});
							var url  = "{{URL('/hrManager/import/attendance-sheet')}}";
							$.ajax({
								url: url,
								type: 'POST',
								data: form_data,
								success: function (data) {
									if(data.flag){
										$('.empList-modal-lg').modal('toggle');
										swal('Success','File Upload Successfully','success');	
									}else{
										$('.empList-modal-lg').modal('toggle');
										swal('Oops',data.error,'warning');	
									}
								},
								contentType: false,
								cache: false,
								processData: false

							});

						}
					});
				});
			</script>
@endsection
