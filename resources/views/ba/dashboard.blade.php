@extends('admin.layouts.app')
@section('content')
@section('title','BA Dashboard')

<div class="page-inner">

	<div class="page-title">
		<h3>Dashboard</h3> 
		<div class="page-breadcrumb">
			<ol class="breadcrumb">
				<li><a href="{{ route('ba.dashboard')}}">Home</a></li>
				<li class="active">Dashboard</li>
			</ol> 
		</div>
	</div>

	<div id="main-wrapper">
		<div class="row" id="dashboard">
            
            <div class="col-sm-12">
                <div class="col-lg-3 col-md-6">
                    <a href="{{route('cm.project_list',['role'=>getRoleStr()])}}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">All Projects </span>
                                    <span class="white">{{$total_project}}</span> 
                                </div>
                            </div>
                        </div>
                    </a>
                </div> 

                <div class="col-lg-3 col-md-6">
                    <a href="{{route('ba.handover_projects')}}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">Handover Projects </span>
                                    <span class="white">{{$handover_project}}</span> 
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{route('cm.project_list',['role'=>getRoleStr()])}}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">Project Notifications </span>
                                    <span class="white"></span> 
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6"> 
                    <a href="{{route('cm.pw_mng',[ 'role' => getRoleStr()] )}}" class="weight-hover">
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
                    <a href="{{ route('ba.holiday') }}" title="" class="weight-hover">
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

                <div class="col-lg-3 col-md-6">
                    <a href="{{URL('/profile')}}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">Profile </span>
                                    <span class="white"></span> 
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
                <div class="col-lg-3 col-md-6">
                    <a href="{{URL('/logout')}}" title="" class="weight-hover">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-icon">
                                    <i class="fa fa-sign-out m-r-xs"></i>
                                </div>
                                <div class="info-box-stats">
                                    <span class="info-box-title">Logout</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <br>
            <div class="col-sm-12">
                  
                  <div class="col-sm-12">
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
                  <div class="col-sm-6">
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
                  </div>
            </div>


        </div><!-- Row -->
    </div>

    <div class="page-footer">
    	<p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
    </div>
</div><!-- Page Inner -->


<!-- change password Modal -->

  {{-- <div class="modal fade empList-modal-lg changePassModal" id="myModal-emp" tabindex="-1" role="dialog" 
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-body">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title" id="msg">Change Password</h4> 
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" >
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="old_password" class="col-sm-4 control-label">Old Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password">  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-sm-4 control-label">New Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-4 control-label">Confirm Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">  
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a  id="changePassword"  class="btn btn-success">Change</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

            <!-- change password Modal -->
@endsection

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


