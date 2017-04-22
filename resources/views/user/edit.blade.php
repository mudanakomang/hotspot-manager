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

                                </p>
                            </div>

                        </div>
                        {!! Form::model($ops,['url'=> route('user.edit',$ops->id),'method'=>'post','class'=>'form-horizontal']) !!}
                        @include('user._form')
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

