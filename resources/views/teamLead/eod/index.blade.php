@extends('admin.layouts.app')
@section('content')
@section('title','EODs')
<div class="page-inner">
   <div class="page-title">
      <h3>EODs</h3>
      <div class="page-breadcrumb">
         <ol class="breadcrumb">
            <li><a href="{{URL(getRoleStr().'/dashboard')}}">Home</a></li>
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
                  <form action="{{route('cm.eod_filter',['role'=> getRoleStr()])}}" method="post">
                     {{ csrf_field() }}
                    <label class="col-md-2"> Filter EODs : </label>
                     <div class="col-md-3">
                        <select name="filter" class="form-control">
                           <option value=""> -- Select Project -- </option>
                           @foreach($eods_filter as $name)
                            <option value="{{$name->id}}" {{(@$req==$name->id) ? 'selected' : '' }}> {{$name->project_name}} </option>
                           @endforeach
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
                              <th>EOD Date</th>
                              <th>Emp Name</th>
										
										<th>Project</th>
										<th>Task Name </th>
										<th>Description</th>
										<th>ES Time </th>
										<th>Total Time </th>
										<th>Delivery Date </th>
										<th>Project Status</th>
                              
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($eods as $eod)
									<tr>
                              
										<td>{{date('d M-Y', strtotime($eod->date))}}</td>
                              <td>{{getEmpName($eod->user_id)}}</td>
										<td>{{$eod->project->project_name}}</td>
										<td>{{$eod->task_name}}</td>
										<td>{{ substr($eod->description,0,50) }}</td>
										<td>{{$eod->es_hours}}</td>
										<td>{{$eod->total_hours}}</td>
										<td>{{date('d M-Y', strtotime($eod->delivery_date))}}</td>
										<td> <span title="{{$eod->eod_reason}}" class="label  label-primary"> {{$eod->task_status}} </span>  
										</td>
                             
										<td>
					                        <!-- <button class="btn btn-info btn-sm eod_details" rel="{{ $eod->id }}">  See Details </button>  -->
					                       <!--  <a href="{{URL('admin/eod/delete/'.$eod->id)}}" class="btn btn-danger">Delete</a> -->
                                      @if($eod->edit_eod_request == 1)
                                        <button class="btn btn-success btn-sm eod_edit_request_accept" rel="{{ $eod->id }}" onclick="edit_Accept({{ $eod->id }})">  Accept </button> 
            <button class="btn btn-danger btn-sm eod_edit_request_reject" rel="{{ $eod->id }}" onclick="edit_Reject({{ $eod->id }})">  Reject </button> 
                                      @endif
                                      @if($eod->edit_eod_request == 2)
                                        <span class="text-success"> Accepted</span>
                                      @endif
                                      @if($eod->edit_eod_request == 3)
                                        <span class="text-danger"> Rejected</span>
                                      @endif
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
<div id="eodeditModel" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Eod Edit Request</h4>
         </div>
         <div class="modal-body" id="eodeditlDetails">
            <button class="btn btn-success btn-sm eod_edit_request_accept" rel="{{ $eod->id }}">  Accept </button> 
            <button class="btn btn-danger btn-sm eod_edit_request_reject" rel="{{ $eod->id }}">  Reject </button> 
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
    });
      

       function edit_Reject(t){  
          swal({
           title: "Are you sure?",
           text: "Are You want to reject the request of edit eod..",
           type: "warning",
           buttons: true,
           dangerMode: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
         })
         .then((willDelete) => {
            if (willDelete) { 
                 var id = t;
             $.ajax({
   
               url:"{{url(getRoleStr().'/edit-eod-update-request-reject')}}",  
   
               type:"GET",
   
               data:{'id':id},
   
               success:function(res){ 
   
                  if(result.status){
                    swal("Success","Accept Successfully..","success");
                  location.reload();
                    }
               }
   
             });
          }
        });
          }
   
   // 	 $(document).on('click','.eod_details',function(){  
   
   // 	 	var id = $(this).attr('rel');
   
   // 	 	    $.ajax({
   
   // 	 	    	url:"{{route('admin.eod_details',['role'=> getRoleStr()])}}",  
   
   // 	 	    	type:"GET",
   
   // 	 	    	data:{id:id},
   
   // 	 	    	success:function(res){ 
   
   // 	 	    		$('#eodModelDetails').html(res); 
   
   // 	                $('#eodModel').modal('show');  
   
   // 	 	    	}
   
   // 	 	    });
   //      });
   // });

   function edit_Accept(t){
           
          swal({
           title: "Are you sure?",
           text: "Are You want to accept the request of edit eod..",
           type: "warning",
           buttons: true,
           dangerMode: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
         })
         .then((willDelete) => {
            if (willDelete) { 

               var id= t;
               //alert(id);
         $.ajax({
            url:"{{url(getRoleStr().'/edit-eod-update-request-accept')}}",
            method:'get',
            dataType:'json',
            data:{'id':id},
            success:function(result){
               if(result.status){
                  swal("Success","Accept Successfully..","success");
                  location.reload();
               }
            }
         });
      }

      }); 
          } 
</script>
@endsection

@endsection