<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="{{ asset("/bower_components/admin-lte/dist/css/admin-lte.min.css") }}" rel="stylesheet" type="text/css" />

<table border="1px" width="458" style="margin-left: auto;">

                @foreach ($data as $d)

                    <tr><td width="130" height="20"> Username  : {{ $d->username }}</td></tr>
                    <tr><td width="130" height="20"> Password  : {{ $d->password }}</td></tr>

                @endforeach

</table>