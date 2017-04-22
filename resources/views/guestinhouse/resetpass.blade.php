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
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                <h3> Reset Password user {{ $users }}</h3>

                            </div>
                            {!! Form:: open(['url'=>route('guestinhouse.passstore'),'method'=>'post','class'=>'form-horizontal']) !!}
                            {!! Form::hidden('users', $users)  !!}
                            <div class="form-group{{ $errors->has('userpassword') ? ' has-error' : '' }}">
                                {!! Form::label('userpassword', 'New Password', ['class'=>'col-md-2 control-label']) !!}
                                <div class="col-md-4"><i class="glyphicon glyphicon-lock"></i>
                                    {!! Form::text('userpassword', null, ['class'=>'form-control '])  !!}
                                    {!! $errors->first('userpassword', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-4 ">
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

