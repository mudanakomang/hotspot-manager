@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Room Management</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body ">
                        <div class="panel-body ">
                            <div class="panel-heading bg-success">
                                <p>

                                @if( $user->hasRole('master'))
                                    <a class="btn btn-primary" href="{{ url("/guestinhouse/addroom") }}">Add Room</a>
                                    @endif

                                <h3> Room  {{ $username }} Edit </h3>

                                    </p>
                            </div>

                            {{ Form::open(array('url' => '/guestinhouse/roomeditstore','class'=>'col-md-4')) }}


                            <div class="form-group">
                                <div class="form-group{{ $errors->has('room') ? ' has-error' : '' }}">
                                    {{  Form::label('room', 'User/Room') }}
                                    {{  Form::text('room', $room[0]->username,['class' => 'form-control','readonly'=>'true']) }}
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
                                    {{  Form::text('shared', $room[0]->shared,['class' => 'form-control ']) }}
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

