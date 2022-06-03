<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/globalFunctions.php';
require __DIR__.'../../../../../includes/brandlogin/functions.php';

if( isset($_POST['brand_signup']) ) {

    if( signup($_POST) > 0 ) {
        echo "
                <script>
                    alert('user baru berhasil ditambahkan');
                    window.location = '../../dashboard/brand/home.php';
                </script>
            ";

        $brand_name = $_POST['brand_name'];
        
        $_SESSION['login'] = true;
        $_SESSION['brand_username'] = $brand_name;

        // cek remember me
        $sql = "SELECT * FROM brand WHERE brand_name = '$brand_name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if( isset($_POST['remember']) ) {
            // buat cookie
                            
            setcookie('ghlf', $row['id'], time()+60);
            setcookie('ksla', hash('sha256', $row['brand_name']), time()+60);
        }

    } else {
        echo "
                <script>
                    alert('user baru gagal ditambahkan');
                </script>
            ";
        echo mysqli_error($conn);
    }

}

?>
<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Sign Up Page Influencer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="keywords" content="pinegrow, blocks, bootstrap" />
        <meta name="description" content="SIGN UP INFLUENCER" />
        <link rel="shortcut icon" href="ico/favicon.png"> 
        <!-- Core CSS -->         
        <link href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../../../style/css/font-awesome.min.css" rel="stylesheet">
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
        <section class="content-block contact-1">
            <div class="container text-center">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="underlined-title">
                        <h1>Sign Up</h1>
                        <hr>
                        <h2>influenza now</h2>
                    </div>
                    <div id="contact" class="form-container">
                        <div id="message"></div>
                        <form method="post" action="">
                            <!-- </div> -->
                                <!-- /.Brand Logo -->
                                <!-- <label for="brand_logo">Brand Logo</label>
                                <input type="file" name="brand_logo" id="brand_logo" class="form-control" placeholder="Input brand logo" required>
                            </div> -->
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Brand Name -->
                                        <label for="brand_name">Brand Name</label>
                                        <input name="brand_name" id="brand_name" type="text" placeholder="Brand Name" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Email -->
                                        <label for="brand_email">Email</label>
                                        <input name="brand_email" id="brand_email" type="text" placeholder="example@example.com" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Brand Sector -->
                                        <label for="brand_sector">Brand Sector</label>
                                        <input name="brand_sector" id="brand_sector" type="text" placeholder="Input your brand sector" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Phone Number -->
                                        <label for="brand_phone_number">Phone Number</label>
                                        <input name="brand_phone_number" id="brand_phone_number" type="text" placeholder="Brand Phone Number" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Password -->
                                        <label for="brand_password">Password</label>
                                        <input name="brand_password" id="brand_password" type="password" placeholder="Password" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- /.Password Confirmation -->
                                        <label for="brand_password2">Confirm Password</label>
                                        <input name="brand_password2" id="brand_password2" type="password" placeholder="Password Confirmation" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                                <!-- /.Brand Description -->
                                <label for="brand_description">Brand Description</label>
                                <textarea name="brand_description" id="brand_description" class="form-control" rows="3" placeholder="Input brand description" id="textArea" required></textarea>
                                <p class="small text-muted"><span class="guardsman">All fields are required.</span> Once we receive your message we will respond as soon as possible.</p>
                            </div>
                            <div>
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="brand_signup" name="brand_signup">Sign Up</button>
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
