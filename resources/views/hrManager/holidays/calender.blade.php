@extends('hrManager.layouts.app')
@section('content')
@section('title','Holidays')
<style>
   td
   {
      text-align:center;
      padding: 2px;
   }
   .holiday {
   background-color: green;
   color: #fff;
   font-weight:700;
   font-size:1em;
   }
   .table td:nth-child(2)
   {background-color:#FFC200;
   }
   .table td:nth-child(9),td:nth-child(8)
   {background-color:#FFC200;
   }
   .table td:nth-child(16),td:nth-child(15)
   {background-color:#FFC200;
   }
   .table td:nth-child(23),td:nth-child(22)
   {background-color:#FFC200;
   }
   .table td:nth-child(30),td:nth-child(29)
   {background-color:#FFC200;
   }
   .table td:nth-child(37),td:nth-child(36)
   {background-color:#FFC200;
   }
   .table th:nth-child(1)
   {background-color:#34425a
   color:#fff;
   font-weight:700;
   }
   .table td:nth-child(1)
   {/*background-color:#34425a;*/
   color:#fff;
   font-weight:700;
   }
   .table th {
   background-color: #22baa0;
   color: #fff;
   font-weight: 700;
   }
   .table tbody td {
   border: 1px solid;
   font-weight: 700;
   }
   .table thead th {
   border: 1px solid;
   font-weight: 700;
   }
   .table td, .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
   padding: 4px!important;
   }
   td.empty-grey {
    background: grey;
    opacity: 0.8;
}

#example tbody tr:nth-child(odd) {
    background: #4084d06b;
}

#example tbody tr:nth-child(odd) td.nr {
    background: #2185d0;
}

#example tbody tr:nth-child(even) td.nr {
    background: #34415a;
}
</style>
<div class="page-inner">
   <div class="page-title">
      <h3>Holidays Calender / Attendance</h3>
      <div class="page-breadcrumb">
         <ol class="breadcrumb">
            <li><a href="{{URL('/employee/dashboard')}}">Home</a></li>
            <li class="active">Holidays Calender</a></li>
         </ol>
      </div>
   </div>
   <div id="main-wrapper">
      <div class="row">
         <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ session('error') }}
            </div>
            @endif
            <?php $employee_id= Auth::user()->cb_profile->employee_id; ?>
            <div class="panel panel-white">
               <div class="panel-body">
                  <div class="table-responsive" id="select-year110">

                      <a style="margin-bottom:10px" class="btn btn-primary view" data-target-id="1" data-toggle="modal" data-target="#myModal">View Details</a><br/>
                     
                     @if(Auth::user()->role!=6)
                     <form class="form-inline">
                        <div class="form-group">
                           <label class="sr-only">Select Year: </label>
                           <select name="year" id="year" class="form-control">
                           @for($curyear = date('Y'); $curyear >= 2017; $curyear--)
                           <option value="{{$curyear}}" {{$year == "$curyear"?"selected":''}}>{{$curyear}}</option>
                           @endfor
                           </select>
                        </div>
                        <div class="form-group">
                           <label class="sr-only">Select Category: </label>
                           <select name="category" id="category" class="form-control">
                              <option value="development" {{$category == "development"?"selected":''}}>Development</option>
                              <option value="sales" {{$category == "sales"?"selected":''}}>Sales</option>
                              <!-- <option value="{{$category}}">{{$category}} </option> -->
                           </select>
                        </div>
                        <button id="filterCalender" class="btn btn-primary">Show</button>	
                     </form>
                     @endif


                     
                     <table id="example" class="display table"  style="width: 100%;" cellspacing="0">
                        <thead>
                           <tr>
                              <th>Month</th>
                              <th>Sun</th>
                              <th>Mon</th>
                              <th>Tues</th>
                              <th>Wed</th>
                              <th>Thur</th>
                              <th>Fri</th>
                              <th>Sat</th>
                              <th>Sun</th>
                              <th>Mon</th>
                              <th>Tues</th>
                              <th>Wed</th>
                              <th>Thur</th>
                              <th>Fri</th>
                              <th>Sat</th>
                              <th>Sun</th>
                              <th>Mon</th>
                              <th>Tues</th>
                              <th>Wed</th>
                              <th>Thur</th>
                              <th>Fri</th>
                              <th>Sat</th>
                              <th>Sun</th>
                              <th>Mon</th>
                              <th>Tues</th>
                              <th>Wed</th>
                              <th>Thur</th>
                              <th>Fri</th>
                              <th>Sat</th>
                              <th>Sun</th>
                              <th>Mon</th>
                              <th>Tues</th>
                              <th>Wed</th>
                              <th>Thur</th>
                              <th>Fri</th>
                              <th>Sat</th>
                              <th>Sun</th>
                              <!-- <th>Mon</th>
                              <th>Tues</th>
                              <th>Wed</th> -->
                           </tr>
                        </thead>
                        <tbody>
                           @for ($i = 1; $i <= 12; $i++)
                           <tr>
                              
                              <td class="nr">{{date("F", mktime(0, 0, 0, $i, 15))}}</td>
                              
                              
                              <?php $days = cal_days_in_month(CAL_GREGORIAN,$i,$year);?>
                              @for ($j = 1; $j <= $days; $j++)
                              <?php
                                 $date = $year.'/'.$i.'/'.$j; 
                                 
                                 $cdate = $year.'-'.$i.'-'.$j; 
                                 
                                 if(strlen($j) == 1){$j = '0'.$j;}
                                 
                                 if(strlen($i) == 1){$i = '0'.$i;}
                                 
                                 $current_date = $i.'/'.$j.'/'.$year; 
                               
                                 $get_name = date('l', strtotime($date)); 
                                 
                                 $day_name = substr($get_name, 0, 3);
                                 
                                 $holiday = holidayComment($current_date,$category);
                                 
                                 
                                 if($j == 1 && $day_name == 'Sun'){
                                  if(isHoliday($current_date,$category)){?>
                              <td class="holiday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?> 
                              <?php }elseif( $j == 1 && $day_name == 'Mon'){?>
                              <?php if(isHoliday($current_date,$category)){?>
                              <td class="empty-grey"></td>
                              <td class="holiday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="empty-grey"></td>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?>
                              <?php }elseif( $j == 1 && $day_name == 'Tue'){
                                 if(isHoliday($current_date,$category)){?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="myHoliday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?>
                              <?php }elseif( $j == 1 && $day_name == 'Wed'){
                                 if(isHoliday($current_date,$category)){?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="myHoliday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?>
                              <?php }elseif( $j == 1 && $day_name == 'Thu'){
                                 if(isHoliday($current_date,$category)){?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="myHoliday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?>
                              <?php }elseif( $j == 1 && $day_name == 'Fri'){
                                 if(isHoliday($current_date,$category)){?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="myHoliday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?>
                              <?php }elseif( $j == 1 && $day_name == 'Sat'){
                                 if(isHoliday($current_date,$category)){?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="myHoliday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="empty-grey"></td>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php }?>
                              <?php }else{
                                 if(isHoliday($current_date,$category)){?>
                              <td class="myHoliday" data-toggle="tooltip" data-placement="top" title="{{$holiday->comments}}">{{$j}}</td>
                              <?php }else{?>
                              <td class="{{getAttendanceBydate($cdate,$employee_id)}}">{{$j}}</td>
                              <?php } } ?>
                              @endfor
                           </tr>
                           @endfor
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="panel-body" style="padding:10px 20px">
                  <div class="col-md-12 colorpanel table-responsive">
                     <table  class="display colorpaneltable" cellspacing="0" width="auto" style="float: left;border-right: 1px solid #e4e4e4">
                        <tr>
                           <td class="colorswach P"></td>
                           <td>Present</td>
                           <td class="colorswach HD"></td>
                           <td>Half Day</td>
                           <td class="colorswach UI"></td>
                           <td>Un-Informed Leave</td>
                           <td class="colorswach OT"></td>
                           <td>Over Time</td>
                           <td class="colorswach AB"></td>
                           <td>Absent</td>
                           <td class="colorswach myHoliday"></td>
                           <td>Company Holiday</td>
                           <td class="colorswach sun"></td>
                           <td>Weekend</td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Row -->
   </div>

   

   <!-- Main Wrapper -->
   <div class="page-footer">
      <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
   </div>
</div>
<!-- Page Inner -->
@section('script')
<script>
   $(document).ready(function() {
	   	$('#filterCalender').on('click',function(event) {
	   		var year = $('#year option:selected').val();
	   		var category = $('#category option:selected').val();
	   		var url = "{{URL('/employee/holiday-calender')}}";
	   		window.location = url+'?year='+year+'&category='+category;
	   	});
   });

  
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>
 <script>
    $(document).on('click','.view',function(){ 
       
        var user = $(this).attr('rel');  
        var role = "{{getRoleStr()}}";
        BootstrapDialog.show({
            title:"Select month & Year",
            message: $('<div> Please wait loading page...</div>').load("{{route('hrcalender')}}"),   
            buttons:[{   
                label:"view",
                cssClass:"btn btn-success",
                action: function(dialog){  
                   var month = $('#payroll_month').val();
                   var year = $('#payroll_year').val();
                   console.log(month);
                   console.log(year);
                   if((month != 0) && (year != 0))
                   {
                   /*========================================================*/
                         BootstrapDialog.show({
                              title:"Attendance of month "+ month,
                              size:BootstrapDialog.SIZE_WIDE,
                              message: $('<div> Please wait loading page...</div>').load("{{route('hrcalenderdata')}}?month="+month+"&year="+year),   
                              buttons:[{   
                                  label:"close",
                                  cssClass:"btn btn-danger",
                                  action: function(dialog1){  
                                    dialog1.close();

                                 }
                              }]
                              }); 

                   /*========================================================*/
                   }
                     else
                     {
                        BootstrapDialog.alert('<b>Please Select The Year & Month First!!</b>');
                     }
                } 
            },{
                label:"Close",
                cssClass:"btn btn-danger",
                action: function(dialog){
                    dialog.close();
                }
            }]
        });
    });

 </script>

@endsection
@endsection