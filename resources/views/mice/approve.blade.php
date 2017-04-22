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
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/jquery.datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body ">
                        <div class="panel-body ">
                          <div class="panel-heading bg-success">
                              <p>
                              <h3>MICE Activation</h3>

                              <div><h4>Name :<strong> {{ $mice[0]->name }}</strong></h4></div>
                              <div><h4>Participant Number : <strong>{{ $mice[0]->number }}</strong></h4></div>
                              <div><h4>Start : <strong>{{ \Carbon\Carbon::parse($mice[0]->start)->format('d M Y H:i') }}</strong></h4></div>
                              <div><h4>End : <strong>{{ \Carbon\Carbon::parse($mice[0]->end)->format('d M Y H:i') }}</strong></h4></div>
                              <div><h4>Service : <strong>{{ $mice[0]->service }}</strong></h4></div>



                              <a class="btn btn-primary" href="{{ url("/mice/$id/approvestore") }}">Activate MICE</a>
                              </p>
                          </div>


                        </div>



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
        $(function() {
            var d = new Date();
            d.setDate(d.getDate());
            var def= new Date();
            def.setDate(def.getDate());
            $('#datetimepicker').datetimepicker({

                autoclose: true,
                todayBtn: true,
                defaultDate:def,
                startDate: d,

            });

            $('#datetimepicker1').datetimepicker({

                autoclose: true,
                todayBtn: true,
                defaultDate:def,
                startDate: d,

            });

        });
    </script>

    <script>
        $('#datetimepicker1').datetimepicker({
            autoclose: true,
            todayBtn: true,
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
