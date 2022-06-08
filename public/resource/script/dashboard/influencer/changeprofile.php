<?php
session_start();

require __DIR__."../../../../../includes/connection.php";
require __DIR__."../../../../../includes/globalFunctions.php";
require __DIR__."../../../../../includes/influencerlogin/functions.php";

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
$influencer = query("SELECT * FROM influencer WHERE inf_username=\"$inf_username\"")[0];

if( isset($_POST['submit']) ) {
    upload($_FILES);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href = "../../../style/css/infProfile.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>About Influencer</h1>
                <hr>
                <br>
                <br>
                <div class="img"></div>
                <br>
                <input type="file" name="inf_pict" id="inf_pict">
                <center><button type="submit" name="submit">Update Profile</button></center>
            </form>
        </div>
    </div>

</body>
</html>