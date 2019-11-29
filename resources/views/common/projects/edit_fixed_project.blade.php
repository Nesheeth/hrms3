@extends('admin.layouts.app')
@section('title','Edit Fixed Project')

@section('content')

<div class="page-inner">
	<div class="page-title">
		<h3>Fixed Project</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li><a href="{{URL('/admin/projects')}}">Projects</a></li>
				<li class="active">Update Project</li>
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
        </div>
        <div class="panel panel-white">
              <div class="panel-body">
              <form class="form-horizontal" method="post" action="{{route('cm.edit_fixed',['role'=> getRole(Auth::user()->role)])}}">  
                            {{csrf_field()}}
                        <input type="hidden" name="project_id" value="{{$project->id}}"> 

                @foreach($fixed as $fx) 
                  <div class="row">
                    <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label">Milestone Number </label> 
                        <div class="col-sm-10">  
                        <input class="form-control" name="milestone_number[]" value="{{(@$fx->milestone_number) ? $fx->milestone_number : old('milestone_number')}}" readonly/>
                     </div> 
                     </div> 

                     <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label">Milestone Details </label> 
                        <div class="col-sm-10"> 
                        <textarea class="form-control" readonly >{{@$fx->milestone_details}}</textarea>
                        </div> 
                     </div> 
                    
                     <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label"> Delivery Date </label> 
                        <div class="col-sm-10"> 
                          <input class="form-control" value="{{date('Y-m-d', strtotime($fx->delivery_date))}}" readonly/>
                        </div> 
                    </div>

                    <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label"> Milestone Notes </label> 
                        <div class="col-sm-10"> 
                          <textarea class="form-control" name="milestone_notes[]">{{$fx->milestone_notes}}</textarea>
                        </div> 
                    </div>

                    <div class="form-group"> 
                        <label for="project_name" class="col-sm-2 control-label"> Delivery Status Notes </label> 
                        <div class="col-sm-10"> 
                          <textarea class="form-control" name="status_notes[]">{{$fx->delivery_notes}}</textarea>
                        </div> 
                    </div> 

                  </div>
                  <hr>
                @endforeach

                <div class="box-footer"> 
                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-unlock-alt"></i> &nbsp; Update</button>
                </div>
             </form>
              </div>
        </div>
    </div>
    
    <div class="page-footer">
      <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>

</div>

@endsection 
@section('script')
{{ Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
<script>
 
</script>
@endsection