<?php
session_start();

require __DIR__.'/../../../includes/connection.php';
require __DIR__.'/../../../includes/globalFunctions.php';
require __DIR__.'/../../../includes/sns/functions.php';

$inf_username = $_SESSION['inf_username'];
$sns_type = "facebook";

// cek apakah tombol submit sudah diklik
if( isset($_POST['add_facebook']) ) {

    // cek apakah facebook berhasil ditambahkan atau tidak
    if( addSNS($_POST) > 0 ) {
        echo "
                <script>
                    alert('facebook berhasil ditambahkan');
                    history.go(-2);
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('facebook gagal ditambahkan');
                    history.go(-1);
                </script>
            ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Facebook</title>
    <link rel="stylesheet" href = "../../style/css/fb.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="https://www.logo.wine/a/logo/Facebook/Facebook-f_Logo-White-Dark-Background-Logo.wine.svg">
        </div>
        <div class="login">
            <form action="" method="post">
                <h1>Facebook</h1>
                <hr>
                <p>InfluenZa Now</p>
                <input type="hidden" name="inf_username" value="<?= $inf_username ?>">
                <input type="hidden" name="sns_type" value="<?= $sns_type ?>">
                <label for="sns_username">Username</label>
                <input type="text" name="sns_username" id="sns_username" placeholder="input facebook username" required>
                <label for="sns_followers">Followers</label>
                <input type="text" name="sns_followers" id="sns_followers" placeholder="input followers" required>
                <label for="sns_link">Link</label>
                <input type="url" name="sns_link" id="sns_link" placeholder="input sns link" required>
                <label for="sns_er">Engagement Rate</label>
                <input type="number" name="sns_er" id="sns_er" min="0" max="100" step="0.01" placeholder="ex: 5.25 (optional)">
                <button type="submit" name="add_facebook">Submit</button>
                <p>
                    <p>You don't have facebook?</p>
                    <center><input type="button" value="Back to Additional Information Page" onclick="history.back()"></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>