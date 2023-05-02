@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  container_main">
        <div class="col-md-3">
            <h5>Categories</h5>
            @include("menu.categories",["categories"=>$categories])
        </div>  
        <div class="col-md-9">
            <h4>Сategories: {{$name_category[0]->name_categories}}</h4>
            <hr>
            @if($projects_incategories)
                @foreach($projects_incategories as $project)
                    <div class="card mb-3">
                        @if($project->img)
                            <img src="{{asset('images/project/'.$project->img)}}" width="350px">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$project->title}}</h5>
                            <p class="card-text">{{$project->antonation}}</p>
                            <p class="card-text"> Start donations<small class="text-muted"> {{$project->started_at}}</small></p>
                            <p class="card-text"> End donations<small class="text-muted"> {{$project->started_end}}</small></p>
                            <br>
                            <a href="/show_creativeproject/{{$project->slug}}" class="btn btn-primary">Show creative project</a>
                             <a href="/show_exclusivematerials/{{$project->slug}}" class="btn btn-warning">Show exclusive materials</a>
                        </div>
                    </div>
                @endforeach
            @else 
                <h4>Not creative project in categories</h4>
           @endif
        </div>
    </div>
</div>

@endsection
