<?php
session_start();

require __DIR__.'/../../../includes/connection.php';
require __DIR__.'/../../../includes/globalFunctions.php';
require __DIR__.'/../../../includes/sns/functions.php';

$inf_id = $_SESSION['inf_id'];
$sns_type = "instagram";

// cek apakah tombol submit sudah diklik
if( isset($_POST['add_instagram']) ) {
    $_POST['sns_link'] = "https://instagram.com/" . $_POST['sns_username'];

    // cek apakah instagram berhasil ditambahkan atau tidak
    if( addSNS($_POST) > 0 ) {
        echo "
                <script>
                    alert('instagram berhasil ditambahkan');
                    history.go(-2);
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('instagram gagal ditambahkan');
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
    <title>Form Instagram</title>
    <link rel="stylesheet" href = "../../style/css/ig.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="https://i.pinimg.com/736x/99/75/97/9975975ce4141f79ea6df0861a7679d4.jpg">
        </div>
        <div class="login">
            <form action="" method="post">
                <h1>Instagram</h1>
                <hr>
                <p>InfluenZa Now</p>
                <input type="hidden" name="inf_id" value="<?= $inf_id ?>">
                <input type="hidden" name="sns_type" value="<?= $sns_type ?>">
                <label for="sns_username">Username</label>
                <input type="text" name="sns_username" id="sns_username" placeholder="input instagram username" required>
                <label for="sns_followers">Followers</label>
                <input type="text" name="sns_followers" id="sns_followers" placeholder="input followers" required>
                <label for="sns_er">Engagement Rate</label>
                <input type="number" name="sns_er" id="sns_er" min="0" max="100" step="0.01" placeholder="ex: 5.25 (optional)">
                <button type="submit" name="add_instagram">Submit</button>
                <p>
                    <p>You don't have Instagram?</p>
                    <center><input type="button" value="Back to Additional Information Page" onclick="history.back()"></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>