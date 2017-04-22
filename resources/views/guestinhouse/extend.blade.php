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
                    <link href="{{ asset("css/jquery.timepicker.min.css") }}" rel="stylesheet" type="text/css" />

                    <link href="{{ asset("css/jquery.datetimepicker.css") }}" rel="stylesheet" type="text/css" />



                    <div class="box-body">
                        <div class="panel-body">

                            {{ Form::open(array('url' => '/guestinhouse/extendstore','class'=>'col-md-4')) }}


                                    {{ Form::hidden('username',$username) }}
                                    <br>




<div class="control-group">
    <label class="radio" for="radio1">
      <input type="radio" name="radio" id="radio1" value="late" checked="checked" onChange="disablefield();">
      Late Checkout
    </label>
    <div class="input-append">
      <input type="text" name="late" id="date1" class="form-control timepicker" >

    </div>



    <label class="radio" for="radio2">
      <input type="radio" name="radio" id="radio2" value="extend" onChange="disablefield();">
    Extend
    </label>
    <input type="text" name="extend" id="date2" class="form-control datetimepicker"  disabled="disabled">

    <br>
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


        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '15',
            maxTime: '11:00pm',
            defaultTime: '15',
            startTime: '15',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });


    </script>

    <script>
  		$(function() {
  			var d = new Date();
  			d.setDate(d.getDate()+1);
  			var def= new Date();
  			def.setDate(def.getDate()+1);
  			$('.datetimepicker').datetimepicker({

  				autoclose: true,
  				todayBtn: true,
  				minView: '2',
  				format: 'd M yyyy 14:00',
  				defaultDate:def,
  				startDate: d,

  			});
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
    <script type="text/javascript">
    function disablefield(){
if (document.getElementById('radio1').checked == 1){
document.getElementById('date1').disabled='';
document.getElementById('date2').disabled='disabled';

}else{
document.getElementById('date1').disabled='disabled';
document.getElementById('date2').disabled='';
 }
}
</script>



@endsection
@stop()
