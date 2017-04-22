@extends('layouts.operator')
@section('content')
<section class="content">
   <div class="row">
	<div class="col-xs-12">
		@include('layouts._flash')
        <div class="box">
			<div class="box-header">
                  <h3 class="box-title">Guest in House User Manager</h3>
            </div><!-- /.box-header -->
               	<div class="box-body ">
					<div class="panel-body ">
						<div class="panel-heading bg-success">
							<p>
								<h3> Online User </h3>

							</p>
						</div>

					</div>
			<form action="{{ url("/guestinhouse/groupcheck") }}" method="POST">

				<table id="example1" class="table table-bordered table-hover">

                    <thead>
                      <tr>
						<th>#</th>
            <th class="col-md-2" >Username</th>
						<th class="col-md-2" >Password</th>
						<th class="col-md-2" >Shared User</th>
						<th class="col-md-2" >Status </th>
						  @if(!$user->hasRole('admin'))
						<th class="no-sort col-md-2 ">Action</th>
							  @endif
            </tr>
           	</thead>

		  <tbody>

		@foreach($online as $online)

				@if($online->attribute !=null)
			   <tr>
				  <td class="info col-md-1"> <input name="users[]" value="{{ $online->username }}" type="checkbox"> </td>
				  <td class="info col-md-2" ><a href="{{ url("/voucher/$online->username/details")}}">  {{ $online->username }} </a> | <a href="javascript://" title ='User {{ $online->username }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="ID : {{ $online->callingstationid }}<br> Online User : {{ $online->count }}<br> IP : {{ $online->framedipaddress }} <br> Check In Date : {{  Carbon\Carbon::parse($online->lastcheckin)->format('d M Y h:i')  }} <br> Check Out Date : {{ $online->value }}" >Details </a></td>
          @if($user->hasRole('mice') || $user->hasRole('admin') || !$online->voucher==NULL)
  				  <td class="info col-md-2" >{{ substr_replace($online->pass,'***',3,strlen($online->pass)) }} </td>
          @else
            <td class="info col-md-2" >{{ substr_replace($online->pass,'***',3,strlen($online->pass)) }} | <a href="{{ url("/guestinhouse/$online->username/resetpassword") }}">Reset Password</a></td>
          @endif
				   <td class="info col-md-2" >{{ $online->shared }} </td>
				  <td class="info col-md-2 " ><i class="fa fa-wifi text-success"> </i> Online </td>
				   @if(!$user->hasRole('admin'))
				  <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$online->username/$online->framedipaddress/disconnect") }}">Disconnect</a> | <a href="{{ url("/guestinhouse/$online->username/$online->framedipaddress/checkout") }}">Check Out</a></td>
					   @endif

			  </tr>
			   @else
					<tr>
						<td class="info col-md-1"> <input name="users[]" value="{{ $online->username }}" type="checkbox"> </td>
						<td class="info col-md-2" ><a href="{{ url("/guestinhouse/$online->id/details")}}">  {{ $online->username }} </a> | <a href="javascript://" title ='User {{ $online->username }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="ID : {{ $online->callingstationid }}<br> Online User : {{ $online->count }}<br> IP : {{ $online->framedipaddress }} <br> Check In Date : {{  Carbon\Carbon::parse($online->lastcheckin)->format('d M Y h:i')  }} <br> Check Out Date : {{ $online->value }}" >Details </a></td>
            @if($user->hasRole('mice') || $user->hasRole('admin') || !$online->voucher==NULL)
    				  <td class="info col-md-2" >{{ substr_replace($online->pass,'***',3,strlen($online->pass)) }} </td>
            @else
              <td class="info col-md-2" >{{ substr_replace($online->pass,'***',3,strlen($online->pass)) }} | <a href="{{ url("/guestinhouse/$online->username/resetpassword") }}">Reset Password</a></td>
            @endif
						<td class="info col-md-2" >{{ $online->shared }} </td>
						<td class="info col-md-2 " ><i class="fa fa-wifi text-success"> </i> Online </td>
						@if(!$user->hasRole('admin'))
						<td class="info col-md-2" ><a href="{{ url("/guestinhouse/$online->username/$online->framedipaddress/disconnect") }}">Disconnect</a> | <a href="{{ url("/guestinhouse/$online->username/$online->framedipaddress/checkout") }}">Check Out</a></td>
							@endif
					</tr>
					@endif

		  @endforeach
		  @foreach($macauth as $mac)
			  <tr>
				  <td class="info col-md-1"> <input name="users[]" value="{{ $mac->user }}" type="checkbox"> </td>
				  <td  class="info col-md-2" ><a href="javascript://">{{ $mac->user }}</a> | <a href="javascript://" title ='User {{ $mac->user }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="ID: {{ $mac->callingstationid }} <br>  IP : {{ $mac->framedipaddress }} <br> Check In Date : {{  Carbon\Carbon::parse($mac->checkin)->format('d M Y h:i')  }} <br> Check Out Date : {{ $mac->value }} "> Details</a></td>
				  <td class="info col-md-2" >-</td>
				  <td class="info col-md-2" >-</td>
				  <td class="info col-md-2 " ><i class="fa fa-wifi text-success"></i> Online | <i class="fa fa-exchange text-success"> </i> Bypassed </td>
				  @if(!$user->hasRole('admin'))
				  <td class="info col-md-2 " ><a href="{{ url("/guestinhouse/$mac->callingstationid/$mac->framedipaddress/disconnect_mac") }}">Disconnect</a> | <a href="{{ url("/guestinhouse/$mac->user/$mac->framedipaddress/checkout") }}">Check Out</a> </td>
					  @endif
			  </tr>
		  @endforeach
		   </tbody>
	   </table>

			@if(!$user->hasRole('admin'))
			<input class="btn btn-primary" type="submit" name="checkin" value="Checkout">
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
				"targets": [0,4],
				"orderable": false,
					"width": "10%"
			} ],
			"autoWidth":true,
			"pageLength": 25,
			"paging": true,
			"LengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
			"scrollY": 400,

		});
        $('#example2').DataTable({

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
