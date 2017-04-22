@extends('layouts.operator')
@section('content')
<section class="content">
   <div class="row">
	<div class="col-xs-12">
        <div class="box">
			<div class="box-header">
                  <h3 class="box-title">Guest in House User Manager</h3>
            </div><!-- /.box-header -->
			<link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
			<link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
			<link href="{{ asset("css/jquery.datetimepicker.css") }}" rel="stylesheet" type="text/css" />

               	<div class="box-body">
					<div class="panel-body">
						<div class="panel-heading">
							<h3> Chek In User {{ $guest->username }}</h3>
						</div>
						{!! Form::model($guest,['url'=>route('guestinhouse.checkin',$guest->id),'method'=>'put','class'=>'form-horizontal']) !!}
						@include('guestinhouse._form')
						{!! Form::close() !!}
					</div>

</div>
</div>
</div>
</div>
</section>

@section('scripts')
	
	<script>
		$(function() {
			var d = new Date();
			d.setDate(d.getDate()+1);
			var def= new Date();
			def.setDate(def.getDate()+1);
			$('#datetimepicker').datetimepicker({

				autoclose: true,
				todayBtn: true,
				minView: '2',
				format: 'd M yyyy 14:00:00',
				defaultDate:def,
				startDate: d,

			});
		});
	</script>

	<script>
$(function () {
$("#example1").DataTable()
$('#example2').DataTable({
"columnDefs": [ {
"targets": 'no-sort',
"ordering": false,
"searching": false
} ],
"paging": true,
"lengthChange": true,
"searching": false,
"ordering": true,
"info": true,
"autoWidth": true,
"LengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
"pageLength": 50
});
});
</script>





@endsection
@stop()

