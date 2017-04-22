<?php
$mac=$_POST['mac'];
$ip=$_POST['ip'];
$username=$_POST['username'];
$linklogin=$_POST['link-login'];
$linkorig=$_POST['link-orig'];
$error=$_POST['error'];
$trial=$_POST['trial'];
$chapid=$_POST['chap-id'];
$chapchallenge=$_POST['chap-challenge'];
$linkloginonly=$_POST['link-login-only'];
$linkorigesc=$_POST['link-orig-esc'];
$macesc=$_POST['mac-esc'];
$identity=$_POST['identity'];
$bytesinnice=$_POST['bytes-in-nice'];
$bytesoutnice=$_POST['bytes-out-nice'];
$sessiontimeleft=$_POST['session-time-left'];
$uptime=$_POST['uptime'];
$refreshtimeout=$_POST['refresh-timeout'];
$linkstatus=$_POST['link-status'];
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Hotspot Manager| Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/agus_img/wifi.ico">
</head><!--/head-->
<body>

<div id="wrap">
    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-4">
                        <a class="navbar-brand" ref="index.html"><img src="images/agus_img/baner.png" alt="logo"></a>
                    </div>
                    <div class="col-sm-6 col-xs-8">
                        <div class="social">
                            <ul class="social-share">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->
        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">

                        <li><a href="http://192.168.100.3/hotspot-manager/public/landing/index_single.php">Home</a></li>
                        <li ><a href="{{ 'http://10.10.7.1/login' }}">Login</a></li>
                        <li><a href="{{ 'http://10.10.7.1/status' }}">Status</a></li>
                        <li><a href="{{ 'http://10.10.7.1/logout' }}">Logout</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->

    @if($chapid)
        <form name="sendin" action="{{ $linkloginonly }}" method="post">
            <input type="hidden" name="username" />
            <input type="hidden" name="password" />
            <input type="hidden" name="dst" value="{{ $linkorig }}" />
            <input type="hidden" name="popup" value="true" />
        </form>

        <script type="text/javascript" src="js/md5.js"></script>
        <script type="text/javascript">
            <!--
            function doLogin() {
                document.sendin.username.value = document.login.username.value;
                document.sendin.password.value = hexMD5('{{ $chapid }}' + document.login.username.value + '{{ $chapchallenge }}');
                document.sendin.submit();
                return false;
            }
            //-->
        </script>
    @endif

    <div align="center">
        <a href="{{ $linkloginonly }}?target=%2F&amp;dst={{ $linkorigesc }}"></a>
    </div>

    <section id="services" class="service-item">
        <div class="container wow fadeInDown">
            <div class="row">
             <div class="container text-center col-md-4 col-md-offset-4">
                                 <div class="row vertical-center-row">
                                     <div class="panel panel-default">

                                         <div class="panel-heading text-center">
                                             <h4 >Public Hotspot Login</h4>
                                         </div>
                                         <div class="panel-body">
                            <form name="login" class="form-horizontal" role="form" action="{{ $linkloginonly }}" method="post"
                                  @if($chapid) onSubmit="return doLogin()" @endif>
                                <input type="hidden" name="dst" value="$(link-orig)" />
                                <input type="hidden" name="popup" value="true" />


                                <div class="form-group">
                                    <label for="inputLogin" class="col-sm-3 control-label">Access Code</label>
                                    <div class="col-sm-8">
                                    <input id="inputLogin" class="form-control input-md" name="username" type="text" value="{{ $username }}"/>
                                    </div>
                                </div>

                               <div class="form-group">
                                    <div class="col-md-offset-3 col-sm-4">
                                        <button type="submit" class="btn btn-primary btn-block">OK</button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <?php if($error) : ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endif; ?>
                                </div>

                            </form>
                    </div>
                </div>
                </div>
                </div>
                </div>
            </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>



    <script type="text/javascript">
        <!--
        document.login.username.focus();
        //-->
    </script>

</section>
</div>




<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <ul class="portfolio-filter text-left">


                </ul><!--/#portfolio-filter-->
            </div>
            <div class="col-md-4 col-sm-6 pull-right" >
                <p class="text-muted">Ramayana & Co. &copy; <?php echo date('Y')?></p>
            </div>
        </div>
    </div>
</footer><!--/#footer-->





</body>
</html>
