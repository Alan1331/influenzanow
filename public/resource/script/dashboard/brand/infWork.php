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

if( isset($_GET['apply_id']) ) {
    $_SESSION['apply_id'] = $_GET['apply_id'];
}

if( isset($_GET['erf_id']) ) {
    $_SESSION['erf_id'] = $_GET['erf_id'];
}

$apply_id = $_SESSION['apply_id'];
$erf_id = $_SESSION['erf_id'];

// data
$task_submissions = query("SELECT * FROM task_submissions WHERE apply_id = $apply_id");

$path = '../../../images/brands/apply/'; 

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Influencer's Work</title>
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
                <button class="btn btn-primary" onclick="window.location='viewERF.php'">Back</button>
                <?php foreach($task_submissions as $submission_data): ?>
                    <?php $submission = $submission_data['submission']; ?>
                    <?php $submission_id = $submission_data['submission_id']; ?>
                    <?php $task_status = $submission_data['submission_status']; ?>
                    <?php $task_id = $submission_data['task_id']; ?>
                    <?php $task_data = query("SELECT * FROM task WHERE task_id = $task_id")[0]; ?>
                    <hr>
                    <!-- Start Row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <h1><?= $task_data['task_name']; ?></h1>
                            <h4>Task Status: <?= $task_status; ?></h4>
                            <h4>Deadline: <?= $task_data['task_deadline'] ?></h4>
                            <h4>Brief/Note:</h4>
                            <p class="lead"><?= $task_data['brief']; ?></p>
                            <!-- <div class="row">
                                <div class="col-sm-5 col-xs-12">
                                </div>
                            </div> -->

                        </div>
                        <?php if( $task_status == 'submitted' ): ?>
                            <div class="col-sm-5 col-sm-offset-1">
                                <center>
                                    <img class="submission-prove" src="<?= $path . $submission ?>">
                                    <h4>Submitted Proof</h4>
                                    <button class="btn btn-primary" type="button" onclick="window.location = 'approveTask.php?submission_id=<?= $submission_id ?>'">Approve the Work</button>
                                    <!-- <i>submitted since</i> -->
                                </center>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                    <div class="col-sm-12">
                            <center>
                            <?php $rules_do = query("SELECT * FROM rules_list WHERE task_id = $task_id AND rules_type = 'do'"); ?>
                            <?php $rules_dont = query("SELECT * FROM rules_list WHERE task_id = $task_id AND rules_type = 'dont'"); ?>
                            <?php $rows = max(sizeof($rules_do), sizeof($rules_dont)); ?>
                            <h2>Task Rules</h2>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Do</th>
                                        <th>Don't</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 0; $i < $rows; $i++): ?>
                                        <tr>
                                            <td><?= $rules_do[$i]['rules']; ?></td>
                                            <td><?= $rules_dont[$i]['rules']; ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                            </center>
                        </div>
                    </div>
                    <!--// END Row -->
                    <?php endforeach; ?>
                </div>
            </section>
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>         
    </body>
</html>
