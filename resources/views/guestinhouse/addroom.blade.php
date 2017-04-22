@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Room Management</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                <h3> Add Room </h3>
                            </div>
                            {{ Form::open(array('url' => '/guestinhouse/roomstore','class'=>'col-md-4')) }}


                            <div class="form-group">
                                <div class="form-group{{ $errors->has('room') ? ' has-error' : '' }}">
                                    {{  Form::label('room', 'User/Room') }}
                                    {{  Form::text('room', null,['class' => 'form-control ']) }}
                                    @if ($errors->has('room'))
                                        <span class="help-block">
                                         <strong>{{ $errors->first('room') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group{{ $errors->has('shared') ? ' has-error' : '' }}">
                                    {{  Form::label('shared', 'Shared User') }}
                                    {{  Form::text('shared', null,['class' => 'form-control ']) }}
                                    @if ($errors->has('shared'))
                                        <span class="help-block">
                                         <strong>{{ $errors->first('shared') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

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
        $('#datetimepicker').datetimepicker({
            autoclose: true,
            todayBtn: true,
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

