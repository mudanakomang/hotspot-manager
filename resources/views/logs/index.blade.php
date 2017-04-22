@extends('layouts.operator')
@section('content')
<section class="content">
   <div class="row">
	<div class="col-xs-12">
		@include('layouts._flash')
        <div class="box">
			<div class="box-header">
                  <h3 class="box-title">Activity Logs</h3>
            </div><!-- /.box-header -->
               	<div class="box-body ">
					<div class="panel-body ">
						<div class="panel-heading bg-success">
							<p>
								<h3>Logs </h3>
							</p>
						</div>

					</div>
			<form action="{{ url("/logs/groupcheck") }}" method="POST">

				<table id="example1" class="table table-bordered table-hover">

          <thead>
            <tr>
						<th>#</th>
            <th class="col-md-2" >Action Type</th>
						<th class="col-md-2" >Action By</th>
						<th class="col-md-2" >Description</th>
						<th class="col-md-2" >Date</th>
						  @if(!$user->hasRole('admin'))
						<th class="no-sort col-md-2 ">Action</th>
							@endif
            </tr>
          </thead>

		  <tbody>

		  @foreach($logs as $key=>$log)
			  <tr>
				  <td class="info col-md-1"> <input name="ids[]" value="{{ $log->id }}" type="checkbox"> </td>
				  <td class="info col-md-2" >{{ $log->action }}</td>
				  <td class="info col-md-2" >{{ $log->action_by }}</td>
				  <td class="info col-md-2 " >{{ $log->description }}</td>
          <td class="info col-md-2 " >{{ \Carbon\Carbon::parse($log->created)->format('d M Y H:i:s') }}</td>
				  @if($user->hasRole('master'))
				  <td class="info col-md-2" ><a href="{{ url("/logs/$log->id/delete") }}" onclick="return confirm('Are you sure to delete this logs')">Delete</a></td>
        @else
            <td class="info col-md-2" ></td>
          @endif

			  </tr>
		  @endforeach


		  </tbody>
	   </table>
				@if(!$user->hasRole('admin'))
					<h4> With Selected : </h4>
					<input class="btn btn-primary" type="submit" name="action" value="Delete">
				@endif


			</form>

		</div>

     </div>
	</div>
   </div>
</section>
@section('scripts')

	<script>
		$('[data-toggle="popover-plugin"]').popover();

		$('body').on('click', function (e) {
			if ($(e.target).data('toggle') !== 'popover-plugin'
					&& $(e.target).parents('.popover.in').length === 0) {
				$('[data-toggle="popover-plugin"]').popover('hide');
			}
		});
	</script>



<script>
      $(function () {
        $("#example1").DataTable({
			"columnDefs": [ {
				"targets": [0],
				"orderable": false,
				"width": "10%",

			} ],
			"autoWidth":true,
			"pageLength": 25,
			"paging": true,
			"LengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
			"scrollY": 400,

		})
        $('#example2').DataTable({
			"scrollY": 250,
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true

        });
      });
   </script>



@endsection
@stop()
