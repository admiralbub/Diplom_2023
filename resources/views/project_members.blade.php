@extends('layouts.app')

@section('content')
<div class="container">
	<h4>Add to Photo Members for Project</h4>
	<hr>
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
    <button type="button" class="btn my_btn" data-bs-toggle="modal" data-bs-target="#exampleModal" >
        Add photo members
    </button>

	    <!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel"> Add to Photo Members for Project</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	         <form  method="post" action="/project_members" enctype="multipart/form-data" novalidate >

	            @csrf
	            <div class="mb-3">
	                <label  class="form-label">Name member</label>
	                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" >
	                  @error('name')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
	                @enderror  
	            </div>
	            <div class="mb-3">
	                <label for="exampleInputEmail1" class="form-label">Projects</label>
	                <select class="form-select @error('project_id') is-invalid @enderror" name="project_id" >
	                    @foreach($projects as $project)
	                        <option value="{{$project->id}}">{{$project->title}}</option>
	                    @endforeach;
	                </select>
	            </div>
	           

	            <div class="mb-3">
	                <label  class="form-label">Image project</label>
	                <br>

	                
	                <input class="form-control" name="img" type="file" id="image">
	            </div>
	           
	            <input type="text" class="form-control"  hidden name="user_id" value="{{auth()->user()->id}}">
	            <input type="submit" name="send" value="Create" class="btn my_btn btn-block">
	        </form>
	      </div>
	     
	    </div>
	  </div>
	</div>
	<hr>
	@if($photo_members) 
		@foreach($photo_members as $photo_member)
			<div class="card">
			  <div class="card-header">
			    Photo memberd
			  </div>
			  <div class="card-body">
			    <h5 class="card-title">{{$photo_member->name}}</h5>
			    <p class="card-text">
			    	<img src="{{asset('images/members/'.$photo_member->img)}}" width="350px">

			    </p>
			    <span>Name Project: {{$photo_member->project["title"]}}</span>
			    <br>
			     <a href="delete_members/{{$photo_member->id}}" class="btn btn-danger" style="margin-top: 40px;">Delete</a>
			    
			  </div>
			</div>
		@endforeach
	@endif
</div>
@endsection