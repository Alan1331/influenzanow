<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
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
if( !isset($_SESSION['login']) || !isset($_SESSION['brand_username']) ) {
    header('Location: ../../login/brandlogin/login.php');
}

$brand_name = $_SESSION['brand_username'];
$brand_logo = query("SELECT brand_logo FROM brand WHERE brand_name = \"$brand_name\"")[0]['brand_logo'];
$path = '../../../images/brands/data/';

if( isset($_POST['submit']) ) {
    $brand_logo = upload($_FILES['brand_logo'], $path);
    if( $brand_logo !== false ) {
        $result = mysqli_query($conn, "UPDATE brand SET brand_logo = \"$brand_logo\" WHERE brand_name = \"$brand_name\"");
    } else {
        echo "
                <script>
                    window.location = 'changeprofile.php';
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
    <title>Profile Page</title>
    <link rel="stylesheet" href = "../../../style/css/brandprofile.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Change Brand Logo</h1>
                <hr>
                <button class="btn btn-primary" type="button" onclick="window.location = 'brandprofile.php'">Go Back</button>
                <br>
                <br>
                <center>
                    <img class="img" src="<?= $path . $brand_logo; ?>" alt="Brand Logo">
                </center>
                <br>
                <input type="file" name="brand_logo" id="brand_logo">
                <center><button type="submit" name="submit">Upload Brand Logo</button></center>
            </form>
        </div>
    </div>

</body>
</html>