<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/sns/functions.php';

$inf_username = $_SESSION['inf_username'];
$sns_type = "youtube";

// query data sns
$sns = query("SELECT * FROM sns WHERE inf_username = \"$inf_username\" AND sns_type = \"$sns_type\"")[0];

// cek apakah tombol update sudah diklik
if( isset($_POST['update_youtube']) ) {

    // cek apakah youtube berhasil diubah atau tidak
    if( updateSNS($_POST) > 0 ) {
        echo "
                <script>
                    alert('youtube berhasil diubah');
                    history.go(-2);
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('youtube gagal diubah');
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
    <title>Form Youtube</title>
    <link rel="stylesheet" href = "../../../style/css/yt.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="https://sdcenderawasih2.sch.id/wp-content/uploads/2021/12/YT-1.png">
        </div>
        <div class="login">
            <form action="" method="post">
                <h1>Youtube</h1>
                <hr>
                <p>InfluenZa Now</p>
                <input type="hidden" name="inf_username" value="<?= $inf_username ?>">
                <input type="hidden" name="sns_type" value="<?= $sns_type ?>">
                <label for="sns_username">Channel Name</label>
                <input type="text" name="sns_username" id="sns_username" value="<?= $sns['sns_username']; ?>" placeholder="input channel name">
                <label for="sns_followers">Subscribers</label>
                <input type="text" name="sns_followers" id="sns_followers" value="<?= $sns['sns_followers']; ?>" placeholder="input followers">
                <label for="sns_link">Link</label>
                <input type="url" name="sns_link" id="sns_link" pattern="https://.*" value="<?= $sns['sns_link']; ?>" placeholder="input sns link">
                <label for="sns_er">Engagement Rate</label>
                <input type="number" name="sns_er" id="sns_er" min="0" max="100" step="0.01" value="<?= $sns['sns_er']; ?>" placeholder="ex: 5.25 (optional)">
                <button type="submit" name="update_youtube">Update</button>
                <p>
                    <p>You don't have Youtube?</p>
                    <center><input type="button" value="Back to Additional Information Page" onclick="history.back()"></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>