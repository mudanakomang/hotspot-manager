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
								<h3> User Management </h3>
                @if($user->hasRole('operator') || $user->hasRole('master'))
								<a class="btn btn-primary" href="{{ url("/guestinhouse/macauth") }}">MAC Address Bypass</a>
                @endif
								<a class="btn btn-primary" href="{{ url("/guestinhouse/online") }}">Online({{ $onlinear[0]->count }})</a>
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
						<th class="col-md-2" >Shared User </th>
						<th class="col-md-2" >Status </th>
						  @if(!$user->hasRole('admin'))
						<th class="no-sort col-md-2 ">Action</th>
							  @endif
                       </tr>
           	   		</thead>

		  <tbody>

		  @foreach($onlineuser as $online)

			  <tr>

				  <td class="info col-md-1"> <input name="users[]" value="{{ $online->username }}" type="checkbox"> </td>
				  <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$online->id/details")}}">  {{ $online->username }} </a> | <a href="javascript://" title ='User {{ $online->username }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="ID : {{ $online->callingstationid }}<br> Connected User : {{ $online->count }}<br> IP : {{ $online->framedipaddress }} <br> Check In Date : {{  Carbon\Carbon::parse($online->lastcheckin)->format('d M Y H:i')  }} <br> Check Out Date : {{ Carbon\Carbon::parse($online->value)->format('d M Y H:i') }}" >Details </a></td>
          @if($user->hasRole('mice') || $user->hasRole('admin'))
				  <td class="info col-md-2" >{{ substr_replace($online->pass,'***',3,strlen($online->pass)) }} </td>
        @else
          <td class="info col-md-2" >{{ substr_replace($online->pass,'***',3,strlen($online->pass)) }} | <a href="{{ url("/guestinhouse/$online->username/resetpassword") }}">Reset Password</a></td>
        @endif
				  <td class="info col-md-2" >{{ $online->shared }}</td>
				  <td class="info col-md-2 " ><i class="fa fa-wifi text-success"> </i> Online </td>
				  @if(!$user->hasRole('admin'))
				  <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$online->username/$online->framedipaddress/disconnect") }}">Disconnect</a> | <a href="{{ url("/guestinhouse/$online->username/$online->framedipaddress/checkout") }}">Check Out</a> | <a href="{{ url("/guestinhouse/$online->username/extend") }}">Extend</a> | <a href="{{ url("guestinhouse/$online->username/print") }}">Print</a> </td>
					  @endif

			  </tr>
		  @endforeach
		  @foreach($macauth as $mac)
			  <tr>
				  <td class="info col-md-2"> <input name="users[]" value="{{ $mac->user }}" type="checkbox"> </td>
				  <td  class="info col-md-2" ><a href="#">{{ $mac->user }}</a> | <a href="javascript://" title ='User {{ $mac->user }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="ID: {{ $mac->callingstationid }} <br>  IP : {{ $mac->framedipaddress }} <br> Check In Date : {{  Carbon\Carbon::parse($mac->checkin)->format('d M Y H:i')  }} <br> Check Out Date : {{ \Carbon\Carbon::parse($mac->value)->format('d M Y H:i') }} "> Details</a></td>
				  <td class="info col-md-2" >-</td>
				  <td class="info col-md-2" >{{ $mac->shared }}</td>
				  <td class="info col-md-2 " ><i class="fa fa-wifi text-success"></i> Online | <i class="fa fa-exchange text-success"> </i> Bypassed </td>
				  @if(!$user->hasRole('admin'))
				  <td class="info col-md-2 " ><a href="{{ url("/guestinhouse/$mac->callingstationid/$mac->framedipaddress/disconnect_mac") }}">Disconnect</a> | <a href="{{ url("/guestinhouse/$mac->user/$mac->framedipaddress/checkout") }}">Check Out</a> </td>
					  @endif
			  </tr>
		  @endforeach
		  @foreach($checkedin as $in)
			  <tr>

				  <td class="info col-md-2"> <input name="users[]" value="{{ $in->username }}" type="checkbox"> </td>
				  <td  class="info col-md-2" ><a href="{{ url("/guestinhouse/$in->id/details") }}">{{ $in->username }}</a> | <a href="javascript://" title ='User {{ $in->username }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content=" Check In Date : {{  Carbon\Carbon::parse($in->lastcheckin)->format('d M Y H:i')  }} <br> Check Out Date : {{ \Carbon\Carbon::parse($in->value)->format('d M Y H:i') }} "> Details</a></td>
          @if($user->hasRole('mice') || $user->hasRole('admin'))
				  <td class="info col-md-2" >{{ substr_replace($in->pass,'***',3,strlen($in->pass)) }} </td>
        @else
          <td class="info col-md-2" >{{ substr_replace($in->pass,'***',3,strlen($in->pass)) }} | <a href="{{ url("/guestinhouse/$in->username/resetpassword") }}">Reset Password</a></td>
        @endif
				  <td class="info col-md-2" >{{ $in->shared }}</td>
				  <td class="info col-md-2 " ><i class="fa fa-sign-out text-success"> </i> Checked In </td>
				  @if(!$user->hasRole('admin'))
				  @if($in->framedipaddress==null)
					  <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$in->username/null/checkout") }}">Check Out</a> | <a href="{{ url("/guestinhouse/$in->username/extend") }}">Extend</a> | <a href="{{ url("guestinhouse/$in->username/print") }}">Print</a></td>
				  @else
					  <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$in->username/$in->framedipaddress/checkout") }}">Check Out</a> | <a href="{{ url("/guestinhouse/$in->username/extend") }}">Extend</a> | <a href="{{ url("guestinhouse/$in->username/print") }}">Print</a></td>
				  @endif
					  @endif

			  </tr>
		  @endforeach






		  @foreach($checkedout as $out)
			@if($out->lastcheckin!=NULL)
			  <tr>
				  <td class="active col-md-2"> <input name="users[]" value="{{ $out->username }}" type="checkbox"> </td>
				  <td class="active col-md-2" ><a href="{{ url("/guestinhouse/$out->id/details") }}">{{ $out->username }}</a></td>
        @if($user->hasRole('mice') || $user->hasRole('admin'))
				  <td class="info col-md-2" >{{ substr_replace($out->pass,'***',3,strlen($out->pass)) }} </td>
        @else
          <td class="info col-md-2" >{{ substr_replace($out->pass,'***',3,strlen($out->pass)) }} | <a href="{{ url("/guestinhouse/$out->username/resetpassword") }}">Reset Password</a></td>
        @endif
				  <td class="active col-md-2" >{{ $out->shared }}</td>
				  <td class="active col-md-2 " ><i class="glyphicon glyphicon-unchecked text-danger"></i> Checked Out</td>
				  @if(!$user->hasRole('admin'))
				  <td class="active col-md-2" ><a href="{{ url("/guestinhouse/$out->id/checkin") }}"> Check In</a> </td>

				  @endif
			  </tr>
			  @endif
			  @endforeach


		  </tbody>
	   </table>
				@if(!$user->hasRole('admin'))
					<h4> With Selected : </h4>
					<input class="btn btn-primary" type="submit" name="checkin" value="Checkin">
					<input class="btn btn-primary" type="submit" name="checkin" value="Checkout">
				@endif


			</form>

		</div>



			<div class="box-body">
				<div class="panel-body">
					<div class="panel-heading bg-success">
						<p>
							<h3> Bypassed MAC List</h3>

						</p>
					</div>

				</div>

				<table id="example2" class="table table-bordered table-hover">

					<thead>
					<tr>
						<th class="col-md-2" >Username</th>
						<th class="col-md-2">MAC</th>
						<th class="col-md-2" >Status </th>
						<th class="no-sort col-md-2 ">Action</th>
					</tr>
					</thead>

					<tbody>

					@foreach($maclist as $list)
						<tr>

							@if($list->acctstoptime==null && $list->framedipaddress==null)
								<td class="active col-md-2" >{{ $list->user }}</td>
								<td class="active col-md-2 " >{{ $list->mac }}</td>
								<td class="active col-md-2 " >Offline</td>
								<td class="active col-md-2" ><a href="{{ url("/guestinhouse/$list->mac/0/deletemac") }}"> Delete </a> </td>
								@else
								<td class="info col-md-2" >{{ $list->user }}</td>
								<td class="info col-md-2" >{{ $list->mac }}</td>
								<td class="info col-md-2" >Online</td>
								<td class="info col-md-2" ><a href="{{ url("/guestinhouse/$list->mac/$list->framedipaddress/deletemac") }}"> Delete </a> </td>
							@endif
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
