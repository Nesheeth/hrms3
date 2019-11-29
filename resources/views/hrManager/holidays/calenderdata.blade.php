<style>
  .table-attendance-2 tbody tr td:last-child {
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 100px;
    overflow: hidden;
}
.rcrdattnd tr td span {
    display: block;
    padding: 5px;
    font-size: 13px;
    color: #fff;
}

.rcrdattnd tr td:nth-child(1) span {
    background: #059405;
}

.rcrdattnd tr td {
    color: #000 !important;
    padding: 0 !important;
    border: 0;
    background: transparent !important;
    box-shadow: 0 0 5px #ccc;
    font-size: 18px;
}

.rcrdattnd tr td:nth-child(2) span {
    background: #3651b3;
}

.rcrdattnd tr td:nth-child(3) span {
    background: #ff0707;
}

.rcrdattnd tr td:nth-child(4) span {
    background: grey;
}
.table-attendance-2 td:first-child {
    color: #4e5e6a;
}
.table-attendance-2 td:nth-child(2){
  background: transparent !important;
}
.table-attendance-2 thead th {
    text-align: center;
}
</style>
<?php $employee_id= Auth::user()->cb_profile->employee_id; ?>
<div class="panel panel-white " >

    <div class="panel-body">
        <table class="table table-attendance rcrdattnd">
          <tr>
            <td>
              <span>Total Present:</span>{{$presents}}
            </td>
            <td>
              <span>Total Absent:</span>{{$absents}}
            </td>
            <td>
              <span>Total Late Login:</span>{{$latelogin}}
            </td>
            <td>
              <span>Total Amount:</span>₹0
            </td>
          </tr>
        <table>
        <div class="row">
            <div class="col-md">
                <table class=" table table-responsive table-stripped table-attendance-2">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Shift In Time</th>
                        <th>Shift Out Time</th>
                        <th>Late Login Status</th>
                        <th>Amount</th>
                        <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody>
                  
                     @foreach($attendance as $data) 
                      <tr>
                 
                        @if($data != null)
                          <td><b>{{date("d/m/Y",strtotime($data->attendance_date))}}</b></td>
                          <td><b>{{date("h:i:s a",strtotime($data->in_time))}}</b></td>
                          <td><b>{{date("h:i:s a",strtotime($data->out_time))}}</b></td>
                                @if($data->late_login==2)
                                  <td class="text-success"><b>No</b></td>
                                @else
                                  <td class="text-danger"><b>Yes</b></td>
                                @endif

                                  <td>₹0</td>
                              
                               
                                <td>
                                  @foreach($data->log as $logs)
                                  {{$logs->reason}}
                                  @endforeach
                                </td>
                               
                              
                              
                       @else
                          <td><b>N/A</b></td>
                          <td><b>N/A</b></td>
                          <td><b>N/A</b></td>
                          <td><b>N/A</b></td>
                       @endif  
                      </tr>
                      @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



  

