<div class="page-inner">
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">				
				<div class="panel panel-white">
					<div class="panel-body">						
						
						<div class="col-md-12">
							<h2 class="pull-left">Attendance Report of Month {{date("F", strtotime('2018-'.$current_month.'-01'))}} of {{$search_year}}</h2>
						</div>
						<hr>
						<table class="table table-bordered">
							<thead>
								<th>
								EmpId
								</th>
								<th>EmpName</th>
								<th>Present</th>
								<th>Absent</th>
								<th>Half day</th>
								<th>UI</th>
								<th>Sandwitch</th>
								<th>Late Login</th>
							</thead>
							<tbody>
								@foreach ($employees as $employee)
									<tr>
										<td>{{$employee->employee_id}}</td>
										<td>{{$employee->first_name}} {{$employee->last_name}}  
                                           @php
                                           		if(date('m')!=1){
											        $y = date('Y');
											        $m = date('m')-1;
											    }
											    else{
											        $y = date('Y')-1;
											        $m=12;
											    }
											    $startdate   = strtotime($y . '-' . $m . '-01');
											    $enddate     = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
											    $start = date('Y-m-d',$startdate);
    											$end = date('Y-m-d',$enddate);
												$arr = [];
												
												$arr = calculate_attendance($employee->id,$start,$end);
												extract($arr);
												
											@endphp
										</td>
										
										<td>{{$present}}</td>
										<td>{{$leaves}}</td>
										<td>{{$half_day}}</td>
										<td>{{$ui}}</td>
										<td>{{$sandwich_leave}}</td>
										<td>{{$late_login}}</td>
									</tr>
								@endforeach
							</tbody>
							
						</table>
					</div>
					
						
				</div>
			</div>
		</div><!-- Row -->
	</div>
</div>
				