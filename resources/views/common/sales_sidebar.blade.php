<div class="page-sidebar sidebar">

      <div class="page-sidebar-inner slimscroll">
        <div class="sidebar-header">
            <div class="sidebar-profile">
          <a href="javascript:void(0);">
            <div class="sidebar-profile-image">
            <a href="{{ URL(getRoleStr().'/dashboard') }}">     
                @php
                    $img = (@Auth::user()->cb_profile->employee_pic) ? Auth::user()->cb_profile->employee_pic : asset('images/employees/default-user.png')
                @endphp
              <img src="{{$img}}" class="img-circle img-responsive" alt="">  
            </a>
          </div>
          <div class="sidebar-profile-details">
          <span>{{Auth::user()->first_name}} {{Auth::user()->last_name}}<br> <small>{{getRoleById(Auth::user()->role)}}</small></span>
          </div>
        </a>
      </div>
      </div>

    <ul class="menu accordion-menu"> 
        <li class="{{ setActive( getRoleStr().'/dashboard') }}">
          <a href="{{ URL(getRoleStr().'/dashboard') }}" class="waves-effect waves-button">
            <span class="menu-icon fa fa-tachometer"></span><p>Dashboard</p>
          </a> 
        </li>

         @if(Auth::user()->role==4 || Auth::user()->role==6)
        <li>
          <a href="{{route('sl.salary')}}">
          <span class="menu-icon fa fa-money "></span>
          <p>Salary</p></a>
        </li>
        @endif

        @if(Auth::user()->role==2)
        <li>
          <a href="{{route('hr.salary')}}">
           
          <span class="menu-icon fa fa-money "></span>
          <p>Salary</p></a>
        </li>
        @endif


        @if(Auth::user()->role==1 || Auth::user()->role==8)
        <li class="{{setActive('admin/payrolls-employees-list')}}">
           <a href="{{route('a.ePayroll',['role'=>getRoleStr()])}}" class="waves-effect waves-button">
             <span class="menu-icon fa fa-inr"></span><p> PayRoll </p>
           </a>
         </li>  
         @endif


        @if(Auth::user()->role==1 || Auth::user()->role==2)
        <li class="droplink  
            {{setActive( getRoleStr().'/employees')}}   
            {{setActive( getRoleStr().'/add-employee')}}    
            {{setActive( getRoleStr().'/upload-employee')}}  ">
            <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-users"></span><p>Employees</p><span class="arrow"></span></a>
              <ul class="sub-menu">  
                <li><a href="{{ URL( getRoleStr().'/employees') }}">Employee Listing</a></li>
                <li><a href="{{ URL( getRoleStr().'/add-employee') }}">Add New Employee</a></li>
              </ul>
        </li>
        @endif

        @if(Auth::user()->role==1 || Auth::user()->role==5)
        <li class="droplink 
        {{setActive( getRoleStr().'/add-system')}}
        {{setActive( getRoleStr().'/assets')}}
        {{setActive( getRoleStr().'/add-asset')}}
        {{setActive( getRoleStr().'/systems')}}">  
          <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-cogs"></span><p>Asset Management</p><span class="arrow"></span></a>
            <ul class="sub-menu"> 
                <li><a href="{{URL(getRoleStr().'/assets/all_assets')}}">Asset List</a></li>
                <li><a href="{{URL(getRoleStr().'/add-asset')}}">Create Asset</a></li>
                <li><a href="{{URL(getRoleStr().'/assets/all_system')}}">Systems</a></li>
                <li><a href="{{URL(getRoleStr().'/add-system')}}">Create System</a></li>
            </ul>
        </li> 
        @endif

        @if(Auth::user()->role==1 || Auth::user()->role==7)
        <li class="droplink {{setActive('admin/projects')}} 
        {{ setActive('admin/add-new-project')}} 
        {{setActive('admin/all-projects')}} 
        {{setActive('admin/employee-projects')}} ">
        <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-folder"></span><p>Project</p><span class="arrow"></span></a>
            <ul class="sub-menu">
                <li><a href="{{ route('cm.project_list',['role'=> getRoleStr()]) }}">Project List</a></li> 
                <li><a href="{{ route('cm.add_project',['role'=> getRoleStr()]) }}">Add New Project</a></li>
                <li><a href="{{ route('cm.assign_project',['role'=> getRoleStr()]) }}">Assign Project</a></li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->role==1)
        <li class="droplink {{ setActive('admin/assign-team-members') }} {{setActive('admin/teams')}} ">
            <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-users"></span><p>Teams</p><span class="arrow"></span></a>
            <ul class="sub-menu">
                <li><a href="{{URL('/admin/assign-team-members')}}">Assign Team Members</a></li>
                <li><a href="{{URL('/admin/teams')}}">Teams</a></li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->role==1 || Auth::user()->role==2)
        <li class="droplink 
            {{setActive(getRoleStr().'/attendance')}}
            {{setActive(getRoleStr().'/leave-details')}}  
            {{setActive(getRoleStr().'/leave-types')}}
            {{setActive(getRoleStr().'/add-leave-type')}}
            {{setActive(getRoleStr().'/holidays')}}
            {{setActive(getRoleStr().'/add-holiday')}}
            {{setActive(getRoleStr().'/holiday-calender')}}
            {{setActive(getRoleStr().'/retract-leave')}}">  
            <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-calendar"></span><p>Attendance / Leave</p><span class="arrow"></span></a>
            <ul class="sub-menu">
                <li><a href="{{URL(getRoleStr().'/attendance')}}">Attendance List</a></li>
                <li><a href="{{URL(getRoleStr().'/leave-types')}}">Leave Types</a></li>
                <li><a href="{{URL(getRoleStr().'/add-leave-type')}}">Add Leave Types</a></li>
                <li><a href="{{URL(getRoleStr().'/leave-listing')}}">Leave Listing</a></li>
                <li><a href="{{URL(getRoleStr().'/retract-leave')}}">Retract Leave Listing</a></li>
                <li><a href="{{URL(getRoleStr().'/holidays')}}">Holidays List</a></li>
                <li><a href="{{URL(getRoleStr().'/add-holiday')}}">Add Holiday</a></li>
                <li><a href="{{URL(getRoleStr().'/holiday-calender')}}">Holiday Calender</a></li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->role==1)
        <li class="droplink {{setActive('admin/eods')}} ">
          <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-book"></span>
            <p>EODs</p><span class="arrow"></span>
          </a>
          <ul class="sub-menu">
              <li><a href="{{URL('/admin/eods')}}">Eod List</a></li>
              <li><a href="{{ route('admin.hreod') }}"> HR Eod List</a></li> 
              <li><a href="{{ route('admin.iteod') }}"> IT Eod List</a></li>   
          </ul>
        </li>

        <li class="droplink {{setActive('admin/resignations')}}  {{setActive('admin/retract')}}">
        <a href="#" class="waves-effect waves-button">
            <span class="menu-icon glyphicon glyphicon-briefcase"></span>
            <p> Resignations </p><span class="arrow"></span>
        </a>
          <ul class="sub-menu">
            <li><a href="{{URL('/admin/resignations')}}">Resignation List</a></li>
            <li><a href="{{URL('/admin/retract')}}">Retract List</a></li>
          </ul>
        </li>
        @endif


        @if(Auth::user()->role!=1 && Auth::user()->role!=8) 
          <li class="droplink {{setActive('employee/send-eod')}} {{setActive('employee/sent-eods')}}">
	  
              <a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-briefcase"></span>
              <p>EODs</p><span class="arrow"></span></a>
                

                @if(Auth::user()->role==2)
                <ul class="sub-menu">
                  <li><a href="{{route('hr.eods')}}">My Sent EODs</a></li>
                  <li><a href="{{route('hr.send_eod')}}">Send {{Auth::user()->role}} </a></li>
                </ul>
                @elseif(Auth::user()->role==5)
				<ul class="sub-menu">
				  <li><a href="{{route('cm.send_eod', ['role'=> getRoleStr()] )}}">Send  </a></li>
				  <li><a href="{{URL('/itExecutive/sent-eods')}}">My Sent EODs</a></li> 
				</ul>
                @else
                <ul class="sub-menu">
                  @if(Auth::user()->role == 4)   
                  <li><a href="{{ route('cm.team_eods', ['role'=> getRoleStr()] )}}">Team Member's EOD</a></li>
                  @endif

                  <li><a href="{{URL('/employee/sent-eods')}}">My Sent EODs</a></li>
                  <li><a href="{{route('cm.send_eod', ['role'=> getRoleStr()] )}}">Send  </a></li>
                </ul>
                @endif
          </li>
        @endif

       

          @if(Auth::user()->role!=1)
          <li class="droplink 
                  {{setActive(getRoleStr().'/apply-leave')}}  
                  {{setActive(getRoleStr().'/my-leaves')}}" >
            <a href="#" class="waves-effect waves-button">
              <span class="menu-icon glyphicon glyphicon-briefcase"></span>
                  <p>Leaves</p><span class="arrow"></span></a>
                    <ul class="sub-menu">
                      <!-- <li><a href="{{URL('/employee/apply-leave')}}">Apply Leave</a></li> -->
                      @if(is_null(\Auth::user()->resignation))
                      <li> <a href="{{ route('cm.apply_leave',['role'=> getRoleStr() ]) }}" {{ (Auth::user()->is_active==1)?'':'disabled' }}> Apply Leave</a> </li>
                      @else
                          
                      @endif
                      <li> <a href="{{ route('em.my_leave',['role'=> getRoleStr() ]) }}">My Leaves</a> </li>
                    </ul>
            </li>
            
          <li class="droplink {{setActive('resign')}}">
              <a href="#" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon-book"></span>
                <p> Resignation </p> <span class="arrow"></span>
              </a>
            <ul class="sub-menu">
              @if(is_null(\App\Resignation::where('user_id',\Auth::user()->id)->first())) 
                <li><a href="{{URL('/resign')}}">Apply Resignation</a></li>
              @elseif(is_null(\App\Retract::where('user_id',\Auth::user()->id)->first())) 
                <li><a href="{{URL('/resign')}}">View Resignation</a></li>
              @else 
                <li><a href="{{ URL( getRoleStr().'/retract') }}">View Retract</a></li>
              @endif
            </ul>
          </li>
          @endif

        @if(Auth::user()->role==1 || Auth::user()->role==2)
        <li class="droplink {{setActive('admin/request/profile-update')}}  {{setActive('admin/leave-listing')}}">
          <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-inbox"></span><p>Requests</p><span class="arrow"></span></a>
            <ul class="sub-menu">
                <li><a href="{{ URL( getRoleStr().'/request/profile-update') }}">Profile Update Requests</a></li>
                <li><a href="{{ URL( getRoleStr().'/leave-listing?&leave_type=3') }}">Leave Requests</a></li> 
            </ul>
        </li>
        @endif

        @if(Auth::user()->role==1)
        <li>
          <a href="{{URL('/admin/settings')}}" class="waves-effect waves-button"><span class="menu-icon fa fa-cog "></span><p>Settings</p></a>
        </li>
        @endif
</ul>
</div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->