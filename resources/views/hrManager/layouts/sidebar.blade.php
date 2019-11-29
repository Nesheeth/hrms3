      <div class="page-sidebar sidebar">



        <div class="page-sidebar-inner slimscroll">



          <div class="sidebar-header">



            <div class="sidebar-profile">



              <!-- <a href="javascript:void(0);" id="profile-menu-link"> -->



                <a href="javascript:void(0);">



                 <div class="sidebar-profile-image">



                  <a href="{{URL('/hrManager/dashboard')}}"><img src="{{@\Auth::user()->cb_profile->employee_pic}}" class="img-circle img-responsive" alt=""></a>



                </div>



                <div class="sidebar-profile-details">



                  <span>{{\Auth::user()->first_name}}<br><small>{{@\Auth::user()->cb_profile->designation}}</small></span>



                </div>



              </a>



            </div>



          </div>















          <ul class="menu accordion-menu">



            <li class="{{setActive('hrManager/dashboard')}}"><a href="{{URL('/hrManager/dashboard')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>







            <li class="droplink {{setActive('hrManager/employees')}} {{setActive('hrManager/add-employee')}} {{setActive('hrManager/upload-employee')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-users"></span><p>Employees</p><span class="arrow"></span></a>



              <ul class="sub-menu">



                <li><a href="{{URL('/hrManager/employees')}}">Employee Listing</a></li>



                <li><a href="{{URL('/hrManager/add-employee')}}">Add New Employee</a></li>



                {{--<li><a href="{{URL('/hrManager/upload-employee')}}">Upload</a></li>--}}



              </ul>



            </li>







            <li class="droplink {{setActive('hrManager/attendance')}}



            {{setActive('hrManager/leave-details')}}  



            {{setActive('hrManager/leave-types')}}



            {{setActive('hrManager/add-leave-type')}}



            



            {{setActive('hrManager/holidays')}}



            {{setActive('hrManager/add-holiday')}}



            {{setActive('hrManager/holiday-calender')}}"



            ><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-calendar"></span><p>Attendance / Leave</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <li><a href="{{URL('/hrManager/attendance')}}">Attendance List</a></li>



              <li><a href="{{URL('/hrManager/leave-details')}}">Leave Details</a></li>              



              <li><a href="{{URL('/hrManager/leave-types')}}">Leave Types</a></li>



              <li><a href="{{URL('/hrManager/add-leave-type')}}">Add Leave Types</a></li>



              <li><a href="{{URL('/hrManager/leave-listing')}}">Leave Listing</a></li>



              <li><a href="{{URL('/hrManager/holidays')}}">Holidays List</a></li>



              <li><a href="{{URL('/hrManager/add-holiday')}}">Add Holiday</a></li>



              <li><a href="{{URL('/hrManager/holiday-calender')}}">Holiday Calender</a></li>



            </ul>



          </li>







          <li class="droplink {{setActive('hrManager/assign-team-members')}} {{setActive('hrManager/teams')}} "><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon fa fa-users"></span><p>Teams</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <li><a href="{{URL('/hrManager/teams')}}"> Teams </a></li>



              <li><a href="{{URL('/hrManager/assign-team-members')}}">Assign Team Members</a></li>



            </ul>



          </li>











          <li class="droplink {{setActive('hrManager/request/profile-update')}} {{setActive('hrManager/leave-listing')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-inbox"></span><p>Requests</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <li><a href="{{URL('/hrManager/request/profile-update')}}">Profile Update Requests</a></li>



              <li><a href="{{URL('/hrManager/leave-listing?type=pending')}}">Leave Requests</a></li>



            </ul>



          </li>







          <li class="droplink {{setActive('hrManager/send-eod')}} {{setActive('hrManager/sent-eods')}} "><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon fa fa-pencil"></span><p>EOD</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <li><a href="{{URL('/hrManager/send-eod')}}"> Send EOD </a></li>



              <li><a href="{{URL('/hrManager/sent-eods')}}">View EODs</a></li>



            </ul>



          </li> 







          <li class="droplink {{setActive('hrManager/apply-leave')}} {{setActive('hrManager/my-leaves')}} "><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon fa fa-calendar"></span><p>My Leaves</p><span class="arrow"></span></a>



            <ul class="sub-menu">



           <!--    <li><a href="{{URL('/hrManager/apply-leave')}}"> Apply Leave </a></li> -->

             @if(is_null(\Auth::user()->resignation))

               

              <li><a href="{{URL('/hrManager/apply-leave')}}" {{ (Auth::user()->is_active==1)?'':'disabled' }}>Apply Leave</a></li>

               

               @else

               

               

               

              @endif



              <li><a href="{{URL('/hrManager/my-leaves')}}">Applied Leaves</a></li>



            </ul>



          </li>







          <li class="droplink {{setActive('/resign')}}">



            <a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Resignation</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <li><a href="{{URL('/hrManager/resignations')}}">View Employee's Resignations</a></li>



              <!-- @if(is_null(\Auth::user()->resignation))



              <li><a href="{{URL('/resign')}}">Apply Resignation</a></li>



              @else



              <li><a href="{{URL('/resign')}}">View Resignation</a></li>



              @endif -->



                           <?php if(is_null(\App\Resignation::where('user_id',\Auth::user()->id)->first())) { ?>

              <li><a href="{{URL('/resign')}}">Apply Resignation</a></li>

      

              <?php } elseif(is_null(\App\Retract::where('user_id',\Auth::user()->id)->first())) { ?>

              <li><a href="{{URL('/resign')}}">View Resignation</a></li>

             <?php }else  {?>

              <li><a href="{{URL('/hrManager/retract')}}">View Retract</a></li>

            <?php } ?>

             



            </ul>



          </li>







          



          {{-- <li class=""><a href="{{URL('logout')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Logout</p></a></li> --}}















        </ul>



      </div><!-- Page Sidebar Inner -->



      </div><!-- Page Sidebar -->