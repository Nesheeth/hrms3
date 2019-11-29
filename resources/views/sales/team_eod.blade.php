@extends('sales.layouts.app')
@section('content')
@section('title','EODs')
<div class="page-inner">
   <div class="page-title">
      <h3>Team Members EODs</h3>
      <div class="page-breadcrumb">
         <ol class="breadcrumb">
            <li><a href="{{URL('sales/'.getRoleStr().'/dashboard')}}">Home</a></li>
            <li class="active">All EODs</a></li>
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
            <div class="panel panel-white">
               <div class="panel-heading clearfix">
                  <!-- <h4 class="panel-title">Sent EODs</h4> -->
               </div>
               <div class="panel">
                  <form action="{{url('admin/eods')}}" method="post">
                     {{ csrf_field() }}
                    <label class="col-md-2"> Filter EODs : </label>
                     <div class="col-md-3">
                        <select name="filter" class="form-control">
                           <option value=""> -- Select Project -- </option>
                           
                           <option value="1">Demo Project</option>
                           
                        </select>
                     </div>
                     <div class="col-md-1">
                        <button class="btn btn-success">GO</button>
                     </div>
                  </form>
               </div>
               <div class="panel-body">
                  <div class="table-responsive table-remove-padding">
                     <table class="table" id="eods">
								<thead>
									<tr> 
                              <th>S. No.</th>
										<th>EOD Date</th>
										<th>Project</th>
										<th>Task 1 </th>
										<th>Task 2</th>
										<th>Task 3 </th>
										<th>Task 4 </th>
										<th>Comments </th>
										
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($eods as $eod)
									<tr>
                              <td>{{$loop->iteration}}</td>
										<td>{{date('d M-Y', strtotime($eod->eod_date))}}</td>
										<td>Demo project</td>
                              <td>{{$eod->task_1}}</td>
                              <td>{{$eod->task_2}}</td>
                              <td>{{$eod->task_3}}</td>
                              <td>{{$eod->task_4}}</td>
										<td>{{$eod->comment}}</td>
										<td>
					                        <button class="btn btn-info btn-sm eod_details" rel="{{ $eod->id }}">  See Details </button> 
					                        <!-- <a href="{{URL('sales/'.getRoleStr().'/eod/delete/'.$eod->id)}}" class="btn btn-danger delete">Delete</a> -->
					                    </td>
									</tr>
									@endforeach
								</tbody>
							</table>

                      
                  </div>
                  {{--
                  <div class="row">
                     <div class="col-md-6">Showing {{$eods->firstItem()}} to {{$eods->lastItem()}} of {{$eods->total()}} entries</div>
                     <div class="col-md-6 pull-right">{{ $eods->links() }}</div>
                  </div>
                  --}}
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
<!-- Modal -->
<div id="eodModel" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Employee EOD Details</h4>
         </div>
         <div class="modal-body" id="eodModelDetails">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
@section('script')
<script type="text/javascript">
   $(document).ready(function(){ 

      $('#eods').dataTable();  
   
   	 $(document).on('click','.eod_details',function(){  
   
   	 	var id = $(this).attr('rel');
   
   	 	    $.ajax({
   
   	 	    	url:"{{route('sales.eod_details',['role'=> getRoleStr()])}}",  
   
   	 	    	type:"GET",
   
   	 	    	data:{id:id},
   
   	 	    	success:function(res){ 
   
   	 	    		$('#eodModelDetails').html(res); 
   
   	                $('#eodModel').modal('show');  
   
   	 	    	}
   
   	 	    });
        });




   });

 $(document).on('click','.delete', function(){

      
 });
</script>
@endsection

@endsection