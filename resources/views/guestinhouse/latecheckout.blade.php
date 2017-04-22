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
                    <link href="{{ asset("css/jquery.timepicker.min.css") }}" rel="stylesheet" type="text/css" />


                    <div class="box-body">
                        <div class="panel-body">

                            {{ Form::open(array('url' => '/guestinhouse/latecheckoutstore','class'=>'col-md-4')) }}

                            <div class="form-group">
                                <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                                    {{ Form::label('time', 'Add Time') }}
                                    {!! Form::text('time', null, ['class'=>'form-control timepicker','readonly'=>'true'])  !!}
                                    {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                           {{ Form::hidden('username',$username) }}

                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@section('scripts')

    <script>


        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '15',
            maxTime: '11:00pm',
            defaultTime: '15',
            startTime: '15',
            dynamic: false,
            dropdown: true,
            scrollbar: true
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

