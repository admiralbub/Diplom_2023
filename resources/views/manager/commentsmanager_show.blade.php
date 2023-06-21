@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  container_main">
        <div class="col-md-12">
            <h4>Show all complaints</h4>
            <hr>
       
             <table class="table">
			    <thead>
					<tr>
						<th scope="col">#</th>
					    <th scope="col">Name</th>
						<th scope="col">Project</th>
						<th scope="col">Message</th>
						<th scope="col">Date</th>
						<th scope="col"></th>
						
					</tr>
				</thead>
				<tbody>	 
					@foreach($comments as $comment)
						<tr>
							@csrf
							<th scope="row">{{$comment->id}}</th>
						    <td><span>{{$comment->user->name}}</span></td>
							<td><a href="/show_creativeproject/{{$comment->project->slug}}">{{$comment->project->title}}</a></td>
							<td><span>{{$comment->body}}</span></td>
							<td><span>{{$comment->created_at}}</span></td>
							<td><a href="/delete_comment/{{$comment->id}}">Delete</a></td>
						</tr>
					@endforeach
							   
				 </tbody>
			</table>
          
        </div>
    </div>
</div>

@endsection