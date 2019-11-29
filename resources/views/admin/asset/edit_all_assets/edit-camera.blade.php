@extends('admin.layouts.app')

@section('content')

@section('title','Asset')



<div class="page-inner">

	<div class="page-title">

		<h3>Asset</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

				<li><a href="{{URL('/admin/assets/all_assets')}}">Asset</a></li>

				<li class="active">Update Asset Camera</li>

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

						<h4 class="panel-title">Update Asset Camera</h4>

					</div>

					<div class="panel-body">

						<form class="form-horizontal" method="post" action="{{URL('/admin/camera/update')}}" enctype="multipart/form-data">

							<div class="box-body">

								{{csrf_field()}}

								<input type="hidden" name="id" value="{{$asset->id}}">

								<div class="form-group">

									<label for="asset_type" class="col-sm-2 control-label">Asset Type</label>

									<div class="col-sm-10">

										<select name="asset_type" id="asset_type" class="form-control select2"  required="required" >

											<option value="{{$asset->asset_type_id}}">{{getAssoc_name($asset->asset_type_id)}}</option>
										</select>

										@if ($errors->has('asset_type'))

										<span class="label label-danger">{{ $errors->first('asset_type') }}</span>

										@endif

									</div>

								</div>



								<div class="form-group">

									<label for="asset" class="col-sm-2 control-label">Asset</label>

									<div class="col-sm-10">

										<select name="asset" id="asset" class="form-control select2"  required="required" >

											<option class="nsns" value="{{$asset->asset_id}}">{{$asset->asset->name}}</option>

										</select>

										@if ($errors->has('asset'))

										<span class="label label-danger">{{ $errors->first('asset') }}</span>

										@endif

									</div>

								</div>



								<div class="form-group">

									<label for="s_no" class="col-sm-2 control-label">S.No</label>

									<div class="col-sm-10">

										<input type="text" name="s_no" id="s_no" value="{{$asset->s_no}}" class="form-control">

										@if ($errors->has('s_no'))

										<span class="label label-danger">{{ $errors->first('s_no') }}</span>

										@endif

									</div>

								</div>
                                <div class="form-group">
									<label for="s_no" class="col-sm-2 control-label">Description</label>
									<div class="col-sm-10">
										<input type="text" name="description" id="description" class="form-control" value="{{$asset->descriptions}}">
										@if ($errors->has('description'))
										<span class="label label-danger">{{ $errors->first('description') }}</span>
										@endif
									</div>
								</div>


								<div class="form-group">

									<label for="purchase_bill_date" class="col-sm-2 control-label">Purchase/Bill Date</label>

									<div class="col-sm-10">

										<input type="text" name="purchase_bill_date" value="{{$asset->purchase_bill_date}}" id="purchase_bill_date" class="form-control datepicker">

										@if ($errors->has('purchase_bill_date'))

										<span class="label label-danger">{{ $errors->first('purchase_bill_date') }}</span>

										@endif

									</div>

								</div>



								<div class="form-group">

									<label for="repair_replacement_date" class="col-sm-2 control-label">Repair/Replacement Date</label>

									<div class="col-sm-10">

										<input type="text" name="repair_replacement_date" id="repair_replacement_date" value="{{$asset->repair_replacement_date}}" class="form-control datepicker">

										@if ($errors->has('repair_replacement_date'))

										<span class="label label-danger">{{ $errors->first('repair_replacement_date') }}</span>

										@endif

									</div>

								</div>
								<div class="form-group">

									<label for="repair_replacement_date" class="col-sm-2 control-label">Purchase from store</label>

									<div class="col-sm-10">

										<input type="text" name="purchase_from_store" id="purchase_from_store" value="{{$asset->purchase_from_store}}" class="form-control">

										@if ($errors->has('purchase_from_store'))

										<span class="label label-danger">{{ $errors->first('purchase_from_store') }}</span>

										@endif

									</div>

								</div>

								<div class="form-group">

									<label for="is_warranty" class="col-sm-2 control-label">Warranty</label>

									<div class="col-sm-10">

										<select name="is_warranty" id="is_warranty"  class="form-control select2">

											<option value="">--Select Warranty--</option>

											<option value="1" {{$asset->is_warranty == 1 ? "selected":""}}>Yes</option>

											<option value="0" {{$asset->is_warranty == 0 ? "selected":""}}>No</option>

										</select>

									</div>

								</div>



								<div class="form-group" id="warranty_end_date_div" style="display: {{$asset->is_warranty == 1 ? "block":"none"}};">

									<label for="warranty_end_date" class="col-sm-2 control-label">Warranty End Date</label>

									<div class="col-sm-10">

										<input type="text" name="warranty_end_date" value="{{$asset->warranty_end_date}}" id="warranty_end_date" class="form-control datepicker">

										@if ($errors->has('warranty_end_date'))

										<span class="label label-danger">{{ $errors->first('warranty_end_date') }}</span>

										@endif

									</div>

								</div>
								<div class="form-group">

									<label for="system_type_id" class="col-sm-2 control-label">System Type</label>

									<div class="col-sm-10">

										<select class="form-control select2" name="system_type_id" id="system_type_id" style="width: 100%;">

											<option value="">--Select System Type--</option>

											@foreach($system_type as $system_type)

											<option value="{{$system_type->id}}">{{$system_type->name}} </option>

											@endforeach

										</select>

									</div>

								</div>



								<div class="form-group">

									<label for="system_id" class="col-sm-2 control-label">Assign To System</label>

									<div class="col-sm-10">

										<select class="form-control select2" name="system_id" id="system_id" style="width: 100%;">

											<option value="">--Select System--</option>

											

										</select>

									</div>

								</div>



								<div class="form-group">

									<label for="asset_status" class="col-sm-2 control-label">Status</label>

									<div class="col-sm-10">

										<select class="form-control" name="asset_status" id="asset_status" style="width: 100%;">

											@if(is_null($asset->system_id))

											<option value="free" s {{$asset->status == "free" ? "selected":""}}>Free</option>

											<option value="discarded" {{$asset->status == "discarded" ? "selected":""}}>Discarded</option>

											@else

											<option value="assigned" {{$asset->status == "assigned" ? "selected":""}}>Assigned</option>

											@endif

										</select>

										@if ($errors->has('asset_status'))

										<span class="label label-danger">{{ $errors->first('asset_status') }}</span>

										@endif

									</div>

								</div>



							</div>

							<!-- /.box-body -->

							<div class="box-footer">

								<a href="{{URL('/admin/assets/all_assets')}}" class="btn btn-default">Cancel</a>

								<button type="submit" class="btn btn-info pull-right">Update</button>

							</div>

							<!-- /.box-footer -->

						</form>

					</div>

				</div>

			</div>

		</div><!-- Row -->

	</div><!-- Main Wrapper -->

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

		$("#asset_type").on('change',function(e){

			var asset_type_id = e.target.value;

			url = "{{URL('admin/assetsByAssetType/')}}";

			$.get(url+'/'+asset_type_id, function(data) {

				$("#asset").empty();

				$("#asset").append('<option value="">--Select Asset--</option>');

				$.each(data, function(index, asset) {

					$("#asset").append('<option value="'+asset.id+'">'+asset.name+'</option>');

				});

			});

		})



		$("#is_warranty").on('change',function(e){

			var is_warranty = e.target.value;

			console.log(is_warranty);

			if(is_warranty == 1){

				$('#warranty_end_date_div').show();

				$('#warranty_end_date').removeAttr('disabled');

				$('#warranty_end_date').attr('required','required');

			}else{

				$('#warranty_end_date_div').hide();

				$('#warranty_end_date').attr('disabled');

			}

		})

		$("#system_id").on('change',function(e){

			var system_id = $('#system_id option:selected').val();

			if(system_id != ""){

				$("#asset_status").empty();

				$("#asset_status").append(`<option value="assigned">Assigned</option>`);

			}else{

				$("#asset_status").empty();

				$("#asset_status").append(`<option value="">--Select Status--</option>

					<option value="free">Free</option><option value="discarded">Discarded</option>`);

			}

		})

		// var system_id = $('#system_id option:selected').val();

		// if(system_id != ""){

		// 	$("#asset_status").empty();

		// 	$("#asset_status").append(`<option value="assigned">Assigned</option>`);

		// }else{

		// 	$("#asset_status").empty();

		// 	$("#asset_status").append(`<option value="">--Select Status--</option>

		// 		<option value="free">Free</option><option value="discarded">Discarded</option>`);

		// }
		$('#system_type_id').change(function(){
           var system_type_id =  $('#system_type_id').val();
           var asset_type_id =  $('#asset').val(); 
            
            url = "{{URL('admin/systemBySystemType/')}}";

			$.get(url+'/'+system_type_id+'/'+asset_type_id, function(data) {
                 //console.log(data);
                 if(data.flag){
				$("#system_id").empty();

				$("#system_id").append('<option value="">--Select System--</option>');
                
				$.each(data.systems, function(index, system) {
                    // console.log(system);
                     
					$("#system_id").append('<option value="'+system.id+'">'+system.system_id+'</option>');
                    
				});
             }
             else{
               $("#system_id").empty();
             	swal('Oops','No System free','error');	
             }

			})

		});

	});

</script>

@endsection

@endsection