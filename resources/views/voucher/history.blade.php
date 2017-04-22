@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Voucher History</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                @if($user->hasRole('master') || $user->hasRole('admin'))
                                    <a class="btn btn-primary" href="{{ url("/voucher/addvoucher") }}">Add Batch</a>
                                    <a class="btn btn-primary" href="{{ url("voucher/voucherhistory") }}">Voucher History</a>
                                @endif

                                <a class="btn btn-primary" href="{{ url("voucher/searchvoucher") }}">Search Voucher</a>



                            </div>
                            <table id="example1" class="table table-bordered table-hover table-responsive">
                                <thead>

                                @if($user->hasRole('admin') or $user->hasRole('master'))
                                    <tr>
                                    <th class="col-md-2" >No</th>
                                    <th class="col-md-2" >Name</th>
                                    <th class="col-md-2" >Deleted/Expired Date</th>
                                    <th class="col-md-2" >Status </th>
                                    <th class="col-md-2" >Deleted By </th>
                                    <th class="col-md-2" >Voucher Number </th>
                                    <th class="no-sort col-md-2 ">Action</th>
                                        </tr>
                                    @else
                                    <tr>
                                        <th class="col-md-2" >No</th>
                                        <th class="col-md-2" >Name</th>
                                        <th class="col-md-2" >Deleted/Expired Date</th>
                                        <th class="col-md-2" >Status </th>
                                        <th class="col-md-2" >Deleted By </th>
                                        <th class="col-md-2" >Voucher Number </th>
                                    </tr>
                                    @endif

                                </thead>

                                <tbody>

                                @foreach($list as $key=>$l)

                                    @if($user->hasRole('admin') or $user->hasRole('master'))
                                        @if($l->status=='Deleted')
                                            <tr class="small">
                                                <td class="success col-md-2">{{ ++$key }}</td>
                                                <td class="success col-md-2" ><a href="{{ url("/voucher/$l->voucher_name/expired")}}"> {{ $l->voucher_name }}</a></td>
                                                <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                                <td class="success col-md-2" >{{ $l->status }}</td>
                                                <td class="success col-md-2" >{{ $l->deleted_by }}</td>
                                                <td class="success col-md-2" >{{ $l->num }}</td>
                                                <td class="success col-md-2" ></td>
                                            </tr>
                                            @else
                                            <tr class="small">
                                                <td class="success col-md-2">{{ ++$key }}</td>
                                                <td class="success col-md-2" ><a href="{{ url("/voucher/$l->voucher_name/expired")}}"> {{ $l->voucher_name }}</a></td>
                                                <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                                <td class="success col-md-2" >{{ $l->status }}</td>
                                                <td class="success col-md-2" >--</td>
                                                <td class="success col-md-2" >{{ $l->num }}</td>
                                                <td class="success col-md-2" ></td>
                                            </tr>
                                        @endif
                                    @else
                                        @if($l->status=='Deleted')
                                            <tr class="small">
                                                <td class="success col-md-2">{{ ++$key }}</td>
                                                <td class="success col-md-2" ><a href="{{ url("/voucher/$l->voucher_name/expired")}}"> {{ $l->voucher_name }}</a></td>
                                                <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                                <td class="success col-md-2" >{{ $l->status }}</td>
                                                <td class="success col-md-2" >{{ $l->deleted_by }}</td>
                                                <td class="success col-md-2" >{{ $l->num }}</td>
                                                <td class="success col-md-2" ></td>
                                            </tr>
                                            @else
                                            <tr class="small">
                                                <td class="success col-md-2">{{ ++$key }}</td>
                                                <td class="success col-md-2" ><a href="{{ url("/voucher/$l->voucher_name/expired")}}"> {{ $l->voucher_name }}</a></td>
                                                <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                                <td class="success col-md-2" >{{ $l->status }}</td>
                                                <td class="success col-md-2" >--</td>
                                                <td class="success col-md-2" >{{ $l->num }}</td>
                                                <td class="success col-md-2" ></td>
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
        </div>
    </section>

@section('scripts')


    <script>
        $('#datetimepicker').datetimepicker({
            autoclose: true,
            todayBtn: true,
        });
    </script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "columnDefs": [ {
                    "targets": [0],
                    "orderable": false,
                    "width": "10%"
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
