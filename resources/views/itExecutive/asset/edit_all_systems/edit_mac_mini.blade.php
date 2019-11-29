@extends('admin.layouts.app')



@section('content')



@section('title','System')







<div class="page-inner">



	<div class="page-title">



		<h3>{{$system->name}} ({{$system->system_id}})</h3>

		<input type ="hidden"  id="system_id" value="{{$system->id}}">



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/itExecutive/dashboard')}}">Home</a></li>



				<li><a href="{{URL('/itExecutive/assets/all_system')}}">System</a></li>



				<li class="active">Update MacMini</li>



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



			</div>



			



			<div class="col-md-8">



				<div class="panel panel-white">



					<div class="panel-heading clearfix">



						<h4 class="panel-title">Update MAcMini</h4>



					</div>



					<div class="panel-body">



						<form class="form-horizontal" action="{{URL('/itExecutive/system/update/'.'5')}}" method="post" enctype="multipart/form-data">



							<div class="box-body">



								{{csrf_field()}}



								<input type="hidden" name="id" value="{{$system->id}}">

								<input type="hidden"  class="system_id" value="{{$system->master_system_id}}">



								<div class="form-group">



									<label for="asset_type" class="col-sm-2 control-label">Asset Type</label>



									<div class="col-sm-10">



										<select name="asset_type" id="asset_type" class="form-control select2"  required="required" style="width: 100%;">



											<option value="">--Select Asset Type--</option>



											@foreach($asset_types as $asset_type )



											<option value="{{$asset_type->id}}" {{$asset_type->id == $system->asset_type_id?"selected":""}}>{{$asset_type->type}}</option>



											@endforeach



										</select>



										@if ($errors->has('asset_type'))



										<span class="label label-danger">{{ $errors->first('asset_type') }}</span>



										@endif



									</div>



								</div>







								<div class="form-group">



									<label for="system_name" class="col-sm-2 control-label">System Name</label>



									<div class="col-sm-10">



										<select name="system_name" id="system_name" class="form-control select2"  required="required" style="width: 100%;">



											<option value="">--Select System Name--</option>



											



											@foreach($system_names as $system_name )



											<option value="{{$system_name->id}}" {{$system_name->id == $system->master_system_id?"selected":""}}>{{$system_name->name}}</option>



											@endforeach



										</select>



										@if ($errors->has('system_name'))



										<span class="label label-danger">{{ $errors->first('system_name') }}</span>



										@endif



									</div>



								</div>







								<div class="form-group">



									<label for="assign_to" class="col-sm-2 control-label">Assign To User</label>



									<div class="col-sm-10">



										<select class="form-control select2" name="assign_to" id="assign_to" style="width: 100%;">



											<option value="">--Select User--</option>



											<option value="">None</option>



											@foreach($employees as $employee)



											<option value="{{$employee->id}}" {{$employee->id == $system->assign_to?"selected":""}}>{{$employee->first_name}} {{$employee->last_name}}</option>



											@endforeach



										</select>



									</div>



								</div>







								<div class="form-group">



									<div class="col-md-7">



										



									</div>



								</div>







								







							</div>



							<!-- /.box-body -->



							<div class="box-footer">



								<a href="{{URL('/itExecutive/systems')}}" class="btn btn-default">Cancel</a>



								<button type="submit" class="btn btn-info pull-right">Update</button>



							</div>



							<!-- /.box-footer -->



						</form>



					</div>



				</div>



			</div>



			<div class="col-md-4">



				<div class="panel panel-white">



					<div class="panel-heading clearfix">



						<h4 class="panel-title">Assigned Assets List</h4>

                        <a href="" data-toggle="modal" id="openAssetModel" data-target="#assignAssetModel" class="btn btn-primary text-center pull-right">Assign Assets</a>

					</div>



					<div class="panel-body">



						<div class="table-responsive table-remove-padding">



							<table class="table">



								<thead>



									<tr>



										<th>Assets Name</th>



										<th>Action</th>



									</tr>



								</thead>



								<tbody>



									@foreach($system->assets as $system_asset)



									<tr>



										<td>{{getAssetById($system_asset->asset_id,$system_asset->asset_type_id)->name}}({{getAssetById($system_asset->asset_id,$system_asset->asset_type_id)->asset_code}})</td>



										<td><a class="btn btn-success" href="{{URL('/itExecutive/release-system-asset/'.$system_asset->system_id.'/'.$system_asset->id.'/'.$system_asset->asset_type_id.'/'.$system_asset->master_asset_id)}}">Release</a></td>







									</tr>



									@endforeach



								</tbody>



							</table>



						</div>



					</div>



				</div>



			</div>



			



			<!--</div>-->



		</div><!-- Row -->



	</div><!-- Main Wrapper -->



	<div class="modal fade" id="assignAssetModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">



		<div class="modal-dialog">



			<div class="modal-body">



				<div class="panel panel-white">



					<div class="panel-heading clearfix">



						<h4 class="panel-title" id="msg">Assign Assets</h4>	



					</div>



					<div class="panel-body">



						<form class="form-horizontal" id="assignAssetForm">



							<div class="form-group">



								<label for="asset_type1" class="col-sm-2 control-label">Asset Type</label>



								<div class="col-sm-10">



									<select name="asset_type1" id="asset_type1" class="form-control"  required="required">



										<option value="">--Select Asset Type--</option>



										@foreach($asset_types as $asset_type )



										<option value="{{$asset_type->id}}">{{$asset_type->type}}</option>



										@endforeach



									</select>



								</div>



							</div>







							<div class="form-group">



								<label for="asset" class="col-sm-2 control-label">Asset</label>



								<div class="col-sm-10">



									<select name="asset" id="asset" class="form-control"  required="required">



										<option value="">--Select Asset --</option>



									</select>



									@if ($errors->has('asset'))



									<span class="label label-danger">{{ $errors->first('asset') }}</span>



									@endif



								</div>



							</div>







							<div class="form-group">



								<label for="asset" class="col-sm-2 control-label">Free Asset</label>



								<div class="col-sm-10">



									<select name="free_asset" id="free_asset" class="form-control"  required="required">



										<option value="">--Select Asset --</option>



									</select>	



								</div>



							</div>



						</form>



					</div>



					<div class="modal-footer">



						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>



						<a  id="assignAssetBtn"  class="btn btn-success">Update</a>



					</div>



				</div>



			</div>







		</div>



	</div>



	<div class="page-footer">



		<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>



	</div>



</div><!-- Page Inner -->



@section('script')



{{ Html::script("assets/plugins/waves/waves.min.js") }}



{{ Html::script("assets/plugins/select2/js/select2.min.js") }}



{{ Html::script("assets/plugins/summernote-master/summernote.min.js") }}



{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}



{{ Html::script("assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js") }}



{{ Html::script("assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js") }}



{{ Html::script("assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js") }}



{{ Html::script("assets/js/pages/form-elements.js") }}



<script>



	$(document).ready(function() {



		$('.select2').select2();



		$("#asset_type").attr('disabled','disabled');



		$("#system_name").attr('disabled','disabled');



		$("#asset_type").on('change',function(e){



			var asset_type_id = e.target.value;



			url = "{{URL('itExecutive/asset_master/')}}";



			$.get(url+'/'+asset_type_id, function(data) {



				$("#system_name").empty();



				$("#system_name").append('<option value="">--Select Master Asset--</option>');



				$.each(data, function(index, system_name) {



					$("#system_name").append('<option value="'+system_name.id+'">'+system_name.name+'</option>');



				});



			});



		})



		$("#asset_type1").on('change',function(e){



			var asset_type_id = e.target.value;

			var system_id = $('#system_id').val();

			var asset_type_id = $('#asset_type1 option:selected').val();

            var master_asset_id = $('.system_id').val();

			url = "{{URL('itExecutive/getAssetByAssetType_unique/')}}";



			$.get(url+'/'+master_asset_id+'/'+asset_type_id,{system_id:system_id,asset_type_id:asset_type_id}, function(data) {







				$("#asset").empty();



				$("#asset").append('<option value="">--Select Asset--</option>');



				$.each(data, function(index, asset) {



					$("#asset").append('<option value="'+asset.id+'">'+asset.name+'</option>');



				});



			});



		})



		$("#asset").on('change',function(e){



			var asset_type_id = $('#asset_type1 option:selected').val();



			var asset_assoc_id = $('#asset option:selected').val();



			url = "{{URL('itExecutive/free_assets/')}}";



			$.get(url+'/'+asset_type_id+'/'+asset_assoc_id, function(data) {



				if(data.length == 0){



					swal('Oops','No Free Assets Found','error')



					$("#free_asset").empty();



					$("#free_asset").append('<option value="">--Select Free Asset--</option>');



				}else{



					$("#free_asset").empty();



					$("#free_asset").append('<option value="">--Select Free Asset--</option>');



					$.each(data, function(index, free_asset) {



						$("#free_asset").append('<option value="'+free_asset.id+'">'+free_asset.name+' '+free_asset.asset_code+'</option>');



					});



				}



			});



		})







		$("#assignAssetBtn").on('click',function(e){



			var asset_type1 = $('#asset_type1 option:selected').val();



			var asset_assoc_id = $('#asset option:selected').val();



			var free_asset_id = $('#free_asset option:selected').val();



			if(asset_type1 == ""){



				swal('Oops','Select Asset Type','error')



			}else if(asset_assoc_id == ""){



				swal('Oops','Select Asset','error')



			}else if(free_asset_id == ""){



				swal('Oops','Select Free Asset','error')



				



			}else{



				var data = $('#assignAssetForm').serialize();



				var queryString = data.split('&');



				var asset = queryString[2].split('=');



				var system_id = "{{$system->id}}";



				var asset_id = asset[1];



				console.log(asset_id);



				url = "{{URL('itExecutive/assignAsset_mac_mini/')}}";

				var data = "{{$system->system_id}}";



				$.get(url+'/'+system_id+'/'+asset_id+'/'+asset_assoc_id, {system_code:data},function(data) {



					if(data.flag){



						$('#assignAssetModel').modal('toggle');



						swal('Assigned','Assigned Successfully!','success');



						setTimeout(function(){



							location.reload();



						}, 2000)  



					}else{



						$('#assignAssetModel').modal('toggle');



						swal('Oops',data.error,'error')







					}



				});



			}



		})



	});



</script>



@endsection



@endsection