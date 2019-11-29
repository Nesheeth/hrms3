@extends('hrManager.layouts.app')

@section('content')

@section('title','Holidays')



<div class="page-inner">

	<div class="page-title">

		<h3>Holidays</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/hrManager/dashboard')}}">Home</a></li>

				<li><a href="{{URL('/hrManager/holidays')}}">Holidays</a></li>

				<li class="active">Add Holiday</li>

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



				<!-- add new code -->

				<div class="col-md-12">

					<div class="panel panel-white">

						<div class="panel-heading clearfix">

							<h3 class="panel-title">Add Holiday</h3>

						</div>

						<div class="panel-body">

							<div role="tabpanel">

								<!-- Nav tabs -->

								<ul class="nav nav-pills" role="tablist">

									<li role="presentation" class="active"><a href="#add-holiday" role="tab" data-toggle="tab">Add Holiday Form</a></li>

									<li role="presentation"><a href="#upload-holiday" role="tab" data-toggle="tab">Upload Holiday </a></li>

								</ul>

								<!-- Tab panes -->

								<div class="tab-content">

									<div role="tabpanel" class="tab-pane active fade in" id="add-holiday">

										<form class="form-horizontal" method="post" enctype="multipart/form-data">

											<div class="box-body">

												{{csrf_field()}}

												<div class="form-group">

													<label for="month" class="col-sm-2 control-label">Month</label>

													<div class="col-sm-10">

														<select name="month" class="select2 form-control" id="">

															<option value="">--Select Month--</option>

															<option value="1">January</option>

															<option value="2">February</option>

															<option value="3">March</option>

															<option value="4">April</option>

															<option value="5">May</option>

															<option value="6">June</option>

															<option value="7">July</option>

															<option value="8">August</option>

															<option value="9">September</option>

															<option value="10">October</option>

															<option value="11">November</option>

															<option value="12">December</option>

														</select>

														@if ($errors->has('month'))

														<span class="label label-danger">{{ $errors->first('month') }}</span>

														@endif

													</div>

												</div>

												<div class="form-group">

													<label for="date" class="col-sm-2 control-label">Date</label>

													<div class="col-sm-10">

														<input type="text" class="form-control datepicker" name="date">	

														@if ($errors->has('date'))

														<span class="label label-danger">{{ $errors->first('date') }}</span>

														@endif

													</div>

												</div>

												<div class="form-group">

													<label for="category" class="col-sm-2 control-label">Category</label>

													<div class="col-sm-10">

														<select name="category" class="select2 form-control" id="">

															<option value="">--Select Category--</option>

															<option value="development">Development</option>

															<option value="sales">Sales</option>

														</select>

														@if ($errors->has('category'))

														<span class="label label-danger">{{ $errors->first('category') }}</span>

														@endif

													</div>

												</div>

												<div class="form-group">

													<label for="comments" class="col-sm-2 control-label">Description</label>

													<div class="col-sm-10">

														<textarea name="comments" id="comments" cols="30" rows="10" class="form-control"></textarea>

														@if ($errors->has('comments'))

														<span class="label label-danger">{{ $errors->first('comments') }}</span>

														@endif

													</div>

												</div>

											</div>

											<!-- /.box-body -->

											<div class="box-footer">

												<a href="{{URL('/hrManager/holidays')}}" class="btn btn-default">Cancel</a>

												<button type="submit" class="btn btn-info pull-right">Add</button>

											</div>

											<!-- /.box-footer -->

										</form>



									</div>

									<div role="tabpanel" class="tab-pane fade" id="upload-holiday">

										<a href="{{URL('/hrManager/export/holiday-sheet')}}" class="btn btn-danger">Export Holiday Sheet</a>
										<a href="{{URL('/templates/HolidayTemplate.xls')}}" class="btn btn-warning">Export Holiday Template</a>

										<form class="form-horizontal" >

											<div class="box-body">

												{{csrf_field()}}

												<div class="form-group">

													<label for="holidayFile" class="col-sm-2 control-label">File</label>

													<div class="col-sm-10">

														<input type="file" class="form-control" id="holidayFile" name="holidayFile">	

														@if ($errors->has('holidayFile'))

														<span class="label label-danger">{{ $errors->first('holidayFile') }}</span>

														@endif

													</div>

												</div>

											</div>

											<!-- /.box-body -->

											<div class="box-footer">

												<a href="{{URL('/hrManager/holidays')}}" class="btn btn-default">Cancel</a>

												<a id="uploadHoliday" class="btn btn-info pull-right">Add</a>

											</div>

											<!-- /.box-footer -->

										</form>

									</div>



								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- add new code -->

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

		$('.datepicker').datepicker();

		$('#uploadHoliday').on('click',function(){

			var imagefile = document.querySelector('#holidayFile');

			if(imagefile.files[0]) {

				var file_data = $('#holidayFile').prop('files')[0];

				var form_data = new FormData();

				form_data.append('holidayFile', file_data);

				$.ajaxSetup({

					headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}

				});

				var url  = "{{URL('/hrManager/import/holiday-sheet')}}";

				$.ajax({

					url: url,

					type: 'POST',

					data: form_data,

					success: function (data) {

						if(data.flag){

							swal('Success','File Upload Successfully','success');	

						}else{

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

@endsection