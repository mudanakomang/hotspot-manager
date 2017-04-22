@extends('layouts.operator')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    @include('layouts._flash')
                    <div class="box-header">
                        <h3 class="box-title">Details User {{ $details[0]->username }}</h3>
                    </div><!-- /.box-header -->
                    <link href="{{ asset("css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
                    <link href="{{ asset("css/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="panel-heading">
                                @if(Entrust::hasRole('admin'))
                                    <a class="btn btn-primary" href="{{ url("/voucher/addvoucher") }}">Add Voucher</a>
                                    <a class="btn btn-primary" href="{{ url("voucher/searchvoucher") }}">Search Voucher</a>
                                @endif
                            </div>

                            <div class="box-body bg-success">

                                <h4>Username :  {{ $details[0]->username }} </h4>
                                <h4> Group    :  {{ $details[0]->groups }}</h4>
                                <h4> Download : {{ $details[0]->download }}</h4>
                                <h4> Upload   : {{ $details[0]->upload }}</h4>
                                <h4> Total    : {{ $details[0]->total }}</h4>
                                <h4> Assigned To : {{ $details[0]->assigned }}</h4>
                                <h4> Last Login : {{ Carbon\Carbon::parse($details[0]->maxs)->format('Y M d h:i:s') }}</h4>


                            </div>

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
                    "searching": false,

                } ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "LengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
                "pageLength": 50
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

