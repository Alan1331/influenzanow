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

if( isset($_GET['erf_id']) ) {
    $_SESSION['erf_id'] = $_GET['erf_id'];
}
$erf_id = $_SESSION['erf_id'];
$brand_name = $_SESSION['brand_username'];
$brand_id = query("SELECT brand_id FROM brand WHERE brand_name = \"$brand_name\"")[0]['brand_id'];
$test_erf_draft = query("SELECT * FROM erf WHERE brand_id = $brand_id AND erf_id = $erf_id");
if( isset($test_erf_draft[0]) ) {
    $erf_draft = $test_erf_draft[0];
    $erf_id = $erf_draft['erf_id'];
    $task_list = query("SELECT * FROM task WHERE erf_id = $erf_id AND task_status = 'added'");
}
$path = '../../../images/brands/erf/';
$path_inf = '../../../images/influencer/data/';

if( isset($erf_draft['erf_id']) ) {
    $erf_id = $erf_draft['erf_id'];
    $inf_criteria = query("SELECT * FROM inf_criteria WHERE erf_id = $erf_id");
    $ref_link = query("SELECT * FROM ref_link WHERE erf_id = $erf_id");
    $apply_applied = query("SELECT * FROM apply_erf, influencer WHERE apply_erf.inf_id = influencer.inf_id AND apply_erf.erf_id = $erf_id AND apply_erf.apply_status = 'Waiting for Approval'");
    $apply_joined = query("SELECT * FROM apply_erf, influencer WHERE apply_erf.inf_id = influencer.inf_id AND apply_erf.erf_id = $erf_id AND apply_erf.apply_status = 'Accepted'");
}

// formatting product_price
$price = explode('.', $erf_draft['product_price']);
$price = $price[0];
$price = strrev($price);
$price = str_split($price, 3);
for($i = 0; $i < sizeof($price) ; $i++) {
    $price[$i] = strrev($price[$i]);
}
$product_price = '';
for($i = sizeof($price)-1; $i >= 0 ; $i--) {
    if($i == sizeof($price) - 1) {
        $product_price .= $price[$i];
    } else {
        $product_price .= '.' . $price[$i];
    }
}
$product_price = 'Rp ' . $product_price;


?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Endorsement Requirement Form</title>
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
                                <a href="#">Notification</a>
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
                        <h1><?= $erf_draft['erf_name']; ?></h1>
                        <h3>Product Name: <?= $erf_draft['product_name']; ?></h3>
                        <h3>Registration Deadline: <?= $erf_draft['reg_deadline']; ?></h3>
                        <h3>Brief / Note:</h3>
                        <p class="lead"><?= $erf_draft['gen_brief']; ?></p>
                        <!-- <div class="row">
                            <div class="col-sm-5 col-xs-12">
                            </div>
                        </div> -->

                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <img class="img-rounded img-responsive" src="<?= $path . $erf_draft['erf_pict']; ?>">
                        <center><h3><?= 'Product Price:<br>' . $product_price; ?></h3></center>
                    </div>
                </div>
                <!--// END Row -->
                <hr>
                <!-- Start Row -->
                <div class="row" style="height: 700px;">
                    <!-- Start Task List -->
                    <div class="col-sm-5" style="border-right: thick solid #E8AEAE;height:inherit;">
                        <center>
                            <h3>Task List</h3>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Task Name</th>
                                        <th>Deadline</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 0; $i < sizeof($task_list); $i++): ?>
                                        <tr class="bold-approved">
                                            <td><?= $i+1 ?></td>
                                            <td><?= $task_list[$i]['task_name'] ?></td>
                                            <td><?= $task_list[$i]['task_deadline'] ?></td>
                                            <td>
                                                <button class="btn btn-primary" type="button" onclick="window.location = 'taskDetail.php?task_id=<?= $task_list[$i]['task_id']; ?>'"><i class="fa fa-eye"></i></button>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <!--// END Task List -->
                    <!-- Start Participant Criteria -->
                    <div class="col-sm-4" style="border-right: thick solid #E8AEAE;height:inherit;">
                        <center><h3>Participant Criteria</h3></center>
                        <ul style="list-style-type:disc">
                            <?php foreach($inf_criteria as $criteria): ?>
                                <li><?= $criteria['criteria'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if( sizeof($ref_link) > 0 ): ?>
                        <hr>
                        <!-- Start Reference Links-->
                            <center><h3>Reference Links</h3></center>
                            <ul style="list-style-type:disc">
                                <?php for($i = 0; $i < sizeof($ref_link); $i++): ?>
                                    <li><a target="_blank" href="<?= $ref_link[$i]['link'] ?>"><?= 'Link' . ($i + 1); ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        <?php endif; ?>
                        <!--// END Reference Links-->
                    </div>
                    <div class="col-sm-3">
                        <!-- Start Applied Participant-->
                        <?php if( sizeof($apply_applied) > 0 ): ?>
                            <div class="participant">
                                <center><h3>Applied Participant</h3></center>
                                <?php foreach($apply_applied as $applied): ?>
                                    <center>
                                        <div class="inf-show">
                                            <a href="view_inf_profile.php?inf_id=<?= $applied['inf_id']; ?>"><img class="img" src="<?= $path_inf . $applied['inf_pict']; ?>" alt="profile picture"></a>                                      
                                            <b><?= $applied['inf_username']; ?></b>
                                            <a href="acceptApply.php?erf_id=<?= $erf_id; ?>&inf_id=<?= $applied['inf_id']; ?>">Accept</a>/<a href="declineApply.php?erf_id=<?= $erf_id; ?>&inf_id=<?= $applied['inf_id']; ?>" class="decline-text">Decline</a>
                                        </div>
                                    </center>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!--// END Applied Participant-->
                        <?php if( sizeof($apply_joined) > 0 ): ?>
                            <div class="participant">
                                <hr>
                            </div>
                            <!-- Start Joined Participant-->
                            <div class="participant">
                                <center><h3>Joined Participant</h3></center>
                                <?php foreach($apply_joined as $joined): ?>
                                    <center>
                                        <div class="inf-show">
                                            <a href="view_inf_profile.php?inf_id=<?= $joined['inf_id']; ?>"><img class="img" src="<?= $path_inf . $joined['inf_pict']; ?>" alt="profile picture"></a>                                      
                                            <b><?= $joined['inf_username']; ?></b>
                                        </div>
                                    </center>
                                <?php endforeach; ?>
                            </div>
                            <!--// END Joined Participant-->
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
