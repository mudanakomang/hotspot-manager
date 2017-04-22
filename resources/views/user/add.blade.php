@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Managae Administrator</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body ">
                        <div class="panel-body ">
                            <div class="panel-heading bg-success">
                                <p>

                                <h3>Administrator List</h3>
                                <a class="btn btn-primary" href="{{ url("/user/add") }}">Add Administrator</a>
                                </p>
                            </div>

                        </div>
                        {!! Form::open(['url'=> route('user.add'),'class'=>'form-horizontal']) !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Name', ['class'=>'col-md-2 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'Email', ['class'=>'col-md-2 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::text('email', null, ['class'=>'form-control']) !!}
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pass') ? ' has-error' : '' }}">
                            {!! Form::label('pass', 'Password', ['class'=>'col-md-2 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::password('pass', ['class'=>'form-control']) !!}
                                {!! $errors->first('pass', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            {!! Form::label('role', 'Role', ['class'=>'col-md-2 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::select('role',$sec,null, ['class'=>'form-control']) !!}
                                {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
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
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({

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

