@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center container_main">
        <div class="col-md-10">
            <h4>All project</h4>
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
           
            <div class="project_all">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>

                            <th>Name project</th>
                        
                            <th>Date start donate</th>
                            <th>Date end donate</th>
                             <th>Categories</th>
                            <th>Status</th>
                            <th>Final amount</th>
 
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
                             <td>{{$project->category->name_categories}}</td>	
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
      
                            <td><a href="/projectmanager_edit/{{$project->id}}">Edit</a></td>
                             @method('delete')
                            <td><a href="/projectmanager_delete/{{$project->id}}">Delete</a></td>
                        </tr>
                         @endforeach
                       
                    </tbody>
      
                </table>
            </div>
           
        </div>
    </div>
</div>

@endsection
