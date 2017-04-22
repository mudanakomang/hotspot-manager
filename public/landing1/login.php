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
                        <li><a href="http://10.10.1.3/hotspot-manager/public/landing/index.php">Home</a></li>
                        <li class="active"><a href="#">Login</a></li>
                        <li><a href="http://10.10.8.1/status">Status</a></li>
                        <li><a href="http://10.10.8.1/logout">Logout</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->

    <section id="portfolio">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="portfolio-items">
                    <div class="portfolio-item apps col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item1.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Hostpot Manger Login</a></h3>
                                    <p>Please Login with Your Account!</p>
                                    <a class="preview" id="item1" href="#ag-login" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item joomla bootstrap col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item2.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 2</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item2.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item bootstrap wordpress col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item3.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 3</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item3.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item joomla wordpress apps col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item4.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 4</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item4.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item joomla html bootstrap col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item5.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 5</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item5.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item wordpress html apps col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item6.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 6</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item6.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item wordpress html col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item7.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 7</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item7.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                    <div class="portfolio-item wordpress html bootstrap col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="images/portfolio/recent/item8.jpg" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">Feature Product 8</a></h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the
                                        majority</p>
                                    <a class="preview" href="images/portfolio/full/item8.jpg" rel="prettyPhoto"><i
                                            class="fa fa-eye"></i> View</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->
                </div>
            </div>
        </div>
    </section><!--/#portfolio-item-->
</div>

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <ul class="portfolio-filter text-left">
                    <li><a class="btn btn-default active" href="#" data-filter="*">Tanah Lot</a></li>
                    <li><a class="btn btn-default" href="#" data-filter=".bootstrap">Portfolio 1</a></li>
                    <li><a class="btn btn-default" href="#" data-filter=".html">Portfolio 2</a></li>
                    <li><a class="btn btn-default" href="#" data-filter=".wordpress">Portfolio 3</a></li>
                </ul><!--/#portfolio-filter-->
            </div>
            <div class="col-md-4 col-sm-6">
                <p class="text-muted">Created by <a target="_blank" href="http://agratitudesign.blogspot.com/"
                                                    title="Agratitudesign Hotspot Templates">agratitudesign.blogspot.com</a>
                </p>
            </div>
        </div>
    </div>
</footer><!--/#footer-->

<div class="panel panel-default" id="ag-login">
    <div class="panel-body">

        <?php if ($error) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="alert alert-info">Please log on to use the hotspot service.</div>

        <?php if ($trial == 'yes') : ?>
            <div class="alert alert-success">
                Free trial available, <a
                    href="<?php echo $linkloginonly; ?>?dst=<?php echo $linkorigesc; ?>&username=T-<?php echo $macesc; ?>">click
                    here</a>.
            </div>
        <?php endif; ?>


        <form id="loginForm" class="form-horizontal" role="form" action="<?php echo $linkloginonly; ?>" method="post">
            <input type="hidden" name="dst" value="<?php echo $linkorig; ?>"/>
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
            default_width: 700,
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
        <!--
        function doLogin() {
            <?php if (strlen($chapid) < 1) echo "return true;\n"; ?>
            document.sendin.username.value = document.login.username.value;
            document.sendin.password.value = hexMD5('<?php echo $chapid; ?>' + document.login.password.value + '<?php echo $chapchallenge; ?>');
            document.sendin.submit();
            return false;
        }
        //-->
    </script>
<?php endif; ?>

<script type="text/javascript">
    document.login.username.focus();
</script>


</body>
</html>
