<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/influencerlogin/functions.php';

$username = $_SESSION['inf_username'];
$interests = query("SELECT * FROM inf_interest WHERE inf_username=\"$username\"");
$snslist = query("SELECT * FROM sns WHERE inf_username=\"$username\"");

// cek apakah tombol add_interest sudah diclick atau belum
if( isset($_POST['add_interest']) ) {

    // cek apakah interest berhasil ditambahkan atau tidak
    if( addInterest($_POST) > 0 ) {
        echo "
                <script>
                    alert('interest berhasil ditambahkan');
                    window.location = 'addInitInfo.php';
                </script>
            ";
        // header('Location: addInitInfo.php');
    } else {
        echo "
                <script>
                    alert('interest gagal ditambahkan');
                    window.location = 'addInitInfo.php';
                </script>
            ";
        // header('Location: addInitInfo.php');
    }
}

// cek apakah tombol add_sns sudah diclick atau belum
if( isset($_POST['add_sns']) ) {

    // cek akan masuk ke halaman tambah sns tipe apa
    switch ($_POST['sns_type']) {
        case "facebook":
            header("Location: ../../sns/fbReg.php");
            break;
        case "instagram":
            header("Location: ../../sns/igReg.php");
            break;
        case "tiktok":
            header("Location: ../../sns/ttReg.php");
            break;
        case "twitter":
            header("Location: ../../sns/twtReg.php");
            break;
        case "youtube":
            header("Location: ../../sns/ytReg.php");
            break;
        default:
        echo "
                <script>
                    alert('sns type not found');
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
    <title>Additional Information</title>
</head>
<body>
<h1>Input Additional Information</h1>

<h2>Interests</h2>
<form action="" method="post">
    <input type="hidden" name="inf_username" value="<?= $username ?>">
    <ul>
        <li>
            <label for="interest">Add interest</label>
            <input type="text" placeholder="type new interest here!" name="interest" id="interest" required>
        </li>
        <li>
            <button type="submit" name="add_interest">Add Interest!</button>
        </li>
    </ul>
</form>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No.</th>
        <th>Interest</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach( $interests as $interest ): ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= $interest['interest'] ?></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
</table>

<br><br>
<h2>Social Network Service (SNS) List</h2>
<form action="" method="post">
    <ul>
        <li>
            <label for="sns_type">SNS type to add:</label>
            <select name="sns_type" id="sns_type">
                <option value="facebook">Facebook</option>
                <option value="instagram">Instagram</option>
                <option value="tiktok">TikTok</option>
                <option value="twitter">Twitter</option>
                <option value="youtube">YouTube</option>
            </select>
        </li>
        <li>
            <button type="submit" name="add_sns">Add SNS!</button>
        </li>
    </ul>
</form>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>SNS Type</th>
        <th>SNS Username</th>
        <th>SNS Followers/Subscribers</th>
        <th>SNS Link</th>
        <th>SNS ER</th>
    </tr>
    <?php foreach( $snslist as $sns ): ?>
    <tr>
        <td><?= $sns['sns_type']; ?></td>
        <td><?= $sns['sns_username'] ?></td>
        <td><?= $sns['sns_followers'] ?></td>
        <td><?= $sns['sns_link'] ?></td>
        <td><?= $sns['sns_er'] ?></td>
    </tr>
    <?php endforeach; ?>
    
</table>


</body>
</html>