@extends('admin.layouts.app')
@section('title','Employees Report')
@section('content')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
	button.btn.btn-md.btn-success {
    margin-top: 22px;
}
.checked {color: orange;}
select.team_list {
    z-index: 9999;
    margin-left: 5px;
    margin-top: 0;
}
/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:1.0em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}</style>

<div class="page-inner" style="min-height:1350px !important">

                <div class="page-title">
                    <h3>Report</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="">Home</a></li>
                            <li><a href="#">Charts</a></li>
                            <li class="active">Report</li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
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
				
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <form id="getreport" method="post" action="">

                                        {{csrf_field()}}
                                       {{-- @if(Auth::user()->role == 4)
                                        <div class="form-group col-md-3">
                                        	<label>Employee</label>
                                        	<select class="form-control col-sm-4 team_list" name="team_member">
                                    	<option>-Select-</option>
                                    	@foreach($team_members as $emp)

                                    	<option @if(!empty(app('request')->input('team_member'))) @if(app('request')->input('team_member') == $emp->id ) selected=true @endif @endif value="{{$emp->id}}">{{$emp->first_name}} {{$emp->last_name}}</option>
                                        @endforeach
                                    </select>
                                        </div>
                                        @endif --}}
                                        <div class="form-group col-md-3">
                                          <label>Month</label>
                                          <select class="form-control {{app('request')->input('month')}}" id="month" name="month" required>
                                            <option value="">-- Select Month --</option>
											 @for($i=1; $i<=12; $i++)
                                             <option value="{{$i}}" {{ (app('request')->input('month')==$i) ? "selected" : "" }}> {{ date("F", mktime(0, 0, 0, $i, 10)) }} </option> 
										     @endfor
                                          </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label>Year</label>
                                           <select class="form-control" id="year" name="year" required>
                                             <option value="">-- Select Year --</option>
                                              @for($y=date('Y'); $y >= date('Y')-3; $y-- ) 
                                              <option value="{{$y}}" {{ (app('request')->input('year') == $y) ? "selected" : "" }} > {{$y}} </option> 
                                              @endfor
                                           </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label style="display:none">&nbsp;ss</label>
                                          <button class="btn btn-md btn-success"> Get Report </button> 
										  <input type="hidden" value="{{Auth::user()->id}}" name="emp_id" />  
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->

                    <div class="row">
					
                        <div class="col-md-4">
                            <div class="panel panel-white">
                                <div class="stats-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Attendance</h3>
                                    </div>
                                    <div class="panel-body">
									    <ul class="list-unstyled">
									      @if(isset($attendance))
											  @forelse($attendance as $key => $atd)
										         <li>{{  ucwords(str_replace('_', ' ', $key)) }} <div class="text-success pull-right"> {{$atd}} </div></li>
										       @empty 
										         <li> Not get any attendance records. </li>
											   @endforelse
										  @else
										  <li> </li> 
									      @endif 
									    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Attendance Report </h3>
                                </div>
                                <div class="panel-body">
								@if(isset($attendance))
                                    <canvas id="attendence" width="700" height="400"></canvas>
								@else
									<p> Select employee, month and year for regenerate report. </p>
								@endif 
                                </div>
                            </div>
                        </div>
					</div>

                    <div class="row">
						<div class="col-md-4">
						    <div class="panel panel-white">
                                <div class="stats-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Project List</h3>
                                    </div>
                                    <div class="panel-body">
									    <ul class="list-unstyled">
											@if(isset($projects))
												  @forelse($projects as $project)
												  <li> {{$project->project_name}} <div class="text-success pull-right">{{$project->pr_time}} (Hours) </i></div></li>  
												  @empty
												  <li> Not any project assign. </li> 
												  @endforelse
											@else
												 <li> </li> 
											@endif 
									    </ul>
                                    </div>
                                </div>
                            </div>
						</div>
						
                        <div class="col-md-8">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Project Report </h3>
                                </div>
                                <div class="panel-body">
								@if(isset($projects))
									@if(isset($labels) && isset($cdata))
                                    <canvas id="project" width="700" height="400"></canvas>
								    @else
										<p>  Not any project assign. </p>
									@endif
								@else
									<p> Select employee, month and year for regenerate report. </p>
								@endif 
                                </div>
                            </div>
                        </div>
                       
                    </div><!-- Row -->
                    <!--for employee -->
					@if(Auth::user()->role == 6)
					<div class="row">
							<div class="col-md-12">
								<div class="panel panel-white">
                                <div class="stats-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Project List</h3>
                                    </div>
                                    <div class="panel-body">
                                    	<table class="table table-responsive datatable">
                                    		<thead>
                                    		<tr>
                                    			<th>S.No</th>
                                    			<th>Project Name</th>
                                    			<th>Rating</th>
                                    			<th>Comment</th>
                                    			<th>Tl Rating</th>
                                    			<th>Tl Comment</th>
                                    			<th>Admin Rating</th>
                                    			<th>Admin Comment</th>
                                    			<th>Action</th>
                                    		</tr>
                                    		</thead>
                                    		<tbody>
	                                    	@if(isset($emp_projects))
	                                    		@foreach($emp_projects as $project)
	                                    			
	                                    				
	                                    			<tr >
		                                    			<form method="POST" class="emp_form_sub-{{$project->id}}"  action="{{URL(getRoleStr().'/add-report')}}" >
	                                    				{{csrf_field()}}
		                                    			<td>{{$loop->iteration}}.</td>
		                                    			<td>{{$project->project_name}}</td>
		                                    			<td>
		                                    				
		                                    				<input type="hidden" name="project_id" value="{{$project->id}}" />
															<div class='rating-stars '>
															<ul id='stars-{{$project->id}}'>
															<input class="rating-{{$project->id}}" type="hidden" name="ratings" value="{{getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['employee_rate']}}" />
															<li class='star' id="star1" title='Poor' data-value='1'>
															<i class='fa fa-star ' ></i>
															</li>
															<li class='star' id="star2" title='Fair' data-value='2'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="star3" title='Good' data-value='3'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="star4" title='Excellent' data-value='4'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="star5" title='WOW!!!' data-value='5'>
															<i class='fa fa-star '></i>
															</li>
															</ul>
															</div>
															@if ($errors->has('ratings'))

										                    <span class="label label-danger">{{ $errors->first('ratings') }}</span>

									                     	@endif
														</td>

		                                    			<td>
		                                    				@if(empty(getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['employee_review'] ))
		                                    				<textarea rows="1" name="comment" class="comment-{{$project->id}}" style="resize: none;" ></textarea>

		                                    				@else
		                                    				<span>{{getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['employee_review']}}</span>
		                                    				@endif
		                                    				@if ($errors->has('comment'))

										                    <span class="label label-danger">{{ $errors->first('comment') }}</span>

									                     	@endif
		                                    			</td>
		                                    			<td>
		                                    				
		                                    				<!-- <input type="hidden" name="project_id1" value="{{$project->project_id}}" /> -->
															<div class='rating-stars '>
															<ul id='tl_stars-{{$project->id}}' disabled="disabled">
															<input class="tl_rating-{{$project->id}}" type="hidden" name="tl_ratings" value="{{getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['tl_rate']}}" />
															<li class='star' id="tl_star1" title='Poor' data-value='1'>
															<i class='fa fa-star ' ></i>
															</li>
															<li class='star' id="tl_star2" title='Fair' data-value='2'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="tl_star3" title='Good' data-value='3'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="tl_star4" title='Excellent' data-value='4'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="tl_star5" title='WOW!!!' data-value='5'>
															<i class='fa fa-star '></i>
															</li>
															</ul>
															</div>
														</td>
														<td>@if(getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['tl_review'] != '')<span rows="1" >{{getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['tl_review']}} </span>
														 @else  
                                                        -
														 @endif
														</td>
														<td>
															<div class='rating-stars '>
															<ul id='admin_stars-{{$project->id}}' disabled="disabled">
															<input class="admin_rating-{{$project->id}}" type="hidden" name="admin_ratings" value="{{getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['admin_rate']}}" />
															<li class='star' id="tl_star1" title='Poor' data-value='1'>
															<i class='fa fa-star ' ></i>
															</li>
															<li class='star' id="admin_star2" title='Fair' data-value='2'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="admin_star3" title='Good' data-value='3'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="admin_star4" title='Excellent' data-value='4'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="admin_star5" title='WOW!!!' data-value='5'>
															<i class='fa fa-star '></i>
															</li>
															</ul>
															</div>
														</td>
														<td>
															@if(getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['admin_review'] != '')<span rows="1" >{{getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['admin_review']}} </span>
														 @else  
                                                        -
														 @endif
														</td>
														 <td><input class="btn btn-success emp-sub emp_sub-{{$project->id}}" type="button" name="sub_btn" value="SET" @if(!empty(getProjectReview($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['emp_update_month'])) disabled="true"  @endif ></td>
		                                    			</form>
		                                    		</tr>
														<script type="text/javascript">
														// rating of employee
													if($('.rating-{{$project->id}}').val() == "" || $('.rating-{{$project->id}}').val() == null){

													$('#stars-{{$project->id}} li').on('mouseover', function(){
													var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on


													// Now highlight all the stars that's not after the current hovered star
													$(this).parent().children('li.star').each(function(e){
													if (e < onStar) {
													$(this).addClass('hover');
													}
													else {
													$(this).removeClass('hover');
													}
													});

													}).on('mouseout', function(){
													$(this).parent().children('li.star').each(function(e){
													$(this).removeClass('hover');
													});
													});

													/* 2. Action to perform on click */
													$('#stars-{{$project->id}} li').on('click', function(){
													var onStar = parseInt($(this).data('value'), 10); // The star currently selected


													var stars = $(this).parent().children('li');
													//var stars = $(this).closest('li');

													for (i = 0; i < stars.length; i++) {
													$(stars[i]).removeClass('selected');
													}

													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}

													// JUST RESPONSE (Not needed)
													var ratingValue = parseInt($('#stars-{{$project->id}} li.selected').last().data('value'), 10);
													var inputfield = $('.rating-{{$project->id}}').val(ratingValue);


													});
													} else{
													var onStar = $('.rating-{{$project->id}}').val();
													var stars = $('#stars-{{$project->id}}').children('li');
													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}



													} 

													// if we have the  rating of team lead

													if($('.tl_rating-{{$project->id}}').val() == "" || $('.tl_rating-{{$project->id}}').val() == null){

													// $('#tl_stars-{{$project->id}} li').on('mouseover', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on


													// // Now highlight all the stars that's not after the current hovered star
													// $(this).parent().children('li.star').each(function(e){
													// if (e < onStar) {
													// $(this).addClass('hover');
													// }
													// else {
													// $(this).removeClass('hover');
													// }
													// });

													// }).on('mouseout', function(){
													// $(this).parent().children('li.star').each(function(e){
													// $(this).removeClass('hover');
													// });
													// });

													// /* 2. Action to perform on click */
													// $('#tl_stars-{{$project->id}} li').on('click', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently selected


													// var stars = $(this).parent().children('li');
													// //var stars = $(this).closest('li');

													// for (i = 0; i < stars.length; i++) {
													// $(stars[i]).removeClass('selected');
													// }

													// for (i = 0; i < onStar; i++) {
													// $(stars[i]).addClass('selected');
													// }

													// // JUST RESPONSE (Not needed)
													// var ratingValue = parseInt($('#tl_stars-{{$project->id}} li.selected').last().data('value'), 10);
													// var inputfield = $('.tl_rating-{{$project->id}}').val(ratingValue);


													// });
													} else{
													var onStar = $('.tl_rating-{{$project->id}}').val();
													var stars = $('#tl_stars-{{$project->id}}').children('li');
													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}



													} 
													// admin rating
													

													if($('.admin_rating-{{$project->id}}').val() == "" || $('.admin_rating-{{$project->id}}').val() == null){

													// $('#admin_stars-{{$project->id}} li').on('mouseover', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on


													// // Now highlight all the stars that's not after the current hovered star
													// $(this).parent().children('li.star').each(function(e){
													// if (e < onStar) {
													// $(this).addClass('hover');
													// }
													// else {
													// $(this).removeClass('hover');
													// }
													// });

													// }).on('mouseout', function(){
													// $(this).parent().children('li.star').each(function(e){
													// $(this).removeClass('hover');
													// });
													// });

													// /* 2. Action to perform on click */
													// $('#admin_stars-{{$project->id}} li').on('click', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently selected


													// var stars = $(this).parent().children('li');
													// //var stars = $(this).closest('li');

													// for (i = 0; i < stars.length; i++) {
													// $(stars[i]).removeClass('selected');
													// }

													// for (i = 0; i < onStar; i++) {
													// $(stars[i]).addClass('selected');
													// }

													// // JUST RESPONSE (Not needed)
													// var ratingValue = parseInt($('#admin_stars-{{$project->id}} li.selected').last().data('value'), 10);
													// var inputfield = $('.admin_rating-{{$project->id}}').val(ratingValue);


													// });
													} else{
													var onStar = $('.admin_rating-{{$project->id}}').val();
													var stars = $('#admin_stars-{{$project->id}}').children('li');
													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}



													} 
													var d = new Date(),
													   m = d.getMonth(),

                                                       y = d.getFullYear();
                                                     var mm =parseInt({!! $month !!})-parseInt(1);
                                                    if(m != mm ){
                                                    	
                                                       $('.emp_sub-{{$project->id}}').attr('disabled',true);
                                                    }else{
                                                    	 //$('.emp-sub').attr('disabled',false);
                                                    }
                                                    $('.emp_sub-{{$project->id}}').click(function(result){
                               var rat = $('.rating-{{$project->id}}').val();
                               var cmt = $('.comment-{{$project->id}}').val();

                               if(rat == '' || rat == null){
                                swal('Error','Rating field is required','error');
                               }else if(cmt == '' || cmt == null){
                                 swal('Error','Comment field is required','error');
                               }else{
                              //  alert('ok');
                                $('form.emp_form_sub-{{$project->id}}').submit();
                               }
                           });

														</script>
	                                    			
	                                    		@endforeach
	                                    	@endif
	                                    	</tbody>
                                    	</table>
                                    </div>
                                </div>
                            </div>
							</div>
					</div>
					@endif
					<!-- for Teamlead -->
					@if(Auth::user()->role == 4)
					<div class="row">
							<div class="col-md-12">
								<div class="panel panel-white">
                                <div class="stats-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Project List {{app('request')->input('month'),app('request')->input('year')}} </h3>
                                        
                                    </div>
                                    <div class="panel-body">
                                    	<table class="table table-responsive datatable">
                                    		<thead>
                                    		<tr>
                                    			<th>S.No</th>
                                    			<th>Project Name</th>
                                    			
                                    			<th>Rating</th>
                                    			<th>Comment</th>
                                    			<!-- <th>Tl Rating</th>
                                    			<th>Tl Comment</th> -->
                                    			<th>Admin Rating</th>
                                    			<th>Admin Comment</th>
                                    			<th>Action</th>
                                    		</tr>
                                    		</thead>
                                            <tbody>
	                                    	@if(!empty($emp_projects))
	                                    		@foreach($emp_projects as $project)
	                                    			
	                                    				
	                                    			<tr >
		                                    			<form method="POST" class="tl_form_sub-{{$project->id}}" action="{{URL(getRoleStr().'/add-report-by-tl')}}">
	                                    				{{csrf_field()}}
		                                    			<td>{{$loop->iteration}}.</td>
		                                    			<td>{{$project->project_name}}</td>
		                                    			
		                                    			<td>
		                                    				
		                                    				<input type="hidden" name="project_id" value="{{$project->id}}" />
															<div class='rating-stars '>
															<ul id='stars-{{$project->id}}'>
															<input class="rating-{{$project->id}}" type="hidden" name="ratings" required value="{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['employee_rate']}}" />
															<li class='star' id="star1" title='Poor' data-value='1'>
															<i class='fa fa-star ' ></i>
															</li>
															<li class='star' id="star2" title='Fair' data-value='2'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="star3" title='Good' data-value='3'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="star4" title='Excellent' data-value='4'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="star5" title='WOW!!!' data-value='5'>
															<i class='fa fa-star '></i>
															</li>
															</ul>
															</div>
															
														</td>

		                                    			<td>
		                                    				@if(empty(getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['employee_review'] ))
		                                    				<textarea style="resize: none;" rows="1" name="comment" class="comment-{{$project->id}}" ></textarea>
		                                    				@else
		                                    				<span>{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['employee_review']}}</span>
		                                    				@endif
		                                    			</td>
		                                    			{{-- <td>
		                                    				<input type="hidden" name="review_id" value="{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['id']}}">
		                                    				<input type="hidden" class="tl_rating-{{$project->id}}" name="tl_rating" value="{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['tl_rate']}}" />
															<div class='rating-stars '>
															<ul id='tl_stars-{{$project->id}}' disabled="disabled">
															<!-- <input class="rating" type="hidden" name="ratings" value="{{$project->employee_rate}}" /> -->
															<li class='star' id="tl_star1" title='Poor' data-value='1'>
															<i class='fa fa-star ' ></i>
															</li>
															<li class='star' id="tl_star2" title='Fair' data-value='2'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="tl_star3" title='Good' data-value='3'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="tl_star4" title='Excellent' data-value='4'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="tl_star5" title='WOW!!!' data-value='5'>
															<i class='fa fa-star '></i>
															</li>
															</ul>
															</div>
														</td>
														<td>@if(getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['tl_review'] != '')<span rows="1" >{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['tl_review']}} </span>
														 @else  
                                                        <textarea rows="1" name="tl_comment"  ></textarea> 
														 @endif</td> --}}
														 <td>
														 <input type="hidden" class="admin_rating-{{$project->id}}" name="admin_rating" value="{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['admin_rate']}}" />
															<div class='rating-stars '>
															<ul id='admin_stars-{{$project->id}}' disabled="disabled">
															<!-- <input class="rating" type="hidden" name="ratings" value="{{$project->employee_rate}}" /> -->
															<li class='star' id="admin_star1" title='Poor' data-value='1'>
															<i class='fa fa-star ' ></i>
															</li>
															<li class='star' id="admin_star2" title='Fair' data-value='2'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="admin_star3" title='Good' data-value='3'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="admin_star4" title='Excellent' data-value='4'>
															<i class='fa fa-star '></i>
															</li>
															<li class='star' id="admin_star5" title='WOW!!!' data-value='5'>
															<i class='fa fa-star '></i>
															</li>
															</ul>
															</div>
														</td>
														<td>
															@if(getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['admin_review'] != '')<span rows="1" >{{getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['admin_review']}} </span>
														 @else  
                                                        -
														 @endif
														</td>
		                                    			<td><input class="btn btn-success tl-sub tl_sub-{{$project->id}}" type="button" name="sub_btn" value="SET" @if( !is_null(getProjectReviewtl($project->id,Auth::user()->id,app('request')->input('month'),app('request')->input('year'))['emp_update_month']) ) disabled="true"  @endif ></td>
		                                    			</form>
		                                    		</tr>
		                                    		 <script type="text/javascript">
													//if we have the value of rating of employee
													if($('.rating-{{$project->id}}').val() == "" || $('.rating-{{$project->id}}').val() == null){

													$('#stars-{{$project->id}} li').on('mouseover', function(){
													var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on


													// Now highlight all the stars that's not after the current hovered star
													$(this).parent().children('li.star').each(function(e){
													if (e < onStar) {
													$(this).addClass('hover');
													}
													else {
													$(this).removeClass('hover');
													}
													});

													}).on('mouseout', function(){
													$(this).parent().children('li.star').each(function(e){
													$(this).removeClass('hover');
													});
													});

													/* 2. Action to perform on click */
													$('#stars-{{$project->id}} li').on('click', function(){
													var onStar = parseInt($(this).data('value'), 10); // The star currently selected


													var stars = $(this).parent().children('li');
													//var stars = $(this).closest('li');

													for (i = 0; i < stars.length; i++) {
													$(stars[i]).removeClass('selected');
													}

													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}

													// JUST RESPONSE (Not needed)
													var ratingValue = parseInt($('#stars-{{$project->id}} li.selected').last().data('value'), 10);
													var inputfield = $('.rating-{{$project->id}}').val(ratingValue);


													});
													} else{
													var onStar = $('.rating-{{$project->id}}').val();
													var stars = $('#stars-{{$project->id}}').children('li');
													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}



													} 

													// // if we have the  rating of team lead

													// if($('.tl_rating-{{$project->id}}').val() == "" || $('.tl_rating-{{$project->id}}').val() == null){

													// $('#tl_stars-{{$project->id}} li').on('mouseover', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on


													// // Now highlight all the stars that's not after the current hovered star
													// $(this).parent().children('li.star').each(function(e){
													// if (e < onStar) {
													// $(this).addClass('hover');
													// }
													// else {
													// $(this).removeClass('hover');
													// }
													// });

													// }).on('mouseout', function(){
													// $(this).parent().children('li.star').each(function(e){
													// $(this).removeClass('hover');
													// });
													// });

													// /* 2. Action to perform on click */
													// $('#tl_stars-{{$project->id}} li').on('click', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently selected


													// var stars = $(this).parent().children('li');
													// //var stars = $(this).closest('li');

													// for (i = 0; i < stars.length; i++) {
													// $(stars[i]).removeClass('selected');
													// }

													// for (i = 0; i < onStar; i++) {
													// $(stars[i]).addClass('selected');
													// }

													// // JUST RESPONSE (Not needed)
													// var ratingValue = parseInt($('#tl_stars-{{$project->id}} li.selected').last().data('value'), 10);
													// var inputfield = $('.tl_rating-{{$project->id}}').val(ratingValue);


													// });
													// } else{
													// var onStar = $('.tl_rating-{{$project->id}}').val();
													// var stars = $('#tl_stars-{{$project->id}}').children('li');
													// for (i = 0; i < onStar; i++) {
													// $(stars[i]).addClass('selected');
													// }



													// } 

													// admin rating
													

													if($('.admin_rating-{{$project->id}}').val() == "" || $('.admin_rating-{{$project->id}}').val() == null){

													// $('#admin_stars-{{$project->id}} li').on('mouseover', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on


													// // Now highlight all the stars that's not after the current hovered star
													// $(this).parent().children('li.star').each(function(e){
													// if (e < onStar) {
													// $(this).addClass('hover');
													// }
													// else {
													// $(this).removeClass('hover');
													// }
													// });

													// }).on('mouseout', function(){
													// $(this).parent().children('li.star').each(function(e){
													// $(this).removeClass('hover');
													// });
													// });

													// /* 2. Action to perform on click */
													// $('#admin_stars-{{$project->id}} li').on('click', function(){
													// var onStar = parseInt($(this).data('value'), 10); // The star currently selected


													// var stars = $(this).parent().children('li');
													// //var stars = $(this).closest('li');

													// for (i = 0; i < stars.length; i++) {
													// $(stars[i]).removeClass('selected');
													// }

													// for (i = 0; i < onStar; i++) {
													// $(stars[i]).addClass('selected');
													// }

													// // JUST RESPONSE (Not needed)
													// var ratingValue = parseInt($('#admin_stars-{{$project->id}} li.selected').last().data('value'), 10);
													// var inputfield = $('.admin_rating-{{$project->id}}').val(ratingValue);


													// });
													} else{
													var onStar = $('.admin_rating-{{$project->id}}').val();
													var stars = $('#admin_stars-{{$project->id}}').children('li');
													for (i = 0; i < onStar; i++) {
													$(stars[i]).addClass('selected');
													}



													}
													var d = new Date(),
													   m = d.getMonth(),

                                                       y = d.getFullYear();
                                                     var mm =parseInt({!! $month !!})-parseInt(1);
                                                    if(m != mm ){
                                                    	
                                                       $('.tl-sub').attr('disabled',true);
                                                    }else{
                                                    	 //$('.emp-sub').attr('disabled',false);
                                                    } 
                                                         $('.tl_sub-{{$project->id}}').click(function(result){
                               var rat = $('.rating-{{$project->id}}').val();
                               var cmt = $('.comment-{{$project->id}}').val();

                               if(rat == '' || rat == null){
                                swal('Error','Rating field is required','error');
                               }else if(cmt == '' || cmt == null){
                                 swal('Error','Comment field is required','error');
                               }else{
                              //  alert('ok');
                                $('form.tl_form_sub-{{$project->id}}').submit();
                               }
                           });
													</script>
	                                    			
	                                    		@endforeach
	                                    	@else
	                                    	
	                                    	@endif
	                                    	</tbody>
                                    	</table>
                                    </div>
                                </div>
                            </div>
							</div>
					</div>
					@endif
					
					{{--<div class="row">
					    <div class="panel panel-white">
							<div class="panel-heading">
								<h3 class="panel-title">Project Reviews by Team </h3>
							</div>
							<div class="panel-body">
							 <div class="col-md-12">
							    <div class="col-md-3">
									<h4> Projects </h4>
								</div>
								 <div class="col-md-3">
									<h4> Employee Review </h4>
								</div>
								 <div class="col-md-3">
									<h4> Team Lead Review </h4>
								</div>
								 <div class="col-md-3">
									<h4> BA Review </h4>
								</div>
							 </div>
							 <div class="col-md-12">
							     <div class="col-md-3" >
								    <h4> Project Name </h4>
								 </div>
								 <div class="col-md-3">
									<p>  Review added by Employee </p>
									<p>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
								 </div>
								 <div class="col-md-3">
									<p>  Review added by Team Lead </p>
									<p>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
								 </div>
								 <div class="col-md-3">
									<p>  Review added by BA </p>
									<p>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
								 </div>
								</div>
								<hr>
							</div> 
						</div>
					</div>--}}
                  
                </div><!-- Main Wrapper -->
				<div class="page-footer">
				  <p class="no-s">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
				</div>
</div> 
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
   
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
      {{Html::style("assets/plugins/datatables/css/jquery.datatables.min.css")}}
   {{ Html::script("assets/plugins/datatables/js/jquery.datatables.min.js") }}
   

	<script>
		//$('.datatable').DataTable();
        $(function() {
			
		@if(isset($at_labels) && isset($at_values)) 
			var attendence = document.getElementById('attendence').getContext('2d');
			var chart = new Chart(attendence, {
				 type: 'bar',
					data: {
						labels: {!! $at_labels !!},
						datasets: [{
							label: 'Days ', 
							data: {!! $at_values !!},
							backgroundColor: [
								'rgba(255, 206, 86)',
								'rgba(255, 159, 64, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(153, 102, 255, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 2
						}]
					},
					options: {
						legend: {display: false},
						events: ['mousemove'],
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
			});
		@endif	
			
		@if(isset($labels) && isset($cdata)) 
			var project = document.getElementById('project').getContext('2d');
			var myChart = new Chart( project, {
				type: 'bar',
				data: {
					showInLegend:false,
					labels: {!! $labels !!},
					datasets: [{
						label: 'Total Hours (%)', 
						data: {!! $cdata !!},
						backgroundColor: [
							'rgba(255, 99, 132, 0.2)',
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 206, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(153, 102, 255, 0.2)',
							'rgba(255, 159, 64, 0.2)'
						],
						borderColor: [
							'rgba(255, 99, 132, 1)',
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(75, 192, 192, 1)',
							'rgba(153, 102, 255, 1)',
							'rgba(255, 159, 64, 1)'
						],
						borderWidth: 2
					}]
				},
				options: {
					 legend: {display: false},
					events: ['mousemove'],
					
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
			
		@endif
		});

		// $('.team_list').change(function(){
  //         var data = $(this).val();
  //         alert(data);
  //         $.ajax({
  //           url:"{{route('c.get_report',['role'=>'teamLead'])}}",
  //           type:'get',
  //           data:{team_member:data},
            
  //           success:function(result){
  //              console.log(result);
  //           }
  //         });
		// });
		// $('.emp-sub').click(function(){
		// 	var rat =$('input[name=ratings]').val();
		// 	var cmt =$('input[name=comment]').val();
  //            if(cmt == '' || cmt == null){
  //               swal('Error','Comment field is required','error');
  //            }else if(rat == '' || rat == null){
  //            	swal('Error','Rating field is required','error');

  //             window.scrollTo(0, 1500);

  //            }else{
  //            	// var data = new FormData(this);
  //             // $.ajax({
  //             //    url:"",
  //             //    method:'post',
  //             //    dataType:'json',
  //             //    data:data,
  //             //    success:function(result){
  //             //       console.log(result);
  //             //    }
  //             // });
  //            }
               
		// });
	</script>
	<!DOCTYPE HTML>
<html>
<head>  


@endsection

