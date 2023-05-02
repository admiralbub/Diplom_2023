@extends('layouts.app')

@section('content')
<div class="container">
	<h4>View exclusive content</h4>
	<hr>
	@foreach($exclusivematerial as $exclusi)
		<div class="card mb-3">
		  <img src="{{asset('images/exclusivematerial/'.$exclusi->img)}}" class="card-img" alt="..." style="    height: 600px;">
		  <div class="card-body">
		    <h5 class="card-title">{{$exclusi->title}}</h5>
		    <p class="card-text">{{$exclusi->body}}</p>
		    <p class="card-text"><small class="text-body-secondary">Date {{$exclusi->created_at->format("Y-m-d")}}</small></p>
		  </div>
		</div>
	@endforeach
</div>
@endsection