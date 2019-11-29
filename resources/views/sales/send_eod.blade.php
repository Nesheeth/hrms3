@extends('sales.layouts.app')
@section('title','Send EOD') 
@section('content')
<div class="page-inner">
    <div class="page-title">
        <h3>Dashboard</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('sl.dashboard',['role'=>getSalesRole()]) }}">Home</a></li>
                <li class="active">Send EOD</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row" id="dashboard">
            @if (session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
            </div>
            @endif @if (session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
            @endif
        </div>
    </div>

    <div class="panel panel-white">
                <div class="panel-body">
                <div class="col-sm-12">
                    <a href="{{ route('sl.eods',['role'=> getSalesRole() ]) }}" class="btn btn-info pull-right">EOD List</a> 
                </div>


                    <form class="form-horizontal" action="" method="post" id="eodForm">
                        {{csrf_field()}}
                       
                        <div class="col-sm-12">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="email">EOD Date:</label>
                                <input type="text" class="form-control  date_of_eod" value="{{ old('date_of_eod')}}" name="date_of_eod" id="date_of_eod" placeholder="Date Of EOD">
                                @if ($errors->has('date_of_eod'))
									<span class="label label-danger">{{ $errors->first('date_of_eod') }}</span>
							    @endif
                            </div>
                        </div>

                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label for="email">Project:</label>
                                <select class="form-control" name="project">
                                  <option value="{{$project['id']}}" selected>{{$project['name']}}</option> 
                                </select>
                                @if ($errors->has('project'))
									<span class="label label-danger">{{ $errors->first('project') }}</span>
							    @endif
                            </div>
                        </div>
                        </div>

                        <div class="col-sm-12">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="email">Task 1</label>
                                <textarea class="form-control" name="task_1"  placeholder="Describe Task 1">{{ old('task_1') }}</textarea>
                                @if($errors->has('task_1'))
									<span class="label label-danger">{{ $errors->first('task_1') }}</span> 
							    @endif
                            </div>
                        </div>

                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label for="email">Task 2</label>
                                <textarea class="form-control " name="task_2"  placeholder="Describe Task 2">{{ old('task_2') }}</textarea>
                            </div>
                        </div>
                        </div>
                       
                        <div class="col-sm-12">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="email">Task 3</label>
                                <textarea class="form-control " name="task_3"  placeholder="Describe Task 3">{{ old('task_3') }} </textarea>
                            </div>
                        </div>

                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label for="email">Task 4</label>
                                <textarea class="form-control " name="task_4"  placeholder="Describe Task 4">{{ old('task_4') }}</textarea>
                            </div>
                        </div>
                        </div>

                        <div class="col-sm-11">
                            <div class="form-group">
                                <label for="email">Comments</label>
                                <textarea class="form-control" name="comment" placeholder="Comments"> {{ old('comments') }} </textarea>
                            </div>
                        </div>
 
                        <div class="col-md-12">
							<button type="submit" class="btn btn-info pull-right"> Send </button> 
						</div>
                    </form>
                </div>
            </div>

    <!-- Main Wrapper -->
    <div class="page-footer">
        <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>
</div>
<!-- Page Inner -->
@endsection

@section('script')
<script>
 $(document).ready(function(){   
      $('#date_of_eod').datepicker({format:"yyyy-mm-dd", startDate:"{{ date('Y-m-d', strtotime('-1 days')) }}", endDate:"{{date('Y-m-d')}}"});       
 });
 </script> 
@endsection

