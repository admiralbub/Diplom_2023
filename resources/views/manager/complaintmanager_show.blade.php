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
						<th scope="col">Cause</th>
						<th scope="col">Accepted complaint</th>
					</tr>
				</thead>
				<tbody>	 
				@foreach($complaints as $complaint)
					@if($complaint !== null)
						<tr>
							@csrf
							<th scope="row">{{$complaint->id}}</th>
						    <td><span>{{$complaint->name}}</span></td>
							

							<td><a href="/show_creativeproject/{{$complaint->project['slug']}}">{{$complaint->project["title"]}}</a></td>
							


							<td><span>{{$complaint->type}}</span></td>
							<td><input  type="checkbox"  id="complaint_accepted_{{$complaint->id}}" value="{{$complaint->id}}" @if($complaint->done==1) checked @endif style="border:1px;"></td>
							<script type="text/javascript">
								$(document).ready(function(){
									$('#complaint_accepted_{{$complaint->id}}').on('click',function(){
										var csrf =  $('input[name="_token"]').attr('value');
										var checked =0;
										
										if($(this).is(":checked")) {
											checked = 1;
										} else {
											checked = 0;
										}
										$.ajax({
											url: '/complaint_done',
											type: 'POST',
											dataType: 'JSON',
											data: {
												_token: csrf,
												id: $(this).val(),
												checked:checked
											},
										});
									});
								});
							</script>
						</tr>

						@else

							<span>Not complaint</span>
						@endif
					@endforeach
							   
				 </tbody>
			</table>
          
        </div>
    </div>
</div>

@endsection