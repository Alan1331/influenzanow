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
$influencer = query("SELECT * FROM influencer WHERE inf_id=\"$inf_id\"")[0];
$inf_pict = $influencer['inf_pict'];
$path = '../../../images/influencer/data/';

if( isset($_POST['submit']) ) {
    $inf_pict = upload($_FILES['inf_pict'], $path);
    $result = mysqli_query($conn, "UPDATE influencer SET inf_pict = \"$inf_pict\" WHERE inf_id = \"$inf_id\"");
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
                <h1>Change Profie Picture</h1>
                <hr>
                <br>
                <button class="btn btn-primary"><a href="infProfile.php">Go Back to Profile Settings</a></button>
                <br>
                <center>
                    <img class="img" src="<?= $path . $inf_pict; ?>" alt="Profile Picture">
                </center>
                <br>
                <input type="file" name="inf_pict" id="inf_pict">
                <center><button type="submit" name="submit">Upload Profile Picture</button></center>
            </form>
        </div>
    </div>

</body>
</html>