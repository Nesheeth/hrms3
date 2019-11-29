@extends('sales.layouts.app')
@section('title','Send EOD') 
@section('content')
<div class="page-inner">
    <div class="page-title">
        <h3>Send EOD</h3>
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
                <a href="{{ route('sl.send_eod',['role'=> getSalesRole() ]) }}" class="btn btn-info pull-right">Send EOD</a> 
            </div>

            <div class="container">
            <br>
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>EOD Date</th>
                          <th>Task 1</th>
                          <th>Task 2</th>
                          <th>Task 3</th>
                          <th>Task 4</th>
                          <th>Comments</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($eods as $eod)
                      <tr>
                           <td>{{$loop->iteration}}</td>  
                           <td> {{date('d F - Y', strtotime($eod->eod_date))}} </td> 
                           <td> {{ $eod->task_1}} </td>
                           <td> {{ $eod->task_2}} </td>
                           <td> {{ $eod->task_3}} </td>
                           <td> {{ $eod->task_4}} </td>
                           <td> {{ $eod->comment}} </td> 
                      </tr>
                      @endforeach
                  </tbody>
              </table>     
            </div>     
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
