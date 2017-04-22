<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="{{ asset("/bower_components/admin-lte/dist/css/admin-lte.min.css") }}" rel="stylesheet" type="text/css" />
<table border="1px" width="40%">
<tr><td><img src="landing/images/agus_img/logo.png" width="50px">


                        <h3 class="box-title"> Guest In House Voucher</h3>
                        <h2 class="box-title bg-info"> Room {{ $data[0]->assigned }}</h2>






    <table  width="250px" style="position: absolute;">

        @foreach ($data as $d)
            <tr><td width="30%"> Username  </td><td width="70%">: {{ $d->username }}</td></tr>
            <tr><td width="30%"> Password </td><td width="70%">: {{ $d->password }}</td></tr>
            <tr><td width="30%"> Expiration </td><td width="70%">: {{ $d->value }}</td></tr>
        @endforeach
    </table>
    </td></tr>
</table>
















