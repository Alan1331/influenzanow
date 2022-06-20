<?php
session_start();

require __DIR__.'../../../../includes/connection.php';
require __DIR__.'../../../../includes/globalFunctions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    // jika akun influencer
    if( $_COOKIE['tp'] === hash('sha256', 'influencer') ) {
        $id = $_COOKIE['ghlf'];
        $key = $_COOKIE['ksla'];
    
        // ambil username berdasarkan cookie nya
        $result = mysqli_query($conn, "SELECT * FROM influencer WHERE inf_id = '$id'");
        $row = mysqli_fetch_assoc($result);
    
        // cek cookie dan username
        if( $key === hash('sha256', $row['inf_name']) ) {
            $_SESSION['login'] = true;
            $_SESSION['inf_username'] = $row['inf_username'];
        }
    }
    // jika akun brand
    if( $_COOKIE['tp'] === hash('sha256', 'brand')) {
        $id = $_COOKIE['ghlf'];
        $key = $_COOKIE['ksla'];
    
        // ambil username berdasarkan cookie nya
        $result = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$id'");
        $row = mysqli_fetch_assoc($result);
    
        // cek cookie dan username
        if( $key === hash('sha256', $row['brand_name']) ) {
            $_SESSION['login'] = true;
            $_SESSION['brand_username'] = $row['brand_name'];
        }
    }
}

// cek login
if( isset($_SESSION['login']) ) {
    // jika akun influencer
    if( isset($_SESSION['inf_id']) ) {
        $ses_inf_id = $_SESSION['inf_id'];
        $interest_info = mysqli_query($conn, "SELECT * FROM inf_interest WHERE inf_id = '$ses_inf_id'");
        $sns_info = mysqli_query($conn, "SELECT * FROM sns WHERE inf_id = '$ses_inf_id'");
        if( (mysqli_num_rows($interest_info) < 1) || (mysqli_num_rows($sns_info) < 1) ) {
            // jika data interest atau data sns kosong
            header('Location: influencerlogin/addInitInfo.php');
        } else {
            // jika data interest atau data sns tidak kosong
            header('Location: ../dashboard/influencer/home.php');
        }
    }
    // jika akun brand
    if( isset($_SESSION['brand_username']) ) {
        // redirect ke dashboard home brand
        header('Location: ../dashboard/brand/home.php');
    }
}

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Sign up or Sign in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="keywords" content="pinegrow, blocks, bootstrap" />
        <meta name="description" content="My new website" />
        <link rel="shortcut icon" href="ico/favicon.png"> 
        <!-- Core CSS -->         
        <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../../style/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">
        <!-- Style Library -->         
        <link href="../../style/css/style-library-1.css" rel="stylesheet">
        <link href="../../style/css/plugins.css" rel="stylesheet">
        <link href="../../style/css/blocks.css" rel="stylesheet">
        <link href="../../style/css/custom.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->         
        <!--[if lt IE 9]>
      <script src="../style/js/html5shiv.js"></script>
      <script src="../style/js/respond.min.js"></script>
    <![endif]-->         
    </head>     
    <body data-spy="scroll" data-target="nav">
        <script type="text/javascript" src="../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../style/js/bskit-scripts.js"></script>         
    </body>
    <header id="header-2" class="soft-scroll header-2">
        <nav class="main-nav navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#">
                        <img src="../../images/logo.png" class="brand-img img-responsive">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <a href="../../../index.php">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a href="loginas.php">Get Started</a>
                        </li>
                        <li class="nav-item">
                            <a href="#">Rating</a>
                        </li>
                        <!-- /.dropdown -->                             
                        <li class="nav-item">
                            <a href="../aboutUs.php">About Us</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <center>
            <h1>Sign Up or Sign In</h1>
        </center>
    </header>
    <section id="content-3-10" class="content-block-nopad content-3-10">
        <div class="image-container col-sm-6 col-xs-12 pull-left">
            <div class="background-image-holder">
                <center>
                    <img src="../../images/influencer.png" width="550" />
                </center>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6 col-xs-12 content">
                    <h3>For Influencers</h3>
                    <p>Jalin Kerja sama dengan berbagai macam Brands.</p>
                    <a href="./influencerlogin/signup.php" class="btn btn-outline btn-outline outline-dark">Sign Up</a>
                    <a href="./influencerlogin/login.php" class="btn btn-outline btn-outline outline-dark">Sign In</a>
                </div>
            </div>
            <!-- /.row-->
        </div>
        <!-- /.container -->
    </section>
    <section id="content-3-11" class="content-block-nopad content-3-11">
        <div class="image-container col-sm-6 col-xs-12 pull-right">
            <div class="background-image-holder">
                <center>
                    <img src="../../images/brand.png" width="600" />
                </center>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12 content pull-left">
                    <h3>For Brands</h3>
                    <p>Jalin Kerja Sama dengan berbagai macam Influencers.</p>
                    <a href="./brandlogin/signup.php" class="btn btn-outline btn-outline outline-dark">Sign up</a>
                    <a href="./brandlogin/login.php" class="btn btn-outline btn-outline outline-dark">Sign In</a>
                </div>
            </div>
            <!-- /.row-->
        </div>
        <!-- /.container -->
    </section>
    <div class="copyright-bar bg-black">
        <div class="container">
            <p class="pull-left small">© InfluenZa Now</p>
            <p class="pull-right small">By Triple AAA</p>
        </div>
    </div>
</html>
