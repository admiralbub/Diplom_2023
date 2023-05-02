@extends('layouts.app')

@section('content')
<div class="container">
	<h4>Show to Photo Members for Project</h4>
	<hr>
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
		   
		    
		  </div>
		</div>
	@endforeach
</div>
@endsection