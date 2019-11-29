@extends('admin.layouts.app')

@section('content')

@section('title','Projects')

<div class="page-inner">
	<div class="page-title">
		<h3>Assign Project</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li class="active">Assign Project</a></li> 
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
						<h4 class="panel-title">Assign Project</h4>
					</div>--}}
					<div class="panel-body">
					  <form method="post" action="" class="form-horizontal">
                          {{csrf_field()}}

                          <div class="form-group">
                            <label for="project_name" class="col-sm-2 control-label">Project</label>
                            <div class="col-sm-10">
                                    <select class="form-control select2" name="project" id="project"> 
                                        <option value="">-- Select Project  --</option>
                                        @foreach($projects as $project) 
                                            @if(@$ass_project->project_id==$project->id || old('project') == $project->id )
                                                <option value="{{$project->id}}" selected>{{$project->project_name}}</option>
                                            @else
                                                <option value="{{$project->id}}" >{{$project->project_name}}</option>
                                            @endif
                                        @endforeach
                                    </select> 
                                    @if ($errors->has('project'))
                                    <span class="label label-danger">{{ $errors->first('project') }}</span>
                                    @endif
                            </div>
                          </div> 
                          <div class="form-group">
                            <label for="project_name" class="col-sm-2 control-label">Employee</label>
                            <div class="col-sm-10">
                                    <select class="form-control select2" name="employee" id="employee">
                                       <option value="">-- Select Employee --</option>
                                        @foreach($emps as $em)
                                        @if(@$ass_project->employee_id==$em->id || old('employee') == $em->id )
                                            <option  value="{{$em->id}}" selected>{{$em->first_name}} {{$em->last_name}}</option>
                                            @else
                                            <option  value="{{$em->id}}" >{{$em->first_name}} {{$em->last_name}}</option>
                                            @endif
                                        @endforeach
                                    </select> 
                                    @if ($errors->has('employee'))
                                    <span class="label label-danger">{{ $errors->first('employee') }}</span>
                                    @endif
                            </div>
                          </div> 

                          <div class="form-group">
                            <label for="project_name" class="col-sm-2 control-label">Employee Role</label>
                            <div class="col-sm-10">
                                    <select class="form-control select2" name="emp_role">
                                        <option value="">-- Select Project Type --</option>
                                        @foreach($emp_roles as $e_role)
                                            @if(@$ass_project->emp_role==$e_role->id || old('emp_role') == $e_role->id )
                                                <option value="{{$e_role->id}}" selected>{{$e_role->name}}</option>
                                            @else
                                                <option value="{{$e_role->id}}" >{{$e_role->name}}</option>
                                            @endif
                                        @endforeach
                                    </select> 
                                    @if ($errors->has('emp_role'))
                                    <span class="label label-danger">{{ $errors->first('emp_role') }}</span>
                                    @endif
                            </div>
                          </div> 

                            <div class="form-group">
                                <label for="end_date" class="col-sm-2 control-label">Start Date</label>
                                <div class="col-sm-10">
                                    <input type="text" name="start_date" id="start_date"  value="{{(@$ass_project->start_date) ? $ass_project->start_date : old('start_date')}}" class=" form-control" placeholder="Start Date"> 
                                    @if ($errors->has('start_date'))
                                    <span class="label label-danger">{{ $errors->first('start_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="col-sm-2 control-label">End Date</label>
                                <div class="col-sm-10">
                                    <input type="text"  id="end_date" name="end_date"  value="{{(@$ass_project->end_date) ? $ass_project->end_date : old('end_date')}}" 
                                    class=" form-control datepicker"placeholder="End Date">
                                    @if ($errors->has('end_date'))
                                    <span class="label label-danger">{{ $errors->first('end_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="col-sm-2 control-label">Assign Percentage</label>
                                <div class="col-sm-10">
                                    <input type="number" min="1" max="100" name="assign_percentage" value="{{(@$ass_project->assign_percentage) ? $ass_project->assign_percentage : old('assign_percentage')}}" class="form-control"  placeholder="Assign Percentage">
                                    @if ($errors->has('assign_percentage'))
                                    <span class="label label-danger">{{ $errors->first('assign_percentage') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="col-sm-2 control-label">Assign Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="assign_status">
                                       <option value=""> -- Assign Status -- </option>
                                       @foreach($assign_status as $key => $status)
                                            @if(@$ass_project->assign_status==$key || old('assign_status') == $key  )
                                                <option value="{{$key}}" selected>{{$status}}</option>
                                            @else
                                                <option value="{{$key}}" >{{$status}}</option>
                                            @endif
                                        @endforeach
                                       
                                    </select>
                                    @if ($errors->has('assign_status'))
                                    <span class="label label-danger">{{ $errors->first('assign_status') }}</span>
                                    @endif
                                </div>
                            </div> 

                            <div class="form-group">
                                <label for="end_date" class="col-sm-2 control-label">Performance Notes</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" name="notes" placeholder="Performance Notes">{{(@$ass_project->performance_notes) ? $ass_project->performance_notes : old('notes')}}</textarea>
                                    @if ($errors->has('notes'))
                                    <span class="label label-danger">{{ $errors->first('notes') }}</span>
                                    @endif
                                </div>
                            </div> 

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><i class="fa fa-lock"></i> Save </button>
                            </div>

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
{{ Html::script("assets/plugins/select2/js/select2.min.js") }}
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}

<script>
	$(document).ready(function() {
		$('.select2').select2({placeholder: 'Select an from list'});  

        $("#start_date").datepicker({ format: 'yyyy-mm-dd',startDate: '+1d'});  
        $(".datepicker").datepicker({ format: 'yyyy-mm-dd',startDate: '+1d'});  

        $(document).on('change','#project',function(){
            var project = $(this).val();
            $.ajax({
                type:"get",
                url:"{{ route('cm.get_project_emp', ['role' => getRoleStr()]) }}",
                data:{project:project},
                success:function(res){
                    //console.log(res.project)
                      $('#employee').html('');
                      $('#employee').html(res.html); 
                      $('#start_date').val('');    
                      $('#start_date').datepicker({format:'yyyy-mm-dd',startDate: new Date(res.project.start_date)});
                      $('#end_date').datepicker({format:'yyyy-mm-dd', startDate: new Date(res.project.start_date)});
                      //console.log(res.project.start_date);  
                }
            });
         });
         
         $(document).on('blur','#end_date',function(){ 
            var end   = new Date($(this).val()); 
            var start = new Date($('#start_date').val());
                diff = (end - start)/1000/60/60/24;
                if(diff <1){
                $(this).val('');
                $(this).focus(); 
                }
         });

	});
</script>
@endsection

@endsection