<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    if( $_COOKIE['tp'] === hash('sha256', 'influencer') ) {
        $id = $_COOKIE['ghlf'];
        $key = $_COOKIE['ksla'];
    
        // ambil inf_id berdasarkan cookie nya
        $result = mysqli_query($conn, "SELECT * FROM influencer WHERE inf_id = '$id'");
        $row = mysqli_fetch_assoc($result);
    
        // cek cookie dan inf_id
        if( $key === hash('sha256', $row['inf_username']) ) {
            $_SESSION['login'] = true;
            $_SESSION['inf_id'] = $row['inf_id'];
        }
    }
}

// cek login
if( $_SESSION['login'] && isset($_SESSION['inf_id']) ) {
    $ses_inf_id = $_SESSION['inf_id'];
    $interest_info = mysqli_query($conn, "SELECT * FROM inf_interest WHERE inf_id = '$ses_inf_id'");
    $sns_info = mysqli_query($conn, "SELECT * FROM sns WHERE inf_id = '$ses_inf_id'");
    if( (mysqli_num_rows($interest_info) < 1) || (mysqli_num_rows($sns_info) < 1) ) {
        // jika data interest atau data sns kosong
        header('Location: ../../login/influencerlogin/addInitInfo.php');
    }
} else {
    header('Location: ../../login/influencerlogin/login.php');
}

$inf_id = $_SESSION['inf_id'];

if(isset($_GET['erf_id'])) {
    $_SESSION['erf_id'] = $_GET['erf_id'];
}

$erf_id = $_SESSION['erf_id'];
$erf = query("SELECT * FROM erf WHERE erf_id = $erf_id")[0];

// cek apakah erf ini sudah diajukan atau belum
$applied = false;
$cari = mysqli_query($conn, "SELECT * FROM apply_erf WHERE erf_id = $erf_id AND inf_id = $inf_id");
$jumlah_cari = mysqli_num_rows($cari);
if( $jumlah_cari > 0 ) {
    $applied = true;
    $apply_erf = query("SELECT * FROM apply_erf WHERE erf_id = $erf_id AND inf_id = $inf_id")[0];
    $apply_id = $apply_erf['apply_id'];
    // cek apakah influencer sudah bergabung dengan erf ini
    $apply_status = $apply_erf['apply_status'];
    if( $apply_status == 'Accepted/Joined' ) {
        $joined = true;
    }
}


?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head>
    <meta charset="utf-8"> 
        <title>ERF Details</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="keywords" content="pinegrow, blocks, bootstrap" />
        <meta name="description" content="SIGN UP INFLUENCER" />
        <link rel="shortcut icon" href="ico/favicon.png"> 
        <!-- Core CSS -->         
        <link href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../../../style/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">
        <!-- Style Library -->         
        <link href="../../../style/css/style-library-1.css" rel="stylesheet">
        <link href="../../../style/css/plugins.css" rel="stylesheet">
        <link href="../../../style/css/blocks.css" rel="stylesheet">
        <link href="../../../style/css/custom.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->         
        <!--[if lt IE 9]>
      <script src="../../../style/js/html5shiv.js"></script>
      <script src="../../../style/js/respond.min.js"></script>
    <![endif]-->         
    </head>     
    <body data-spy="scroll" data-target="nav">
        <header id="header-1" class="soft-scroll header-1">
            <!-- Navbar -->
            <nav class="main-nav navbar-fixed-top headroom headroom--pinned">
                <div class="container">
                    <!-- Brand and toggle -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#">
                            <img src="../../../images/logo-white.png" class="brand-img img-responsive">
                        </a>
                    </div>
                    <!-- Navigation -->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active nav-item">
                                <a href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="infProfile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="notification.php">Notification</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#">Message </a> 
                            </li>
                            <!--//dropdown-->                     
                            <li class="nav-item">
                                <a href="savedERF.php">Saved ERF</a>
                            </li>
                            <li class="nav-item">
                                <a href="../../login/influencerlogin/logout.php">Log Out</a>
                            </li>
                        </ul>
                        <!--//nav-->
                    </div>
                    <!--// End Navigation -->
                </div>
                <!--// End Container -->
            </nav>
            <!--// End Navbar -->
        </header>
        <section id="content-1-2" class="content-block content-1-2">
            <div class="container">
                <!-- Start Row -->
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="button" onclick="window.location = 'home.php'">Back to home</button>
                        <h1><?= $erf['erf_name']; ?></h1>
                        <h3>Product Name: <?= $erf['product_name']; ?></h3>
                        <p class="lead"><?= $erf['gen_brief']; ?></p>
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <?php if( !$applied ): ?>
                                    <a href="applyERF.php?erf_id=<?= $erf['erf_id']; ?>" class="btn btn-block btn-warning"><span class="fa fa-check"></span>&nbsp;Apply now</a>
                                <?php endif; ?>
                                <?php if( $applied && !isset($joined) ): ?>
                                    <i>You have applied to this campaign</i>
                                    <a href="CancelApplyERF.php?apply_id=<?= $apply_id; ?>" class="btn btn-block btn-warning"><span class="fa fa-check"></span>&nbsp;Cancel Apply</a>
                                <?php endif; ?>
                                <?php if( isset($joined) ): ?>
                                    <i>You have joined this campaign</i>
                                <?php endif; ?>
                                <a href="erfTask.php?erf_id=<?= $erf['erf_id']; ?>" class="btn btn-block btn-warning"><span class="fa fa-eye"></span>&nbsp;View Task List</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <img class="img-rounded img-responsive" src="../../../images/brands/erf/<?= $erf['erf_pict']; ?>">
                    </div>
                </div>
                <!--// END Row -->
            </div>
        </section>
        <section id="content-2-2" class="content-block content-2-2 bg-pomegranate">
            <div class="container">
                <!-- Start Row -->
                <div class="row">
                    <div class="col-sm-4 col-xs-12 text-center">
                        <div class="icon-outline">
                            <span class="fa fa-shopping-cart"></span>
                        </div>
                        <h3>Save ERF</h3>
                        <p>Save this ERF if you want to apply later</p>
                    </div>
                    <div class="col-sm-4 col-xs-12 text-center">
                        <div class="icon-outline">
                            <span class="fa fa-calendar"></span>
                        </div>
                        <h3>Registration Deadline</h3>
                        <p><?= $erf['reg_deadline']; ?></p>
                    </div>
                    <div class="col-sm-4 col-xs-12 text-center">
                        <div class="icon-outline">
                            <span class="fa fa-paper-plane"></span>
                        </div>
                        <h3>Promote and Submit Proof</h3>
                        <p>15 February 2022 - 25 February 2022</p>
                    </div>
                </div>
                <!--// END Row -->
            </div>
        </section>
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>           
    </body>     
</html>
