@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            @include('layouts._flash')
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Batch Voucher List</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                @if($user->hasRole('master') || $user->hasRole('admin'))
                                    <a class="btn btn-primary" href="{{ url("/voucher/addvoucher") }}">Add Batch</a>

                                @endif

                                <a class="btn btn-primary" href="{{ url("voucher/searchvoucher") }}">Search Voucher</a>
                                <a class="btn btn-primary" href="{{ url("voucher/expiredvoucher") }}">Expired Voucher</a>


                            </div>
                            <table id="example1" class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>


                                    <th class="col-md-2" >#</th>
                                    <th class="col-md-2" >Group</th>
                                    <th class="no-sort col-md-2 ">Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($group as $key=>$g)
                                    <tr>
                                    <td class="info col-md-2" >{{ ++$key }}</td>
                                    <td class="info col-md-2" ><a href=" {{ url("/voucher/$g->voucher/expired") }}">{{ $g->voucher }}</a></td>
                                    <td class="info no-sort col-md-2 "><a href="{{ url("/voucher/$g->voucher/expired/delete/") }}" onclick="return confirm('This action will completely delete all users in this voucher group. Are You sure to continue delete?')">Delete</a> </td>
                                    </tr>
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
                    "width": "5%"
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

