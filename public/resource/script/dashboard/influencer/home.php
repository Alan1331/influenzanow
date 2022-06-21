<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

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

if( isset($_SESSION['back_url']) ) {
    unset($_SESSION['back_url']);
}

if( isset($_SESSION['apply_id']) ) {
    unset($_SESSION['apply_id']);
}

if( isset($_SESSION['task_id']) ) {
    unset($_SESSION['task_id']);
}

if( isset($erf_name) ) {
    unset($erf_name);
}

// data
$influecer = query("SELECT * FROM influencer WHERE inf_id = $inf_id");

if( isset($_POST['search']) ) {
    $key = $_POST['key'];
    $erf_list = query("SELECT erf_id, erf_pict, erf_name FROM erf WHERE erf_status != 'drafted' AND erf_name LIKE \"%$key%\"");
    $apply_list = query("SELECT * FROM apply_erf, erf WHERE apply_erf.erf_id = erf.erf_id AND apply_erf.inf_id = $inf_id AND apply_erf.apply_status = 'Accepted/Joined' AND erf.erf_name LIKE \"%$key%\"");
    $erf_done = query("SELECT * FROM apply_erf, erf WHERE apply_erf.apply_status = 'Done' AND apply_erf.erf_id = erf.erf_id AND apply_erf.inf_id = $inf_id AND erf.erf_name LIKE \"%$key%\"");
} else {
    $erf_list = query("SELECT erf_id, erf_pict, erf_name FROM erf WHERE erf_status != 'drafted'");
    $apply_list = query("SELECT * FROM apply_erf, erf WHERE apply_erf.erf_id = erf.erf_id AND apply_erf.inf_id = $inf_id AND apply_erf.apply_status = 'Accepted/Joined'");
    $erf_done = query("SELECT * FROM apply_erf, erf WHERE apply_erf.apply_status = 'Done' AND apply_erf.erf_id = erf.erf_id AND apply_erf.inf_id = $inf_id");
}

$saved_erf = query("SELECT erf_id FROM saved_erf WHERE inf_id = $inf_id");

$saved_erf_id_list = array();
foreach($saved_erf as $erf_id) {
    array_push($saved_erf_id_list, $erf_id['erf_id']);
}

function get_sub_status($sub_status) {
    switch($sub_status) {
        case 'not submitted':
            return 'bold-approval';
        case 'submitted':
            return 'bold-approved';
        case 'approved':
            return 'bold-approved';
        default:
            return '';
    }
}



?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Influencer Menu</title>
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
        <link href="../../../style/css/table.css" rel="stylesheet">
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
                            <!--//ADD TO SAVED-->                     
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
        <section class="content-block gallery-1 gallery-1-1">
            <div class="container">
                <div class="underlined-title">
                    <h1>Influencer Home Page</h1>
                    <hr>
                    <h2>A Selection For Your Work</h2>
                </div>
                <center>
                <div class="row">
                    <form method="post" action="">
                        <input type="text" name="key" id="key" type="text" placeholder="Enter keyword(ex: ERF name, task on process, and history ERF)" class="form-control">
                        <button class="btn btn-primary" type="submit" id="cf-submit" name="search">SEARCH</button>
                    </form>
                </div>
                </center>
                <ul class="filter">
                    <li>
                        <a href="#" data-filter=".ERF">ERF</a>
                    </li>
                    <li>
                        <a href="#" data-filter=".PROCESS">Process</a>
                    </li>
                    <li>
                        <a href="#" data-filter=".PAYMENT">Payment</a>
                    </li>
                    <li>
                        <a href="#" data-filter=".HISTORY">History</a>
                    </li>
                </ul>
                <!-- /.gallery-filter -->
                <div class="row">
                    <div class="isotope-gallery-container">
                        <!-- /.gallery-item-wrapper -->
                        <!-- /.ERF -->
                        <?php foreach($erf_list as $erf): ?>
                            <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper ERF">
                                <div class="gallery-item">
                                    <div class="gallery-thumb">
                                        <img src="../../../images/brands/erf/<?= $erf['erf_pict']; ?>" class="img-responsive" alt="Product Picture">
                                        <div class="image-overlay"><img src="../../../images/brands/erf/<?= $erf['erf_pict']; ?>" alt=""></div>
                                        <?php if( !in_array($erf['erf_id'], $saved_erf_id_list) ): ?>
                                            <a href="saveERF.php?erf_id=<?= $erf['erf_id']; ?>" class="gallery-link2"><i class="fa fa-shopping-cart" alt="Save ERF"></i></a>
                                        <?php endif; ?>
                                        <a href="erfDetail.php?erf_id=<?= $erf['erf_id']; ?>" class="gallery-link"><i class="fa fa-arrow-right" alt="Learn more"></i></a>
                                    </div>
                                    <div class="gallery-details">
                                        <h4><?= $erf['erf_name']; ?></h4>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- /.ERF END -->
                        <!-- /.gallery-item-wrapper START PROCESS -->
                        <?php if( sizeof($apply_list) > 0 ): ?>
                            <?php foreach( $apply_list as $apply ): ?>
                                <?php $erf_id = $apply['erf_id']; ?>
                                <?php $erf_name = query("SELECT erf_name FROM erf WHERE erf_id = $erf_id")[0]['erf_name']; ?>
                                <?php $apply_id = $apply['apply_id']; ?>
                                <?php $all_aproved = check_approved($apply_id, $erf_id); ?>
                                <?php $sub_list = query("SELECT * FROM task_submissions WHERE apply_id = $apply_id"); ?>
                                <div class="col-sm-6 col-xs-12 gallery-item-wrapper PROCESS">
                                    <div class="gallery-item">
                                        <div class="gallery-thumb">
                                            <table class="styled-table">
                                                <thead>
                                                    <tr>
                                                        <th>Task ID</th>
                                                        <th>Task Name</th>
                                                        <th>Deadline</th>
                                                        <th>ERF Status</th>
                                                        <th>Task Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($sub_list as $sub): ?>
                                                        <?php $task_status = $sub['submission_status']; ?>
                                                        <?php $task_id = $sub['task_id']; ?>
                                                        <?php $task = query("SELECT * FROM task WHERE task_id = $task_id")[0]; ?>
                                                        <tr class="<?= get_sub_status($task_status); ?>">
                                                            <td><?= $task_id; ?></td>
                                                            <td><?= $task['task_name']; ?></td>
                                                            <td><?= $task['task_deadline']; ?></td>
                                                            <td><?= $task_status; ?></td>
                                                            <td><button class="button button2" type="button" onclick="window.location = 'taskInfo.php?task_id=<?= $task_id; ?>&back_url=home.php&apply_id=<?= $apply_id; ?>&erf_id=<?= $erf_id ?>'">View Task</button></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="gallery-details">
                                                <?php if($all_aproved): ?>
                                                    <center>
                                                    <button class="btn btn-primary" type="button" onclick="window.location = 'doneERF.php?apply_id=<?= $apply_id; ?>'">Done</button><br>
                                                    <i>All task was approved you could <b>done</b> this ERF to claim your rewards</i>
                                                    </center>
                                                <?php endif; ?>
                                                <h4><?= $erf_name; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- /.gallery-item-wrapper END PROCESS -->
                        <!-- /.gallery-item-wrapper -->
                        <?php foreach($erf_done as $erf): ?>
                            <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper HISTORY">
                                <div class="gallery-item">
                                    <div class="gallery-thumb">
                                        <img src="../../../images/brands/erf/<?= $erf['erf_pict']; ?>" class="img-responsive" alt="Product Picture">
                                        <div class="image-overlay"></div>
                                        <a href="saveERF.php" class="gallery-zoom"><i class="fa fa-shopping-cart" alt="Save ERF"></i></a>
                                        <a href="erfDetail.php?erf_id=<?= $erf['erf_id']; ?>" class="gallery-link"><i class="fa fa-arrow-right" alt="Learn more"></i></a>
                                    </div>
                                    <div class="gallery-details">
                                        <h4><?= $erf['erf_name']; ?></h4>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- /.gallery-item-wrapper -->
                        <!-- <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PAYMENT">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/totalbalance.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>YOUR BALANCE IS:</h5>
                                </div>
                            </div>
                        </div> -->
                        <!-- /.gallery-item-wrapper -->
                        <!-- <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PAYMENT">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/payments1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>Bank Virtual Account</h5>
                                </div>
                            </div>
                        </div> -->
                        <!-- /.gallery-item-wrapper -->
                        <!-- <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PAYMENT">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/payments2.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>e-Wallet<br></h5>
                                </div>
                            </div>
                        </div> -->
                        <!-- /.gallery-item-wrapper END -->
                    </div>
                    <!-- /.isotope-gallery-container -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>         
    </body>     
</html>