@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Edit project {{$project[0]->title}}</h3>
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
             <form  method="post" action="/project_edit/{{$project[0]->id}}" enctype="multipart/form-data" novalidate >

            @csrf
            <div class="mb-3">
                <label  class="form-label">Title project</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$project[0]->title}}">
                  @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Categories</label>
                <select class="form-select @error('categories_id') is-invalid @enderror" name="categories_id" >
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"  @if($project[0]->categories_id == $category->id) selected @endif>{{$category->name_categories}}</option> 
                    @endforeach;
                </select>
            </div>
            <div class="mb-3">
                <label  class="form-label">Image project</label>
                <br>
                @if($project[0]->img)
                    <img src="{{asset('images/project/'.$project[0]->img)}}" width="200px">
                @endif
                
                  <input class="form-control" name="img" type="file" id="formFile" value="{{ old('images/project/'.$project[0]->img)}}">
                <script>document.foo.submit();</script>
            </div>


            <div class="mb-3">
                <label  class="form-label">Video project</label>
                <br>
                @if($project[0]->video)
                   <video width="320" height="240" controls>
                        <source src="{{asset('video/project/'.$project[0]->video)}}" type="video/mp4">
        
                    </video>
                @endif
                
                  <input class="form-control" name="video" type="file" id="formFile" value="{{ old('images/project/'.$project[0]->img)}}">
                <script>document.foo.submit();</script>
            </div>



            <div class="mb-3">
                <label  class="form-label">Short About</label>
                <input type="text" class="form-control @error('annotation') is-invalid @enderror" name="annotation" value="{{$project[0]->annotation}}">
                @error('annotation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            <div class="mb-3">
                <label  class="form-label">Description</label>
                  <textarea class="form-control @error('body') is-invalid @enderror" name="body" placeholder="Leave a comment here"  style="height: 100px" ">{{$project[0]->body}}</textarea>
                  @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              
            </div>
            <div class="mb-3">
                <label  class="form-label">Web site</label>
                  <input type="text" class="form-control" name="website" value="{{$project[0]->website}}">
                 
              
            </div>
            <div class="mb-3">
                <label  class="form-label">Facebook</label>
                  <input type="text" class="form-control" name="facebook" value="{{$project[0]->facebook}}">
                 
              
            </div>
            <div class="mb-3">
                <label  class="form-label">Telegram Chanel</label>
                  <input type="text" class="form-control" name="telegram" value="{{$project[0]->telegram}}">
                 
              
            </div>
            <div class="mb-3">
                <label  class="form-label">Instagram</label>
                  <input type="text" class="form-control" name="instagram" value="{{$project[0]->instagram}}">
                 
              
            </div>
            <div class="mb-3">
                <label  class="form-label">Twitter</label>
                  <input type="text" class="form-control" name="twitter" value="{{$project[0]->twitter}}">
                 
              
            </div>

            <div class="mb-3">
                <label  class="form-label">Final amount</label>
                  <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{$project[0]->amount}}">
                  @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              
            </div>

            <div class="mb-3">
                <label  class="form-label">Start donates for project</label>
                <input type="datetime-local" class="@error('started_at') is-invalid @enderror" name="started_at" class="form-control" value="{{$project[0]->started_at}}">
                 @error('started_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
        
            <div class="mb-3">
                <label  class="form-label">End donates for project</label>
                <input type="datetime-local" class="@error('started_end') is-invalid @enderror" name="started_end" class="form-control" value="{{$project[0]->started_end}}">
                @error('started_end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror             
            </div>
            <input type="text" class="form-control"  hidden name="user_id" value="{{auth()->user()->id}}">
            <input type="submit" name="send" value="Edit project" class="btn my_btn btn-block">
        </form>
        </div>
        <hr>
       
    </div>
</div>
@endsection
