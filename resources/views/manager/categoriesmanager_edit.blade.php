@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Edit categories </h3>
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
             <form  method="post" action="/categoriesmanager_edit/{{$project_edit->id}}"  >

            @csrf
            <div class="mb-3">
                <label  class="form-label">Name categories</label>
                <input type="text" class="form-control @error('name_categories') is-invalid @enderror" name="name_categories" value="{{$project_edit->name_categories}}">
                  @error('name_categories')
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
