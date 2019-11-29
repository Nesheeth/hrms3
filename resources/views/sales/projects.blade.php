@extends('sales.layouts.app')
@section('title','Send EOD') 
@section('content')
<div class="page-inner">
    <div class="page-title">
        <h3>Dashboard</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('sl.dashboard',['role'=>getSalesRole()]) }}">Home</a></li>
                <li class="active">Projects</li>
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
            <div class="container">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Name</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($projects as $project)
                      <tr>
                           <td>{{ $loop->iteration }}</td>  
                           <td> {{ $project['name'] }} </td> 
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
