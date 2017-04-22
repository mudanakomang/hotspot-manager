@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Dashboard</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body ">
                        <div class="panel-body ">



                            <div class="col-lg-4 col-xs-6">
                                <div class="small-box bg-aqua">

                                    <div class="inner">
                                        <div class="icon ">
                                            <i class="ion ion-iphone"></i>
                                        </div>
                                        <h2>Guest {{ $guest[0]->cuser }} ({{ round($guest[0]->cuser/$totalguest[0]->total,2)*100 }} %)</h2>
                                        <h2>Public {{ $public[0]->cuser }}</h2>
                                        <h2>Mice {{$mice[0]->cuser}}</h2>
                                        <h2>Total : {{$guest[0]->cuser + $public[0]->cuser + $mice[0]->cuser }}</h2>
                                    </div>

                                    <a class="small-box-footer" href="{{ url("/guestinhouse/online") }}">Online User -- Details <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xs-6">
                                <div class="small-box bg-aqua">

                                    <div class="inner">
                                        <div class="icon ">
                                            <i class="ion ion-iphone"></i>
                                        </div>
                                      @if($totalbytes[0]->down_user<1073741824)
                                            <h2>Download <strong>{{ round($totalbytes[0]->down_user/1048576,2) }} MB</strong></h2>
                                          @else
                                            <h2>Download <strong>{{ round($totalbytes[0]->down_user/1073741824,2) }} GB</strong></h2>
                                          @endif
                                        @if($totalbytes[0]->up_user<1073741824)
                                        <h2>Upload <strong>{{ round($totalbytes[0]->up_user/1048576,2) }} MB</strong></h2>
                                        @else
                                            <h2>Upload <strong>{{ round($totalbytes[0]->up_user/1073741824,2) }} GB</strong></h2>
                                            @endif
                                        <h2>{{ \Carbon\Carbon::now('Asia/Makassar')->format('d M Y') }}</h2>

                                    </div>

                                    <a class="small-box-footer" href="">Total Upload/Download</a>
                                </div>
                            </div>




                        </div>


                    </div>
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="box ">
                                <h4 class="center">Online Users</h4>
                                <canvas id="chartUser"  width="900" height="300"></canvas>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
@section('scripts')

    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script>
        var ctx = document.getElementById("chartUser");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($times) !!},
                datasets: [{
                    label: 'Guest',
                    backgroundColor: "rgba(255, 192, 56,0.4)",
                    borderColor: "rgba(255, 192, 56,1)",
                    data: {!! json_encode($tguests) !!}
                }, {
                    label: 'Public',
                    backgroundColor: "rgba(137, 202, 255,0.4)",
                    borderColor: "rgba(137, 202, 255,1)",
                    data: {!! json_encode($tpublics) !!}
                },
                    {
                        label: 'MICE',
                        backgroundColor: "rgba(240, 170, 255,0.4)",
                        borderColor: "rgba(240, 170, 255,1)",
                        data: {!! json_encode($tmices) !!}
                    }]
            }
        });

    </script>

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
