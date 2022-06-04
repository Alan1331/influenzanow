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
$inf_name = query("SELECT inf_name FROM influencer WHERE inf_username='$inf_username'");

?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Influencer Homepage</title>
</head>
<body>
    <h1>Selamat datang <?= $inf_name[0]['inf_name'] ?></h1>
    <br><br><br><br>
    <p><a href="../../login/influencerlogin/logout.php">logout</a></p>
</body>
</html> -->

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
                                <a href="infMenu.php">Home</a>
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
                            <!--//ADD TO CART-->                     
                            <li class="nav-item">
                                <a href="#">Cart</a>
                            </li>
                            <li class="nav-item">
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
                    <h1>A Selection For Your Work</h1>
                    <hr>
                    <h2>Hand-picked just for you</h2>
                </div>
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
                                                                    <!-- /.ERF1 -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper ERF">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <!-- /.gambar -->
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    <!-- /.add to cart -->
                                    <a href="erfDetail.php" class="gallery-link"><i class="fa fa-shopping-cart" alt="This is the title"></i></a>
                                    <!-- /.target icon -->
                                    <a href="erfDetail.php" class="gallery-link" target="_blank"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <!-- /.erf name -->
                                    <h5>1st ERF</h5>
                                </div>
                            </div>
                        </div>
                                                                <!-- /.ERF1 END -->
                                                                <!-- /.ERF2 -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper ERF">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    <a href="http://placehold.it/800x600" class="gallery-zoom"><i class="fa fa-shopping-cart" alt="This is the title"></i></a>
                                    <a href="erfDetail.php" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>2nd ERF</h5>
                                </div>
                            </div>
                        </div>
                                                                <!-- /.ERF2 END -->
                        <!-- /.gallery-item-wrapper -->
                                                                <!-- /.ERF3 -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper ERF">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    <a href="http://placehold.it/800x600" class="gallery-zoom"><i class="fa fa-shopping-cart" alt="This is the title"></i></a>
                                    <a href="erfDetail.php" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>3rd ERF</h5>
                                </div>
                            </div>
                        </div>
                                                                <!-- /.ERF3 END -->
                                                                <!-- /.ERF4 -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper ERF">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    <a href="http://placehold.it/800x600" class="gallery-zoom"><i class="fa fa-shopping-cart" alt="This is the title"></i></a>
                                    <a href="erfDetail.php" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>4th ERF</h5>
                                </div>
                            </div>
                        </div>
                                                                <!-- /.ERF4 END -->
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PROCESS">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="erfTask.php" class="gallery-link"><i class="fa fa-eye"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>1st Process</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PROCESS">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="erfTask.php" class="gallery-link"><i class="fa fa-eye"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>2nd Process</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PROCESS">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="erfTask.php" class="gallery-link"><i class="fa fa-eye"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>3rd Process</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PROCESS">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="erfTask.php" class="gallery-link"><i class="fa fa-eye"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>4th Process</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper HISTORY">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>History 1</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper HISTORY">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>History 2</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper HISTORY">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                    
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>History 3</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper HISTORY">
                            <div class="gallery-item">
                                <div class="gallery-thumb">
                                    <img src="../../../images/brands/brand1.png" class="img-responsive" alt="1st gallery Thumb">
                                    <div class="image-overlay"></div>
                                
                                    <a href="#" class="gallery-link"><i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="gallery-details">
                                    <h5>History 4</h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PAYMENT">
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
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PAYMENT">
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
                        </div>
                        <!-- /.gallery-item-wrapper -->
                        <div class="col-md-3 col-sm-6 col-xs-12 gallery-item-wrapper PAYMENT">
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
                        </div>
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