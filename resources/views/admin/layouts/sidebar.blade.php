      <div class="page-sidebar sidebar">

      	<div class="page-sidebar-inner slimscroll">

      		<div class="sidebar-header">

      			<div class="sidebar-profile">

              <!-- <a href="javascript:void(0);" id="profile-menu-link"> -->

                <a href="javascript:void(0);">

                 <div class="sidebar-profile-image">

                  <a href="{{URL('/admin/dashboard')}}"><img src="http://hrms.codingbrains.com/images/employees/default-user.png" class="img-circle img-responsive" alt=""></a>

                </div>

                <div class="sidebar-profile-details">

                  <span>{{\Auth::user()->first_name}}<br><small>{{getRoleById(\Auth::user()->role)}}</small></span>

                </div>

              </a>

            </div>

          </div>



          <ul class="menu accordion-menu">

           <li class="{{setActive('admin/dashboard')}}"><a href="{{URL('/admin/dashboard')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>

           <li class="{{setActive('admin/payrolls-employees-list')}}"><a href="{{route('payroll',['role'=>getRoleStr()])}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>PayRoll</p></a></li>  




           <li class="droplink  {{setActive('admin/employees')}}   {{setActive('admin/add-employee')}}   {{setActive('admin/upload-employee')}}  "><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-users"></span><p>Employees</p><span class="arrow"></span></a>

            <ul class="sub-menu">

              <li><a href="{{URL('/admin/employees')}}">Employee Listing</a></li>

              <li><a href="{{URL('/admin/add-employee')}}">Add New Employee</a></li>

              {{--<li><a href="{{URL('/admin/upload-employee')}}">Upload</a></li>--}}

            </ul>

          </li>


          <li class="droplink {{setActive('admin/add-system')}}

          {{setActive('admin/assets')}}

          {{setActive('admin/add-asset')}}

          {{setActive('admin/systems')}} 

          "><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-cogs"></span><p>Asset Management</p><span class="arrow"></span></a>

          <ul class="sub-menu">

            <li><a href="{{URL('/admin/assets/all_assets')}}">Asset List</a></li>

            <li><a href="{{URL('/admin/add-asset')}}">Create Asset</a></li>

            <li><a href="{{URL('/admin/assets/all_system')}}">Systems</a></li>

            <li><a href="{{URL('/admin/add-system')}}">Create System</a></li>

          </ul>

        </li>

      <li class="droplink {{setActive('admin/projects')}} 
        {{setActive('admin/add-new-project')}} 
        {{setActive('admin/all-projects')}} 
        {{setActive('admin/employee-projects')}} ">
        <a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-folder"></span><p>Project</p><span class="arrow"></span></a>

        <ul class="sub-menu">
          <li><a href="{{route('cm.project_list',['role'=> getRole(Auth::user()->role)])}}">Project List</a></li> 
          <li><a href="{{route('cm.add_project',['role'=> getRole(Auth::user()->role)])}}">Add New Project</a></li>
          <li><a href="{{URL('/admin/assign-project')}}">Assign Project</a></li>
          {{--<li><a href="{{URL('/admin/employee-projects')}}">Assigned Project List</a></li>--}}
        </ul>
      </li>


      <li class="droplink {{setActive('admin/assign-team-members')}} {{setActive('admin/teams')}} "><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-users"></span><p>Teams</p><span class="arrow"></span></a>

        <ul class="sub-menu">

          <li><a href="{{URL('/admin/assign-team-members')}}">Assign Team Members</a></li>

          <li><a href="{{URL('/admin/teams')}}">Teams</a></li>

        </ul>

      </li>



      <li class="droplink {{setActive('admin/attendance')}}

      {{setActive('admin/leave-details')}}  

      {{setActive('admin/leave-types')}}

      {{setActive('admin/add-leave-type')}}

      

      {{setActive('admin/holidays')}}

      {{setActive('admin/add-holiday')}}

      {{setActive('admin/holiday-calender')}}
      {{setActive('admin/retract-leave')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-calendar"></span><p>Attendance / Leave</p><span class="arrow"></span></a>

      <ul class="sub-menu">

        <li><a href="{{URL('/admin/attendance')}}">Attendance List</a></li>

        <li><a href="{{URL('/admin/leave-types')}}">Leave Types</a></li>

        <li><a href="{{URL('/admin/add-leave-type')}}">Add Leave Types</a></li>

        <li><a href="{{URL('/admin/leave-listing')}}">Leave Listing</a></li>
          <li><a href="{{URL('/admin/retract-leave')}}">Retract Leave Listing</a></li>

        <li><a href="{{URL('/admin/holidays')}}">Holidays List</a></li>

        <li><a href="{{URL('/admin/add-holiday')}}">Add Holiday</a></li>

        <li><a href="{{URL('/admin/holiday-calender')}}">Holiday Calender</a></li>

      </ul>

    </li>





    <li class="droplink {{setActive('admin/eods')}} "><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-book"></span><p>EODs</p><span class="arrow"></span></a>

      <ul class="sub-menu">

        <li><a href="{{URL('/admin/eods')}}">Eod List</a></li>
        <li><a href="{{ route('admin.hreod') }}"> HR Eod List</a></li> 

      </ul>

    </li>







    <li class="droplink {{setActive('admin/resignations')}}  {{setActive('admin/retract')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-briefcase"></span><p>Resignations</p><span class="arrow"></span></a>

      <ul class="sub-menu">

        <li><a href="{{URL('/admin/resignations')}}">Resignation List</a></li>
         <li><a href="{{URL('/admin/retract')}}">Retract List</a></li>



      </ul>

    </li>



    {{--

      <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-briefcase"></span><p>Meeting Invitation</p><span class="arrow"></span></a>

        <ul class="sub-menu">

          <li><a href="{{URL('/admin/inivitations')}}">Invitation List</a></li>

          <li><a href="{{URL('/admin/create-invitation')}}">Create Invitation</a></li>

        </ul>

      </li>

      --}}



      <li class="droplink {{setActive('admin/request/profile-update')}}  {{setActive('admin/leave-listing')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-inbox"></span><p>Requests</p><span class="arrow"></span></a>

        <ul class="sub-menu">

          <li><a href="{{URL('/admin/request/profile-update')}}">Profile Update Requests</a></li>

          <li><a href="{{URL('/admin/leave-listing?type=pending')}}">Leave Requests</a></li>

        </ul>

      </li>

      



      

      {{-- <li class=""><a href="{{URL('logout')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Logout</p></a></li> --}}

    </ul>

  </div><!-- Page Sidebar Inner -->

      </div><!-- Page Sidebar -->