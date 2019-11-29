      <div class="page-sidebar sidebar">



      	<div class="page-sidebar-inner slimscroll">



      		<div class="sidebar-header">



      			<div class="sidebar-profile">



              <!-- <a href="javascript:void(0);" id="profile-menu-link"> -->



                <a href="javascript:void(0);">



                 <div class="sidebar-profile-image">



                  <a href="{{URL('/employee/dashboard')}}"><img src="{{\Auth::user()->cb_profile->employee_pic}}" class="img-circle img-responsive" alt=""></a>



                </div>



                <div class="sidebar-profile-details">



                  <span>{{\Auth::user()->first_name}}<br><small>{{\Auth::user()->cb_profile->designation}}</small></span>



                </div>



              </a>



            </div>



          </div>







          <ul class="menu accordion-menu">



           <li class="{{setActive('employee/dashboard')}}"><a href="{{URL('/employee/dashboard')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>







           <li class="droplink {{setActive('employee/apply-leave')}}  {{setActive('employee/my-leaves')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-briefcase"></span><p>Leaves</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <!-- <li><a href="{{URL('/employee/apply-leave')}}">Apply Leave</a></li> -->

                @if(is_null(\Auth::user()->resignation))

               

              <li><a href="{{URL('/employee/apply-leave')}}" {{ (Auth::user()->is_active==1)?'':'disabled' }}>Apply Leave</a></li>

               

               @else

               

               

               

              @endif



              <li><a href="{{URL('/employee/my-leaves')}}">My Leaves</a></li>



            </ul>



          </li>

          @if(Auth::user()->role == 4)

          <li class="droplink {{setActive('teamLead/projects')}} 

        {{setActive('teamLead/add-project')}} 

        {{setActive('teamLead/assign-project')}} 

        {{setActive('teamLead/employee-projects')}} "><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-folder"></span><p>Project</p><span class="arrow"></span></a>

        <ul class="sub-menu">

        <!--   <li><a href="{{URL('/teamLead/projects')}}">Project List</a></li> -->

          <!-- <li><a href="{{URL('/teamLead/add-project')}}">Add New Project</a></li> -->

          <li><a href="{{URL('/teamLead/assign-project')}}">Assign Project</a></li>

          <li><a href="{{URL('/teamLead/employee-projects')}}">Team Project List</a></li>

        </ul>

      </li>

       @endif







          <li class="droplink {{setActive('employee/send-eod')}} {{setActive('employee/sent-eods')}}"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-briefcase"></span><p>EODs</p><span class="arrow"></span></a>



            <ul class="sub-menu">







            	@if(Auth::user()->role == 4)



              <li><a href="{{URL('/employee/see-eod')}}">Team Member's EOD</a></li>



              @endif







              <li><a href="{{URL('/employee/sent-eods')}}">My Sent EODs</a></li>



              <li><a href="{{URL('/employee/send-eod')}}">Send</a></li>



            </ul>



          </li>







          <li class="droplink {{setActive('resign')}}">



            <a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Resignation</p><span class="arrow"></span></a>



            <ul class="sub-menu">



              <!-- @if(is_null(\Auth::user()->resignation))



              <li><a href="{{URL('/resign')}}">Apply Resignation</a></li>

              @else

              <li><a href="{{URL('/resign')}}">View  Resignation</a></li>

             @endif -->



            

                           <?php if(is_null(\App\Resignation::where('user_id',\Auth::user()->id)->first())) { ?>

              <li><a href="{{URL('/resign')}}">Apply Resignation</a></li>

      

              <?php } elseif(is_null(\App\Retract::where('user_id',\Auth::user()->id)->first())) { ?>

              <li><a href="{{URL('/resign')}}">View Resignation</a></li>

             <?php }else  {?>

              <li><a href="{{URL('/employee/retract')}}">View Retract</a></li>

            <?php } ?>

             

              

            

             

                

                

           

              



            </ul>



          </li>



          



          {{-- <li class=""><a href="{{URL('logout')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Logout</p></a></li> --}}



        </ul>



      </div><!-- Page Sidebar Inner -->



      </div><!-- Page Sidebar -->