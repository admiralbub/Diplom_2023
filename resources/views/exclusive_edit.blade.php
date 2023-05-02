@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Edit exclusive material {{$exclusivematerial[0]->title}}</h3>
            <hr>
            <div class="p-3 mb-2 bg-light text-dark">Project - {{$exclusivematerial[0]->project->title}}</div>
            <br>
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
             <form  method="post" action="/exclusive_edit/{{$exclusivematerial[0]->id}}" enctype="multipart/form-data" novalidate >

            @csrf
            <div class="mb-3">
                <label  class="form-label">Title exclusiv ematerial</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$exclusivematerial[0]->title}}">
                  @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            
            <div class="mb-3">
                <label  class="form-label">Image exclusive material</label>
                <br>
                @if($exclusivematerial[0]->img)
                    <img src="{{asset('images/exclusivematerial/'.$exclusivematerial[0]->img)}}" width="500px">
                @endif
                <br>    
                <input class="form-control" name="img" type="file" id="formFile" value="{{ old('images/exclusivematerial/'.$exclusivematerial[0]->img)}}">
                <script>document.foo.submit();</script>
            </div>


         



          
            <div class="mb-3">
                <label  class="form-label">Description</label>
                  <textarea class="form-control @error('body') is-invalid @enderror" name="body" placeholder="Leave a comment here"  style="height: 100px" ">{{$exclusivematerial[0]->body}}</textarea>
                  @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              
            </div>
        
            <input type="submit" name="send" value="Edit project" class="btn my_btn btn-block">
        </form>
        </div>
        <hr>
       
    </div>
</div>
@endsection
