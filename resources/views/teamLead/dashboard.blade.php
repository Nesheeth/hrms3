@extends('employee.layouts.app')
@section('content')
@section('title','Dashboard')
<div class="page-inner">
	<div class="page-title">
		<h3>Dashboard</h3>
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{URL(getRoleStr().'/dashboard')}}">Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>
	</div>
	<div id="main-wrapper">
		<div class="row" id="dashboard">

			{{--<div class="col-lg-3 col-md-6">
				<a href="{{URL('/hrManager/employees')}}" title="" class="weight-hover">
					<div class="panel info-box panel-white">
						<div class="panel-body">
                        <div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title">Active Employees</span>
							</div>
						</div>
					</div>
				</a>
			</div>--}} 

			<div class="col-lg-3 col-md-6">
                <a href="{{route('cm.leave_mng',[ 'role' => getRoleStr()] )}}"  class="weight-hover">
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
                <a href="{{route('cm.pw_mng',[ 'role' => getRoleStr()] )}}"  class="weight-hover">
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
				<a href="{{ route('leave')}}" title="" class="weight-hover"> 
					<div class="panel info-box panel-white">
						<div class="panel-body">
                        <div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title"> Team Member Leave Requests </span> 
							</div>
						</div>
					</div>
					</a>
					</div>

					<div class="col-lg-3 col-md-6">
				<a href="{{ URL(getRoleStr().'/get-report-cart')}}" title="" class="weight-hover"> 
					<div class="panel info-box panel-white">
						<div class="panel-body">
                        <div class="info-box-icon">
								<i class="icon-users"></i>
							</div>
							<div class="info-box-stats">
								<span class="info-box-title"> Team Member Reports </span> 
							</div>
						</div>
					</div>
					</a>
					</div>

					{{--<div class="col-lg-3 col-md-6">
						<a href="{{URL('/hrManager/request/profile-update')}}" title="" class="weight-hover">
							<div class="panel info-box panel-white">
								<div class="panel-body">
                                <div class="info-box-icon">
										<i class="icon-users"></i>
									</div>
									<div class="info-box-stats">
										<span class="info-box-title">Profile Update Requests</span>
									</div>
								</div>
							</div>
						</a>
					</div>--}}

							<!--add new div -->
							<!-- <div class="col-lg-3 col-md-6">
								<a href="https://drive.google.com/drive/" title="" class="weight-hover">
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
						                <a href="{{ route('cm.my_project',[ 'role'=> getRoleStr()]) }}" title="" class="weight-hover">
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
						                <a href="{{URL('/employee/send-eod')}}" title="" class="weight-hover">
						                    <div class="panel info-box panel-white">
						                        <div class="panel-body">
						                            <div class="info-box-icon">
						                                <i class="icon-eye"></i> 
						                            </div>
						                            <div class="info-box-stats">
						                                <span class="info-box-title">EOD Management</span>
						                            </div>
						                        </div>
						                    </div>
						                </a>
						            </div>
						            <div class="col-lg-3 col-md-6">
										<a href="{{URL('knowledge-transfer')}}" title="" class="weight-hover">
											<div class="panel info-box panel-white">
												<div class="panel-body">
						                        <div class="info-box-icon">
														<i class="icon-users"></i>
													</div>
													<div class="info-box-stats">
														<span class="info-box-title">Team Member Knowledge Transfer</span>
													</div>
												</div>
											</div>
										</a>
									</div>
									{{--<div class="col-lg-3 col-md-6">
										<a href="#" data-toggle="modal" data-target="#myModal-changepass" title="" class="weight-hover">
											<div class="panel info-box panel-white">
												<div class="panel-body">
                                                <div class="info-box-icon">
														<i class="icon-pencil"></i>
													</div>
													<div class="info-box-stats">
														<span class="info-box-title">Change password</span>
													</div>
												</div>
											</div>
										</a>
									</div>--}}
									<div class="col-lg-3 col-md-6">
										<a href="{{URL('/employee/holiday-calender')}}" title="" class="weight-hover"> 
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
											@if(Auth::user()->role == 4)
											<div class="col-lg-3 col-md-6">

                <a href="{{URL('/employee/sent-eods')}}" title="" class="weight-hover">

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
														<a href="{{URL('/profile')}}" title="" class="weight-hover">
															<div class="panel info-box panel-white">
																<div class="panel-body">
                                                                <div class="info-box-icon">
																		<i class="icon-eye"></i>
																	</div>
																	<div class="info-box-stats">
																		<span class="info-box-title">View Profile</span>
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
											                       <button type="button" class="btn btn-success">Pending</button>@endif 
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
              
            <!--add new div --->
        </div><!-- Row -->
        <!-- <div class="row">
        	<div class="col-lg-12 col-md-12">
        		<table class="table table-responsive table-bordered table-stripped">

				  <tr>
				    <th>Team Member Name</th>
				    <th>Project Assign Status</th>
				  </tr>
				  <tr>
				    <td>jksd</td>
				    <td>Maria Anders</td>
				  </tr>
				  
				</table>

        	</div>	
        </div> -->
        </div>
        <div class="page-footer">
        	<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
        </div>
    </div><!-- Page Inner -->
    @section('script')
    {{ Html::script("assets/plugins/waypoints/jquery.waypoints.min.js") }}
    {{ Html::script("assets/plugins/jquery-counterup/jquery.counterup.min.js") }}
    {{ Html::script("assets/plugins/toastr/toastr.min.js") }}
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