@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    @include('layouts._flash')
                    <div class="box-header">
                        <h3 class="box-title">Voucher List</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                @if($user->role=='admin')
                                    <a class="btn btn-primary" href="{{ url("/voucher/addvoucher") }}">Add Voucher</a>

                                @endif

                                    <a class="btn btn-primary" href="{{ url("voucher/searchvoucher") }}">Search Voucher</a>
                            </div>
                  <form action="{{ url("/voucher/usercheck") }}" method="post" name="users">
                  <table id="example1" class="table table-bordered table-hover table-responsive">
                  <thead>
                @if($vgroup=='GuestInHouse')
                  <tr>
                      <th class="col-md-2  " ><input type="checkbox" id="selectall" /></th>
                      <th class="col-md-2  " >Username</th>
                      <th class="col-md-2" >Password</th>
                      <th class="col-md-2" >Group</th>
                      <th class="col-md-2" >Assigned To </th>
                      <th class="col-md-2" >Assigned By </th>
                      <th class="col-md-2" >Status </th>
                      <th class="no-sort col-md-2 ">Action</th>
                  </tr>
                    @else
                    <tr>
                        <th class="col-md-2  " ><input type="checkbox" id="selectall" /></th>
                        <th class="col-md-2 " >Access Code</th>

                        <th class="col-md-2" >Group</th>
                        <th class="col-md-2" >Status </th>
                        <th class="no-sort col-md-2 ">Action</th>
                    </tr>
                    @endif
                  </thead>

                      <tbody>

                      @foreach($listuser as $l)


                              @if($l->status=='0')
                                    <tr>
                                        <td class="info col-md-2 " > <input  class="case" name="users[]" value="{{ $l->id }}" type="checkbox"> </td>
                                        @if($l->group=='Public')
                                        <td class="info col-md-2" >{{ $l->username }}</td>
                                        @else
                                        <td class="info col-md-2" >{{ $l->username }}</td>
                                        <td class="info col-md-2" >{{ $l->password }}</td>
                                        @endif
                                        <td class="info col-md-2" >{{ $l->group }}</td>
                                        @if($l->group=='GuestInHouse')
                                            <td class="info col-md-2" >{{ $l->assigned }}</td>
                                            <td class="info col-md-2" >{{ $l->assigned_by }}</td>
                                        @endif
                                        <td class="info col-md-2" >Inactive</td>
                                        @if($l->group=='GuestInHouse')
                                            <td class="info col-md-2" ><a href="{{ url("/voucher/$l->id/assign") }}">Assign</a>

                                        @else
                                            <td class="info col-md-2" ><a href="{{ url("/voucher/$l->id/activate") }}">Activate</a>
                                                | <a href="{{ url("/voucher/$l->id/deleteuser") }}" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a></td>
                                        @endif
                                    </tr>
                              @else
                                  @if($l->useracct!=NULL)
                                  <tr>
                                    <td class="danger col-md-2 "> <input class="case"   name="users[]" value="{{ $l->id }}" type="checkbox"> </td>
                                      @if($l->group=='Public')
                                    <td class="danger col-md-2" ><a href="{{ url("/voucher/$l->username/details") }}">{{ $l->username }}</a> </td>
                                      @else
                                          <td class="danger col-md-2" ><a href="{{ url("/voucher/$l->username/details") }}">{{ $l->username }}</a> </td>
                                    <td class="danger col-md-2" >{{ $l->password }}</td>
                                      @endif
                                    <td class="danger col-md-2" >{{ $l->group }}</td>

                                      @if($l->group=='GuestInHouse')
                                    <td class="danger col-md-2" >{{ $l->assigned }}</td>
                                          <td class="danger col-md-2" >{{ $l->assigned_by }}</td>
                                      @endif
                                    <td class="danger col-md-2" >Used</td>
                                      @if($l->group=='GuestInHouse')
                                    <td class="danger col-md-2" ><a href="{{ url("/voucher/$l->id/deleteuser") }}" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a></td></td>
                                          @else
                                          <td class="danger col-md-2" > <a href="{{ url("/voucher/$l->id/deleteuser") }}" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a></td>
                                          @endif
                                  </tr>
                                      @else
                                        @if(\Carbon\Carbon::parse($l->value) < \Carbon\Carbon::now('Asia/Makassar'))
                                      <tr>
                                          <td class="danger col-md-2 "> <input class="case"   name="users[]" value="{{ $l->id }}" type="checkbox"> </td>
                                          @if($l->group=='Public')
                                          <td class="danger col-md-2" >{{ $l->username }}</td>
                                          @else
                                          <td class="danger col-md-2" >{{ $l->username }}</td>
                                          <td class="danger col-md-2" >{{ $l->password }}</td>
                                          @endif
                                          <td class="danger col-md-2" >{{ $l->group }}</td>

                                          @if($l->group=='GuestInHouse')
                                              <td class="danger col-md-2" >{{ $l->assigned }}</td>
                                              <td class="danger col-md-2" >{{ $l->assigned_by }}</td>
                                          @endif
                                          <td class="danger col-md-2" >Unused</td>
                                          @if($l->group=='GuestInHouse')
                                              <td class="danger col-md-2" ><a href="{{ url("/voucher/$l->id/deleteuser") }}" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a></td>
                                          @else
                                              <td class="danger col-md-2" ><a href="{{ url("/voucher/$l->id/deleteuser") }}" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a></td>
                                          @endif
                                      </tr>
                                            @else
                                            <tr>
                                                <td class="info col-md-2 "> <input class="case"   name="users[]" value="{{ $l->id }}" type="checkbox"> </td>
                                               @if($l->group=='Public')
                                                <td class="info col-md-2" >{{ $l->username }}</td>
                                                @else
                                                    <td class="info col-md-2" >{{ $l->username }}</td>
                                                <td class="info col-md-2" >{{ $l->password }}</td>
                                                @endif
                                                <td class="info col-md-2" >{{ $l->group }}</td>

                                                @if($l->group=='GuestInHouse')
                                                    <td class="info col-md-2" >{{ $l->assigned }}</td>
                                                    <td class="info col-md-2" >{{ $l->assigned_by }}</td>
                                                @endif
                                                <td class="info col-md-2" >Unused</td>
                                                @if($l->group=='GuestInHouse')
                                                    <td class="info col-md-2" ><a href="{{ url("/voucher/$l->id/printguest") }}">Print</a></td>
                                                @else
                                                    <td class="info col-md-2" ><a href="{{ url("/voucher/$l->id/deleteuser") }}" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a> </td>
                                                @endif
                                            </tr>
                                            @endif
                                      @endif
                              @endif
                          @endforeach

                      </tbody>

                  </table>

                      <input class="btn btn-primary" type="submit" name="action" value="Delete" onclick="return confirm('Are you sure you want to delete selected User?');">



                      </form>

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
    <script language="javascript">
        $(function(){

            // add multiple select / deselect functionality
            $("form #selectall").click(function () {
                $('.case').prop('checked', this.checked);
            });

            // if all checkbox are selected, check the selectall checkbox
            // and viceversa


            $("form .case").click(function(){

                if($(".case").length == $(".case:checked").length) {
                   $("#selectall").prop('checked', this.checked);
                } else {
                   $("#selectall").prop('checked',false);
                }

            });

        $('#example1').on('submit', function(e){
            var form = this;

            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    // If checkbox is checked
                    if(this.checked){
                        // Create a hidden element
                        $(form).append(
                                $('<input>')
                                        .attr('type', 'hidden')
                                        .attr('name', this.name)
                                        .val(this.value)
                        );
                    }
                }
            });
        });

        });

    </script>


@endsection
@stop()
