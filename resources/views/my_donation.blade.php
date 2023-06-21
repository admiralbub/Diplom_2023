@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  container_main">
        <div class="col-md-12">
            <h4>My donations to creative projects</h4>
            
            <br>
            <canvas id="myChart" style="width:100%;max-width:1000px"></canvas>

            <br>
            <table class="table">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Project</th>
							      <th scope="col">Donation</th>
							      <th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>
							  	@php ($total_s = [])
							  	@foreach($donations as $donation)
								    <tr>
								      <th scope="row">{{$donation->id}}</th>
								      <td><a href="/show_creativeproject/{{$donation->project->slug}}">{{$donation->project->title}}</a></td>
								      <td><strong>{{$donation->amount}} $</strong></td>
								      <td>{{$donation->created_at}}</td>
								    </tr>
							    @endforeach
							    @foreach ($totalsByMonth as $month => $total)

								  
								    @php ($total_s[] = $total)
								@endforeach
							  </tbody>
							</table>
        </div>
    </div>
</div>
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      
      		labels: ['March','April','May','June','July','August','September','October','November','December'],
      
      datasets: [{
        label: '# Donation amount',
        
        	data: [
        		@foreach ($totalsByMonth as $month => $total)
        		   '{{ $total }}',
        		@endforeach
        	],
         
        backgroundColor: "#33AEEF",
    	strokeColor: "brown",
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endsection