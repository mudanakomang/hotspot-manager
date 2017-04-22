@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Batch Voucher List</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                               @if(!$user->hasRole('mice'))
                                <a class="btn btn-primary" href="{{ url("/voucher/addvoucher") }}">Add Batch</a>
                                <a class="btn btn-primary" href="{{ url("voucher/voucherhistory") }}">Voucher History</a>
                                @endif

                                <a class="btn btn-primary" href="{{ url("voucher/searchvoucher") }}">Search Voucher</a>



                            </div>
                  <table id="example1" class="table table-bordered table-hover table-responsive">
                  <thead>
                  <tr>

                      <th class="col-md-2" >Name</th>
                      <th class="col-md-2" >Group</th>
                      <th class="col-md-2" >Total </th>
                      <th class="col-md-2" >Used/Unused </th>
                      <th class="col-md-2" >Creation Date </th>
                      <th class="col-md-2" >Valid Until </th>
                      <th class="col-md-2" >Description </th>
                      <th class="col-md-2" >Created By </th>
                      <th class="no-sort col-md-2 ">Action</th>
                  </tr>
                  </thead>

                      <tbody>

                      @foreach($list as $l)

                          @if($user->hasRole('admin') or $user->hasRole('master'))
                                @if($l->status=='1')
                                    <tr class="small">
                                        <td class="success col-md-2" ><a href="{{ url("/voucher/$l->name/listuser")}}"> {{ $l->name }}</a></td>
                                         <td class="success col-md-2" >{{ $l->group }}</td>
                                        <td class="success col-md-2" >{{ (int)$l->total }}</td>
                                        <td class="success col-md-2" >{{ (int)$l->used }} / {{ (int)$l->unused }}</td>
                                            <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                            <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->valid)->format('d M Y H:i') }}</td>
                                            <td class="success col-md-2" >{{ $l->description }}</td>
                                            <td class="success col-md-2" >{{ $l->createdby }}</td>
                                                @if($l->group=='GuestInHouse')
                                            <td class="success col-md-2" ></td>
                                                @else
                                            <td class="success col-md-2" ><a href="{{ url("/voucher/$l->name/print") }}">Print</a></td>
                                                @endif
                                        </tr>
                                  @else
                                  <tr class="small">
                                      <td class="danger col-md-2" > {{ $l->name }}</td>
                                      <td class="danger col-md-2" >{{ $l->group }}</td>
                                      <td class="danger col-md-2" >{{ (int)$l->total }}</td>
                                      <td class="danger col-md-2" >{{ (int)$l->used }} / {{ (int)$l->unused }}</td>
                                      <td class="danger col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                      <td class="danger col-md-2" >{{ \Carbon\Carbon::parse($l->valid)->format('d M Y H:i') }}</td>
                                      <td class="danger col-md-2" >{{ $l->description }}</td>
                                      <td class="danger col-md-2" >{{ $l->createdby }}</td>
                                      <td class="danger col-md-2" ></td>
                                  </tr>
                                  @endif
                              @else
                               @if($l->group=='GuestInHouse')
                                   @if($l->status=='1')
                                       <tr class="small">
                                           <td class="success col-md-2" ><a href="{{ url("/voucher/$l->name/listuser")}}"> {{ $l->name }}</a></td>
                                           <td class="success col-md-2" >{{ $l->group }}</td>
                                           <td class="success col-md-2" >{{ (int)$l->total }}</td>
                                           <td class="success col-md-2" >{{ (int)$l->used }} / {{ (int)$l->unused }}</td>
                                           <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                           <td class="success col-md-2" >{{ \Carbon\Carbon::parse($l->valid)->format('d M Y H:i') }}</td>
                                           <td class="success col-md-2" >{{ $l->description }}</td>
                                           <td class="success col-md-2" >{{ $l->createdby }}</td>
                                           <td class="success col-md-2" ></td>


                                       </tr>
                                       @else
                                       <tr class="small">
                                           <td class="danger col-md-2" ><a href="{{ url("/voucher/$l->name/listuser")}}"> {{ $l->name }}</a></td>
                                           <td class="danger col-md-2" >{{ $l->group }}</td>
                                           <td class="danger col-md-2" >{{ (int)$l->total }}</td>
                                           <td class="danger col-md-2" >{{ (int)$l->used }} / {{ (int)$l->unused }}</td>
                                           <td class="danger col-md-2" >{{ \Carbon\Carbon::parse($l->created)->format('d M Y H:i') }}</td>
                                           <td class="danger col-md-2" >{{ \Carbon\Carbon::parse($l->valid)->format('d M Y H:i') }}</td>
                                           <td class="danger col-md-2" >{{ $l->description }}</td>
                                           <td class="danger col-md-2" >{{ $l->createdby }}</td>
                                           @if($user->can('print'))
                                               <td class="success col-md-2" ><a href="{{ url("/voucher/$l->name/print") }}">Print</a></td>
                                           @else
                                               <td class="success col-md-2" ></td>
                                           @endif
                                       </tr>
                                    @endif
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
