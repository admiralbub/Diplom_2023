@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  container_main">
        <div class="col-md-12">
            <h4>Show all complaints comments</h4>
            <hr>
       
             <table class="table">
			    <thead>
					<tr>
						<th scope="col">#</th>
					    <th scope="col">Comment</th>
						<th scope="col">Project</th>
				
						<th scope="col">Accepted complaint</th>
					</tr>
				</thead>
				<tbody>	 
					@foreach($complaint_comments as $complaint_comment)
					@if($complaint_comment !== null)
						<tr>
							@csrf
							<th scope="row">{{$complaint_comment->id}}</th>
						    <td><span>{{$complaint_comment->comments["body"]}}</span></td>
							<td><a href="/show_creativeproject/{{$complaint_comment->project->slug}}">{{$complaint_comment->project->title}}</a></td>
							
							<td><input  type="checkbox"  id="complaint_accepted_{{$complaint_comment->id}}" value="{{$complaint_comment->id}}" @if($complaint_comment->done==1) checked @endif style="border:1px;"></td>
							<script type="text/javascript">
								$(document).ready(function(){
									$('#complaint_accepted_{{$complaint_comment->id}}').on('click',function(){
										var csrf =  $('input[name="_token"]').attr('value');
										var checked =0;
										
										if($(this).is(":checked")) {
											checked = 1;
										} else {
											checked = 0;
										}
										$.ajax({
											url: '/complaintcomments_done',
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