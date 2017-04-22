@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">MICE Management</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body ">
                        <div class="panel-body ">
                            <div class="panel-heading bg-success">
                                <p>

                                <h3>MICE List</h3>
                                <a class="btn btn-primary" href="{{ url("/mice/addform") }}">Add MICE</a>
                                </p>
                            </div>

                        </div>
                        <table class="table table-hover table-bordered" id="example1">
                            <thead>

                            <th>No</th>
                            <th>Name</th>
                            <th>Participant Number</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Aproved</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($data as $key=>$d)
                                  @if($d->status=='0' && $d->approved=='0')
                                    <tr class="small">
                                        <td class="info col-md-2" >{{ ++$key }}</td>
                                        <td class="info col-md-2" ><a href="javascript://" title ='User {{ $d->name }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="MICE Name : {{ $d->name }}<br> Username : {{ $d->username }}<br> Password : {{ $d->password }}" >{{ $d->name }} </a></td>
                                        <td class="info col-md-2" >{{ $d->number }}</td>
                                        <td class="info col-md-2" >{{ \Carbon\Carbon::parse($d->start)->format('d M Y H:i:s') }}</td>
                                        <td class="info col-md-2" >{{ \Carbon\Carbon::parse($d->end)->format('d M Y H:i:s') }}</td>
                                        <td class="info col-md-2" >{{ $d->service }}</td>
                                        <td class="info col-md-2" >Inactive</td>
                                        <td class="info col-md-2" >No</td>
                                        @if($user->hasRole('mice'))
                                        <td class="info col-md-2" ><a href="{{ url("/mice/$d->id/delete") }}" onclick="return confirm('Are you sure to delete this Voucher?')">Delete</a></td>
                                      @else
                                        <td class="info col-md-2" ></td>
                                      @endif
                                    </tr>
                                  @elseif($d->status=='0' && $d->approved=='1')
                                    <tr class="small">
                                        <td class="success col-md-2" >{{ ++$key }}</td>
                                        <td class="success col-md-2" ><a href="javascript://" title ='User {{ $d->name }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="MICE Name : {{ $d->name }}<br> Username : {{ $d->username }}<br> Password : {{ $d->password }}" >{{ $d->name }} </a></td>
                                        <td class="success col-md-2" >{{ $d->number }}</td>
                                        <td class="success col-md-2" >{{ \Carbon\Carbon::parse($d->start)->format('d M Y H:i:s') }}</td>
                                        <td class="success col-md-2" >{{ \Carbon\Carbon::parse($d->end)->format('d M Y H:i:s') }}</td>
                                        <td class="success col-md-2" >{{ $d->service }}</td>
                                        <td class="success col-md-2" >Inactive</td>
                                        <td class="success col-md-2" >Yes</td>
                                        @if($user->hasRole('mice'))
                                        <td class="success col-md-2" ><a href="{{ url("/mice/$d->id/delete") }}" onclick="return confirm('Are you sure to delete this Voucher?')">Delete</a></td>
                                      @else
                                        <td class="success col-md-2" ></td>
                                      @endif
                                    </tr>
                                  @else
                                    @if($d->end < \Carbon\Carbon::now('Asia/Makassar'))
                                    <tr class="small">
                                        <td class="danger col-md-2" >{{ ++$key }}</td>
                                        <td class="danger col-md-2" ><a href="javascript://" title ='User {{ $d->name }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="MICE Name : {{ $d->name }}<br> Username : {{ $d->username }}<br> Password : {{ $d->password }}" >{{ $d->name }} </a></td>
                                        <td class="danger col-md-2" >{{ $d->number }}</td>
                                        <td class="danger col-md-2" >{{ \Carbon\Carbon::parse($d->start)->format('d M Y H:i:s') }}</td>
                                        <td class="danger col-md-2" >{{ \Carbon\Carbon::parse($d->end)->format('d M Y H:i:s') }}</td>
                                        <td class="danger col-md-2" >{{ $d->service }}</td>
                                        <td class="danger col-md-2" >Active</td>
                                        <td class="danger col-md-2" >Yes</td>
                                        @if($user->hasRole('mice'))
                                        <td class="danger col-md-2" ><a href="{{ url("/mice/$d->id/delete") }}" onclick="return confirm('Are you sure to delete this Voucher?')">Delete</a></td>
                                      @else
                                        <td class="danger col-md-2" ></td>
                                      @endif
                                    </tr>
                                  @else
                                    <tr class="small">
                                        <td class="success col-md-2" >{{ ++$key }}</td>
                                        <td class="success col-md-2" ><a href="javascript://" title ='User {{ $d->name }} Details' data-toggle="popover-plugin" data-html="true"  data-placement="right" data-content="MICE Name : {{ $d->name }}<br> Username : {{ $d->username }}<br> Password : {{ $d->password }}" >{{ $d->name }} </a></td>
                                        <td class="success col-md-2" >{{ $d->number }}</td>
                                        <td class="success col-md-2" >{{ \Carbon\Carbon::parse($d->start)->format('d M Y H:i:s') }}</td>
                                        <td class="success col-md-2" >{{ \Carbon\Carbon::parse($d->end)->format('d M Y H:i:s') }}</td>
                                        <td class="success col-md-2" >{{ $d->service }}</td>
                                        <td class="success col-md-2" >Active</td>
                                        <td class="success col-md-2" >Yes</td>
                                        @if($user->hasRole('mice'))
                                        <td class="success col-md-2" ><a href="{{ url("/mice/$d->id/delete") }}" onclick="return confirm('Are you sure to delete this Voucher?')">Delete</a></td>
                                      @else
                                        <td class="success col-md-2" ></td>
                                      @endif
                                    </tr>
                                  @endif
                                @endif
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
