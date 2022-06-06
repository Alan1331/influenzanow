<?php
session_start();

require __DIR__."../../../../../includes/connection.php";
require __DIR__."../../../../../includes/globalFunctions.php";
require __DIR__."../../../../../includes/influencerlogin/functions.php";

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
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
}

// cek login
if( $_SESSION['login'] && isset($_SESSION['inf_username']) ) {
    $ses_inf_username = $_SESSION['inf_username'];
    $interest_info = mysqli_query($conn, "SELECT * FROM inf_interest WHERE inf_username = '$ses_inf_username'");
    $sns_info = mysqli_query($conn, "SELECT * FROM sns WHERE inf_username = '$ses_inf_username'");
    if( (mysqli_num_rows($interest_info) < 1) || (mysqli_num_rows($sns_info) < 1) ) {
        // jika data interest atau data sns kosong
        header('Location: ../../login/influencerlogin/addInitInfo.php');
    }
} else {
    header('Location: ../../login/influencerlogin/login.php');
}

$inf_username = $_SESSION['inf_username'];
$influencer = query("SELECT * FROM influencer WHERE inf_username=\"$inf_username\"")[0];

if( isset($_POST['update_profile']) ) {

    // jika input null, maka akan diisi oleh data lama
    // if( $_POST['inf_username'] == "" ) {
    //     $_POST['inf_username'] = $influencer['inf_username'];
    // }
    if( $_POST['inf_name'] == "" ) {
        $_POST['inf_name'] = $influencer['inf_name'];
    }
    if( $_POST['inf_email'] == "" ) {
        $_POST['inf_email'] = $influencer['inf_email'];
    }
    if( $_POST['inf_phone_number'] == "" ) {
        $_POST['inf_phone_number'] = $influencer['inf_phone_number'];
    }
    if( $_POST['inf_address'] == "" ) {
        $_POST['inf_address'] = $influencer['inf_address'];
    }
    
    if( updateInfProfile($_POST) > 0 ) {
        // jika username berhasil diganti, maka session dan cookie username akan diset ulang
        // if( $_POST['inf_username'] != $influencer['inf_username'] ) {
        //     setcookie('ghlf', $row['inf_username'], time()+(60*60*60*24*30*12), '/');
        //     $_SESSION['inf_username'] = $influencer['inf_username'];
        // }
        echo "
                <script>
                    alert('user berhasil diubah');
                    window.location = 'infProfile.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('user gagal diubah');
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
    <link rel="stylesheet" href = "../../../style/css/infProfile.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <form action="" method="post">
                <h1>About Influencer</h1>
                <hr>
                <br>
                <br>
                <div class="img"></div>
                <br>
                <center>
                <a href="changeprofile.php">Change Picture ></a>
                </center>
                <br>
                <input type="hidden" name="inf_password" value="<?= $influencer['inf_password']; ?>">
                <input type="hidden" name="inf_reg_date" value="<?= $influencer['inf_reg_date']; ?>">
                <div class="input-left">
                    <input type="hidden" name="inf_username" value="<?= $influencer['inf_username'] ?>">
                    <!-- <label for="inf_username">Username</label>
                    <input type="text" id="inf_username" name="inf_username" value="" placeholder=""> -->
                    <label for="inf_name">Full Name</label>
                    <input type="text" id="inf_name" name="inf_name" value="<?= $influencer['inf_name'] ?>" placeholder="<?= $influencer['inf_name'] ?>">
                    <label for="inf_email">Email</label>
                    <input type="text" id="inf_email" name="inf_email" value="<?= $influencer['inf_email'] ?>" placeholder="<?= $influencer['inf_email'] ?>">
                    <label for="inf_phone_number">Phone Number</label>
                    <input type="text" id="inf_phone_number" name="inf_phone_number" value="<?= $influencer['inf_phone_number'] ?>" placeholder="<?= $influencer['inf_phone_number'] ?>">
                    <center><button type="submit" name="update_profile">Save Profile Updates</button></center>
                </div>
                <div class="input-right">
                    <div class="radio">
                        <div class="radio-label">
                            <label for="others">Gender</label>
                        </div>
                        <div class="radio-input">
                            <input type="radio" id="male" name="inf_gender" value="M" <?php if ($influencer['inf_gender'] == 'M'){ echo 'checked'; }?> />      
                            <label for="male">Male</label>
                        </div>
                        <div class="radio-input">
                            <input type="radio" id="female" name="inf_gender" value="F" <?php if ($influencer['inf_gender'] == 'F'){ echo 'checked'; }?> />
                            <label for="female">Female</label>
                        </div>
                        <div class="radio-input">
                            <input type="radio" id="others" name="inf_gender" value="O" <?php if ($influencer['inf_gender'] == 'O'){ echo 'checked'; }?> />
                            <label for="others">Others</label>
                        </div>
                    </div>
                    <br><br>
                    <label for="inf_birthdate">Birthday</label>
                    <input type="date" id="inf_birthdate" name="inf_birthdate" value="<?= $influencer['inf_birthdate']; ?>" >
                    <label for="inf_address">Address</label>
                    <textarea name="inf_address" id="inf_address" name="inf_address" cols="60" rows="4" placeholder="<?= $influencer['inf_address']; ?>"><?= $influencer['inf_address']; ?></textarea>
                </div>
            </form>
            <div class="row">
                <a href="editInterestSns.php"><button>Edit Interest or SNS</button></a>
            </div>
        </div>
    </div>

</body>
</html>