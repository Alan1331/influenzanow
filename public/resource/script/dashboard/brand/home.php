<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';

$brand_name = $_SESSION['brand_username'];

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

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>HOME</title>
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
        <header id="header-2" class="soft-scroll header-2">
        <nav class="main-nav navbar navbar-default navbar-fixed-top">
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
        <div class="content-block contact-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="contact" class="form-container">
                            <fieldset>
                                <center>
                                    <h4>FILTER<br></h4>
                                    <h6>ENDORSE REQUIREMENT FORM<br></h6>
                                </center>
                                <div id="message"></div>
                                <!--// ERF FILTER -->
                                <form method="post" action="">
                                    <label for="erf_name">ERF NAME</label>
                                    <div class="form-group">
                                        <input name="name" id="name" type="text" value="" placeholder="Name" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" id="cf-submit" name="submit">SEARCH NOW</button>
                                    </div>
                                    <div class="form-group">
                                        
                                        <button class="btn btn-primary"><a href="newERF.php">+ CREATE NEW ERF</a></button>
                
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                        <!-- /.form-container -->
                    </div>
                    <div class="col-md-6">
                        <!--// LIST ERF -->
                        <center>
                            <h2>List ERF</h2>
                        </center>
                        <center>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>ERF ID</th>
                                        <th>ERF Name</th>
                                        <th>ERF Deadline</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bold-approved">
                                        <td>1</td>
                                        <td>Make a Purchase</td>
                                        <td>(02-15-2022) - (02-25-2022)</td>
                                        <td>
                                            <button class="btn btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>         
    </body>     
</html>
