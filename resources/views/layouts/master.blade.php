<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Hotspot Manager | Home</title>
    <link href="{{ asset("/landing/css/bootstrap.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/landing/css/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/landing/css/animate.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/landing/css/main.css") }}" rel="stylesheet">
    <link href="{{ asset("/landing/css/custom.css") }}" rel="stylesheet">
    <link href="{{ asset("/landing/css/prettyPhoto.css") }}" rel="stylesheet">
    <link href="{{ asset("/landing/css/responsive.css") }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/agus_img/wifi.ico">
</head><!--/head-->
<body>
@include('layouts.landing-header')
@include('layouts.landing-portofolio')
<div class="panel panel-default" id="ag-login">
    <div class="panel-body">
        <!-- $(if error) -->
        @if($error)
            <div>{{ $error }}</div>
        @endif
    <!-- $(endif) -->

        <div class="alert alert-info">Please log on to use the hotspot service.</div>

        <!-- $(if trial == 'yes') -->
        @if($trial=='yes')
            <div class="alert alert-success">
                Free trial available, <a href="{{ $linkloginonly }}?dst={{ $linkorigesc }}&username=T-{{ $macesc }}">click here</a>.
            </div>
    @endif
    <!-- $(endif) -->


        <form id="loginForm" class="form-horizontal" role="form" action="{{ $linkloginonly }}" method="post">
            <input type="hidden" name="dst" value="{{ $linkorig }}"/>
            <input type="hidden" name="popup" value="true"/>

            <div class="form-group">
                <label for="inputLogin" class="col-sm-2 control-label">Login</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control input-lg" id="inputLogin" name="username"
                           placeholder="Login" autofocus required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                <div class="col-sm-10">
                    <input type="password" class="form-control input-lg" id="inputPassword" name="password"
                           placeholder="Password" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">OK</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('layouts.landing-footer')


<script src="{{ asset("/landing/js/jquery.min.js") }}"></script>
<script src="{{asset("/landing/js/bootstrap.min.js") }}"></script>
<script src="{{asset("/landing/js/jquery.isotope.min.js") }}"></script>
<script src="{{asset("/landing/js/main.js") }}"></script>
<script src="{{asset("/landing/js/wow.min.js") }}"></script>
<script src="{{asset("/landing/js/jquery.prettyPhoto.js") }}"></script>


</body>
</html>
