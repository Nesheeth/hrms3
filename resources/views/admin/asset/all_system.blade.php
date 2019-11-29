@extends('admin.layouts.app')



@section('content')



@section('title','System')







<div class="page-inner">



	<div class="page-title">



		<h3>System</h3>



		<div class="page-breadcrumb">



			<ol class="breadcrumb">



				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>



				<li><a href="{{URL('/admin/assets/all_system')}}">System</a></li>



				<li class="active">View Systems</li>



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



						<h4 class="panel-title">View Systems list </h4>



					</div>



					<div class="panel-body">



						<form class="form-horizontal" action="{{url('/admin/assets/all_system')}}" method="post" enctype="multipart/form-data">



							<div class="box-body">



								{{csrf_field()}}



								<div class="form-group">



									<label for="asset_type" class="col-sm-2 control-label">Asset Type</label>



									<div class="col-sm-10">



										<select name="asset_type" id="asset_type" class="form-control select2"  required="required">



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



									<label for="system_name" class="col-sm-2 control-label">System Name</label>



									<div class="col-sm-10">



										<select name="system_name" id="system_name" class="form-control select2"  required="required">



											<option value="">--Select System Name--</option>



										</select>



										@if ($errors->has('system_name'))



										<span class="label label-danger">{{ $errors->first('system_name') }}</span>



										@endif



									</div>



								</div>



								





							</div>



							<!-- /.box-body -->



							<div class="box-footer">



								<a href="{{URL('/admin/assets/all_system')}}" class="btn btn-default">Cancel</a>



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



			url = "{{URL('admin/asset_master/')}}";



			$.get(url+'/'+asset_type_id, function(data) {



				$("#system_name").empty();



				$("#system_name").append('<option value="">--Select Master Asset--</option>');



				$.each(data, function(index, system_name) {



					$("#system_name").append('<option value="'+system_name.id+'">'+system_name.name+'</option>');



				});



			});



		})



		// $("#system_name").on('change',function(e){



		// 	var system_name_id = e.target.value;



		// 	if(system_name_id != ""){



		// 		url = "{{URL('/getNewSystemId/')}}";



		// 		$.get(url, function(system_data) {



		// 			if(system_data.flag){



		// 				maste_url = "{{URL('/getMasterSystemById/')}}";



		// 				$.get(maste_url+'/'+system_name_id, function(master_data) {



		// 					if(master_data.flag){



		// 						$("#system_code").empty();



		// 						$("#system_code").val(master_data.master_system.asset_code+"00"+(system_data.system.id+1));



		// 						$("#system_code").attr('disabled','disabled');



		// 						$(".system_code").show();



		// 					}



		// 				});











		// 			}



		// 		});



		// 	}else{



		// 		$(".system_code").hide();



		// 	}



		// })



		



	});



</script>



@endsection



@endsection