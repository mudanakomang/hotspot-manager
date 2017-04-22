@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">MAC Address Bypass</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                <h3> MAC Authentication </h3>
                            </div>
                            {{ Form::open(array('url' => '/guestinhouse/macauthstore','class'=>'col-md-4')) }}

                            <div class="form-group">
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                {{ Form::label('address', 'MAC Address') }}
                                {{ Form::text('address',Null, array('class' => 'form-control ','style'=>'text-transform:uppercase')) }}
                                {{ $errors->first('address', '<p class="help-block">:message</p>') }}
                             </div>
                            </div>



                            <div class="form-group">
                                <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                                {{  Form::label('user', 'User/Room') }}
                                {{  Form::select('user',$list, null,['class' => 'form-control ']) }}
                                    {{ $errors->first('user', '<p class="help-block">:message</p>') }}
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

