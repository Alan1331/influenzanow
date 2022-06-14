<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/sns/functions.php';

$inf_id = $_SESSION['inf_id'];
$sns_type = "tiktok";

// query data sns
$sns = query("SELECT * FROM sns WHERE inf_id = \"$inf_id\" AND sns_type = \"$sns_type\"")[0];

// cek apakah tombol update sudah diklik
if( isset($_POST['update_tiktok']) ) {

    // cek apakah tiktok berhasil diubah atau tidak
    if( updateSNS($_POST) > 0 ) {
        echo "
                <script>
                    alert('tiktok berhasil diubah');
                    history.go(-2);
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('tiktok gagal diubah');
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
    <title>Form Tiktok</title>
    <link rel="stylesheet" href = "../../../style/css/tt.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="https://www.kibrispdr.org/dwn/3/tik-tok-png.png">
        </div>
        <div class="login">
            <form action="">
                <h1>Tiktok</h1>
                <hr>
                <p>InfluenZa Now</p>
                <input type="hidden" name="inf_id" value="<?= $inf_id ?>">
                <input type="hidden" name="sns_type" value="<?= $sns_type ?>">
                <label for="sns_username">Username</label>
                <input type="text" name="sns_username" id="sns_username" value="<?= $sns['sns_username']; ?>" placeholder="input tiktok username">
                <label for="sns_followers">Followers</label>
                <input type="text" name="sns_followers" id="sns_followers" value="<?= $sns['sns_followers']; ?>" placeholder="input followers">
                <label for="sns_link">Link</label>
                <input type="url" name="sns_link" id="sns_link" pattern="https://.*" value="<?= $sns['sns_link']; ?>" placeholder="input sns link">
                <label for="sns_er">Engagement Rate</label>
                <input type="number" name="sns_er" id="sns_er" min="0" max="100" step="0.01" value="<?= $sns['sns_er']; ?>" placeholder="ex: 5.25 (optional)">
                <button type="submit" name="update_tiktok">Update</button>
                <p>
                    <p>You don't have Tiktok?</p>
                    <center><input type="button" value="Back to Additional Information Page" onclick="history.back()"></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>