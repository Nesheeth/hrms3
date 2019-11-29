
<div class="page-sidebar sidebar">
   
      <div class="page-sidebar-inner slimscroll">
        <div class="sidebar-header">
            <div class="sidebar-profile">
         
            <div class="sidebar-profile-image">
              
                @php
                    $img = (@Auth::user()->cb_profile->employee_pic) ? Auth::user()->cb_profile->employee_pic : asset('images/employees/default-user.png')
                @endphp
                
              <img src="{{$img}}" class="img-circle img-responsive" alt="">  
          
          </div>
          <div class="sidebar-profile-details">
          <span>{{Auth::user()->first_name}} {{Auth::user()->last_name}}<br> <small>{{getRoleById(Auth::user()->role)}}</small></span>
          </div>
      
      </div>
      </div>

    <ul class="menu accordion-menu"> 
        <li class="{{ setActive('sales/'.getRoleStr().'/dashboard') }}">
          <a href="{{ URL('sales/'.getRoleStr().'/dashboard') }}" class="waves-effect waves-button">
            <span class="menu-icon fa fa-tachometer"></span><p>Dashboard</p>
          </a> 
        </li>

         @if(Auth::user()->role==4 || Auth::user()->role==6)
        <li>
          <a href="{{route('sl.salary',['role'=> getSalesRole() ])}}">
          <span class="menu-icon fa fa-money "></span>
          <p>Salary</p></a>
        </li>
        @endif

       
          @if(Auth::user()->role!=1 && Auth::user()->role!=8) 
          <li class="droplink"> 
              <a href="#" class="waves-effect waves-button">
              <span class="menu-icon glyphicon glyphicon-briefcase"></span>
              <p> EODs </p> <span class="arrow"></span></a>
              <ul class="sub-menu"> 
                @if(Auth::user()->role ==4)
                <li> <a href="{{ route('sales_team_eods',['role'=> getSalesRole() ]) }}"> Team Member's EOD </a> </li>

                @endif
                <li> <a href="{{ route('sl.send_eod',['role'=> getSalesRole() ]) }}"> Send EOD </a> </li> 
                <li> <a href="{{ route('sl.eods',['role'=> getSalesRole() ]) }}"> My EODs </a> </li>  

              </ul> 
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
                      <li> <a href="{{ route('sl.apply_leave',['role'=> getRoleStr() ]) }}" {{ (Auth::user()->is_active==1)?'':'disabled' }}> Apply Leave</a> </li>
                      @else
                          
                      @endif
                      
                      <li> <a href="{{route('sl.leave_mng',[ 'role' => getSalesRole()] )}}">My Leaves</a> </li>
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
                <li><a href="{{ URL('/employee/retract') }}">View Retract</a></li>
              @endif
            </ul>
          </li>
          @endif

      

        

  {{-- <li class=""><a href="{{URL('logout')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Logout</p></a></li> --}}

</ul>
</div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->