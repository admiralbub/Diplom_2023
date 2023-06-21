@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center container_main">
        <div class="col-md-10">
            <h4>My project</h4>
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
                Create project
            </button>

            <a href="/exclusive_list" class="btn my_btn">Exclusive material</a>
            <hr>
            <a href="/project_members">Photo members</a>
            <div class="project_all">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>

                            <th>Name project</th>
                        
                            <th>Date start donate</th>
                            <th>Date end donate</th>
                            <th>Status</th>
                            <th>Final amount</th>
                            <th>Already donated</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($projects as $project)
                        <tr>
                            <td>{{$project->title}}</td>
                            
                            <td>{{ date('Y-m-d ', strtotime($project->started_at)) }}</td>
                            <td>{{ date('Y-m-d ', strtotime($project->started_end)) }} </td>
                            <td>
                                @if($project->amount <= $project->donations->sum('amount'))
                                    <span class="badge text-bg-success">Money collected</span>
                                @elseif($project->started_end <= $mytime)
                                    <span class="badge text-bg-danger">Time is up</span>

                                @else
                                    <span class="badge text-bg-light">Active</span>
                                @endif


                            </td>
                            <td><span class="badge text-bg-secondary">{{$project->amount}} $</span></td>
                            <td><span class="badge text-bg-secondary">{{$project->donations->sum('amount')}} $</span></td>
                            <td><a href="/project_edit/{{$project->id}}">Edit</a></td>
                             @method('delete')
                            <td><a href="/project_delete/{{$project->id}}">Delete</a></td>
                          
                        </tr>
                         @endforeach
                       
                    </tbody>
      
                </table>
            </div>
           
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> Create project</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form  method="post" action="{{ route('validate.form') }}" enctype="multipart/form-data" novalidate >

            @csrf
            <div class="mb-3">
                <label  class="form-label">Title project</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" >
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
                        <option value="{{$category->id}}">{{$category->name_categories}}</option>
                    @endforeach;
                </select>
            </div>
           

            <div class="mb-3">
                <label  class="form-label">Short About</label>
                <input type="text" class="form-control @error('annotation') is-invalid @enderror" name="annotation" >
                @error('annotation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
             <div class="mb-3">
                <label  class="form-label">Amount</label>
                 <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" >
                @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            <div class="mb-3">
                <label  class="form-label">Image project</label>
                <br>

                
                <input class="form-control" name="image" type="file" id="image">
            </div>
            <div class="mb-3">
                <label  class="form-label">Video project</label>
                <br>

                
                <input class="form-control" name="video" type="file" id="image">
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
            <div class="mb-3">
                <label  class="form-label">Start donates for project</label>
                <input type="datetime-local" class="@error('started_at') is-invalid @enderror" name="started_at" class="form-control" >
                 @error('started_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            <div class="mb-3">
                <label  class="form-label">End donates for project</label>
                <input type="datetime-local" class="@error('started_at') is-invalid @enderror" name="started_end" class="form-control" >
                @error('started_end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror             
            </div>
            <input type="text" class="form-control"  hidden name="user_id" value="{{auth()->user()->id}}">
            <input type="submit" name="send" value="Create" class="btn my_btn btn-block">
        </form>
      </div>
     
    </div>
  </div>
</div>
@endsection
