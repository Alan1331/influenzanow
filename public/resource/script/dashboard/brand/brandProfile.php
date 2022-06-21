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
$brand = query("SELECT * FROM brand WHERE brand_name = \"$brand_name\"")[0];
$brand_logo = "../../../images/brands/data/" . $brand['brand_logo'];

if( isset($_POST['update_profile']) ) {

    // jika input null, maka akan diisi oleh data lama
    if( $_POST['brand_email'] == "" ) {
        $_POST['brand_email'] = $brand['brand_email'];
    }
    if( $_POST['brand_phone_number'] == "" ) {
        $_POST['brand_phone_number'] = $brand['brand_phone_number'];
    }
    if( $_POST['brand_sector'] == "" ) {
        $_POST['brand_sector'] = $brand['brand_sector'];
    }
    if( $_POST['brand_description'] == "" ) {
        $_POST['brand_description'] = $brand['brand_description'];
    }

    if( updateBrandProfile($_POST) > 0 ) {
        echo "
                <script>
                    alert('profile berhasil diubah');
                    window.location = 'brandProfile.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('profile gagal diubah');
                </script>
            ";
        echo mysqli_error($conn);
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
            <form action="" method="post">
                <h1>Profile Settings</h1>
                <hr>
                <br>
                <!--<a href="home.php"><--Back to home</a> -->
                <button class="btn btn-primary" type="button" onclick="window.location = 'home.php'">Back to Home</button>
                <br>
                <center>
                    <img class="img" src="<?= $brand_logo; ?>">
                </center>
                <br>
                <center>
                    <!--<a href="changeprofile.php">Change Picture ></a>-->
                    <button class="btn btn-primary" type="button" onclick="window.location = 'changeprofile.php'">Change Logo</button>
                </center>
                <br>
                <input type="hidden" name="brand_name" value="<?= $brand_name; ?>">
                <div class="input-left">
                    <label for="brand_email">Email</label>
                    <input type="text" id="brand_email" name="brand_email" value="<?= $brand['brand_email']; ?>" placeholder="<?= $brand['brand_email']; ?>">
                    <label for="brand_phone_number">Phone Number</label>
                    <input type="text" id="brand_phone_number" name="brand_phone_number" value="<?= $brand['brand_phone_number']; ?>" placeholder="<?= $brand['brand_phone_number']; ?>">
                    <label for="brand_sector">Brand Sector</label>
                    <input type="text" id="brand_sector" name="brand_sector" value="<?= $brand['brand_sector']; ?>" placeholder="<?= $brand['brand_sector']; ?>">
                    <center><button type="submit" name="update_profile">Save Profile Updates</button></center>
                </div>
                <div class="input-right">
                    <div class="radio">
                    <label for="brand_description">Brand Description</label>
                    <textarea id="brand_description" name="brand_description" cols="60" rows="4" placeholder="<?= $brand['brand_description']; ?>"><?= $brand['brand_description']; ?></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>