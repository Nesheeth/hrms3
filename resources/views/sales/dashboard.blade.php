@extends('sales.layouts.app')
@if(Auth::User()->role == 4 && Auth::User()->department == 'sales')
@section('title','Sales Lead')
@else
@section('title','Sales Analyst')
@endif


@section('content')
<div class="page-inner">
    <div class="page-title">
        <h3>Dashboard</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('sl.dashboard',['role'=>getSalesRole()]) }}">Home</a></li>
                <li class="active">Dashboard</li>
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

            <div class="col-lg-3 col-md-6">
                <a href="{{route('sl.leave_mng',[ 'role' => getSalesRole()] )}}"  class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="icon-pencil"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">Leave Management</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{route('sl.pw_mng',[ 'role' => getSalesRole()] )}}"  class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="icon-pencil"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">Password Management</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

@if(Auth::User()->role == 4)
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('salesleave', [ 'role'=> getSalesRole()])}}"  class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="icon-users"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">Team Member Leave Requests</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
    @endif
           
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('sl.projects',[ 'role'=> getSalesRole()]) }}" title="" class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">Projects</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('sl.eods',['role'=> getSalesRole() ]) }}" title="" class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="icon-pencil"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">EOD Management</span> 
                            </div>
                        </div>
                    </div>
                </a>
			</div>
            
            

            

            <div class="col-lg-3 col-md-6">
                <a href="{{route('sl.holiday',[ 'role' => getSalesRole()] )}}?category=sales" title="" class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">Holiday Calender / Attendance</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            @if(Auth::user()->role == 4)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('sales_team_eods',['role'=> getSalesRole() ]) }}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="icon-eye"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">View EOD List</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <div class="col-lg-3 col-md-6">
                <a href="{{route('sl.profile',[ 'role' => getSalesRole()] )}}" title="" class="weight-hover">
                    <div class="panel info-box panel-white"> 
                        <div class="panel-body"> 
                            <div class="info-box-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title"> Profile </span> 
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @if(Auth::user()->is_active==1)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ URL( getRoleStr().'/loan-management') }}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="icon-eye"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">Loan</span>
                                    @if(!is_null($loan))
                                        @if($loan->status =='0') 
                                            <button type="button" class="btn btn-success">Pending</button>
                                        @endif 
                                        @if($loan->status =='1')
                                            <button type="button" class="btn btn-primary">Approved</button>
                                        @endif 
                                        @if($loan->status =='2')
                                            <button type="button" class="btn btn-danger">Rejected</button> 
                                        @endif 
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
 
    <!-- Main Wrapper -->
    <div class="page-footer">
        <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>
</div>
<!-- Page Inner -->
@endsection

