
<br>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-condensed">
      <tr>
          <th>Name</th>
          <th>Role</th>
          <th>Assign Date</th>
          <th>Assign %</th>
          <th>Notes</th>
          <th>Assign By</th>
          <th>Last Update</th>
          <th>Action</th>
        </tr>
      @foreach($users as $u)
        <tr>
          <td>{{$u->employee->first_name}} {{$u->employee->last_name}}</td>
          <td>{{$u->role->name}}</td>
          <td>{{date('d M Y', strtotime($u->start_date))}}</td>
          <td>{{$u->assign_percentage}} %</td>
          <td>{{$u->performance_notes}}</td>
          <td>{{$u->assign->first_name}} {{$u->assign->last_name}}</td>
          <td>{{$u->last_update->first_name}} {{$u->last_update->last_name}}</td>
          <td><button rel="{{$u->id}}" class="btn btn-info edit_assign">Edit</button></td>
        </tr>
      @endforeach
  </table>
</div>

