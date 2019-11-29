      <div class="page-sidebar sidebar">



      	<div class="page-sidebar-inner slimscroll">



      		<div class="sidebar-header">



      			<div class="sidebar-profile">



              <!-- <a href="javascript:void(0);" id="profile-menu-link"> -->



                <a href="javascript:void(0);">



                 <div class="sidebar-profile-image">



                   <img src="{{\Auth::user()->cb_profile->employee_pic}}" class="img-circle img-responsive" alt="">



                 </div>



                 <div class="sidebar-profile-details">



                  <span>{{\Auth::user()->first_name}}<br><small>{{getRoleById(\Auth::user()->role)}}</small></span>



                </div>



              </a>



            </div>



          </div>







          <ul class="menu accordion-menu">



           <li class="{{setActive('itExecutive/dashboard')}}"><a href="{{URL('/itExecutive/dashboard')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>







           <li class="droplink {{setActive('itExecutive/assets')}}



           {{setActive('itExecutive/add-asset')}}



           {{setActive('itExecutive/systems')}}



           {{setActive('itExecutive/add-system')}}



           "><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-cogs"></span><p>Asset Management</p><span class="arrow"></span></a>



           <ul class="sub-menu">



            <li><a href="{{URL('/itExecutive/assets/all_assets')}}">All Asset List</a></li>



            <li><a href="{{URL('/itExecutive/add-asset')}}">Create Asset</a></li>



            <li><a href="{{URL('/itExecutive/assets/all_system')}}">Systems</a></li>



            <li><a href="{{URL('/itExecutive/add-system')}}">Create System</a></li>



          </ul>



        </li>







        <li class="droplink {{setActive('itExecutive/apply-leave')}}  {{setActive('itExecutive/my-leaves')}}"><a href="#" class="waves-effect waves-button nnn"><span class="menu-icon fa fa-calendar"></span><p>Leaves</p><span class="arrow"></span></a>



          <ul class="sub-menu">



           <!--  <li><a href="{{URL('/itExecutive/apply-leave')}}">Apply Leave</a></li> -->

             @if(is_null(\Auth::user()->resignation))

               

              <li><a href="{{URL('/itExecutive/apply-leave')}}" {{ (Auth::user()->is_active==1)?'':'disabled' }}>Apply Leave</a></li>

               

               @else

               

               

               

              @endif



            <li><a href="{{URL('/itExecutive/my-leaves')}}">My Leaves</a></li>



          </ul>



        </li>



       



          <li class="droplink {{setActive('itExecutive/send-eod')}} {{setActive('itExecutive/sent-eods')}}"><a href="#" class="waves-effect waves-button nesh"><span class="menu-icon fa fa-book"></span><p>EODs</p><span class="arrow"></span></a>



           



              <ul class="sub-menu nesh">
				  <li><a href="{{route('cm.send_eod', ['role'=> getRoleStr()] )}}">Send  </a></li>
				  <li><a href="{{URL('/itExecutive/sent-eods')}}">My Sent EODs</a></li> 
				</ul>



         



          </li>



          



          <li class="droplink {{setActive('resign')}}">



            <a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Resignation</p><span class="arrow"></span></a>



            <ul class="sub-menu">



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

              <li><a href="{{URL('/itExecutive/retract')}}">View Retract</a></li>

            <?php } ?>

             



            </ul>



          </li>



          



          {{-- <li class=""><a href="{{URL('logout')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Logout</p></a></li> --}}







        </ul>



      </div><!-- Page Sidebar Inner -->



      </div><!-- Page Sidebar -->