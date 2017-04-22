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
                                <h3> Room List </h3>
                                @if( $user->hasRole('master'))
                                <a class="btn btn-primary" href="{{ url("/guestinhouse/addroom") }}">Add Room</a>
                                @endif


                                </p>
                            </div>

                        </div>


                            <table id="example1" class="table table-bordered table-hover">

                                <thead>

                                <tr>
                                    <th>#</th>
                                    <th class="col-md-2" >Room/User</th>
                                    <th class="col-md-2" >Shared User</th>
                                    <th class="no-sort col-md-2 ">Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($lists as $key=>$list)
                                    @if($user->hasRole('master'))
                                    <tr>
                                        <td class="info col-md-2">{{ ++$key }}</td>
                                        <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$list->id/details")}}">  {{ $list->username }} </a> </td>
                                        <td class="info col-md-2" >{{ $list->shared }}</td>
                                        <td class="info col-md-2 " ><a href="{{ url("/guestinhouse/$list->username/roomedit") }}" onclick="return confirm('Are You sure to edit this room ?')">Edit Room</a>
                                            | <a href="{{ url("/guestinhouse/$list->username/roomdelete") }}" onclick="return confirm('Are You sure to delete this room ?')">Delete Room</a> </td>

                                    </tr>
                                  @elseif(!$user->hasRole('master'))
                                    <tr>
                                        <td class="info col-md-2">{{ ++$key }}</td>
                                        <td class="info col-md-2" ><a href="{{ url("/guestinhouse/$list->id/details")}}">  {{ $list->username }} </a> </td>
                                        <td class="info col-md-2" >{{ $list->shared }}</td>
                                        <td class="info col-md-2 " >-</td>

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
