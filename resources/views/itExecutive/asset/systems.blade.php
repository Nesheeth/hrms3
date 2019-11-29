@extends('admin.layouts.app')



@section('content')



@section('title','System')







<div class="page-inner">



	<div class="page-title">



		<h3>System</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/itExecutive/dashboard')}}">Home</a></li>



				<li class="active"><a href="{{URL('/itExecutive/assets/all_system')}}">System</a></li>



			</ol>



		</div>



	</div>



	<div id="main-wrapper">



		<div class="row">



			<div class="col-md-12">



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



				<div class="panel panel-white">



					<div class="panel-heading clearfix">



						<a href="{{URL('/itExecutive/export_desktop/system-sheet')}}" class="btn btn-danger pull-right" style="margin-top: -16px;margin-right: 10px;">Export Systems</a>



                       <a data-toggle="modal" data-target="#importData" class="btn btn-info pull-right" style="margin-top: -16px;margin-right: 10px;">Import Systems</a>

					</div>



					<div class="panel-body">



						<div class="table-responsive table-remove-padding">



							<table class="table" id="datatable">



								<thead>



									<tr>

                                        <th style="display:none;">System id</th>

										<th>System Code</th>



										<th>Name</th>



										<th>Assigned To</th>



										<th>Status</th>



										<th>Action</th>

										<th style="display:none;">Descriptions</th>



									</tr>



								</thead>



								<tbody>



									@foreach($systems as $system)



									<tr>

                                        <td style="display:none;">{{$system->id}}</td>

										<td>{{$system->system_id}}</td>



										<td>{{$system->name}}</td>



										<td>



											@if(!is_null($system->assign_to))



											

												<span style="color: #900ba9;">{{getEmpId($system->assign_to)}} </span>  {{getUserById($system->assign_to)->first_name}} {{getUserById($system->assign_to)->last_name}}</td>



											@else



											<b>N/A</b>



											@endif



										</td>



										<td>



											@if(is_null($system->assign_to))



											<b>Free</b>



											@else



											<b>Assigned</b>



											@endif



										</td>



										<td>



											<a class="btn btn-danger" href="#" onclick="getSystem({{$system->id}},{{$system->master_system_id}})" data-toggle="modal" data-target=".view-asset-list">View Details</a> 



											<a class="btn btn-primary" href="{{URL('/itExecutive/system/'.$system->id.'/'.$system->master_system_id)}}">Edit</a>



										</td>



                                         <td style ="display:none;">{{getAssetDescriptionsById(getSystemAssetById($system->id))}}</td>





									</tr>



									@endforeach



								</tbody>



							</table>



						</div>



					</div>



				</div>



			</div>



		</div><!-- Row -->



	</div><!-- Main Wrapper -->



	<!-- Modal -->

  <div class="modal fade" id="importData" role="dialog">

    <div class="modal-dialog">

    

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Upload System Excel Sheet</h4>

        </div>

        <div class="modal-body">

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

          <button type="button" class="btn btn-success" id="uploadAsset">Submit</button> 

        </div>

      </div>

      

    </div>

  </div>



	<div class="page-footer">



		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>



	</div>



	











</div><!-- Page Inner -->















<div class="modal fade view-asset-list" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">



	<div class="modal-dialog modal-sm">



		<div class="modal-content">



			<div class="modal-header">



				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>



				<h4 class="modal-title" id="mySmallModalLabel" ><i class="fa fa-cogs fa-2x assetName" aria-hidden="true"> Assigned Assets</i></h4>



				<p>System Code:1110</p>



			</div>



			<div class="modal-body">



				<h5>Assigned To:<span id="assignedTo"></span></h5>







				<div class="table-responsive table-remove-padding">



					<table class="table">



						<thead>



							<tr>



								<th>Assets Code</th>



								<th>Assets Name</th>



								<th>Descriptions</th>



							</tr>



						</thead>



						<tbody id="assignedAssets">



						</tbody>



					</table>



				</div>



			</div>



			<div class="modal-footer">



				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>







			</div>



		</div>



	</div>



</div>







@section('script')



<script>



	$('#uploadAsset').on('click',function(){

		var assetFile = document.querySelector('#assetFile');

		if(assetFile.files[0]) {

			var file_data = $('#assetFile').prop('files')[0];

			var form_data = new FormData();

			form_data.append('assetFile', file_data);

			form_data.append('type', "system"); 

			$.ajaxSetup({

				headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}

			});

			

			$.ajax({

				url: "{{route('it.uploadsystem')}}",

				type: 'POST',

				data: form_data,

				success: function (data) {

					if(data.flag){

						$('#importData').modal('toggle');

						swal('Success','File Upload Successfully','success');	

						setTimeout(function(){

							window.location.reload();

						}, 2000);

					}else{

						$('#importData').modal('toggle');

						swal('Oops',data.error,'warning');	

					}

				},

				contentType: false,

				cache: false,

				processData: false

			});

		}

	});



	function getSystem(id,master_system_id){



		var systemUrl = "{{URL('/getSystem/')}}";



		$.get(systemUrl+'/'+id+'/'+master_system_id, function(data) {



			if(data.flag){



				var userUrl = "{{URL('/getUser/')}}";



				if(data.system.assign_to == null){



					var username = "N/A";



					$('#assignedTo').text(' '+username);



				}else{



					$.get(userUrl+'/'+data.system.assign_to, function(data) {



						if(data.flag){



							var username = data.user.first_name+' '+data.user.last_name;



							$('#assignedTo').text(' '+username);



						}



					});



				}



				$('.assetName').text(data.system.name+' ('+data.system.system_id+')');



				$("#assignedAssets").empty();



				$.each(data.system.assets, function(index, asset) {

                     

					var assetUrl = "{{URL('/getAsset/')}}";



					$.get(assetUrl+'/'+asset.asset_id+'/'+asset.asset_type_id, function(data) {



						if(data.flag){



							



							if(data.asset.s_no == null){



								s_no = "<b>N/A</b>";



							}else{



								s_no = data.asset.s_no;



							}

                            if(asset.asset_type_id == 1){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/monitor/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/monitor/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 2){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/keyboard/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/keyboard/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 3){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/mouse/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/mouse/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 4){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/cabinet/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/cabinet/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 5){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/motherboard/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/motherboard/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 6){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/ram/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/ram/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 7){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/processer/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/processer/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 8){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/ups_battery/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/ups_battery/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 9){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/smps/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/smps/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 10){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/hdd/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/hdd/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 11){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/desktop/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/desktop/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 12){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/laptop/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/laptop/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 13){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/mac_mini/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/mac_mini/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 14){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/i_mac/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/i_mac/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 15){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/network_switch/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/network_switch/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 16){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/router/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/router/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 17){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/repeater/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/repeater/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 18){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/ups/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/ups/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 19){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/pen_drive/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/pen_drive/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 20){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/dvr/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/dvr/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 21){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/camera/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/camera/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 22){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/web_cam/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/web_cam/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 23){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/printer/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/printer/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 24){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/chair/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/chair/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 25){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/desk/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/desk/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 26){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/fan/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="fan/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 27){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/ac/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/ac/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 28){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/almirah/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/almirah/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }

                             if(asset.asset_type_id == 29){

                            	$("#assignedAssets").append('<tr><td><a href="/itExecutive/headphone/'+data.asset.id+'">'+data.asset.asset_code+'</a></td><td><a href="/itExecutive/headphone/'+data.asset.id+'">'+data.asset.name+'</a></td><td>'+data.asset.descriptions+'</td></tr>');

                            }



                           

						}



					});



				});



			}else{



				swal('Oops','Something Went Wrong!','error')



			}



		});



	}



	function empList(id){



		$('.systemValue').val(id);



		$('.empList-modal-sm').modal('toggle');



	}



	function assignsystem(){



		var data = $('#assignsystemForm').serialize();



		var queryString = data.split('&');



		var emp = queryString[1].split('=');



		var system_id = $('.systemValue').val();



		var emp_id = emp[1];



		url = "{{URL('itExecutive/assignsystem/')}}";



		$.get(url+'/'+system_id+'/'+emp_id, function(data) {



			if(data.flag){



				$('.empList-modal-sm').modal('toggle');



				swal('Assigned','Assigned Successfully!','success');



				setTimeout(function(){



					location.reload();



				}, 2000)  



			}else{



				swal('Oops','Something Went Wrong!','error')







			}



		});



	}







	function releasesystem(system_id){



		var url = "{{URL('itExecutive/systemRelease/')}}";



		$.get(url+'/'+system_id, function(data) {



			if(data.flag){



				swal('Released','Released Successfully!','success');



				setTimeout(function(){



					location.reload();



				}, 2000)  



			}else{



				swal('Oops','Something Went Wrong!','error')



			}



		});



	}







	$('#uploadsystem').on('click',function(){



		var systemFile = document.querySelector('#systemFile');



		if(systemFile.files[0]) {



			var file_data = $('#systemFile').prop('files')[0];



			var form_data = new FormData();



			form_data.append('systemFile', file_data);



			$.ajaxSetup({



				headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}



			});



			var url  = "{{URL('/itExecutive/import/system-sheet')}}";



			$.ajax({



				url: url,



				type: 'POST',



				data: form_data,



				success: function (data) {

                       console.log(data);

					if(data.flag){



						$('.empList-modal-lg').modal('toggle');



						swal('Success','File Uploaded Successfully','success');	



						setTimeout(function(){



							window.location.reload();



						}, 2000);



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



</script>



@endsection



@endsection