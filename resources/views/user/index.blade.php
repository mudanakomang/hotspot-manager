@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layouts._flash')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Administrator</h3>
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
                        <table class="table table-hover table-bordered" id="example1">
                            <thead>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                        @foreach($operator as $op)

                            @if($op->role=='master')
                            <tr>
                               <td class="danger "> {{ $op->name }}</td>
                               <td class="danger "> {{ $op->email }}</td>
                                <td class="danger">{{ $op->role }}</td>
                                @if($count<=1)
                               <td class="danger "><a href="{{ url("/user/$op->id/edit") }}" onclick="return confirm('Are you sure to edit this operator?')">Edit</a></td>
                                    @else
                                    <td class="danger "><a href="{{ url("/user/$op->id/edit") }}" onclick="return confirm('Are you sure to edit this operator?')">Edit</a> | <a href="{{ url("/user/$op->id/delete") }}" onclick="return confirm('Are you sure to delete this operator?')">Delete</a></td>
                                @endif
                             </tr>
                                @else
                                <tr>
                                    <td class="info "> {{ $op->name }}</td>
                                    <td class="info "> {{ $op->email }}</td>
                                    <td class="info">{{ $op->role }}</td>
                                    <td class="info "><a href="{{ url("/user/$op->id/edit") }}" onclick="return confirm('Are you sure to edit this operator?')">Edit</a> | <a href="{{ url("/user/$op->id/delete") }}" onclick="return confirm('Are you sure to delete this operator?')">Delete</a></td>
                                </tr>
                            @endif

                        @endforeach
                            </tbody>
                        </table>

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

