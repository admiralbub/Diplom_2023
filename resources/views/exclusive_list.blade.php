@extends('layouts.app')

@section('content')
	<div class="container">
    	<div class="row  container_main">
    		<h4>Creation of exclusive materials for projects</h4>
            <br>
            <div class="col-md-10">
	             @if(Session::has('success'))
	                <div class="alert alert-success ">
	                    {{Session::get('success')}}
	                </div>
	            @endif   
	            @if(Session::has('errors'))
	                <div class="alert alert-danger">
	                    @foreach ($errors->all() as $error)
	                        <li>{{ $error }}</li>
	                    @endforeach
	                </div>
	            @endif    
	            <button type="button" class="btn my_btn" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-top:25px;">
	                Create exclusive materials
	            </button>
	            <br>
	            <table class="table" style="margin-top: 50px;">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Title</th>
				      <th scope="col">Project</th>
				      <th scope="col">Date create</th>
				      <th scope="col"></th>
				      <th scope="col"></th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($exclusivematerial as $exclusivem)
					  <tr>
					      <th scope="row" style="width:10%">{{$exclusivem->id}}</th>
					      <td style="width:40%">{{$exclusivem->title}}</td>
					      <td>{{$exclusivem->project->title}}</td>
					      <td>{{$exclusivem->created_at}}</td>
					      <td><a href="/exclusive_edit/{{$exclusivem->id}}">Edit</a></td>
					      <td><a href="/exclusive_delete/{{$exclusivem->id}}">Delete</a></td>
					  </tr>
				    @endforeach
				  </tbody>
				</table>


	        </div>
        </div>
    </div>
	 <!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel">Create exclusive materials</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        	<form  method="post" action="/exclusive_list" enctype="multipart/form-data" novalidate >
	        		@csrf
	        		<div class="mb-3">
			            <label for="exampleInputEmail1" class="form-label">Project</label>
			            <select class="form-select @error('projectid') is-invalid @enderror" name="project_id" >
			                @foreach($projects as $project)
			                     <option value="{{$project->id}}">{{$project->title}}</option>
			                @endforeach;
			           </select>
			        </div>
			        <div class="mb-3">
		                <label  class="form-label">Image material</label>
		                <br>

		                
		                <input class="form-control" name="image" type="file" id="image">
		            </div>
		            <div class="mb-3">
		                <label  class="form-label">Title exclusive materials</label>
		                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" >
		                  @error('title')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror  
		            </div>
		            <div class="mb-3">
		                <label  class="form-label">Description</label>
		                 <textarea class="form-control @error('body') is-invalid @enderror" name="body" placeholder="Leave a comment here"  style="height: 100px"></textarea>
		                 @error('body')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                 @enderror  
		              
		            </div>
		            <input type="submit" name="send" value="Create" class="btn my_btn btn-block">
	        	</form>
	      </div>
	     
	    </div>
	  </div>
	</div>
@endsection