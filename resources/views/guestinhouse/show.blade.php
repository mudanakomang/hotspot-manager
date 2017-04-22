@extends('layouts.operator')
@section('content')
<section class="content">
   <div class="row">
	<div class="col-xs-12">
        <div class="box">
			<div class="box-header">
                  <h3 class="box-title">User Details </h3>
            </div><!-- /.box-header -->
               	<div class="box-body">
		<table id="example1" class="table table-bordered table-hover ">
          <thead>

		  	<tr>
			  <th>Last Start Time </th>
			  <th>Last Stop Time </th>
			  <th>Total Time </th>
			  <th>Total Transfer (MB)</th>
				<th>MAC Address</th>
			  <th>IP Address</th>
			  <th>Termination</th>
		  	</tr>


          </thead>
		  <tbody>

		  @foreach($username as $us )
			  <div class="small-box bg-green-active">
				  <div class="inner">
				<h4>Username	: <b>{{ $us->username }}</b></h4>
				<h4>Last Checkin	: <b>{{ Carbon\Carbon::parse($us->lastcheckin)->format('d M Y H:i') }}</b></h4>
		  @endforeach
			<h4>Check Out    : <b>{{ $checkout }}</b></h4>
			@foreach($status as $s)
			  @if($s->status=='0')
				  <h4>Check In Status :	<b>Checked Out</b></h4>
			  @else
				  <h4>Check In Status : <b>Checked In</b></h4>
			  @endif
			@endforeach

			<h4>Total Data Today :  <b>{{ $tdaily }} MB</b></h4>
			<h4>Total Data All Time :  <b>{{ $tall }} MB</b></h4>

			@if($tdaily >= $tlimit)
				<h4>Status FUP :<b> ON</b></h4>
				<h4>Speed : <b> 1 Mbps</b></h4>
			@else
				<h4>Status FUP : <b> OFF</b></h4>
				<h4>Speed : <b> 5 Mbps</b></h4>
				@endif
				  </div>
			  </div>


		  @foreach($guest as $g)

			<tr>
				<td>{{ Carbon\Carbon::parse($g->acctstarttime)->format('d M Y H:i')  }}</td>
				@if($g->acctstoptime !=null)
				<td>{{ Carbon\Carbon::parse($g->acctstoptime)->format('d M Y H:i') }}</td>
				@else
					<td></td>
				@endif
				<td>{{ $g->totaltime }}</td>
				<td>{{ $g->totalbyte }}</td>
				<td>{{ $g->callingstationid }}</td>
				<td>{{ $g->framedipaddress }}</td>
				<td>{{ $g->acctterminatecause }}</td>
			</tr>
		  @endforeach
		  </tbody>
	   </table>
	</div>
     </div>
   </div>
</div>
</section>
@section('scripts')
<script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
   </script>

@endsection
@stop()

