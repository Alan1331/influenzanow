<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/globalFunctions.php';
require __DIR__.'../../../../../includes/influencerlogin/functions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    // jika akun influencer
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
    if( isset($_SESSION['inf_username']) ) {
        $ses_inf_username = $_SESSION['inf_username'];
        $interest_info = mysqli_query($conn, "SELECT * FROM inf_interest WHERE inf_username = '$ses_inf_username'");
        $sns_info = mysqli_query($conn, "SELECT * FROM sns WHERE inf_username = '$ses_inf_username'");
        if( (mysqli_num_rows($interest_info) < 1) || (mysqli_num_rows($sns_info) < 1) ) {
            // jika data interest atau data sns kosong
            header('Location: addInitInfo.php');
        } else {
            // jika data interest atau data sns tidak kosong
            header('Location: ../../dashboard/influencer/home.php');
        }
    }
    // jika akun brand
    if( isset($_SESSION['brand_username']) ) {
        // redirect ke dashboard home brand
        header('Location: ../../dashboard/brand/home.php');
    }
}

if( isset($_POST['inf_login']) ) {

    $inf_username = $_POST['inf_username'];
    $inf_password = $_POST['inf_password'];

    $result = mysqli_query($conn, "SELECT * FROM influencer WHERE inf_username = '$inf_username'");

    // cek username
    if( mysqli_num_rows($result) === 1 ) {
        
        // cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($inf_password, $row['inf_password']) ) {
            // set session
            $_SESSION['login'] = true;
            $_SESSION['inf_username'] = $inf_username;

            // cek remember me
            if( isset($_POST['remember']) ) {
                // buat cookie
                setcookie('ghlf', $row['inf_username'], time()+(60*60*24*30*12), '/');
                setcookie('ksla', hash('sha256', $row['inf_name']), time()+(60*60*24*30*12), '/');
                setcookie('tp', hash('sha256', 'influencer'), time()+(60*60*24*30*12), '/');
            }

            header("Location: ../../dashboard/influencer/home.php");
        }

    }

    $error = true;

}

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
    <meta charset="utf-8"> 
        <title>Task</title>
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
        <section class="content-block contact-1">
            <div class="container text-center">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="underlined-title">
                        <h1>Sign In</h1>
                        <hr>
                        <h2>as influencer</h2>
                    </div>
                    <div id="contact" class="form-container">
                        <div id="message"></div>
                        <form method="post" action="">
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-sm-4">
</div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Username -->
                                        <label for="inf_username">Username</label>
                                        <input name="inf_username" id="inf_username" type="text" placeholder="Username" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
</div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Password -->
                                        <label for="inf_password">Password</label>
                                        <input name="inf_password" id="inf_password" type="password" placeholder="Password" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
</div>
                            </div>
                            <!-- /.Birthdate -->
                            <!-- /.Gender -->
                            
                                <br>
                            </label>
                            <div class="row">
                            <div>
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">Remember me</label>
                            </div>                                 
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="small text-muted"><font color="black">Don't have an Account? <a href="signup.php">Register Here</a></font></p>
                            </div>
                            <div class="form-group">
                                <p class="small text-muted"><font color="black">Have Brand Account? <a href="../brandlogin/login.php">Log In as Brand</a></font></p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="cf-submit" name="inf_login">SIGN IN</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.form-container -->
                </div>
                <!-- /.col-sm-10 -->
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