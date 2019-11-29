@extends('admin.layouts.app')
@section('content')
@section('title','Dashboard')
<div class="page-inner">
	<div class="page-title">
		<h3>Welcome <span>{{Auth::user()->first_name}} {{Auth::user()->last_name}}!</span></h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL('/admin/dashboard')}}">Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>
        <div class="col-sm-12">
            @if($salary_status_of_month!=null)
                @if($salary_status_of_month->hr_status==1 && $salary_status_of_month->admin_status==0)
                    
                        <a href="{{url(getRoleStr().'/payrolls-employees-list')}}" style="color: red !important;font-weight: bold;font-size: 20px"><marquee height="50" width="100%" bgcolor="white" >HR has verified salary his side Please verify salary your side</marquee></a>
                    
                @endif
            @endif
        </div>
	</div>
	<div id="main-wrapper">
		<div class="row" id="dashboard">
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/employees?type=active')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="ribbon ribbon-box green">
                                {{$activeemp}}
                            </div>
							<div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Active Employees</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/leave-listing?type=pending')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="ribbon ribbon-box red">
                                {{$pendleave}}
                            </div>
							<div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Leave Requests</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/request/profile-update')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="ribbon ribbon-box green">
                                {{$is_requested_approved}}
                            </div>
							<div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Profile Update Requests</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<!--add new div -->
			<!-- <div class="col-lg-3 col-md-6">
				<a href="https://drive.google.com/drive/" target='_blank' title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="fa fa-google"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Google Drive</span>
							</div>
						</div>
					</div>
				</a>
			</div> -->
			 <div class="col-lg-3 col-md-6">
                <a href="{{route('ad.pw_mng')}}"  class="weight-hover">
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
			<div class="col-lg-3 col-md-6">
				<a href="/admin/resignations" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="icon-briefcase"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Resignation Requests</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/holiday-calender')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="fa fa-calendar"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Holiday Calender</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<!--add new div -->
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/attendance')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Attendance</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/eods')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="icon-eye"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">View EODs</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/kt_list/')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="fa fa-building"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Knowledge Transfer List</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="{{URL('/admin/view-notification')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
							<div class="info-box-icon">
								<i class="fa fa-bell"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">View Notification</span>
							</div>
						</div>
					</div>
				</a>
			</div>
            <div class="col-lg-3 col-md-6">
                <a href="{{URL('/admin/loan-list')}}" title="" class="weight-hover">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-icon">
                                <i class="fa fa-rupee"></i>
                            </div>
                            <div class="info-box-stats">
                                <span class="info-box-title">Loan Management</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!--add new div --->
        </div><!-- Row -->

        <div class="row" id="stats">
        	<div class="col-xl-4 col-lg-6 col-md-12">
        		<div class="row payroll">
        			<div class="col-md-12">
        				<div class="card">
		                    
		                    <div class="card-body">
		              <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h6>Developer</h6>
                            <h3 class="pt-3">{{$developer}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h6>Web Designer</h6>
                            <h3 class="pt-3">{{$designer}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h6>Team Lead</h6>
                            <h3 class="pt-3">{{$tl}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h6>Business Analyst</h6>
                            <h3 class="pt-3">{{$ba}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h6>IT Executive</h6>
                            <h3 class="pt-3">{{$it}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h6>HR Manager</h6>
                            <h3 class="pt-3">{{$hr}}</h3>
                            </div>
                        </div>
                    </div>
		                    </div>
		                </div>
        			</div> 
        		</div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Project Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-sm-4 border-right pb-4 pt-4">
                                <label class="mb-0">Total Project</label>
                                <h4 class="font-30 font-weight-bold text-col-blue countr">{{$project}}</h4>
                            </div>
                            <div class="col-sm-4 border-right pb-4 pt-4">
                                <label class="mb-0">On Going</label>
                                <h4 class="font-30 font-weight-bold text-col-blue countr">{{$project_status}}</h4>
                            </div>
                            <div class="col-sm-4 pb-4 pt-4">
                                <label class="mb-0">Pending</label>
                                <h4 class="font-30 font-weight-bold text-col-blue countr">{{$pending}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-left"><strong>{{$active}}%</strong></div>
                                            <div class="float-right"><small class="text-muted">On Going Projects</small></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-azure" role="progressbar" style="width: {{$active}}%" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-left"><strong>{{$hold}}%</strong></div>
                                            <div class="float-right"><small class="text-muted">Pending projects</small></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-yellow" role="progressbar" style="width: {{$hold}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-left"><strong>{{$completed}}%</strong></div>
                                            <div class="float-right"><small class="text-muted">Closed Projects</small></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-green" role="progressbar" style="width: {{$completed}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="stats">
            <div class=" col-md-12">
                <div class="row payroll">
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="col-sm-12" >
                                         
                                        
                                           
                                              <h4> Meeting Reminder </h4>
                                              <table class="table table-bordered">
                                                  <thead>
                                                      <tr>
                                                          <th>Project  </th>
                                                          <th>Client </th>
                                                          <th>Metting Date/Day </th>
                                                          <th>Metting Time </th>
                                                          <th>Metting Notes </th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($daily_reminders as $reminder)
                                                        <tr>
                                                            <td>{{$reminder->project->project_name}}</td>
                                                            <td>{{$reminder->project->client_name}}</td>
                                                            <td>{{date('d M - Y')}}</td>
                                                            <td>{{date('h:i A', strtotime($reminder->reminder_time))}}</td>
                                                            <td>{{$reminder->reminder_notes}}</td>
                                                        </tr>
                                                      @endforeach
                                                      @foreach($reminders as $reminder)
                                                        <tr>
                                                            <td>{{$reminder->project->project_name}}</td>
                                                            <td>{{$reminder->project->client_name}}</td>
                                                            <td> @if($reminder->reminder_type==1)
                                                                    {{ date('d M - Y', strtotime($reminder->reminder_date)) }}
                                                                 @else
                                                                    {{ $reminder->reminder_day }} 
                                                                 @endif
                                                            </td>
                                                            <td>{{--date('h:i A', strtotime($reminder->reminder_time))--}}</td>
                                                            <td>{{$reminder->reminder_notes}}</td>
                                                        </tr>
                                                      @endforeach
                                                  </tbody>
                                              </table>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
                 
        <!--           <div class="col-sm-6">
                    <h4> Expiring Project </h4>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                              <th> Project  </th>
                              <th> Expiry Date </th>
                              <th> Remaining Hours </th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($expired as $ex) 
                             <tr>
                                 <td>{{$ex->project_name}}</td>
                                 <td>{{ date('d M - Y', strtotime($ex->mile_expiry)) }}</td>
                                 <td>{{ $ex->rem_hours }}</td> 
                             </tr>
                            @endforeach
                        </tbody>
                      </table>
                 </div>
                 <div class="col-sm-6">
                      <h4>Project Timeline Notification</h4>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                              <th>Project  </th>
                              <th>Timeline Date </th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($timelines as $timeline) 
                             <tr>
                                 <td>{{$timeline->project->project_name}}</td>
                                 <td>{{ date('d M - Y', strtotime($timeline->delivery_date)) }}</td>
                             </tr>
                            @endforeach
                        </tbody>
                      </table>
                  </div> -->
            
        
    </div>

    <div class="page-footer">
    	<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>
</div><!-- Page Inner -->
@section('script')
{{ Html::script("assets/plugins/waypoints/jquery.waypoints.min.js") }}
{{ Html::script("assets/plugins/jquery-counterup/jquery.counterup.min.js") }}
<!-- {{ Html::script("assets/plugins/toastr/toastr.min.js") }} -->
{{ Html::script("assets/plugins/flot/jquery.flot.min.js") }}
{{ Html::script("assets/plugins/flot/jquery.flot.time.min.js") }}
{{ Html::script("assets/plugins/flot/jquery.flot.symbol.min.js") }}
{{ Html::script("assets/plugins/flot/jquery.flot.resize.min.js") }}
{{ Html::script("assets/plugins/flot/jquery.flot.tooltip.min.js") }}
{{ Html::script("assets/plugins/curvedlines/curvedLines.js") }}
{{ Html::script("assets/plugins/metrojs/MetroJs.min.js") }}
{{ Html::script("assets/js/pages/dashboard.js") }}
@endsection
@endsection
