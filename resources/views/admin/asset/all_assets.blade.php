@extends('admin.layouts.app')

@section('content')

@section('title','Asset')



<div class="page-inner">

	<div class="page-title">

		<h3>Asset </h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>

				<li class="active">Asset list</li>

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

						<h4 class="panel-title">Select asset for view</h4>

					</div>

					<div class="panel-body">

						<form class="form-horizontal" action="{{URL('/admin/assets/all_assets')}}" method="post" enctype="multipart/form-data" id="form" >

							<div class="box-body">

								{{csrf_field()}}

								<div class="form-group">

									<label for="asset_type" class="col-sm-2 control-label">Asset Type</label>

									<div class="col-sm-10">

										<select name="asset_type" id="asset_type" class="form-control select2" >

											<option value="">--Select Asset Type--</option>

											@foreach($asset_types as $asset_type )

											<option value="{{$asset_type->id}}">{{$asset_type->type}}</option>

											@endforeach

										</select>

										@if ($errors->has('asset_type'))

										<span class="label label-danger">{{ $errors->first('asset_type') }}</span>

										@endif

									</div>

								</div>



								<div class="form-group">

									<label for="asset" class="col-sm-2 control-label">Asset</label>

									<div class="col-sm-10">

										<select name="asset" id="asset" class="form-control select2"  required="required">

											<option value="">--Select Asset --</option>

										</select>

										@if ($errors->has('asset'))

										<span class="label label-danger">{{ $errors->first('asset') }}</span>

										@endif

									</div>

								</div>



								

							</div>

							<!-- /.box-body -->

							<div class="box-footer">

								<a href="{{URL('admin/assets/all_assets')}}" class="btn btn-default">Cancel</a>

								<button type="submit" class="btn btn-info pull-right">Show</button>

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



		// $("#is_warranty").on('change',function(e){

		// 	var is_warranty = e.target.value;

		// 	console.log(is_warranty);

		// 	if(is_warranty == 1){

		// 		$('#warranty_end_date_div').show();

		// 		$('#warranty_end_date').removeAttr('disabled');

		// 		$('#warranty_end_date').attr('required','required');

		// 	}else{

		// 		$('#warranty_end_date_div').hide();

		// 		$('#warranty_end_date').attr('disabled');

		// 	}

		// })

		// $("#system_id").on('change',function(e){

		// 	var system_id = $('#system_id option:selected').val();

		// 	if(system_id != ""){

		// 		$("#asset_status").empty();

		// 		$("#asset_status").append(`<option value="assigned">Assigned</option>`);

		// 	}else{

		// 		$("#asset_status").empty();

		// 		$("#asset_status").append(`<option value="">--Select Status--</option>

		// 			<option value="free">Free</option><option value="discarded">Discarded</option>`);

		// 	}

		// })

		// var system_id = $('#system_id option:selected').val();

		// if(system_id != ""){

		// 	$("#asset_status").empty();

		// 	$("#asset_status").append(`<option value="assigned">Assigned</option>`);

		// }else{

		// 	$("#asset_status").empty();

		// 	$("#asset_status").append(`<option value="">--Select Status--</option>

		// 		<option value="free">Free</option><option value="discarded">Discarded</option>`);

		// }

	});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
<script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#form" ).validate({
  rules: {
    asset_type: {
      required: true
    }
    asset: {
      required: true
    }
  }
});
</script>

@endsection

@endsection