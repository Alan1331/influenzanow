<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/sns/functions.php';

$sns_type = "facebook";

// cek apakah tombol submit sudah diklik
if( isset($_POST['add_facebook']) ) {

    // cek apakah facebook berhasil ditambahkan atau tidak
    if( addSNS($_POST) > 0 ) {
        echo "
                <script>
                    alert('facebook berhasil ditambahkan');
                    window.location = '../login/influencerlogin/addInitInfo.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('facebook gagal ditambahkan');
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
                <label for="sns_username">Username</label>
                <input type="text" name="sns_username" id="sns_username placeholder="input facebook username" required>
                <label for="sns_followers">Followers</label>
                <input type="text" name="sns_followers" id="sns_followers placeholder="input followers" required>
                <label for="sns_link">Link</label>
                <input type="text" name="sns_link" id="sns_link placeholder="input sns link" required>
                <label for="sns_er">Engagement Rate</label>
                <input type="text" name="sns_link" id="sns_link placeholder="input sns er (optional)">
                <button type="submit" name="add_facebook">Submit</button>
                <p>
                    <p>You don't have facebook?</p>
                    <center><a href="../login/influencerlogin/addInitInfo.php">Back to Additional Information Page</a></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>