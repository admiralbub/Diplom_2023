@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  container_main">
        <div class="col-md-12">
            <h4>All Categories</h4>
            
            <br>
            <button type="button" class="btn my_btn" data-bs-toggle="modal" data-bs-target="#exampleModal" >
                Create categories
            </button>

            
            <table class="table" style="margin-top: 70px;">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Name categories</th>
							      <th scope="col"></th>
							      <th scope="col"></th>
							    </tr>
							  </thead>
							  <tbody>
							  	
							  	@foreach($categories as $catgory)
								    <tr>
								      <th scope="row">{{$catgory->id}}</th>
								      <td>{{$catgory->name_categories}}</td>
								      <td><a href="/categoriesmanager_edit/{{$catgory->id}}">Edit</a></td>
     
                      <td><a href="/categoriesmanager_delete/{{$catgory->id}}">Delete</a></td>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel"> Create categories</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form  method="post" action="/categoriesmanager_create" enctype="multipart/form-data" novalidate >

            @csrf
            <div class="mb-3">
                <label  class="form-label">Name categories</label>
                <input type="text" class="form-control @error('name_categories') is-invalid @enderror" name="name_categories" >
                  @error('name_categories')
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
@endsection