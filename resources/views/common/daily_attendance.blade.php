
<form class="modal-content"  id="updateAttendence">
	<div class="table-responsive" style="overflow: hidden;">
	 {{csrf_field()}}
		<table class="table display" style="width: 100%; cellspacing: 0;">
				<thead>
					<tr>
						<th> Employee Id</th>
						<th> Employee Name</th>
						<th> In Time</th>
						<th> Out Time</th>
						<th> Action</th>
						<th> Late Login</th>
					</tr>
				</thead>
				<tbody>
					   @foreach( $attendance as $key=>$employee)
							<tr>
								<td>
								   <b> {{$employee['employee_id']}} </b>  
								   <input type="hidden" name="attendance[{{@$key}}][attendance_date]" value="{{$current_date}}">
									<input type="hidden" name="attendance[{{@$key}}][employee_id]" value="{{$employee['employee_id']}}">
									<input type="hidden" name="attendance[{{@$key}}][attendance_id]" value="{{$employee['attendance_id']}}"> 
								</td>
								<td>{{$employee['first_name']}} {{ $employee['last_name']}}</td>
								<td>{{($employee['status'] == 'AB') ? '' :$employee['in_time'] }}</td>
								<td>{{($employee['status'] == 'AB') ? '' :$employee['out_time'] }}</td> 
								<td>
									<select id="ST{{$employee['employee_id']}}" 
										   class="at_status {{getAttendanceBydate(date('Y-m-d'),$employee['employee_id'])}}" 
										   name="attendance[{{@$key}}][status]" rel="{{$key}}"> 
										@foreach($dayTypes as $dayType)
										<option class="{{$dayType->short_name}}" style="color:#262626;" value="{{$dayType->short_name}}"
											{{ ($employee['status'] == $dayType->short_name) ? 'selected' : '' }} > {{$dayType->short_name}} </option> 
											@endforeach
									</select> 
								</td>
								<td>
									<select id="latelogin" name="attendance[{{@$key}}][latelogin]">
										<option value="2" selected>No</option>
										<option value="1">Yes</option> 
									</select>	
									<input type="hidden" name="attendance[{{@$key}}][remark]" />
									
								</td>
							</tr>
					   @endforeach
				</tbody>
		</table>
	</div>
</form>

<script>
 function changeColor(t,id){ 
		document.getElementById(id).className = t.value; 
	}
</script>