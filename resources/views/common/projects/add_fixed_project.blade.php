
@extends('admin.layouts.app')
@section('title','Fix Project')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.bootstrap-dialog .modal-header{ border-top-left-radius: 0px !important; border-top-right-radius: 0px !important;} 
</style>
<div class="page-inner">
	<div class="page-title">
		<h3>Fix Projects</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/projects')}}">Projects</a></li>
				<li class="active">Project Details</li>
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
                    <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{route('cm.save_fixed_project',['role'=> getRole(Auth::user()->role),(Request::segment(2)=='edit-fixed-project')?'type=edit':'type=add'])}}">  
                            {{csrf_field()}}
                        <input type="hidden" name="project_id" value="{{$project->id}}"> 
                        
                        <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label">Milestone Number </label> 
                        <div class="col-sm-10"> 
                        <input class="form-control" type="number" min="1" max="6" name="milestone_number" value="{{(@$fixed->milestone_number) ? $fixed->milestone_number : old('milestone_number')}}" {{(@$fixed->milestone_number) ? "readonly" : ""}} placeholder="Milestone Number "/>
                          @if ($errors->has('milestone_number'))  
                            <span class="label label-danger">{{ $errors->first('milestone_number') }}</span>
                          @endif
                        </div> 
                        </div> 

                        <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label">Milestone Details </label> 
                        <div class="col-sm-10"> 
                          <textarea class="form-control"  name="milestone_details" placeholder="Milestone Details ..." rows="6">{{(@$fixed->milestone_details) ? $fixed->milestone_details : old('milestone_details')}}</textarea>
                          @if ($errors->has('milestone_details'))
                            <span class="label label-danger">{{ $errors->first('milestone_details') }}</span>
                          @endif
                        </div> 
                        </div> 

                        <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label"> Delivery Date </label> 
                        <div class="col-sm-10"> 
                          <input class="datepicker form-control" name="delivery_date" value="{{(@$fixed->delivery_date) ? date('Y-m-d' ,strtotime($fixed->delivery_date)) : old('delivery_date')}}" placeholder="Milestone Delivery Date..."/>
                          @if ($errors->has('delivery_date')) 
                            <span class="label label-danger">{{ $errors->first('delivery_date') }}</span>
                          @endif
                        </div> 
                        </div> 
                        
                          <div class="col-sm-12" style="{{(Request::segment(2)=='edit-fixed-project')?'':'display:none'}}" >
                                <div class="form-group"> 
                            <label for="project_name" class="col-sm-2 control-label"> Is Update Delivery Date </label> 
                            <div class="col-sm-10"> 
                            <select class="form-control" name="delivery_date_updated" id="delivery_date_updated">
                               <option value=""> --  Select Delivery Date Status --</option>
                               <option value="1"> Yes </option>
                               <option value="2" selected> No </option>
                            </select>
                              @if ($errors->has('delivery_date_updated')) 
                                <span class="label label-danger">{{ $errors->first('delivery_date_updated') }}</span>
                              @endif
                            </div> 
                            </div> 
                     
                       <div id="reason_div" style="display:none">
                          <div class="form-group"> 
                          <label for="project_name" class="col-sm-2 control-label">Reason for Delay </label> 
                          <div class="col-sm-10"> 
                            <textarea class="form-control"  name="reason_for_delay" placeholder="Reason for delay ..." rows="5">{{(@$dedicated->reason_for_delay) ? $dedicated->reason_for_delay : old('reason_for_delay')}}</textarea>
                            @if ($errors->has('reason_for_delay'))
                              <span class="label label-danger">{{ $errors->first('reason_for_delay') }}</span>
                            @endif
                          </div> 
                          </div>

                          <div class="form-group"> 
                          <label for="project_name" class="col-sm-2 control-label">New Delivery Date </label> 
                          <div class="col-sm-10"> 
                            <input class="datepicker form-control"  name="new_delivery_date" placeholder="New Delivery Date ..." />
                            @if ($errors->has('new_delivery_date'))
                              <span class="label label-danger">{{ $errors->first('new_delivery_date') }}</span>
                            @endif
                          </div> 
                          </div>
                       </div>
                          </div>
                            
                    

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-unlock-alt"></i> &nbsp; Save</button>
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
</div> 
@endsection 
@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script>
 $(document).on('change','#delivery_date_updated',function(){
     if($(this).val()==1){
        $('#reason_div').show();
     }else{
      $('#reason_div').hide();
     } 
 });
</script>
@endsection
