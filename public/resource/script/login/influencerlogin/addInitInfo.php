<?php
session_start();

require __DIR__.'../../../../../includes/connection.php';
require __DIR__.'../../../../../includes/globalFunctions.php';
require __DIR__.'../../../../../includes/influencerlogin/functions.php';
require __DIR__.'../../../../../includes/sns/functions.php';

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
if( !isset($_SESSION['login']) || !isset($_SESSION['inf_username']) ) {
    header('Location: ../loginas.php');
}

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
    $sns_page = getSnsPage($_POST['sns_type']);
    header('Location: ../../sns/'.$sns_page);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Additional Information</title>
    <link href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../../../style/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">
        <!-- Style Library -->         
        <link href="../../../style/css/style-library-1.css" rel="stylesheet">
        <link href="../../../style/css/plugins.css" rel="stylesheet">
        <link href="../../../style/css/blocks.css" rel="stylesheet">
        <link href="../../../style/css/custom.css" rel="stylesheet">
        <link href="../../../style/css/table.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->         
        <!--[if lt IE 9]>
      <script src="../../../style/js/html5shiv.js"></script>
      <script src="../../../style/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <center>
<h1>Input Additional Information</h1>

<h2>Interests</h2>
<form action="" method="post">
    <input type="hidden" name="inf_username" value="<?= $username ?>">
    <ul>
        <li>
            <label for="interest">Add interest</label><br>
            <input type="text" placeholder="type new interest here!" name="interest" id="interest" required>
        </li>
        <li>
            <button class="btn btn-primary" type="submit" name="add_interest">Add Interest!</button>
        </li>
    </ul>
</form>
<table class="styled-table">
    <tr>
        <th>No.</th>
        <th>Interest</th>
        <th>Action</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach( $interests as $interest ): ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= $interest['interest'] ?></td>
        <td><a href="../../delete/hapusInterest.php?interest=<?= $interest['interest']; ?>" onclick="return confirm('Do you really want to delete this?');">Delete</a></td>
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
            <button class="btn btn-primary" type="submit" name="add_sns">Add SNS!</button>
        </li>
    </ul>
</form>
<table class="styled-table">
    <tr>
        <th>SNS Type</th>
        <th>SNS Username</th>
        <th>SNS Followers/Subscribers</th>
        <th>SNS Link</th>
        <th>SNS ER</th>
        <th>Action</th>
    </tr>
    <?php foreach( $snslist as $sns ): ?>
    <tr>
        <td><?= $sns['sns_type']; ?></td>
        <td><?= $sns['sns_username'] ?></td>
        <td><?= $sns['sns_followers'] ?></td>
        <td><?= $sns['sns_link'] ?></td>
        <td><?= $sns['sns_er'] ?></td>
        <td>
            <a href="../../delete/hapusSns.php?sns_type=<?= $sns['sns_type']; ?>" onclick="return confirm('Do you really want to delete this?');">Delete</a>
            <a href="../../update/sns/<?= getSnsPage($sns['sns_type']); ?>">Edit</a>
        </td>
    </tr>
    <?php endforeach; ?>
    
</table>
<button class="btn btn-primary"><a href="../../../script/dashboard/influencer/home.php">Continue to dashboard</a></button>

<script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>
        </center>
</body>
</html>