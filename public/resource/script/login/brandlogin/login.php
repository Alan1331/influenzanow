<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/globalFunctions.php';
require __DIR__.'../../../../../includes/brandlogin/functions.php';

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
            header('Location: ../influencerlogin/addInitInfo.php');
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

if( isset($_POST['brand_login']) ) {

    $brand_name = $_POST['brand_name'];
    $brand_password = $_POST['brand_password'];
    $sql = "SELECT * FROM brand WHERE brand_name = '$brand_name'";

    $result = mysqli_query($conn, $sql);

    // cek name
    if( mysqli_num_rows($result) === 1 ) {
        
        // cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($brand_password, $row['brand_password']) ) {
            echo "password valid";
            // set session
            $_SESSION['login'] = true;
            $_SESSION['brand_username'] = $brand_name;

            // cek remember me
            if( isset($_POST['remember']) ) {
                // buat cookie
                setcookie('ghlf', $row['id'], time()+(60*60*60*24*30*12), '/');
                setcookie('ksla', hash('sha256', $row['brand_name']), time()+(60*60*60*24*30*12), '/');
                setcookie('tp', hash('sha256', 'brand'), time()+(60*60*60*24*30*12), '/');
            }

            header("Location: ../../dashboard/brand/home.php");
            exit;
        } else {
            echo "password invalid";
        }

    }

    $error = true;

}
?>

<!DOCTYPE html>
<head>
    <title>Login</title>
</head>
<body>
    
    <style type="text/css">

    #text{
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin #aaa;
        width: 100%;
    }
    
    #button{
        padding: 10px;
        width: 100px;
        color: white;
        background-color: lightblue;
        border: none;
    }

    #box{
        background-color: grey;
        margin: auto;
        width: 300px;
        padding: 20px;
    }

    </style>

    <div id="box">

        <form method="post" action="">
            <div style="font-size: 20px;margin: 10px;color: white;">Login</div>
            <label for="brand_name">Brand Name: </label>
            <input id="brand_name" type="text" name="brand_name" placeholder="Input your brand name"><br><br>
            <label for="brand_password">Password: </label>
            <input id="brand_password" type="password" name="brand_password" placeholder="Input your password"><br><br>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>

            <input id="button" type="submit" name="brand_login" value="login"><br><br>

            <a href="signup.php">Click to Sign up</a>
            <br><br>
            <a href="../loginas.php">Back</a>
        </form>

    </div>
    
</body>
</html>