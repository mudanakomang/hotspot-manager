<?php
$mac = $_POST['mac'];
$ip = $_POST['ip'];
$username = $_POST['username'];
$linklogin = $_POST['link-login'];
$linkorig = $_POST['link-orig'];
$error = $_POST['error'];
$trial = $_POST['trial'];
$loginby = $_POST['login-by'];
$chapid = $_POST['chap-id'];
$chapchallenge = $_POST['chap-challenge'];
$linkloginonly = $_POST['link-login-only'];
$linkorigesc = $_POST['link-orig-esc'];
$macesc = $_POST['mac-esc'];
$identity = $_POST['identity'];
$bytesinnice = $_POST['bytes-in-nice'];
$bytesoutnice = $_POST['bytes-out-nice'];
$sessiontimeleft = $_POST['session-time-left'];
$uptime = $_POST['uptime'];
$refreshtimeout = $_POST['refresh-timeout'];
$linkstatus = $_POST['link-status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Hotspot Manager| Status</title>
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
                        <li><a href="http://10.10.1.3/hotspot-manager/public/landing/index.php">Home</a></li>
                        <li><a href="http://10.10.8.1/login">Login</a></li>
                        <li><a href="http://10.10.8.1/status">Status</a></li>
                        <li class="active"><a href="http://10.10.8.1/logout">Logout</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->

    <section id="services" class="service-item">
        <div class="container wow fadeInDown">
            <div class="row">
                <div class="col-sm-6 col-md-12">

                    <div class="row">
                        <?php if ($error) : ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <div class="alert alert-success">You have just logged out.</div>
                    </div>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <td>user name</td>
                                        <td><?php echo $username; ?></td>
                                    </tr>
                                    <tr>
                                        <td>IP address</td>
                                        <td><?php echo $ip; ?></td>
                                    </tr>
                                    <tr>
                                        <td>MAC address</td>
                                        <td><?php echo $mac; ?></td>
                                    </tr>
                                    <tr>
                                        <td>session time</td>
                                        <td><?php echo $uptime; ?></td>
                                    </tr>
                                    <?php if ($sessiontimeleft) : ?>
                                        <tr>
                                            <td>time left</td>
                                            <td><?php echo $sessiontimeleft; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>bytes up/down:</td>
                                        <td><?php echo $bytesinnice; ?> / <?php echo $bytesoutnice; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#services-->

</div>

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 fleft">
                <p class="text-muted">Created by <a target="_blank" href="http://agratitudesign.blogspot.com/"
                                                    title="Agratitudesign Hotspot Templates">agratitudesign.blogspot.com</a>
                </p>
            </div>
            <div class="col-md-6 col-sm-6 fright">
                <p class="text-muted">Supported by <a target="_blank" href="http://wiswaweb.com/"
                                                      title="Agratitudesign Hotspot Templates">wiswaweb.com</a></p>
            </div>
        </div>
    </div>
</footer><!--/#footer-->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/jquery.isotope.min.js"></script>
<script src="js/main.js"></script>
<script src="js/wow.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(" a[rel^='prettyPhoto']").prettyPhoto({
            animationSpeed: 'normal', /* fast/slow/normal */
            allow_resize: true, /* Resize the photos bigger than viewport. true/false */
            default_width: 600,
            default_height: 500,
            social_tools: false,
        });
        //now that it has been initialized, just "click" it:
        $("#item1").click();
    });
</script>
<?php if ($chapid) : ?>
    <script type="text/javascript" src="js/md5.js"></script>
    <script type="text/javascript">
        $('#loginForm').submit(function () {
            var password = $('#inputPassword');
            password.val(hexMD5('$(chap-id)' + password.val() + '$(chap-challenge)'));
        });
    </script>
<?php endif; ?>

</body>
</html>
