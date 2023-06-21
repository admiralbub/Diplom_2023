@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  container_main">
        <div class="col-md-12">
            <div class="card w-75 mb-3">
            	@if(Session::has('success_complaint'))
                	<div class="alert alert-success ">
                    	{{Session::get('success_complaint')}}
                	</div>
            	@endif   
            	@if($project[0]->amount <= $donation_total)
            		<div class="alert alert-success" role="alert">
  						For this creative project, the final amount has already been collected
					</div>
            	 @else
				  <div class="card-body">
				  	 	@if($project[0]->img)
                        	<img src="{{asset('images/project/'.$project[0]->img)}}" width="550px">
                    	@endif
                    	<hr>
					    <h2 class="card-title">{{$project[0]->title}}</h2>
					    
					    <span class="card-text">{{$project[0]->annotation}}</span>
					    <p style="line-height: 30px;">{{$project[0]->body}}</p>
					    <p>Collected amount: <span class="badge bg-secondary">{{$project[0]->amount}} $</span></p>
					    <p>Required amount: <span class="badge bg-secondary">{{$donation_total}}$</span></p>
					    @if($project[0]->website)
                        	<p class="card-text"> Web site <a href="{{$project[0]->website}}">{{$project[0]->website}}</a></p>

                        @endif
                        @if($project[0]->instagram)
                        	<p class="card-text">  <a href="{{$project[0]->instagram}}">Instagram</a></p>

                        @endif
                        @if($project[0]->telegram)
                        	<p class="card-text">  <a href="{{$project[0]->telegram}}">Telegram Chanel</a></p>

                        @endif
                        @if($project[0]->twitter)
                        	<p class="card-text"> <a href="{{$project[0]->twitter}}">Twitter</a></p>

                        @endif
                        @if($project[0]->facebook)
                        	<p class="card-text"> <a href="{{$project[0]->facebook}}">Facebook</a></p>

                        @endif





					    <p class="card-text"> Start donations<i class="text-muted"> {{$project[0]->started_at}}</i></p>
                        <p class="card-text"> End donations<i class="text-muted"> {{$project[0]->started_end}}</i></p>
                        <hr>
					    <a href="/show_project_members/{{$project[0]->id}}">Show photo members</a>
					    <hr>
                        @if($project[0]->video)
                        	<div class="video_presenet" style="margin: 30px;">
                        		<h4>Video presentation of the creative project</h4>
                        		<br>
                   				<video  width="480" controls>
                        			<source src="{{asset('video/project/'.$project[0]->video)}}" type="video/mp4">
        
                    			</video>
                        	</div>
                        	
                		@endif
                         @if(Auth::check() )
                    		@if(auth()->user()->role == 0)
		                        @if(count($donation)>0)
		                        	<div class="alert alert-success" role="alert">
			  								You have already made donations for this project in the amount of {{$donation[0]->amount}} USD
									</div>
								   
								@else
									 @if($project[0]->started_end <= $mytime)
								    	<div class="alert alert-danger" role="alert">
			  								Sorry. This collection of donations for this creative project has already ended
										</div>

								    @else
								    	<div class="alert alert-success" role="alert">
			  								We are actively collecting donations for this creative project.
										</div>
								    @endif
								    <br>
								    <button class="btn btn-primary" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal" @if($project[0]->started_end <= $mytime) disabled  @endif >Donation to the project</button>
								@endif
								<hr>
								<h4>Send your comment </h4>
								<br>
								<form method="POST" action="/add_commentsproject">
								    @csrf
								    <div class="form-group">
								    	<label for="text" class="col-form-label">Body comment</label>
								        <textarea name="body" class="form-control" required style="height:50% ;"> </textarea>
								        <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}">
						      			<input type="hidden" id="project_id" name="project_id" value="{{$project[0]->id}}">
								    </div>
								    <br>
								    <button type="submit" class="btn btn-primary">Send comments</button>
								
								</form>
							@endif
							@else 
								<div class="alert alert-danger" role="alert">
  									You are not authorized to make donations to this project
								</div>
						@endif




						<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						      	 @csrf
						        <h1 class="modal-title fs-5" id="exampleModalLabel">Make a donation for this creative project</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						      	<label  class="form-label">Amoint donation</label>
						        <input type="number" class="form-control" name="amount" id="amount">
						      </div>
						       @if(Auth::check() )
                    				@if(auth()->user()->role == 0)
						      			<input type="hidden" id="user_id" name="custId" value="{{auth()->user()->id}}">
						      			<input type="hidden" id="project_id" name="custId" value="{{$project[0]->id}}">
						      		@endif
								@endif
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" id="send_donation">Send donation</button>
						      </div>
						      <div class="alert alert-success t-form__successbox" role="alert" style="display: none;"></div>
						      <div class="alert alert-danger error_block" role="alert" style="display: none;"></div>
						    </div>


						  </div>
						</div>
				  </div>
				  @endif

				  <hr>
				  @if(Auth::check() )
				  	@if(auth()->user()->id != $project[0]->user_id)
				  		<button type="button" class="btn btn-danger" style="width: 30%;" data-bs-toggle="modal" data-bs-target="#exampleModal_error">Complain about the project</button>
				  	  @endif
				  @else 
				  		<button type="button" class="btn btn-danger" style="width: 30%;" data-bs-toggle="modal" data-bs-target="#exampleModal_error">Complain about the project</button>
				  @endif
				 



				  <div class="modal fade" id="exampleModal_error" tabindex="-1" aria-labelledby="exampleModal_error" aria-hidden="true">
						<div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						      	 @csrf
						        <h1 class="modal-title fs-5" id="exampleModalLabel">Complain about the project</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>

						      <div class="modal-body">
						      	<form method="POST" action="/complaint_project">
								    @csrf
								    <div class="form-group">
								    	<label for="text" class="col-form-label">Name</label>
								        <input type="name" class="form-control" name="name" value=" @if(Auth::check() ) {{auth()->user()->name}} @endif" placeholder="">
								        
								    </div>
								    <div class="form-group">
								    	<label for="text" class="col-form-label">Reason for complaint</label>
								        <select class="form-select" aria-label="Default select example" name="type">
										  
											  <option value="Spam">Spam</option>
											  <option value="Insults">Insults</option>
											  <option value="Indecent scenes">Indecent scenes</option>
											  <option value="Call to violence">Call to violence</option>
											  <option value="Hostile saying">Hostile saying</option>
										</select>
								        
								    </div>
								    <input type="hidden" id="project_id" name="project_id" value="{{$project[0]->id}}">
								    <br>
								    <div class="mb-3">
										<label for="exampleFormControlTextarea1" class="form-label">Body</label>
										<textarea class="form-control" name="body" rows="3"></textarea>
									</div>
								
						
								    <div class="modal-footer">
						        		<button type="submit" class="btn btn-primary" id="send_donation">Send сomplain</button>
						      		</div>
								
								</form>
						      </div>
						     
						     
						      <div class="alert alert-success t-form__successbox" role="alert" style="display: none;"></div>
						      <div class="alert alert-danger error_block" role="alert" style="display: none;"></div>
						    </div>
						</div>
					</div>
				  <br>
				  <h4>Show comment about project ({{count($comments)}})</h4>
				  @foreach($comments as $comment)
				  	<div class="card" style="margin-top: 30px;">
					  <div class="card-header">
					    Author: <strong>{{$comment->user->name}}</strong> on {{$comment->created_at}}
					  </div>
					  <div class="card-body">
					    
					   	 <p class="card-text">{{$comment->body}}</p>
					   	 	 @csrf
					     	<button type="button" id="com_{{$comment->id}}" class="btn btn-link">Сomplain comment</button>
					     <script type="text/javascript">
					     	$('#com_{{$comment->id}}').click(function() {
					     	  var csrf =  $('input[name="_token"]').attr('value');
							  $.post('/complaint_comment', {_token: csrf, project_id: {{ $project[0]->id}}, comment: {{$comment->id}} }, function(response) {
							    	 $(".tes-form__successbox").html('<div class="alert alert-success" role="alert">You have successfully reported this comment!</div>')
							  })
							  
							});
					     </script>	
					     <div class="tes-form__successbox"></div>



					  </div>

					</div>
				  @endforeach
			</div>
        </div>
    </div>
</div>

@endsection