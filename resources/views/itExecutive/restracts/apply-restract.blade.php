@extends('itExecutive.layouts.app')

@section('content')

@section('title','Resignation')







<div class="page-inner">

	<div class="page-title">

		<h3>Resignation</h3>

		<div class="page-breadcrumb">

			<ol class="breadcrumb">

				<li><a href="{{URL('/itExecutive/dashboard')}}">Home</a></li>
				<li class="active">Retract</a></li>

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

				<div class="panel panel-white info-box-re">

					<div class="panel-heading clearfix">

						<h4 class="panel-title">Exit Formality Form</h4>

					</div>

					<div class="row">
					

					<div class="panel-body">

						<form class="form-horizontal" method="post" action="{{url('/itExecutive/retract/')}}" enctype="multipart/form-data" id="resignForm">

							<div class="box-body">

								{{csrf_field()}}

								<div class="form-group">

									<label for="reason" class="col-sm-2 control-label">Reason For Restract</label>

									<div class="col-sm-10">

										<select name="reason_retract" id="reason" class="form-control select2" required>

											<option value="">--Select Reason--</option>

											<option value="Resignation click by mistake">Resignation click by mistake</option>

											<option value="I change my mind">I change my mind</option>

											

										</select>

										@if ($errors->has('reason'))

										<span class="label label-danger">{{ $errors->first('reason') }}</span>

										@endif

									</div>

								</div>
								

								<input type="hidden" id="resignation_reason">

								<input type="hidden" id="type" name="type">

								<div class="form-group">

									<label for="message" class="col-sm-2 control-label">Message</label>

									<div class="col-sm-10">

										<textarea name="message_retract" id="message" cols="30" rows="10" class="form-control" required></textarea>

										@if ($errors->has('message'))

										<span class="label label-danger">{{ $errors->first('message') }}</span>

										@endif

									</div>

								</div>
								

							</div>

							<!-- /.box-body -->

							<div class="modal-footer">

											<a href="{{url('/resign')}}" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">Cancel</a>

											<button type="submit" class="btn btn-info pull-right btn-info-re">Submit</button>

										</div>

										
							<!-- preview Modal -->

						</form>

					</div>

				</div>

			</div>

		</div><!-- Row -->

	</div>

	<!-- Main Wrapper -->

	



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

{{ Html::script("assets/plugins/fullcalendar/lib/moment.min.js") }}

{{ Html::script("assets/js/pages/form-elements.js") }}

<script type="text/javascript">

	$('.select2').select2();

	$(document).ready(function() {

		$('#previewBtn').on('click',function(event) {

			if($('#reason option:selected').val() == ""){

				swal('Oops','Please Select Reason','warning');

			}else if($('#message').val() == ""){

				swal('Oops','Please Add message','warning');

			}else if($('#konwledge_transfer_to option:selected').val() == ""){

				swal('Oops','Please Add Knowledge Transfer To','warning');

              }
              else if($('#upload_knowledge_tranfer_file').val() == ""){

				swal('Oops','Please Upload Knowledge Transfer File','warning');

              }

			else{

				$('#date_of_resign1').empty().text($('#date_of_resign').val());

				$('#last_working_day1').empty().text($('#last_working_day').val());

				$('#fnf_date1').empty().text($('#fnf_date').val());

				$('#current_project1').empty().text($('#current_project option:selected').text());

				$('#reporting_manager1').empty().text($('#reporting_manager option:selected').text());

				$('#message1').empty().text($('#message').val());
				$('#knowledge_transfer_to1').empty().text($('#konwledge_transfer_to option:selected').text());

				$('#reason1').empty().text($('#reason option:selected').val());

				$('#previewModal').modal('toggle');

			}



		});

	});

</script>

@endsection

@endsection