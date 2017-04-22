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

                                <h3>MICE Add</h3>

                            </div>

                        </div>

                        {{ Form::open(array('url' => '/mice/addstore','class'=>'col-md-4')) }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'MICE Name', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::text('name', null, ['class'=>'form-control '])  !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            {!! Form::label('username', 'MICE Username', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::text('username', null, ['class'=>'form-control '])  !!}
                                {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'MICE Password', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::text('password', null, ['class'=>'form-control '])  !!}
                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('num') ? ' has-error' : '' }}">
                            {!! Form::label('num', 'Participant Number', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::text('num', null, ['class'=>'form-control '])  !!}
                                {!! $errors->first('num', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }}">
                            {!! Form::label('from', 'Start', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::text('from', null, ['class'=>'form-control ','id'=>'datetimepicker','data-date-format'=>'dd M yyyy hh:ii:ss','readonly' => 'true'])  !!}
                                {!! $errors->first('from', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('to') ? ' has-error' : '' }}">
                            {!! Form::label('to', 'End', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::text('to', null, ['class'=>'form-control ','id'=>'datetimepicker1','data-date-format'=>'dd M yyyy hh:ii:ss','readonly' => 'true'])  !!}
                                {!! $errors->first('to', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                            {!! Form::label('service', 'Service', ['class'=>'control-label']) !!}
                            <div >
                                {!! Form::select('service',['512K/512K'=>'512 Kbps','1M/1M'=>'1 Mbps','2M/2M'=>'2 Mbps'],'512K/512K', ['class'=>'form-control'])  !!}
                                {!! $errors->first('servcie', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>



                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}

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
