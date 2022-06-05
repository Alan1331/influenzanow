<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/sns/functions.php';

$inf_username = $_SESSION['inf_username'];
$sns_type = "instagram";

// query data sns
$sns = query("SELECT * FROM sns WHERE inf_username = \"$inf_username\" AND sns_type = \"$sns_type\"")[0];

// cek apakah tombol update sudah diklik
if( isset($_POST['update_instagram']) ) {
    $_POST['sns_link'] = "https://instagram.com/" . $_POST['sns_username'];

    // cek apakah instagram berhasil diubah atau tidak
    if( updateSNS($_POST) > 0 ) {
        echo "
                <script>
                    alert('instagram berhasil diubah');
                    window.location = '../../login/influencerlogin/addInitInfo.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('instagram gagal diubah');
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
    <link rel="stylesheet" href = "../../../style/css/ig.css">
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
                <input type="hidden" name="inf_username" value="<?= $inf_username ?>">
                <input type="hidden" name="sns_type" value="<?= $sns_type ?>">
                <label for="sns_username">Username</label>
                <input type="text" name="sns_username" id="sns_username" value="<?= $sns['sns_username']; ?>" placeholder="input instagram username">
                <label for="sns_followers">Followers</label>
                <input type="text" name="sns_followers" id="sns_followers" value="<?= $sns['sns_followers']; ?>" placeholder="input followers">
                <label for="sns_er">Engagement Rate</label>
                <input type="number" name="sns_er" id="sns_er" min="0" max="100" step="0.01" value="<?= $sns['sns_er']; ?>" placeholder="ex: 5.25 (optional)">
                <button type="submit" name="update_instagram">Update</button>
                <p>
                    <p>You don't have Instagram?</p>
                    <center><a href="../../login/influencerlogin/addInitInfo.php">Back to Additional Information Page</a></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>