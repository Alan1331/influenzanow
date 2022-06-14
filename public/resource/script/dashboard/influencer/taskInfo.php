<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    if( $_COOKIE['tp'] === hash('sha256', 'influencer') ) {
        $id = $_COOKIE['ghlf'];
        $key = $_COOKIE['ksla'];
    
        // ambil username berdasarkan cookie nya
        $result = mysqli_query($conn, "SELECT * FROM influencer WHERE inf_username = '$id'");
        $row = mysqli_fetch_assoc($result);
    
        // cek cookie dan username
        if( $key === hash('sha256', $row['inf_name']) ) {
            $_SESSION['login'] = true;
            $_SESSION['inf_username'] = $row['inf_username'];
        }
    }
}

// cek login
if( $_SESSION['login'] && isset($_SESSION['inf_username']) ) {
    $ses_inf_username = $_SESSION['inf_username'];
    $interest_info = mysqli_query($conn, "SELECT * FROM inf_interest WHERE inf_username = '$ses_inf_username'");
    $sns_info = mysqli_query($conn, "SELECT * FROM sns WHERE inf_username = '$ses_inf_username'");
    if( (mysqli_num_rows($interest_info) < 1) || (mysqli_num_rows($sns_info) < 1) ) {
        // jika data interest atau data sns kosong
        header('Location: ../../login/influencerlogin/addInitInfo.php');
    }
} else {
    header('Location: ../../login/influencerlogin/login.php');
}

$inf_username = $_SESSION['inf_username'];

if(isset($_GET['task_id'])) {
    $_SESSION['task_id'] = $_GET['task_id'];
}

$erf_id = $_SESSION['erf_id'];
$task_id = $_SESSION['task_id'];
$task = query("SELECT * FROM task WHERE erf_id = $erf_id AND task_status = 'added' AND task_id = $task_id")[0];
$rules_do = query("SELECT rules FROM rules_list WHERE task_id = $task_id AND rules_type = 'do'");
$rules_dont = query("SELECT rules FROM rules_list WHERE task_id = $task_id AND rules_type = 'dont'");
$table_rows = 0;
if( sizeof($rules_do) >= sizeof($rules_dont) ) {
    $table_rows = sizeof($rules_do);
} else {
    $table_rows = sizeof($rules_dont);
}

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Task Detail</title>
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
                            <img src="../../../images/logo.png" class="brand-img img-responsive">
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
                                <a href="#">Notification</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#">Message </a> 
                            </li>
                            <!--//dropdown-->                     
                            <li class="nav-item">
                                <a href="#">Cart</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">Log Out</a>
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
        
        <section id="content-3-7" class="content-block content-3-7">
            <div class="container">
                <div class="col-sm-12">
                    <div class="underlined-title">
                        <h1>Task Detail</h1>
                        <hr>
                        <h2>- you reap what you sow -</h2>
                    </div>
                </div>
            </div>
            <hr>
            <a href="erfTask.php">
            <button style="margin: 40px;" class="btn btn-primary"><i class="fa fa-arrow-left">Back</i></button>
            </a>
            <center>
                <div class="underlined-title">
            <h2>
                Task Name:<br>
            </h2>
            <h3>
                <?= $task['task_name']; ?><br>
                <br>
            </h3>
            <h2>
                Task Deadline:<br>
            </h2>
            <h3>
                <?= $task['task_deadline']; ?><br>
            </h3>
                <br>
                <h2>
                Brief/Note:<br>
                </h2>
                <h3>
                <?= $task['brief']; ?>
                </h3>
                <br>
            </h3>
                </div>
            </center>
        </section>

        <div class="col-sm-12">
            <div class="underlined-title">
            <center>
            <h1>Task Rules</h1>
            <table class="styled-table">
            <thead>
                <tr>
                    <th>Do</th>
                    <th>Don't do</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i = 0; $i < $table_rows; $i++): ?>
                    <tr class="bold-approved">
                        <?php if( isset($rules_do[$i]) ): ?>
                            <td><?= $rules_do[$i]['rules'] ?></td>
                        <?php endif; ?>
                        <?php if( isset($rules_dont[$i]) ): ?>
                            <td><?= $rules_dont[$i]['rules'] ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
            </center>
        </div>
    </div>

    <script src="../../../bootstrap/js/progress.js"></script>
    <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
    <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
    <script type="text/javascript" src="../../../style/js/plugins.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>      
</body> 
