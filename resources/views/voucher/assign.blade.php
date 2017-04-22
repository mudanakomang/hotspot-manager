@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Voucher Add</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                            </div>
                            {!! Form::open(array('url'=>'/voucher/assignstore','class'=>'form-horizontal')) !!}
                            {!! Form::hidden('user',$user->name) !!}
                            {!! Form::hidden('id',$id) !!}
                            <div class="form-group{{ $errors->has('room') ? ' has-error' : '' }}">
                                {!! Form::label('room', 'Room', ['class'=>'col-md-2 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::select('room',$room,null, ['class'=>'form-control']) !!}
                                    {!! $errors->first('room', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                                  <div class="form-group">
                                <div class="col-md-4 col-md-offset-2">
                                    {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
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

