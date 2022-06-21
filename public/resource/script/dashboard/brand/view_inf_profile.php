<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
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
if( !isset($_SESSION['login']) || !isset($_SESSION['brand_username']) ) {
    header('Location: ../../login/brandlogin/login.php');
}


if( isset($_GET['inf_id']) ) {
    $_SESSION['inf_id'] = $_GET['inf_id'];
}

if( isset($_GET['back_url']) ) {
    $_SESSION['back_url'] = $_GET['back_url'];
}

$back_url = $_SESSION['back_url'];

$inf_id = $_SESSION['inf_id'];

// data
$inf_data = query("SELECT * FROM influencer WHERE inf_id = $inf_id")[0];
$sns_data = query("SELECT * FROM sns WHERE inf_id = $inf_id");
$interest_data = query("SELECT * FROM inf_interest WHERE inf_id = $inf_id");

$path = '../../../images/influencer/data/';
$gender = '';
switch( $inf_data['inf_gender'] ) {
    case 'M':
        $gender = 'Male';
        break;
    case 'F':
        $gender = 'Female';
        break;
    default:
        $gender = 'Unknown';
}
    

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Influencer Profile</title>
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
        <link href="../../../style/css/custom.css" rel="stylesheet"> <!-- sahlan yang nambahin -->
        <link href="../../../style/css/roundedimage.css" rel="stylesheet"> <!-- sahlan yang nambahin -->
        <link href="../../../style/css/table.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->         
        <!--[if lt IE 9]>
      <script src="../../../style/js/html5shiv.js"></script>
      <script src="../../../style/js/respond.min.js"></script>
    <![endif]-->
        <script>
        </script>
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
                        <a href="#"><img src="../../../images/logo-white.png" class="brand-img img-responsive"></a>
                    </div>
                    <!-- Navigation -->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active nav-item">
                                <a href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="brandProfile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="notification.php">Notification</a>
                            </li>
                            <!--//dropdown-->                             
                            <li class="nav-item">
                                <a href="#">Message</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">Review</a>
                            </li>
                            <li class="nav-item">
                                <a href="../../login/brandlogin/logout.php">Log Out</a>
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
                        <button class="btn btn-primary" onclick="window.location='<?= $back_url; ?>'">Back</button>
                        <h1><?= $inf_data['inf_name']; ?></h1>
                        <h4>Email: <?= $inf_data['inf_email']; ?></h4>
                        <h4>Gender: <?= $gender; ?></h4>
                        <h4>Date of Birth: <?= $inf_data['inf_birthdate']; ?></h4>
                        <h4>Phone Number: <?= $inf_data['inf_phone_number']; ?></h4>
                        <h4>Address:</h4>
                        <p class="lead"><?= $inf_data['inf_address']; ?></p>
                        <!-- <div class="row">
                            <div class="col-sm-5 col-xs-12">
                            </div>
                        </div> -->

                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <center>
                            <img class="big-img" src="<?= $path . $inf_data['inf_pict']; ?>">
                            <h4><?= 'username: ' . $inf_data['inf_username']; ?></h4>
                            <i>has joined influenzanow since <?= $inf_data['inf_reg_date']; ?></i>
                        </center>
                    </div>
                </div>
                <!--// END Row -->
                <hr>
                <!-- Start Row -->
                <div class="row" style="height: 700px;">
                    <!-- Start Task List -->
                    <div class="col-sm-6" style="border-right: thick solid #E8AEAE;height:fit-content;">
                        <?php if( sizeof($sns_data) > 0 ): ?>
                            <center><h3>Social Network Services</h3></center>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>SNS Username</th>
                                        <th>Followers/Subscribers</th>
                                        <th>Engagement Rate</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="bold-approved">
                                    <?php foreach( $sns_data as $sns ): ?>
                                        <tr>
                                            <td><?= $sns['sns_type']; ?></td>
                                            <td><?= $sns['sns_username']; ?></td>
                                            <td><?= $sns['sns_followers']; ?></td>
                                            <td><?= $sns['sns_er']; ?>%</td>
                                            <td>
                                                <a href="<?= $sns['sns_link']; ?>" target="_blank"><button class="btn btn-primary" type="button"><i class="fa fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <?php if( sizeof($interest_data) > 0 ): ?>
                            <h3>Influencer's Interests</h3>
                            <ul style="list-style-type:disc">
                                <?php foreach( $interest_data as $interest ): ?>
                                    <li><h5><?= $interest['interest']; ?></h5></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
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
